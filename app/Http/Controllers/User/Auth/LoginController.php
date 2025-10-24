<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    /**
     * Show the user login form.
     */
    public function showLoginForm()
    {
        $barangays = User::getBarangays(); // ✅ List of barangays
        return view('user.login', compact('barangays'));
    }

    /**
     * Handle user login request.
     */
    public function login(Request $request)
    {
        // ✅ Collect valid barangay keys
        $barangayKeys = array_keys(User::getBarangays());

        // ✅ Validate form input
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:6'],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ], [
            'barangay_role.required' => 'Please select your barangay.',
            'barangay_role.in' => 'Please select a valid barangay from the list.',
        ]);

        // ✅ Find user by email and barangay (case-insensitive)
        $user = User::where('email', $request->email)
            ->whereRaw('LOWER(barangay_role) = ?', [strtolower($request->barangay_role)])
            ->first();

        // ❌ No matching user found
        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with these details. Please check your email and barangay.',
            ])->withInput($request->only('email', 'barangay_role'));
        }

        // ✅ Manually check password hash
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password. Please try again.',
            ])->withInput($request->only('email', 'barangay_role'));
        }

        // ✅ If hash algorithm changed, rehash automatically
        if (Hash::needsRehash($user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // ✅ Log user in
        Auth::guard('user')->login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')->with('success',
            'Welcome back, ' . $user->full_name . '! You are logged in as a resident of ' . ucfirst($user->barangay_role) . ' Barangay.'
        );
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')->with('status', 'You have been successfully logged out.');
    }
}
