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

/**
 * User Login Controller
 *
 * oData Minimization: Only collect and store data necessary for functionality
 * and purge old data regularly. (NEEDS OF DATA DISPLAY)
 *
 * oProtect Personal Data (DPA OF 2012 Compliance):
 * Ensure all data collection, processing, and storage comply with
 * Republic Act No. 10173 (Data Privacy Act of 2012) and protect user data
 * from unauthorized access, misuse, or disclosure. (TERMS AND CONDITION)
 *
 * Only the following data is used:
 * - Email
 * - Password (hashed)
 * - Barangay_role
 */
class LoginController extends Controller
{
    /**
     * Show the user login form.
     *
     * oData Minimization: Only pass necessary data (barangay list) to view.
     * oProtect Personal Data (DPA OF 2012 Compliance): Ensure no sensitive
     * user data is exposed during view rendering.
     */
    public function showLoginForm()
    {
        $barangays = User::getBarangays(); // Only fetching barangay names, minimal data
        return view('user.login', compact('barangays'));
    }

    /**
     * Handle user login request.
     *
     * oData Minimization: Only store and use email, password, and barangay_role.
     * oProtect Personal Data (DPA OF 2012 Compliance):
     * Validate and process login securely to ensure user data privacy and integrity.
     */
    public function login(Request $request)
    {
        // Check if user is temporarily locked out
        if ($this->isLockedOut($request)) {
            return $this->sendLockoutResponse($request);
        }

        $barangayKeys = array_keys(User::getBarangays());

        // Validate login inputs
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8'],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ], [
            'barangay_role.required' => 'Please select your barangay.',
            'barangay_role.in' => 'Please select a valid barangay.',
        ]);

        // Retrieve user with minimal data access
        $user = User::where('email', $request->email)
            ->whereRaw('LOWER(barangay_role) = ?', [strtolower($request->barangay_role)])
            ->first();

        // Handle user not found
        if (!$user) {
            $this->incrementLoginAttempts($request);
            return back()->withErrors([
                'email' => 'No account found with these details. Please check your email and barangay.',
            ])->withInput($request->only('email', 'barangay_role'));
        }

        // Check password securely
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

        // Correct password — clear attempts
        $this->clearLoginAttempts($request);

        // Auto-rehash old passwords if needed
        if (Hash::needsRehash($user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Authenticate user
        Auth::guard('user')->login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')->with(
            'success',
            'Welcome back, ' . $user->full_name . '! You are logged in as a resident of ' . ucfirst($user->barangay_role) . '.'
        );
    }

    /**
     * Logout user.
     *
     * oData Minimization: Clear session data to remove sensitive info.
     * oProtect Personal Data (DPA OF 2012 Compliance):
     * Session and personal data are securely destroyed upon logout.
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

    /**
     * Generate lockout key for user/IP combination.
     *
     * oProtect Personal Data: Avoid storing sensitive info in cache keys.
     */
    protected function lockoutKey(Request $request): string
    {
        return 'login_lockout_' . sha1($request->ip() . '|' . strtolower($request->input('email')));
    }

    /**
     * Generate login attempt key.
     *
     * oData Minimization: Use hashed identifiers to prevent data exposure.
     */
    protected function attemptKey(Request $request): string
    {
        return 'login_attempts_' . sha1($request->ip() . '|' . strtolower($request->input('email')));
    }

    /**
     * Increment failed login attempts.
     *
     * oProtect Personal Data: Do not log sensitive credentials.
     */
    protected function incrementLoginAttempts(Request $request): void
    {
        $attemptKey = $this->attemptKey($request);
        $lockoutKey = $this->lockoutKey($request);

        $attempts = Cache::get($attemptKey, 0) + 1;
        Cache::put($attemptKey, $attempts, 60); // reset after 60 seconds

        if ($attempts >= 3) {
            $lockoutEndsAt = now()->addSeconds(60)->timestamp;
            Cache::put($lockoutKey, $lockoutEndsAt, 60); // lockout for 60s
            Cache::forget($attemptKey); // reset attempts
        }
    }

    /**
     * Determine if the user is locked out.
     */
    protected function isLockedOut(Request $request): bool
    {
        $lockoutTimestamp = Cache::get($this->lockoutKey($request));
        return $lockoutTimestamp && time() < $lockoutTimestamp;
    }

    /**
     * Clear all login attempts.
     *
     * oData Minimization: Remove temporary data after use.
     */
    protected function clearLoginAttempts(Request $request): void
    {
        Cache::forget($this->attemptKey($request));
        Cache::forget($this->lockoutKey($request));
    }

    /**
     * Calculate retries left before lockout.
     */
    protected function retriesLeft(Request $request): int
    {
        $attempts = Cache::get($this->attemptKey($request), 0);
        return max(0, 3 - $attempts);
    }

    /**
     * Send a lockout response with remaining wait time.
     *
     * oProtect Personal Data: Provide user feedback without exposing security logic.
     */
    protected function sendLockoutResponse(Request $request)
    {
        $lockoutTimestamp = Cache::get($this->lockoutKey($request));
        $seconds = $lockoutTimestamp ? $lockoutTimestamp - time() : 60;

        if ($seconds <= 0 || $seconds > 60) {
            $seconds = 60; // ensure safe countdown
        }

        throw ValidationException::withMessages([
            'email' => ["Too many login attempts. Please try again in {$seconds} second(s)."],
        ])->status(429);
    }
}
