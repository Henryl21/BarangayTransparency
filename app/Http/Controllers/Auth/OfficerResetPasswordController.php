<?php

namespace App\Http\Controllers\Officer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\OfficerUser;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for resetting the officer's password.
     */
    public function showResetForm(Request $request)
    {
        // Ensure the token and email are valid
        $token = $request->get('token');
        $email = $request->get('email');

        // Check if a valid reset token exists for the given email
        $passwordReset = DB::table('officer_password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            // Token is invalid or expired
            return redirect()->route('officer.forgot.password')
                ->withErrors(['email' => 'This password reset token is invalid or expired.']);
        }

        return view('officer.auth.reset-password', compact('token', 'email'));
    }

    /**
     * Handle the password reset process.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:officer_users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Check if the token is valid
        $passwordReset = DB::table('officer_password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return redirect()->route('officer.forgot.password')
                ->withErrors(['email' => 'This password reset token is invalid or expired.']);
        }

        // Ensure the token is not expired (based on the created_at timestamp)
        $tokenExpiry = $passwordReset->created_at->addMinutes(config('auth.passwords.officers.expire'));
        if (now()->gt($tokenExpiry)) {
            return redirect()->route('officer.forgot.password')
                ->withErrors(['email' => 'This password reset token has expired.']);
        }

        // Update the officer's password
        $officer = OfficerUser::where('email', $request->email)->first();
        $officer->password = Hash::make($request->password);
        $officer->save();

        // Delete the reset token after it’s been used
        DB::table('officer_password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('officer.login')
            ->with('status', 'Your password has been reset successfully!');
    }
}
