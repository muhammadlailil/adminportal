<?php

namespace Laililmahfud\Adminportal;

use Illuminate\Support\ServiceProvider;
use Laililmahfud\Adminportal\Http\Crud\ModuleRegistry;
use Laililmahfud\Adminportal\Providers\AdminModuleProvider;
use Laililmahfud\Adminportal\Providers\MacroServiceProvider;
use Laililmahfud\Adminportal\Providers\RouteServiceProvider;
use Laililmahfud\Adminportal\Providers\CommandServiceProvider;
use Laililmahfud\Adminportal\Providers\AuthGuardServiceProvider;
use Laililmahfud\Adminportal\Http\Middleware\AdminAuthMiddleware;
use Laililmahfud\Adminportal\Http\Middleware\AdminGuestMiddleware;
use Laililmahfud\Adminportal\Http\Middleware\EnsureEmailIsVerified;
use Laililmahfud\Adminportal\Providers\ConfigPreferenceServiceProvider;


class AdminPortalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require __DIR__ . '/adminportal.php';
        $this->app->singleton(ModuleRegistry::class, function () {
            return new ModuleRegistry;
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $router->aliasMiddleware('admin-auth', AdminAuthMiddleware::class);
        $router->aliasMiddleware('admin-guest', AdminGuestMiddleware::class);
        $router->aliasMiddleware('admin-verified', EnsureEmailIsVerified::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'portal');

        $this->app->register(AdminModuleProvider::class);
        $this->app->register(AuthGuardServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
        $this->app->register(ConfigPreferenceServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        
    }

}