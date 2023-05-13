<?php
namespace Laililmahfud\Adminportal;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Laililmahfud\Adminportal\Middleware\ApiPortalMiddleware;
use Laililmahfud\Adminportal\Middleware\AdminPortalMiddleware;
use Laililmahfud\Adminportal\Commands\AdminKeyGeneratorCommand;
use Laililmahfud\Adminportal\Commands\AdminPortalMigrationCommand;
use Laililmahfud\Adminportal\Commands\AdminPortalInstallationCommand;

class AdminPortalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require __DIR__ . '/Helpers/helpers.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(\Illuminate\Contracts\Http\Kernel$kernel)
    {
        Paginator::useBootstrap();
        
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('portal-admin', AdminPortalMiddleware::class);
        $router->aliasMiddleware('portal-api', ApiPortalMiddleware::class);
        
        
        $this->loadViewsFrom(__DIR__ . '/../resources', 'portal');
        $this->loadViewsFrom(__DIR__ . '/../resources/module', 'portalmodule');
        $this->registerRoutes();
        $this->registerBladeDirective();
        $this->configureRateLimiting();


        $this->publishes([__DIR__.'/../lang' => base_path('lang')], 'portal-lang');
        $this->publishes([__DIR__ . '/../config/adminportal.php' => config_path('adminportal.php')], 'portal-config');
        $this->publishes([
            __DIR__ . '/../assets' => public_path('adminportal'),
        ], 'portal-asset');

        $this->commands([
            AdminPortalInstallationCommand::class,
            AdminKeyGeneratorCommand::class,
            AdminPortalMigrationCommand::class
        ]);
        
    }

      /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::middleware('web')
            ->as('admin.')
            ->prefix(portalconfig('admin_path'))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
            });

        Route::middleware('api')
            ->as('api.')
            ->prefix('api')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });
    }


    private function registerBladeDirective(){
        Blade::if('itcan', function ($do) {
            return itcan($do);
        });
    }

    private function configureRateLimiting(){
        RateLimiter::for('60perMinute', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
