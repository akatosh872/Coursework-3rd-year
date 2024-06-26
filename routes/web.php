<?php

use App\Http\Controllers\Backend\RoomController as BackRoom;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRegisterController as UserAuth;
use App\Http\Controllers\Backend\AuthRegisterController as BackAuth;
use App\Http\Controllers\Backend\HotelController as BackHotel;
use App\Http\Controllers\HotelController as UserHotel;
use App\Http\Controllers\RoomController as UserRoom;
use App\Http\Controllers\BookingController as UserBooking;
use App\Http\Controllers\Backend\BookingController as BackBooking;
use App\Http\Controllers\Backend\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $hotels = Hotel::all();
    return view('home', compact('hotels'));
})->name('home');

Route::post('logout', [UserAuth::class, 'logout'])->name('logout');

Route::get('/hotels', [UserHotel::class, 'showHotelsForm'])->name('hotels.list');
Route::get('/hotels/search', [UserHotel::class, 'search'])->name('hotels.search');
Route::get('/hotel/{id}', [UserHotel::class, 'showHotelForm'])->name('hotel.details');

Route::get('/rooms', [UserRoom::class, 'showRoomsForm'])->name('rooms.list');
Route::get('/rooms/search', [UserRoom::class, 'search'])->name('rooms.search');
Route::get('/room/{id}', [UserRoom::class, 'showRoomForm'])->name('room.details');
Route::post('/room/{id}', [UserRoom::class, 'storeReview'])->name('room.storeReview');

Route::middleware(['guest:web'])->group(function () {
    Route::get('register', [UserAuth::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [UserAuth::class, 'register']);

    Route::get('login', [UserAuth::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserAuth::class, 'login']);
});

Route::middleware(['auth:web'])->group(function () {
    Route::post('/booking', [UserBooking::class, 'create'])->name('booking.store');
    Route::get('/booking/{bookingId}/payment', [UserBooking::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{bookingId}/payment', [UserBooking::class, 'paymentConfirm'])->name('payment.confirm');

    Route::get('/personal-cabinet', [UserAuth::class, 'showPersonalCabinet'])->name('personal.cabinet');
});



Route::prefix('admin')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('login', [BackAuth::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [BackAuth::class, 'login']);
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', function () {
            return view('admin.home');
        })->name('admin.home');

        Route::post('logout', [BackAuth::class, 'logout'])->name('admin.logout');

        Route::get('hotels', [BackHotel::class, 'showHotelsView'])->name('admin.hotels.list');

        Route::get('hotel/create', [BackHotel::class, 'showCreateHotelForm'])->name('admin.hotel-create');
        Route::post('hotel/create', [BackHotel::class, 'createHotel'])->name('admin.hotel.store');

        Route::get('hotel/{id}', [BackHotel::class, 'showHotelForm'])->name('admin.hotel.details');
        Route::put('hotel/{id}', [BackHotel::class, 'update'])->name('admin.hotel.update');
        Route::delete('hotel/{id}', [BackHotel::class, 'deleteHotel'])->name('admin.hotel.delete');

        Route::post('hotels/{hotelId}/rooms', [BackRoom::class, 'create'])->name('admin.hotel.rooms.create');
        Route::get('hotel/{hotel}/rooms/{room}', [BackRoom::class, 'showRoomForm'])->name('admin.hotel.rooms.show');
        Route::put('hotel/{hotel}/rooms/{room}', [BackRoom::class, 'update'])->name('admin.hotel.rooms.update');
        Route::post('hotel/rooms/{room}/photos/{photo}/delete', [BackRoom::class, 'deletePhoto'])->name('admin.hotel.rooms.photos.delete');

        Route::get('bookings', [BackBooking::class, 'showBookingsForm'])->name('admin.bookings.list');
        Route::delete('bookings/{id}', [BackBooking::class, 'delete'])->name('admin.booking.delete');

        Route::get('booking/{id}', [BackBooking::class, 'showBookingForm'])->name('admin.booking.details');
        Route::put('booking/{id}', [BackBooking::class, 'edit'])->name('admin.booking.edit');

        Route::get('reviews', [ReviewController::class, 'showReviewsForm'])->name('admin.reviews.list');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.delete');
        Route::patch('reviews/{review}', [ReviewController::class, 'update'])->name('admin.reviews.update');
    });
});
