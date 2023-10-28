<?php

use App\Models\Room;
use App\Models\Round;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

test('index not allowed', function () {
    getJson('/api/rooms')->assertMethodNotAllowed();
});

test('update not allowed', function () {
    putJson('/api/rooms/1')->assertMethodNotAllowed();
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

    /** @var Round */
    $round = Round::sole();

    $response->assertJson([
        'name' => $name,
        'slug' => Str::slug($name),
        'round' => $round->makeHidden('finished_at')->jsonSerialize(),
    ]);

    assertDatabaseHas('rooms', [
        'name' => $name,
        'slug' => Str::slug($name),
        'round_id' => $round->id,
    ]);

    assertDatabaseCount('rounds', 1);
});

test('can fetch current round on controller', function () {
    $room = Room::factory()->create();
    $round = Round::factory()->create();
    $room->round()->associate($round);
    $room->save();

    getJson("/api/rooms/{$room->slug}")->assertOk()->assertJson([
        'name' => $room->name,
        'slug' => $room->slug,
        'round_id' => $round->id,
        'round' => [
            'id' => $round->id,
            'created_at' => $round->created_at->toISOString(),
            'updated_at' => $round->updated_at->toISOString(),
            'finished_at' => null,
            'votes' => [],
        ],
    ]);
});
