<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    public function showResetPasswordForm(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        Log::info("ResetPasswordForm: Loaded for email={$email} token={$token}");

        if (!$email || !$token) {
            Log::warning("ResetPasswordForm: Missing email or token");
            return redirect()->route('admin.forgot.password')
                ->withErrors(['email' => 'Invalid or missing password reset link.']);
        }

        return view('admin.auth.reset-password', [
            'email' => $email,
            'token' => $token,
        ]);
    }

    public function resetPassword(Request $request)
    {
        Log::info("Admin ResetPassword: Attempting reset for {$request->input('email')}");

        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $request->input('email');
        $token = $request->input('token');

        try {
            $record = DB::table('password_resets')->where('email', $email)->first();

            if (!$record) {
                Log::error("ResetPassword: No password reset record found for {$email}");
                return back()->withErrors(['email' => 'Invalid password reset request.']);
            }

            if (!Hash::check($token, $record->token)) {
                Log::error("ResetPassword: Token mismatch for {$email}");
                return back()->withErrors(['email' => 'Invalid password reset token.']);
            }

            if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
                Log::warning("ResetPassword: Token expired for {$email}");
                return back()->withErrors(['email' => 'Password reset link expired. Please request a new one.']);
            }

            $admin = Admin::where('email', $email)->first();
            $admin->password = Hash::make($request->password);
            $admin->save();

            DB::table('password_resets')->where('email', $email)->delete();

            Log::info("ResetPassword: Password successfully reset for {$email}");

            return redirect()->route('admin.login')
                ->with('success', 'Your password has been reset successfully!');

        } catch (\Exception $e) {
            Log::error("Admin password reset error: " . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to reset password. Please try again later.']);
        }
    }
}
