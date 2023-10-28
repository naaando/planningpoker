<?php

use App\Events\RoundUpdated;
use App\Models\Room;
use App\Models\Round;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

test('can create round', function () {
    assertDatabaseCount('rounds', 0);

    $room = Room::factory()->create();

    postJson('/api/rounds', [
        'room_id' => $room->id,
    ])
        ->assertCreated()
        ->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.id')
                // ->has('secret')
            ;
        });

    assertDatabaseCount('rounds', 1);
});

test('can get round with votes', function () {
    $round = Round::factory()->for(Room::factory())->create();

    getJson("/api/rounds/{$round->id}")
        ->assertJson(function (AssertableJson $json) use ($round) {
            $json
                ->where('data.id', $round->id)
                ->has('data.created_at')
                ->has('data.updated_at')
                ->has('data.finished_at')
                ->has('data.votes')
            ;
        });
});

test('average is zero on empty votes', function () {
    $round = Round::factory()->for(Room::factory())->create();

    getJson("/api/rounds/{$round->id}")
        ->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.votes_average')
                ->where('data.votes_average', 0)
            ;
        });
});

test('average is zero on nulled votes', function () {
    $round = Round::factory()->for(Room::factory())->create();
    Vote::factory()->for($round)->create(['vote' => null]);

    getJson("/api/rounds/{$round->id}")
        ->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.votes_average')
                ->where('data.votes_average', 0)
            ;
        });
});

test('average is correctly calculated', function () {
    $round = Round::factory()->for(Room::factory())->create();
    Vote::factory()->for($round)->createMany([
        ['vote' => null],
        ['vote' => 1],
        ['vote' => 2],
        ['vote' => 3],
        ['vote' => 4],
        ['vote' => 5],
        ['vote' => 6],
        ['vote' => 7],
        ['vote' => 8],
        ['vote' => 9],
        ['vote' => 10],
    ]);

    getJson("/api/rounds/{$round->id}")
        ->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.votes_average')
                ->where('data.votes_average', 5.5)
            ;
        });
});

test('count votes works', function () {
    $round = Round::factory()->for(Room::factory())->create();
    Vote::factory()->for($round)->createMany([
        ['vote' => null],
        ['vote' => 1],
        ['vote' => 2],
        ['vote' => 3],
        ['vote' => 4],
        ['vote' => 5],
        ['vote' => 6],
        ['vote' => 7],
        ['vote' => 8],
        ['vote' => 9],
        ['vote' => 10],
    ]);

    getJson("/api/rounds/{$round->id}")
        ->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.votes_count')
                ->where('data.votes_count', 10)
            ;
        });
});

// a bit redundant but validates logic
test('count vote ignores null voters', function () {
    $round = Round::factory()->for(Room::factory())->create();
    Vote::factory()->for($round)->createMany([
        ['vote' => null],
        ['vote' => null],
        ['vote' => null],
        ['vote' => 1],
    ]);

    getJson("/api/rounds/{$round->id}")
        ->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.votes_count')
                ->where('data.votes_count', 1)
            ;
        });
});

test('can finish round', function () {
    Event::fake();
    $round = Round::factory()->for(Room::factory())->create();

    putJson("/api/rounds/{$round->id}", [
        'finished' => true,
    ])
        ->assertOk()
        ->assertJson(function (AssertableJson $json) use ($round) {
            $json
                ->where('data.id', $round->id)
                ->has('data.created_at')
                ->has('data.updated_at')
                ->has('data.finished_at')
                ->whereNot('data.finished_at', null)
            ;
        });

    Event::assertDispatched(RoundUpdated::class);
});

test('finish can be false', function () {
    Event::fake();
    $round = Round::factory()->for(Room::factory())->create();

    putJson("/api/rounds/{$round->id}", [
        'finished' => false,
    ])
        ->assertOk()
        ->assertJson(function (AssertableJson $json) use ($round) {
            $json
                ->where('data.id', $round->id)
                ->has('data.created_at')
                ->has('data.updated_at')
                ->has('data.finished_at')
                ->where('data.finished_at', null)
            ;
        });

    Event::assertDispatched(RoundUpdated::class);
});
