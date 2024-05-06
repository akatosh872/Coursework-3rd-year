<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $booking = new Booking();

        $booking->room_id = $request->input('room_id');
        $booking->user_id = $request->input('user_id');
        $booking->user_name = $request->input('user_name');
        $booking->user_contact = $request->input('user_contact');
        $booking->check_in_date = $request->input('check_in_date');
        $booking->check_out_date = $request->input('check_out_date');
        $booking->guests = $request->input('guests');
        $booking->payment_method_id = $request->input('payment_method_id');

        $booking->save();

        return redirect()->route('booking.payment', ['bookingId' => $booking->id]);
    }

    public function payment($bookingId)
    {
        $booking = Booking::with('room')->find($bookingId);

        return view('payment', compact('booking'));
    }

    public function paymentConfirm(Request $request,$bookingId)
    {
        $booking = Booking::find($bookingId);
        $booking->payment_confirm = 1;
        $booking->save();

        return redirect()->route('room.show', ['id'=>$booking->room_id])->with('status', 'Номер зарезервовано!!');
    }
}
