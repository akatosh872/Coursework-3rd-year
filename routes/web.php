<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRegisterController as UserAuth;
use App\Http\Controllers\Backend\AuthRegisterController as BackAuth;
use App\Http\Controllers\Backend\HotelController as BackHotel;
use App\Http\Controllers\HotelController as UserHotel;

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

Route::get('hotels', [UserHotel::class, 'showHotelsForm'])->name('hotels.show');

Route::post('logout', [UserAuth::class, 'logout'])->name('logout');

Route::middleware(['guest:web'])->group(function () {
    Route::get('register', [UserAuth::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [UserAuth::class, 'register']);

    Route::get('login', [UserAuth::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserAuth::class, 'login']);
});



Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.welcome');
        });

        Route::get('login', [BackAuth::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [BackAuth::class, 'login']);

        Route::post('logout', [BackAuth::class, 'logout'])->name('admin.logout');

        Route::get('hotel/create', [BackHotel::class, 'showCreateHotelForm'])->name('admin.hotel_create');
        Route::post('hotel/create', [BackHotel::class, 'createHotel'])->name('admin.hotel.store');

        Route::get('hotel/{id}', [BackHotel::class, 'showHotelForm'])->name('hotel.show');
        Route::put('hotel/{id}', [BackHotel::class, 'update'])->name('hotel.update');
});
