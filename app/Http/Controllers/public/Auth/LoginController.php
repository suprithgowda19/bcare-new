<?php

namespace App\Http\Controllers\Public\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('public.auth.login');
    }

    public function authenticate(Request $request)
    {
        // 1. Validate Input with inline error messages
        $request->validate([
            'phone'    => 'required|digits:10',
            'password' => 'required|string|min:6',
        ], [
            'phone.required'    => 'ಮೊಬೈಲ್ ಸಂಖ್ಯೆಯನ್ನು ನಮೂದಿಸಿ.',
            'phone.digits'      => 'ಮೊಬೈಲ್ ಸಂಖ್ಯೆ 10 ಅಂಕಿಗಳನ್ನು ಹೊಂದಿರಬೇಕು.',
            'password.required' => 'ಸಂಕೇತ ಪದವನ್ನು ನಮೂದಿಸಿ.',
        ]);

        // 2. Attempt Login
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'status' => 'active'])) {

            $user = Auth::user();

            // 3. Spatie Role Check
            if (!$user->hasRole('public')) {
                Auth::logout();
                return back()->withErrors(['phone' => 'ಈ ಲಾಗಿನ್ ಸಾರ್ವಜನಿಕರಿಗೆ ಮಾತ್ರ ಮೀಸಲಾಗಿದೆ.'])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->route('public.home');
        }

        // 4. Fail Case - Incorrect credentials
        return back()->withErrors([
            'phone' => 'ಮೊಬೈಲ್ ಸಂಖ್ಯೆ ಅಥವಾ ಸಂಕೇತ ಪದ ತಪ್ಪಾಗಿದೆ.',
        ])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.login')
            ->with('success', 'Logged out successfully.');
    }
}
