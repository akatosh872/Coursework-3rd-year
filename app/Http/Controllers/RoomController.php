<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $room = Room::with('photos', 'amenities', 'reviews.user')->findOrFail($id);
        $payment_methods = DB::table('payment_methods')->get();
        $booking = Booking::where('room_id', $id)->where('user_id', auth('web')->id())->first();

        return view('room', compact('room', 'payment_methods', 'booking'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('query');
        $amenities = $request->input('amenities');
        $price = $request->input('price');
        $beds = $request->input('beds');
        $stars = $request->input('stars');
        $checkInDate = $request->input('check_in_date');
        $checkOutDate = $request->input('check_out_date');
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

        if ($checkInDate && $checkOutDate) {
            $rooms->whereDoesntHave('bookings', function ($q) use ($checkInDate, $checkOutDate) {
                $q->where(function ($q) use ($checkInDate, $checkOutDate) {
                    $q->where('check_in_date', '<=', $checkOutDate)
                        ->where('check_out_date', '>=', $checkInDate);
                });
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

    public function storeReview(Request $request, $id)
    {
        // Валідація вхідних даних
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'review' => 'required|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Створення нового відгуку
        $review = new Review;
        $review->room_id = $request->room_id;
        $review->user_id = auth('web')->id();
        $review->review = $request->review;
        $review->rating = $request->rating;

        // Збереження відгуку в базі даних
        $review->save();

        // Повернення відповіді
        return redirect()->back()->with('status', 'Ваш відгук було успішно збережено!');
    }
}
