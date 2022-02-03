<?php

namespace App\Providers;

use App\Models\User;
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

        Gate::define('isAdmin', function (User $user) {
            return ($user->role == 1);
        });

        Gate::define('isPengurus', function (User $user) {
            return ($user->role == 3 && $user->id_jabatan == null);
        });

        Gate::define('isUstadz', function (User $user) {
            return ($user->role == 4);
        });

        Gate::define('isUser', function (User $user) {
            return ($user->role == 2);
        });

        Gate::define('isProduksi', function (User $user) {
            return ($user->id_jabatan == 2);
        });

        Gate::define('isDistribusi', function (User $user) {
            return ($user->id_jabatan == 1);
        });

        Gate::define('isBendahara', function (User $user) {
            return ($user->id_jabatan == 3);
        });
        Gate::define('isKetua', function (User $user) {
            return ($user->id_jabatan == 4);
        });
        //
    }
}
