<?php
namespace Laililmahfud\Adminportal;

use Illuminate\Routing\Router;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laililmahfud\Adminportal\Middleware\AdminPortalMiddleware;
use Laililmahfud\Adminportal\Commands\AdminKeyGeneratorCommand;
use Laililmahfud\Adminportal\Commands\AdminPortalInstalationCommand;
use Illuminate\Support\Facades\Blade;

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
        
        
        $this->loadViewsFrom(__DIR__ . '/../resources', 'portal');
        $this->loadViewsFrom(__DIR__ . '/../resources/module', 'portalmodule');
        $this->registerRoutes();
        $this->registeBladeDirective();


        $this->publishes([__DIR__.'/../lang' => base_path('lang')], 'portal-lang');
        $this->publishes([__DIR__ . '/../config/adminportal.php' => config_path('adminportal.php')], 'portal-config');
        $this->publishes([
            __DIR__ . '/../assets' => public_path('adminportal'),
        ], 'portal-asset');

        $this->commands([
            AdminPortalInstalationCommand::class,
            AdminKeyGeneratorCommand::class,
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
            ->prefix(portal_config('admin_path'))
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


    private function registeBladeDirective(){
        Blade::if('canDo', function ($do) {
            return canDo($do);
        });
    }
}
