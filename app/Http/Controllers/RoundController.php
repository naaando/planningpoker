<?php

namespace App\Http\Controllers;

use App\Events\RoundCreated;
use App\Events\RoundRevealed;
use App\Http\Resources\RoundResource;
use App\Models\Room;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class RoundController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
        ]);

        $room = Room::find($request->input('room_id'));

        abort_unless(
            $room->round === null || $room->round->finished_at,
            422,
            'Room already has a active round'
        );

        $round = Round::create($request->all());
        Event::dispatch(new RoundCreated($round));

        return new RoundResource($round);
    }

    /**
     * Display the specified resource.
     */
    public function show(Round $round)
    {
        return new RoundResource($round);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Round $round)
    {
        $request->validate([
            'finished' => ['required', 'boolean'],
        ]);

        if ($request->finished) {
            $round->finished_at = now();
        } else {
            $round->finished_at = null;
        }

        $round->save();

        Event::dispatch(new RoundRevealed($round));

        return new RoundResource($round);
    }
}
