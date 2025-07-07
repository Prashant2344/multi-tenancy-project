<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;
use Stancl\Tenancy\Tenancy;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'workspace' => ['required', 'string', 'max:255', 'alpha_dash'],
        ])->validate();

        // Explicitly create the tenant in the central database
        $tenant = \App\Models\Tenant::on('central')->create([
            'id' => $input['email'],
            'email' => $input['email'],
        ]);

        // Create a domain for the tenant using the workspace as the subdomain
        $tenant->domains()->create([
            'domain' => $input['workspace'] . '.multi-tenancy-project.test',
            'tenant_id' => $tenant->id,
        ]);

        // Switch to the tenant context, create the user, then end tenancy
        tenancy()->initialize($tenant);
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        tenancy()->end();
        return $user;
    }
}
