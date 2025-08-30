<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TenantSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (function_exists('tenant') && tenant()) {
            $tenantId = tenant('id');
            
            // Set session domain to current tenant subdomain only (not wildcard)
            Config::set('session.domain', $tenantId . '.multi-tenancy-project.test');
            
            // Set session cookie name to be tenant-specific
            Config::set('session.cookie', 'laravel_session_' . $tenantId);
            
            // Set session path to be tenant-specific
            Config::set('session.path', '/');
            
            // Force file driver for this tenant
            Config::set('session.driver', 'file');
            
            // Set session files path to be tenant-specific
            $sessionPath = storage_path('framework/sessions/tenant_' . $tenantId);
            if (!is_dir($sessionPath)) {
                mkdir($sessionPath, 0755, true);
            }
            Config::set('session.files', $sessionPath);
        }

        return $next($request);
    }
}
