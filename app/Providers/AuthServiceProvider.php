<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('Admin', function(User $user){
            return $user->role == '1';
        });
        Gate::define('User', function(User $user){
            return $user->role == '2';
        });
        Gate::define('pengguna', function(Pengguna $pengguna){
            return $pengguna;
        });
        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole(env('APP_SUPER_ADMIN', 'super-admin'))) {
                return true;
            }
        });
        //
    }
}
