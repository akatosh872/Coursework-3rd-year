<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function showHotelsForm()
    {
        $hotels = Hotel::all();
        return view('hotels', compact('hotels'));
    }

    public function showHotelForm($id)
    {
        $hotel = Hotel::findOrFail($id);

        $rooms = Room::with('type')->where('hotel_id', $id)
            ->orderBy(request('sort', 'number'))
            ->paginate(10);

        return view('hotel', compact('hotel', 'rooms'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $location = $request->input('location');
        $stars = $request->input('stars');

        $hotels = Hotel::query();

        if($query) {
            $hotels->where('name','like', "%{$query}%");
        }

        if($location) {
            $hotels->where('location','like', "%{$location}%");
        }

        if($stars) {
            $hotels->where('stars', $stars);
        }

        $hotels = $hotels->get();

        return view('hotels', compact('hotels'));
    }
}
