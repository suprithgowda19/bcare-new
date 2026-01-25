<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * List all registered public users
     */
    public function index()
    {
        $users = User::query()
            ->role('public') // Spatie role filter (MANDATORY)
            ->select('id', 'name', 'phone', 'email', 'created_at', 'status')
            ->latest()
            ->paginate(15);

        return view('admin.master.public.index', compact('users'));
    }

    /**
     * Show a single public user
     */
    public function show(User $user)
    {
        abort_unless($user->hasRole('public'), 404);

        return view('admin.master.public.show', compact('user'));
    }
}
