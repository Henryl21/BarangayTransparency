<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Show the user registration form.
     */
    public function showRegisterForm()
    {
        $barangays = User::getBarangays();
        return view('user.register', compact('barangays'));
    }

    /**
     * Handle registration (no OTP verification).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'number'        => 'required|string|max:20',
            'age'           => 'required|integer|min:1',
            'birthdate'     => 'required|date',
            'email'         => 'required|email|unique:users,email',
            'password'      => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // must contain lowercase
                'regex:/[A-Z]/',      // must contain uppercase
                'regex:/[0-9]/',      // must contain number
                'regex:/[@$!%*?&]/',  // must contain special char
            ],
            'barangay_role' => ['required', Rule::in(array_keys(User::getBarangays()))],
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ Handle photo upload
        $profilePhotoName = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhotoName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
            $request->file('profile_photo')->storeAs('profile_photos', $profilePhotoName, 'public');
        }

        // ✅ Create user (auto-verified)
        $user = User::create([
            'full_name'           => $validated['full_name'],
            'number'              => $validated['number'],
            'age'                 => $validated['age'],
            'birthdate'           => $validated['birthdate'],
            'email'               => $validated['email'],
            'password'            => Hash::make($validated['password']),
            'barangay_role'       => $validated['barangay_role'],
            'profile_photo'       => $profilePhotoName,
            'password_changed_at' => now(),
            'is_verified'         => true, // ✅ auto-verified
        ]);

        // ✅ (Optional) Auto-login user after registration
        // Auth::guard('user')->login($user);

        // ✅ Redirect to login with success message
        return redirect()->route('user.login')->with('success', 'Account created successfully! You can now log in.');
    }
}
