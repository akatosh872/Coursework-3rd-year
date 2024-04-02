<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRegisterController as UserAuth;
use App\Http\Controllers\Backend\AuthRegisterController as BackAuth;

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
});

Route::get('register', [UserAuth::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserAuth::class, 'register']);

Route::get('login', [UserAuth::class, 'showLoginForm'])->name('login');
Route::post('login', [UserAuth::class, 'login']);



Route::prefix('admin')->group(function () {
    Route::get('login', [BackAuth::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [BackAuth::class, 'login']);
});

//Route::middleware(['auth'])->group(function () {
//    // ваші маршрути для користувачів
//});
//
//// Маршрути для адміністраторів
//Route::middleware(['auth', 'admin'])->group(function () {
//    // ваші маршрути для адміністраторів
//});
