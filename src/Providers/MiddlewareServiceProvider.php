<?php namespace Xcms\ACL\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Xcms\Acl\Http\Middleware\Authenticate;
use Xcms\Acl\Http\Middleware\RedirectIfAuthenticated;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var  Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('auth.admin', Authenticate::class);
        $router->aliasMiddleware('guest.admin', RedirectIfAuthenticated::class);
    }
}
