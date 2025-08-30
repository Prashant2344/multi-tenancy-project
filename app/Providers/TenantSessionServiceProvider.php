<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class TenantSessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Override session configuration when tenancy is initialized
        $this->app->booted(function () {
            if (function_exists('tenant') && tenant()) {
                $tenantId = tenant('id');
                
                // Set session domain to current tenant subdomain only
                Config::set('session.domain', $tenantId . '.multi-tenancy-project.test');
                
                // Set session cookie name to be tenant-specific
                Config::set('session.cookie', 'laravel_session_' . $tenantId);
                
                // Ensure file driver is used
                Config::set('session.driver', 'file');
                
                // Remove any database connection
                Config::set('session.connection', null);
            }
        });
    }
}
