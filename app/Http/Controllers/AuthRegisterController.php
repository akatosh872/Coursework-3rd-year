<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRegisterController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function showRegistrationForm ()
    {
        return view('register');
    }
    public function showLoginForm ()
    {
        return view('login');
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function logout()
    {
        auth('web')->logout();
        return redirect('/');
    }

    /**
     * Обробка запиту на реєстрацію нового користувача.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:50|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return redirect('/')->with('success', 'Ви успішно зареєстровані!');
    }


    /**
     * Вхід для користувача
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended('/');
        }

        // Невдала аутентифікація, повернення на сторінку входу з помилкою
        return redirect()->back()->withErrors(['email' => 'Невірна електронна пошта або пароль']);
    }

    /**
     * Особистий кабінет для зареєстрованого користувача
     *
     * @return Application|Factory|View
     */
    public function showPersonalCabinet()
    {
        $bookings = Booking::with('room.hotel')->where('user_id', Auth::id())->get();

        return view('personal-cabinet', compact('bookings'));
    }
}
