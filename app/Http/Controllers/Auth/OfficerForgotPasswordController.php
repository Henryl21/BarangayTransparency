<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OfficerUser;
use App\Services\PHPMailerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OfficerForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('officer.auth.forgot-pass');
    }

    /**
     * Handle sending the reset password link to officer email.
     */
    public function sendResetLink(Request $request, PHPMailerService $mailer)
    {
        // Validate email only (no 'exists' here — we check it manually)
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = trim($request->email);

        // Check if officer user exists
        $officer = OfficerUser::where('email', $email)->first();
        if (!$officer) {
            return back()->withErrors(['email' => 'This email is not registered as an officer.']);
        }

        // Generate token
        $token = Str::random(64);
        $hashedToken = Hash::make($token);

        // Store token in officer_password_resets table
        DB::table('officer_password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $hashedToken,
                'created_at' => now(),
            ]
        );

        // Create reset link with email and raw token
        $resetLink = route('officer.reset.password', [
            'token' => $token,
            'email' => $email,
        ]);

        try {
            $mailer->sendResetLinkEmail($email, $resetLink);
            return back()->with('success', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            \Log::error('Reset link failed to send: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send the reset link. Please try again later.']);
        }
    }

    /**
     * Show the reset password form with token and email.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('officer.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Handle the password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:officer_users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('officer_password_resets')
            ->where('email', $request->email)
            ->latest()
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Update the officer's password
        $officer = OfficerUser::where('email', $request->email)->first();
        $officer->password = Hash::make($request->password);
        $officer->save();

        // Remove used reset token
        DB::table('officer_password_resets')->where('email', $request->email)->delete();

        return redirect()->route('officer.login')->with('success', 'Your password has been reset. You can now log in.');
    }
}
