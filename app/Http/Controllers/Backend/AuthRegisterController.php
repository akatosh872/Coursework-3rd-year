<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
     * Повертає сторінку входа до акаунту
     *
     * @return Application|Factory|View
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Вихід з акаунту
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function logout()
    {
        auth('admin')->logout();
        return redirect('admin');
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
