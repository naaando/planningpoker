<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        $room = Room::create([
            'name' => $request->name,
        ]);

        $room->round()->associate(
            Round::create()
        );

        $room->save();

        DB::commit();

        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return response()->json($room);
    }
}
