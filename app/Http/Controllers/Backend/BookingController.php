<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function showBookingsForm()
    {
        $adminId = auth('admin')->id();

        $bookings = Booking::whereHas('room.hotel', function ($query) use ($adminId){
            $query->where('admin_id', $adminId);
        })->with('room.hotel', 'payment_method')->get();

        return view('admin.bookings', compact('bookings'));
    }

    public function showBookingForm($id)
    {
        $booking = Booking::findOrFail($id);
        $payment_methods = DB::table('payment_methods')->get();

        return view('admin.booking', compact('booking', 'payment_methods'));
    }

    public function edit(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->user_name = $request->input('user_name');
        $booking->user_contact = $request->input('user_contact');
        $booking->check_in_date = $request->input('check_in_date');
        $booking->check_out_date = $request->input('check_out_date');
        $booking->guests = $request->input('guests');
        $booking->payment_method_id = $request->input('payment_method_id');
        $booking->payment_confirm = $request->input('payment_confirm');

        $booking->save();

        return redirect()->back()->with('status', 'Бронювання оновлено!');
    }

    public function delete($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->delete();

        return redirect()->route('admin.bookings.show')->with('status', 'Бронювання видалено!');
    }

}
