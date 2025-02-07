<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(12);
        return view('front.room', compact('rooms'));
    }

    public function show(Room $room)
    {
        $room->load('photos');
        return view('front.room-detail', compact('room'));
    }
}
