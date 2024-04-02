<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRegisterController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Обробка запиту на вхід адміністратора.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin');
        }

        // Невдала аутентифікація, повернення на сторінку входу з помилкою
        return redirect()->back()->withErrors(['email' => 'Невірна електронна пошта або пароль']);
    }
}
