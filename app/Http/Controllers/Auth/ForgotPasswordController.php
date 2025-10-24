<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\PHPMailerService;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        Log::info("Admin ForgotPassword: Starting for email {$request->input('email')}");

        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $email = $request->input('email');

        try {
            $token = bin2hex(random_bytes(32));
            $hashedToken = Hash::make($token);

            Log::info("Admin ForgotPassword: Generated token for {$email}");

            DB::table('password_resets')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => $hashedToken,
                    'created_at' => now(),
                ]
            );

            Log::info("Admin ForgotPassword: Token saved to DB for {$email}");

            $resetLink = url('/admin/reset-password') . '?email=' . urlencode($email) . '&token=' . urlencode($token);

            Log::info("Admin ForgotPassword: Reset link generated: {$resetLink}");

            $mailer = new PHPMailerService();
            $success = $mailer->sendResetLinkEmail($email, $resetLink);

            if ($success) {
                Log::info("Admin ForgotPassword: Email sent successfully to {$email}");
                return back()->with('success', 'Password reset link has been sent to your email.');
            } else {
                Log::error("Admin ForgotPassword: Failed to send email to {$email}");
                return back()->withErrors(['email' => 'Failed to send reset email. Please try again later.']);
            }

        } catch (\Exception $e) {
            Log::error("Admin ForgotPassword: Exception for {$email} -> " . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to process reset request. Please try again later.']);
        }
    }
}
