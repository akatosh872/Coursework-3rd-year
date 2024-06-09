<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    /**
     * Створення нового бронювання. Перед збереженням проводиться валідація форм, зокрема дат заїзду та виїзду
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $booking = new Booking();

        $this->validate($request, [
            'user_name' => 'required|string|max:255',
            'user_contact' => 'required|string|max:255',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'guests' => 'required|integer|min:1|max:10',
            'payment_method_id' => 'required|integer',
        ]);

        $booking->room_id = $request->input('room_id');
        $booking->user_id = $request->input('user_id');
        $booking->user_name = $request->input('user_name');
        $booking->user_contact = $request->input('user_contact');
        $booking->check_in_date = $request->input('check_in_date');
        $booking->check_out_date = $request->input('check_out_date');
        $booking->guests = $request->input('guests');
        $booking->payment_method_id = $request->input('payment_method_id');
        $booking->payment_confirm = 0;

        $booking->save();

        return redirect()->route('booking.payment', ['bookingId' => $booking->id]);
    }

    /**
     * Повертає сторінку оплати
     *
     * @param $bookingId
     * @return Application|Factory|View
     */
    public function payment($bookingId)
    {
        $booking = Booking::with('room')->find($bookingId);

        return view('payment', compact('booking'));
    }

    /**
     * Оплата бронювання. Метод формальний, дані ніде не зберігаються
     * Вайлідація йде на суму оплати
     *
     * @param Request $request
     * @param $bookingId
     * @return RedirectResponse|void
     * @throws ValidationException
     */
    public function paymentConfirm(Request $request, $bookingId)
    {
        $booking = Booking::find($bookingId);
        $this->validate($request, [
            'cardNumber' => 'required',
            'amount' => 'required|numeric|min:'.
                $booking->room->price_per_night, // Мінімальна сума оплати - вартість однієї ночі
        ]);

        if ($request->amount >= $booking->room->price_per_night *
            ($booking->check_out_date - $booking->check_in_date)) {
            $booking->payment_confirm = 1;
            $booking->save();

            return redirect()->route('room.details', ['id' => $booking->room_id])
                ->with('status', 'Номер зарезервовано!!');
        }
    }
}
