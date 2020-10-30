<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies(); 
        
        Gate::define('funville-dashboard', function($user){
            return $user->hasAnyRoles(['admin', 'order-control', 'stock-control', 'user']);
        });

        Gate::define('manage-reports', function($user){
            return $user->hasAnyRoles(['admin', 'order-control', 'stock-control', 'user']);
        });

        Gate::define('manage-orders', function($user){
            return $user->hasAnyRoles(['admin', 'order-control']);
        });

        Gate::define('manage-stock', function($user){
            return $user->hasAnyRoles(['admin', 'stock-control']);
        });

        Gate::define('all-admin-features', function($user){
            return $user->hasRole('admin');
        });

        

    }
}
