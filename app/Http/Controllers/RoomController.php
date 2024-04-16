<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function showRoomsForm()
    {
        $rooms = Room::with('photos', 'amenities')->paginate(10);
        $amenities = Amenity::all();
        $types = RoomType::all();

        return view('rooms', compact('rooms', 'amenities', 'types'));
    }

    public function showRoomForm($id)
    {
        $room = Room::with('photos', 'amenities')->findOrFail($id);

        return view('room', compact('room'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('query');
        $amenities = $request->input('amenities');
        $price = $request->input('price');
        $beds = $request->input('beds');
        $stars = $request->input('stars');
        $type = $request->input('type');

        $rooms = Room::query();

        if ($searchTerm) {
            $rooms->where('number', 'LIKE', "%{$searchTerm}%")
                ->orWhereHas('hotel', function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('location', 'LIKE', "%{$searchTerm}%");
                });
        }

        if ($amenities) {
            foreach ($amenities as $amenity) {
                $rooms->whereHas('amenities', function ($q) use ($amenity) {
                    $q->where('amenity_id', $amenity);
                });
            }
        }

        if ($price) {
            $rooms->where('price_per_night', '<=', $price);
        }

        if ($beds) {
            $rooms->where('beds', $beds);
        }

        if ($stars) {
            $rooms->whereHas('hotel', function ($q) use ($stars) {
                $q->where('stars', $stars);
            });
        }

        if ($type) {
            $rooms->whereHas('type', function ($q) use ($type) {
                $q->where('id', $type);
            });
        }

        $rooms = $rooms->with('photos', 'amenities', 'type')->paginate(10);

        // Отримуємо всі можливі зручності та типи номерів для форми пошуку
        $amenities = Amenity::all();
        $types = RoomType::all();

        return view('rooms', compact('rooms', 'amenities', 'types'));
    }
}
