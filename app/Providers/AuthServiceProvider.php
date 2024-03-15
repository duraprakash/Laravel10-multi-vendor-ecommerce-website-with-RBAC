<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Products;
use App\Models\User;
use App\Models\Vendors;
use App\Policies\V1\ProductPolicy;
use App\Policies\V1\RolePolicy;
use App\Policies\V1\UserPolicy;
use App\Policies\V1\VendorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // registering the ModelPolicies
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Vendors::class => VendorPolicy::class,
        Products::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Implicitly grant "Super-Admin" role all permission checks using can()
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });

        // // Register the VendorPolicy for the Vendors model
        // Gate::resource('vendor', VendorPolicy::class);
    }
}
