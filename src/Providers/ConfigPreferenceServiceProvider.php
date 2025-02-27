<?php

namespace Laililmahfud\Adminportal\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;


class ConfigPreferenceServiceProvider extends ServiceProvider
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

          Model::unguard();
          Model::shouldBeStrict();

          Date::use(CarbonImmutable::class);
          DB::prohibitDestructiveCommands($this->app->isProduction());
     }

}