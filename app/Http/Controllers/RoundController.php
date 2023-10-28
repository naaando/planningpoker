<?php

namespace App\Http\Controllers;

use App\Events\RoundUpdated;
use App\Http\Resources\RoundResource;
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
        return new RoundResource(
            Round::create(
                $request->all()
            )
        );
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

        Event::dispatch(new RoundUpdated($round));

        return new RoundResource($round);
    }
}
