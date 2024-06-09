<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment_method;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Повертає для адиіна всі бронювання в його готелях
     *
     * @return Application|Factory|View
     */
    public function showBookingsForm()
    {
        $adminId = auth('admin')->id();

        $bookings = Booking::whereHas('room.hotel', function ($query) use ($adminId){
            $query->where('admin_id', $adminId);
        })->with('room.hotel', 'payment_method')->get();

        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Повертає сторінку бронювання за id
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function showBookingForm($id)
    {
        $booking = Booking::findOrFail($id);
        $payment_methods = Payment_method::all();

        return view('admin.booking', compact('booking', 'payment_methods'));
    }

    /**
     * Модифікація бронювання адміном
     * Валідацію не реалізовано через бізнес-логіку функціоналу
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function edit(Request $request, $id): RedirectResponse
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

    /**
     * Видаленя бронювання за id. До бронювання не прив'язано каскадне видалення
     *
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        $booking->delete();

        return redirect()->route('admin.bookings.list')->with('status', 'Бронювання видалено!');
    }

}
