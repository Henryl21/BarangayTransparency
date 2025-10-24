<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show user profile.
     */
    public function show()
    {
        $user = Auth::guard('user')->user();
        return view('user.profile.show', compact('user'));
    }

    /**
     * Show edit form.
     */
    public function edit()
    {
        $user = Auth::guard('user')->user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update profile.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('user')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('user.profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete account.
     */
    public function destroy()
    {
        $user = Auth::guard('user')->user();
        Auth::guard('user')->logout();
        $user->delete();

        return redirect()->route('user.login')->with('success', 'Your account has been deleted.');
    }
}
