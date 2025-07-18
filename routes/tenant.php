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

    // Redirect root to login if not authenticated, else to /home
    Route::get('/', function () {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        return redirect()->route('home');
    });

    // Home route: show all user details and tenant details
    Route::middleware(['auth'])->get('/home', function () {
        dd('dd');
        $users = \App\Models\User::all();
        $tenant = tenant();
        return response()->json([
            'users' => $users,
            'tenant' => $tenant,
        ]);
    })->name('home');

    // Protected routes for authenticated users
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return 'Welcome, ' . auth()->user()->name . '! You are in tenant ' . tenant('id');
        });
    });
});

