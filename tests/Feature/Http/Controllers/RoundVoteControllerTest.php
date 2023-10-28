<?php

use App\Events\RoundUpdated;
use App\Models\Room;
use App\Models\Round;
use App\Models\Vote;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

uses(RefreshDatabase::class);

test('can join round with null vote', function () {
    Event::fake();
    $round = Round::factory()->for(Room::factory())->create();

    postJson("api/rounds/{$round->id}/votes", [
        'name' => fake()->name,
        'vote' => null,
    ])->assertCreated();

    $myVote = $round->votes()->first();

    expect($myVote->vote)->toBe(null);
    Event::assertDispatched(RoundUpdated::class);
});

test('can vote on round', function () {
    Event::fake();
    $round = Round::factory()->for(Room::factory())->create();

    $emtpyVoteResponse = postJson("api/rounds/{$round->id}/votes", [
        'name' => fake()->name,
    ]);

    assertDatabaseCount('votes', 1);
    $emptyVote = Vote::sole();
    assertEquals($emptyVote->id, $emtpyVoteResponse->json('data.id'));
    assertEquals($emptyVote->name, $emtpyVoteResponse->json('data.name'));
    assertNull($emptyVote->vote);

    putJson("api/rounds/{$round->id}/votes/{$emptyVote->id}", [
        'vote' => 5,
    ])->assertOk();

    $myVote = $round->votes()->first();

    expect($myVote->vote)->toBe(5);
    Event::assertDispatched(RoundUpdated::class);
});
