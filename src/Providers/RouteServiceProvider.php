<?php

namespace Laililmahfud\Adminportal\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class RouteServiceProvider extends ServiceProvider
{
     /**
      * Register services.
      *
      * @return void
      */
     public function register()
     {
     }

     /**
      * Bootstrap services.
      *
      * @return void
      */
     public function boot()
     {   
          Route::middleware('web')
               ->as('admin.')
               ->prefix(portalconfig('admin_path'))
               ->group(__DIR__ . '/../../routes/admin.php');
     }

}