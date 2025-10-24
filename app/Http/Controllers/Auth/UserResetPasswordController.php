<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PHPMailerService; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserForgotPasswordController extends Controller
{
    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('user.forget-pass');
    }

    // Handle sending reset link
    public function sendResetLink(Request $request, PHPMailerService $mailer)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = trim($request->email);

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This email is not registered.']);
        }

        // Generate a token
        $token = Str::random(64);
        $hashedToken = Hash::make($token);

        // Store token in password_resets table (default Laravel table)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $hashedToken,
                'created_at' => now(),
            ]
        );

        // Generate reset link
        $resetLink = route('user.reset.password.form', [
            'token' => $token,
            'email' => $email,
        ]);

        try {
            $mailer->sendResetLinkEmail($email, $resetLink);
            return back()->with('success', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            \Log::error('Reset link email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send reset link. Please try again later.']);
        }
    }

    // Show reset password form
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return view('user.reset-password', compact('token', 'email'));
    }

    // Handle password reset submission
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->latest()
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Update user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete reset record after successful reset
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('user.login')->with('success', 'Your password has been reset. You can now log in.');
    }
}
