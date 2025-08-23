<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        // Validate input including profile_photo file
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'profile_photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        $profilePhotoPath = null;

        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('admin_profiles', 'public');
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo' => $profilePhotoPath,
        ]);

        // Log in the admin after registration
        Auth::guard('admin')->login($admin);

        // Redirect to dashboard or wherever after login
        return redirect()->route('admin.dashboard');
    }
}
