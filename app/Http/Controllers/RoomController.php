<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:rooms'],
        ]);

        $room = Room::create([
            'name' => $request->name,
        ]);

        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Room $room)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
        ]);

        $room->update([
            'name' => $request->name,
        ]);

        return new RoomResource($room);
    }
}
