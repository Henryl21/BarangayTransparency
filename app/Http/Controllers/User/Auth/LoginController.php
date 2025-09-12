<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // your login blade
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('user')->attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('user.dashboard')); // 👈 fixed
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

public function logout(Request $request)
{
    Auth::guard('user')->logout(); // 👈 logout using user guard
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('user.login');
}
}