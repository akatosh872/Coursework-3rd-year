<?php

use App\Http\Controllers\Backend\RoomController as BackRoom;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRegisterController as UserAuth;
use App\Http\Controllers\Backend\AuthRegisterController as BackAuth;
use App\Http\Controllers\Backend\HotelController as BackHotel;
use App\Http\Controllers\HotelController as UserHotel;
use App\Http\Controllers\RoomController as UserRoom;

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
    return view('welcome');
})->name('welcome');

Route::post('logout', [UserAuth::class, 'logout'])->name('logout');
Route::get('hotels', [UserHotel::class, 'showHotelsForm'])->name('hotels.show');
Route::get('/hotels/search', [UserHotel::class, 'search'])->name('hotels.search');
Route::get('hotel/{id}', [UserHotel::class, 'showHotelForm'])->name('hotel.show');

Route::get('/rooms', [UserRoom::class, 'showRoomsForm'])->name('rooms.show');
Route::get('/rooms/search', [UserRoom::class, 'search'])->name('rooms.search');
Route::get('/room/{id}', [UserRoom::class, 'showRoomForm'])->name('room.show');


Route::middleware(['guest:web'])->group(function () {
    Route::get('register', [UserAuth::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [UserAuth::class, 'register']);

    Route::get('login', [UserAuth::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserAuth::class, 'login']);
});



Route::prefix('admin')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('login', [BackAuth::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [BackAuth::class, 'login']);
    });
        Route::get('/', function () {
            return view('admin.welcome');
        })->name('admin.welcome');

        Route::post('logout', [BackAuth::class, 'logout'])->name('admin.logout');

        Route::get('hotels', [BackHotel::class, 'showHotelsView'])->name('admin.hotels.show');

        Route::get('hotel/create', [BackHotel::class, 'showCreateHotelForm'])->name('admin.hotel_create');
        Route::post('hotel/create', [BackHotel::class, 'createHotel'])->name('admin.hotel.store');

        Route::get('hotel/{id}', [BackHotel::class, 'showHotelForm'])->name('admin.hotel.show');
        Route::put('hotel/{id}', [BackHotel::class, 'update'])->name('admin.hotel.update');
        Route::delete('hotel/{id}', [BackHotel::class, 'deleteHotel'])->name('admin.hotel.delete');

        Route::post('hotels/{hotelId}/rooms', [BackRoom::class, 'create'])->name('admin.hotel.rooms.create');
        Route::get('hotel/{hotel}/rooms/{room}', [BackRoom::class, 'showHotelForm'])->name('admin.hotel.rooms.show');
        Route::put('hotel/{hotel}/rooms/{room}', [BackRoom::class, 'update'])->name('admin.hotel.rooms.update');
});
