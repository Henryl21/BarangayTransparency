<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BarangayAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated as admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();
        
        // Ensure admin has a barangay role assigned
        if (!$admin->barangay_role) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'No barangay role assigned to your account.']);
        }

        // Add the admin's barangay to the request for easy access in controllers
        $request->merge(['current_barangay' => $admin->barangay_role]);
        
        return $next($request);
    }
}