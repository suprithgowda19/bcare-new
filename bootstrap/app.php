<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 1. Spatie Role Middleware Aliases
        $middleware->alias([
            'role'                => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'          => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission'  => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        // 2. Best Practice: Redirect GUESTS (Not logged in)
        // This solves the "Route [login] not defined" error dynamically
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.auth.login');
            }
            if ($request->is('staff') || $request->is('staff/*')) {
                return route('staff.auth.login');
            }
            return route('public.auth.login');
        });

        // 3. Best Practice: Redirect AUTHENTICATED users 
        // Prevents logged-in users from seeing login pages (Guest Middleware)
        $middleware->redirectUsersTo(function (Request $request) {
            $user = $request->user();
            
            if ($user->hasRole('admin')) {
                return route('admin.master.staff.index');
            }
            if ($user->hasRole('staff')) {
                return route('staff.dashboard');
            }
            return route('public.home');
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();