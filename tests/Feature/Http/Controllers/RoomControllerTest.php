<?php

use App\Models\Room;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

test('index not allowed', function () {
    getJson('/api/rooms')->assertMethodNotAllowed();
});

test('delete not allowed', function () {
    deleteJson('/api/rooms/1')->assertMethodNotAllowed();
});

test('can create a room', function () {
    $name = fake()->name;

    $response = postJson('/api/rooms', [
        'name' => $name,
    ]);

    $response->assertCreated();

    $response->assertJson([
        'data' => [
            'name' => $name,
            'slug' => Str::slug($name),
        ],
    ]);

    assertDatabaseHas('rooms', [
        'name' => $name,
        'slug' => Str::slug($name),
    ]);
});

test('can fetch current round on controller', function () {
    $room = Room::factory()->create();
    $round = $room->rounds()->create();

    getJson("/api/rooms/{$room->slug}")->assertOk()->assertJson([
        'data' => [
            'name' => $room->name,
            'slug' => $room->slug,
            'round' => [
                'id' => $round->id,
                'created_at' => $round->created_at->toISOString(),
                'updated_at' => $round->updated_at->toISOString(),
                'finished_at' => null,
                'votes' => [],
            ],
        ],
    ]);
});

test('can update name and slug', function () {
    $room = Room::factory()->create();

    $name = fake()->name;

    putJson("/api/rooms/{$room->slug}", [
        'name' => $name,
    ])->assertOk()->assertJson([
        'data' => [
            'name' => $name,
            'slug' => Str::slug($name),
        ]
    ]);

    assertDatabaseHas('rooms', [
        'name' => $name,
        'slug' => Str::slug($name),
    ]);
});
