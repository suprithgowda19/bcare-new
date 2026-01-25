<?php

namespace App\Http\Controllers\Public\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function show()
    {
        return view('public.auth.register');
    }

    /**
     * Handle the registration request for a public user.
     */
    public function store(Request $request)
    {
        // 1. Validation - Standard citizen details
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|unique:users,phone',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Create User
        // Note: category_id, zone, wards etc. will be NULL in DB for these users
        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => 'active', // Defaulting to active
        ]);


        if (Role::where('name', 'public')->exists()) {
            $user->assignRole('public');
        }

        // 4. Automatic Login
        Auth::login($user);

        // 5. Redirect to Dashboard or Category Selection
        return redirect()->route('public.complaints.category')->with('success', 'ನೋಂದಣಿ ಯಶಸ್ವಿಯಾಗಿದೆ!');
    }
}