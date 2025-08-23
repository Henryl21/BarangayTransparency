<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();

        // If logged in as admin
        if (Auth::guard('admin')->check()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // If logged in as normal user
        if (Auth::guard('web')->check()) {
            return redirect()->intended(route('user.dashboard', absolute: false));
        }

        // Default fallback (in case guard is unknown)
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout from default guard
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
