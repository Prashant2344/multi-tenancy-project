<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Register Fortify routes for authentication
    // Fortify routes are registered automatically

    // Root route: show dashboard if authenticated, else redirect to login
    Route::get('/', function () {
        // Debug: log the current state
        \Log::info('Tenant root route accessed', [
            'tenant' => tenant('id'),
            'authenticated' => auth()->check(),
            'user' => auth()->user() ? auth()->user()->email : 'none'
        ]);
        
        if (auth()->check()) {
            // User is authenticated, show dashboard directly
            $users = \App\Models\User::all();
            $tenant = tenant();
            
            return view('tenant.dashboard', compact('users', 'tenant'));
        }
        
        // User is not authenticated, redirect to login
        return redirect('/login');
    });

    // Dashboard route: main tenant dashboard (alias for root when authenticated)
    Route::middleware(['auth'])->get('/dashboard', function () {
        $users = \App\Models\User::all();
        $tenant = tenant();
        
        return view('tenant.dashboard', compact('users', 'tenant'));
    })->name('dashboard');

    // Protected routes for authenticated users
    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', function () {
            return 'Profile page for ' . auth()->user()->name . ' in tenant ' . tenant('id');
        })->name('profile');
        
        Route::get('/users', function () {
            $users = \App\Models\User::all();
            return response()->json([
                'users' => $users,
                'tenant' => tenant(),
            ]);
        })->name('users');
    });
});

