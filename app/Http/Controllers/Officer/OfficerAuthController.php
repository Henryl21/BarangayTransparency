<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OfficerAuthController extends Controller
{
    public function showRegister()
    {
        return view('officer.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:officer_users',
            'password' => 'required|string|min:6|confirmed',
            'position' => 'nullable|string|max:255',
        ]);

        $officer = OfficerUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'position' => $request->position,
        ]);

        Auth::guard('officer')->login($officer);

        return redirect()->route('officer.dashboard')->with('success', 'Welcome Officer!');
    }

    public function showLogin()
    {
        return view('officer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('officer')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('officer.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid login credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('officer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('officer.login');
    }
}
