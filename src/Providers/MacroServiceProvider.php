<?php

namespace Laililmahfud\Adminportal\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laililmahfud\Adminportal\Models\CmsAdmin;

class MacroServiceProvider extends ServiceProvider
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
          Request::macro('admin', function ($eloquent = false) {
               if (!$admin = admin()) {
                    return null;
               }
               $model = config('adminportal.authentication.model');
               if ($eloquent && !$admin instanceof $model) {
                    $admin = app($model)->findOrFail($admin->id);
               }
               return $admin;
          });

          Redirector::macro('withToast', function ($url, $props) {
               return redirect($url)->with('toast', $props);
          });

          Str::macro('initial', function ($string) {
               $nameParts = explode(" ", $string);
               $str = $nameParts[0][0];
               if( @$nameParts[1]){
                    $str .=  @$nameParts[1][0];
               }else{
                    $str .= @$nameParts[0][1];
               }
               $initials = strtoupper($str);
               return $initials;
          });
     }

}