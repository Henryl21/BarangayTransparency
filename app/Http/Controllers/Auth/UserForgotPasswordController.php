<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;  // Use User model for normal users
use App\Services\PHPMailerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('user.forget-pass');
    }

    /**
     * Handle sending the reset password link to user email.
     */
    public function sendResetLink(Request $request, PHPMailerService $mailer)
    {
        // Validate email only (no 'exists' here — we check it manually)
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = trim($request->email);

        // Check if user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'This email is not registered.']);
        }

        // Generate token
        $token = Str::random(64);
        $hashedToken = Hash::make($token);

        // Store token in user_password_resets table
        DB::table('user_password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $hashedToken,
                'created_at' => now(),
            ]
        );

        // Create reset link with email and raw token (use correct route name)
        $resetLink = route('user.reset.password.form', [
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
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return view('user.reset-password', compact('token', 'email'));
    }

    /**
     * Handle the password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('user_password_resets')
            ->where('email', $request->email)
            ->latest()
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Update the user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Remove used reset token
        DB::table('user_password_resets')->where('email', $request->email)->delete();

        return redirect()->route('user.login')->with('success', 'Your password has been reset. You can now log in.');
    }
}
