<?php

namespace App\Http\Controllers;

use App\Events\RoundUpdated;
use App\Http\Resources\VoteResource;
use App\Models\Round;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class RoundVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Round $round)
    {
        return VoteResource::collection($round->votes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Round $round)
    {
        $vote = $round->votes()->create($request->all());

        Event::dispatch(new RoundUpdated($round));

        return new VoteResource($vote);
    }

    /**
     * Display the specified resource.
     */
    public function show(Round $round, Vote $vote)
    {
        return new VoteResource($vote);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Round $round, Vote $vote)
    {
        $vote->update($request->all());

        Event::dispatch(new RoundUpdated($round));

        return new VoteResource($vote);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Round $round, Vote $vote)
    {
        $removed = Vote::where('round_id', $round->id)->delete($vote->id);

        if (!$removed) {
            abort(404);
        }

        Event::dispatch(new RoundUpdated($round));

        return response()->noContent();
    }
}
