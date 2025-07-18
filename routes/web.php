<?php

use Illuminate\Support\Facades\Route;

// Central domain: Tenant CRUD routes
Route::resource('tenants', App\Http\Controllers\TenantController::class);

// Optionally, redirect the root to the tenants index
Route::get('/', function () {
    return redirect()->route('tenants.index');
});

Route::get('/debug-db', function () {
    return \DB::connection()->getDatabaseName();
});
