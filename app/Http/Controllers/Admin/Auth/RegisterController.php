<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $barangays = Admin::getBarangays();
        return view('admin.auth.register', compact('barangays'));
    }

    public function register(Request $request)
    {
        // Get available barangays for validation
        $barangayKeys = array_keys(Admin::getBarangays());
        
        // Validate input including profile_photo file and barangay role
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            ],
            'barangay_role' => ['required', Rule::in($barangayKeys)],
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol (@$!%*?&).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'barangay_role.required' => 'Please select a barangay role.',
            'barangay_role.in' => 'Please select a valid barangay from the list.',
        ]);

        // Check if barangay role is already taken
        $existingAdmin = Admin::where('barangay_role', $request->barangay_role)->first();
        if ($existingAdmin) {
            return back()->withErrors([
                'barangay_role' => 'This barangay already has an assigned admin. Please choose a different barangay.'
            ])->withInput();
        }

        $profilePhotoPath = null;

        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('admin_profiles', 'public');
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Will be automatically hashed by the model
            'barangay_role' => $request->barangay_role,
            'profile_photo' => $profilePhotoPath,
        ]);

        // Log in the admin after registration
        Auth::guard('admin')->login($admin);

        // Redirect to dashboard with success message
        return redirect()->route('admin.dashboard')->with('success', 
            'Registration successful! Welcome, ' . $admin->name . '. You are now the admin for ' . $admin->barangay_name . ' Barangay.');
    }
}