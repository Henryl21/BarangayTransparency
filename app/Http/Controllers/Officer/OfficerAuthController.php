<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\OfficerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OfficerAuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLogin()
    {
        return view('officer.auth.login');
    }

    /**
     * Handle officer login (3-attempt limit + countdown + secure sessions)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'role'     => 'required|string',
        ]);

        $email = strtolower($request->email);
        $ip = $request->ip();
        $key = Str::lower("officer-login:{$email}|{$ip}");

        // Check if user is locked out
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            // Send back error with countdown message
            throw ValidationException::withMessages([
                'email' => "Too many failed attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        // Try to find officer account
        $officer = OfficerUser::where('email', $email)
            ->where('role', $request->role)
            ->first();

        // Validate password
        if ($officer && Hash::check($request->password, $officer->password)) {
            // ✅ Clear login attempts after successful login
            RateLimiter::clear($key);

            // ✅ Login securely
            Auth::guard('officer')->login($officer, $request->boolean('remember'));

            // ✅ Regenerate session to prevent fixation
            $request->session()->regenerate();

            // ✅ Update last login timestamp (optional)
            $officer->update(['last_login_at' => now()]);

            return redirect()->intended(route('officer.dashboard'))
                ->with('success', 'Welcome back, ' . $officer->name . '!');
        }

        // ❌ Failed login — increment attempts
        RateLimiter::hit($key, 60); // lock for 60 seconds after 3 fails

        throw ValidationException::withMessages([
            'email' => 'Invalid email, password, or role. Please try again.',
        ]);
    }

    /**
     * Handle officer logout with full session termination
     */
    public function logout(Request $request)
    {
        Auth::guard('officer')->logout();

        // ✅ Invalidate and regenerate session token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('officer.login')
            ->with('status', 'You have been logged out securely.');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:officer_users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|string|max:255',
        ]);

        $officer = OfficerUser::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::guard('officer')->login($officer);
        $request->session()->regenerate();

        return redirect()->route('officer.dashboard')->with('success', 'Welcome, Officer!');
    }
}
