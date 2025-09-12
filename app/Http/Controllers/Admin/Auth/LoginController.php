<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        $barangays = Admin::getBarangays();
        return view('admin.auth.login', compact('barangays'));
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        // Get available barangays for validation
        $barangayKeys = array_keys(Admin::getBarangays());
        
        // Validate the request inputs
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            ],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol (@$!%*?&).',
            'password.min' => 'Password must be at least 8 characters long.',
            'barangay_role.required' => 'Please select your barangay role.',
            'barangay_role.in' => 'Please select a valid barangay from the list.',
        ]);

        // Find admin by email AND barangay role
        $admin = Admin::where('email', $request->email)
                     ->where('barangay_role', $request->barangay_role)
                     ->first();

        if ($admin && $admin->checkPassword($request->password)) {
            // Login the admin manually using the admin guard
            Auth::guard('admin')->login($admin);
            
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            
            return redirect()->route('admin.dashboard')->with('success', 
                'Welcome back! You are logged in as admin for ' . $admin->barangay_name . ' Barangay.');
        }

        // Check if user exists with email but wrong barangay role
        $adminWithEmail = Admin::where('email', $request->email)->first();
        if ($adminWithEmail && $adminWithEmail->barangay_role !== $request->barangay_role) {
            return back()->with('error', 'Invalid credentials. The email and barangay role combination is incorrect.')
                        ->withInput($request->only('email', 'barangay_role'));
        }

        // Return back with a generic error if login fails
        return back()->with('error', 'Invalid credentials. Please check your email, barangay role, and password.')
                    ->withInput($request->only('email', 'barangay_role'));
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been successfully logged out.');
    }
}