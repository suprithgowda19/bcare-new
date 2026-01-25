<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the staff login form.
     */
    public function showLoginForm()
    {
        // If already logged in as staff, go to dashboard
        if (Auth::check() && Auth::user()->hasRole('staff')) {
            return redirect()->route('staff.dashboard');
        }

        return view('staff.auth.login');
    }

    /**
     * Handle staff login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Strictly verify the 'staff' role
            if ($user->hasRole('staff')) {
                $request->session()->regenerate();
                return redirect()->intended(route('staff.dashboard'));
            }

            // If not staff, log them out and show error
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Access denied. This portal is for staff only.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Handle staff logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('staff.auth.login')
            ->with('info', 'Logged out successfully.');
    }
}