<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRegisterController extends Controller
{
    public function showRegistrationForm ()
    {
        return view('register');
    }
    public function showLoginForm ()
    {
        return view('login');
    }

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
        // Валідація даних форми
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:50|confirmed',
        ]);

        // Створення нового користувача
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Автентифікація нового користувача
        auth()->login($user);

        // Перенаправлення після успішної реєстрації
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
}
