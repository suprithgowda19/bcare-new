<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display the Admin Login View.
     */
    public function showLoginForm()
    {
        // If already logged in as admin, skip the login page
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.master.staff.index');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle Admin Login Request.
     */
    public function login(Request $request)
    {
        // 1. Validate Credentials
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt Authentication
        // 'remember' helps keep the admin logged in across browser sessions
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            $user = Auth::user();

            // 3. SECURE CHECK: Is this user actually an Admin?
            if ($user->hasRole('admin')) {
                // Regenerate session to prevent Session Fixation attacks
                $request->session()->regenerate();

                return redirect()->intended(route('admin.master.staff.index'))
                    ->with('success', 'Logged in to Admin Panel successfully.');
            }

            // If not an admin, logout immediately and block access
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Access denied. You do not have administrator privileges.',
            ]);
        }

        // 4. Failed Login
        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Handle Admin Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.auth.login')
            ->with('info', 'You have been logged out.');
    }
   
}