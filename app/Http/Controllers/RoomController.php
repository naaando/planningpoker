<?php

namespace App\Http\Controllers;

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
            'name' => ['required', 'string'],
        ]);

        $room = Room::create([
            'name' => $request->name,
        ]);

        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return response()->json($room);
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

        return response()->json($room);
    }
}
