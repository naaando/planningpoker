<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(LazilyRefreshDatabase::class);

test('can start a round and play planning poker', function () {
    $room = createRoom();

    // we get the round id to use on url
    $round = createRound($room);

    // The voter is represented by posting the vote, either numbered or null
    $voter1 = joinRound($round, fake()->name);
    $voter2 = joinRound($round, fake()->name);
    $voter3 = joinRound($round, fake()->name);

    // The voter votes on the round
    voteOnRound($round, $voter1, 1);
    voteOnRound($round, $voter2, 2);
    voteOnRound($round, $voter3, 3);

    // The round is finished
    finishRound($round)->assertJson(function (AssertableJson $json) {
        $json
            ->whereNot('data.finished_at', null)
            ->where('data.votes_count', 3)
            ->where('data.votes_average', 2)
            ->where('data.votes.0.vote', 1)
            ->where('data.votes.1.vote', 2)
            ->where('data.votes.2.vote', 3)
        ;
    });
});

function createRoom(): array
{
    return postJson('api/rooms', [
        'name' => fake()->name,
    ])->json('data');
}

function createRound($room): array
{
    return postJson('api/rounds', [
        'room_id' => $room['id'],
    ])->json('data');
}

function joinRound($round, $name): array
{
    return postJson("api/rounds/{$round['id']}/votes", [
        'name' => $name,
    ])->json('data');
}

function voteOnRound($round, $voter, $vote): array
{
    return putJson("api/rounds/{$round['id']}/votes/{$voter['id']}", [
        'vote' => $vote,
    ])->json('data');
}

function finishRound($round): TestResponse
{
    return putJson("api/rounds/{$round['id']}", [
        'finished' => true,
    ]);
}
