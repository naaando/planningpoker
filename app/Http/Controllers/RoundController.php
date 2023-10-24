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
     * Finish the round
     */
    public function finish(Round $round)
    {
        $round->finished_at = now();
        $round->save();
        Event::dispatch(new RoundUpdated($round));

        return new RoundResource($round);
    }
}
