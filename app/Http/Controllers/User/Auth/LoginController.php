<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the user login form.
     */
    public function showLoginForm()
    {
        $barangays = User::getBarangays();
        return view('user.login', compact('barangays'));
    }

    /**
     * Handle user login request.
     */
    public function login(Request $request)
    {
        // Check if locked out
        if ($this->isLockedOut($request)) {
            return $this->sendLockoutResponse($request);
        }

        $barangayKeys = array_keys(User::getBarangays());

        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8'],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ], [
            'barangay_role.required' => 'Please select your barangay.',
            'barangay_role.in' => 'Please select a valid barangay.',
        ]);

        $user = User::where('email', $request->email)
            ->whereRaw('LOWER(barangay_role) = ?', [strtolower($request->barangay_role)])
            ->first();

        if (!$user) {
            $this->incrementLoginAttempts($request);
            return back()->withErrors([
                'email' => 'No account found with these details. Please check your email and barangay.',
            ])->withInput($request->only('email', 'barangay_role'));
        }

        if (!Hash::check($request->password, $user->password)) {
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

        // Password correct → reset attempt counter
        $this->clearLoginAttempts($request);

        // Rehash old passwords if necessary
        if (Hash::needsRehash($user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        Auth::guard('user')->login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')->with(
            'success',
            'Welcome back, ' . $user->full_name . '! You are logged in as a resident of ' . ucfirst($user->barangay_role) . '.'
        );
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')->with('status', 'You have been successfully logged out.');
    }

    // ============================================================
    // == CUSTOM RATE LIMIT (3 attempts then 60s lockout) ==
    // ============================================================

    protected function lockoutKey(Request $request): string
    {
        return 'login_lockout_' . sha1($request->ip() . '|' . strtolower($request->input('email')));
    }

    protected function attemptKey(Request $request): string
    {
        return 'login_attempts_' . sha1($request->ip() . '|' . strtolower($request->input('email')));
    }

    protected function incrementLoginAttempts(Request $request): void
    {
        $attemptKey = $this->attemptKey($request);
        $lockoutKey = $this->lockoutKey($request);

        $attempts = Cache::get($attemptKey, 0) + 1;
        Cache::put($attemptKey, $attempts, 60); // attempts reset after 60 seconds

        if ($attempts >= 3) {
            // store lockout end timestamp (fixed bug)
            $lockoutEndsAt = now()->addSeconds(60)->timestamp;
            Cache::put($lockoutKey, $lockoutEndsAt, 60); // lockout lasts 60s
            Cache::forget($attemptKey); // reset attempts after lockout starts
        }
    }

    protected function isLockedOut(Request $request): bool
    {
        $lockoutTimestamp = Cache::get($this->lockoutKey($request));
        return $lockoutTimestamp && time() < $lockoutTimestamp;
    }

    protected function clearLoginAttempts(Request $request): void
    {
        Cache::forget($this->attemptKey($request));
        Cache::forget($this->lockoutKey($request));
    }

    protected function retriesLeft(Request $request): int
    {
        $attempts = Cache::get($this->attemptKey($request), 0);
        return max(0, 3 - $attempts);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $lockoutTimestamp = Cache::get($this->lockoutKey($request));
        $seconds = $lockoutTimestamp ? $lockoutTimestamp - time() : 60;

        if ($seconds <= 0 || $seconds > 60) {
            $seconds = 60; // ensure valid countdown
        }

        throw ValidationException::withMessages([
            'email' => ["Too many login attempts. Please try again in {$seconds} second(s)."],
        ])->status(429);
    }
}
