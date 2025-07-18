<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Jobs\MigrateDatabase;
use Stancl\JobPipeline\JobPipeline;

class TenantController extends Controller
{
    // List all tenants
    public function index()
    {
        $tenants = Tenant::all();
        return view('tenants.index', compact('tenants'));
    }

    // Show form to create a new tenant
    public function create()
    {
        return view('tenants.create');
    }

    // Store a new tenant
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:tenants,id'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $tenant = Tenant::create([
            'id' => $validated['id'],
            'email' => $validated['email'],
        ]);

        // Create a domain for the tenant
        $tenant->domains()->create([
            'domain' => $validated['id'] . '.multi-tenancy-project.test',
            'tenant_id' => $tenant->id,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    // Show a single tenant
    public function show(Tenant $tenant)
    {
        return view('tenants.show', compact('tenant'));
    }

    // Show form to edit a tenant
    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    // Update a tenant
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'id' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:tenants,id,' . $tenant->id . ',id'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $tenant->update([
            'id' => $validated['id'],
            'email' => $validated['email'],
        ]);

        // Update the domain as well
        $domain = $tenant->domains()->first();
        if ($domain) {
            $domain->update([
                'domain' => $validated['id'] . '.multi-tenancy-project.test',
            ]);
        } else {
            $tenant->domains()->create([
                'domain' => $validated['id'] . '.multi-tenancy-project.test',
                'tenant_id' => $tenant->id,
            ]);
        }

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    // Delete a tenant
    public function destroy(Tenant $tenant)
    {
        // Delete associated domains first
        $tenant->domains()->delete();
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
    }
}
