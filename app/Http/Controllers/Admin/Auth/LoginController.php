<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        $barangays = Admin::getBarangays();

        // Optional CAPTCHA if too many attempts
        $requireCaptcha = false;
        if (request()->has('email') && $this->hasTooManyLoginAttempts(request())) {
            $requireCaptcha = true;
        }

        return view('admin.auth.login', compact('barangays', 'requireCaptcha'));
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        // Lockout check before validation
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $barangayKeys = array_keys(Admin::getBarangays());

        $rules = [
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8'],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ];

        if ($this->hasTooManyLoginAttempts($request)) {
            $rules['captcha'] = 'required|captcha';
        }

        $request->validate($rules, [
            'barangay_role.required' => 'Please select your barangay.',
            'barangay_role.in' => 'Please select a valid barangay from the list.',
            'captcha.required' => 'Please complete the CAPTCHA verification.',
            'captcha.captcha' => 'CAPTCHA verification failed. Please try again.',
        ]);

        // Find admin by email and barangay
        $admin = Admin::where('email', $request->email)
            ->whereRaw('LOWER(barangay_role) = ?', [strtolower($request->barangay_role)])
            ->first();

        if (!$admin) {
            $this->incrementLoginAttempts($request);
            return back()->withErrors([
                'email' => 'No admin found with these details. Please check your email and barangay.',
            ])->withInput($request->only('email', 'barangay_role'));
        }

        if (!Hash::check($request->password, $admin->password)) {
            $this->incrementLoginAttempts($request);

            $attemptsLeft = $this->retriesLeft($request);
            $errorMessage = 'Incorrect password.';

            if ($attemptsLeft > 0) {
                $errorMessage .= " You have {$attemptsLeft} attempt(s) remaining.";
            }

            return back()->withErrors([
                'password' => $errorMessage,
            ])->withInput($request->only('email', 'barangay_role'));
        }

        // Rehash old passwords if needed
        if (Hash::needsRehash($admin->password)) {
            $admin->password = Hash::make($request->password);
            $admin->save();
        }

        $this->clearLoginAttempts($request);

        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with(
            'success',
            'Welcome back, ' . $admin->name . '! You are logged in as Admin of ' . ucfirst($admin->barangay_role) . ' Barangay.'
        );
    }

    /**
     * Logout the admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been successfully logged out.');
    }

    // ============================================================
    // == RATE LIMITING HELPERS (3 attempts → 60s lockout) ==
    // ============================================================

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    protected function hasTooManyLoginAttempts(Request $request): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request), 3);
    }

    /**
     * Increment failed login attempts.
     * Keeps 60s countdown stable.
     */
    protected function incrementLoginAttempts(Request $request): void
    {
        $key = $this->throttleKey($request);
        $maxAttempts = 3;
        $decaySeconds = 60; // lockout duration

        RateLimiter::hit($key, $decaySeconds);
    }

    protected function clearLoginAttempts(Request $request): void
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    protected function retriesLeft(Request $request): int
    {
        return RateLimiter::retriesLeft($this->throttleKey($request), 3);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        // ✅ Ensure countdown stays in range (fixes 988874s bug)
        if ($seconds <= 0 || $seconds > 60) {
            $seconds = 60;
        }

        throw ValidationException::withMessages([
            'email' => ["Too many login attempts. Please try again in {$seconds} second(s)."],
        ])->status(429);
    }
}
