<?php

namespace Xcms\Acl\Providers;

use Illuminate\Support\ServiceProvider;
use Xcms\Acl\Models\AdminUser;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        config([
            'auth.guards.admin' => [
                'driver' => 'session',
                'provider' => 'admins',
            ]
        ]);

        config([
            'auth.providers.admins' => [
                'driver' => 'eloquent',
                'model' => AdminUser::class
            ]
        ]);

//        $this->registerPolicies();

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
