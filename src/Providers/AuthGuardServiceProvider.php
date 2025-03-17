<?php

namespace Laililmahfud\Adminportal\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Events\RefreshSession;
use Laililmahfud\Adminportal\Auth\AdminSessionGuard;
use Laililmahfud\Adminportal\Auth\CachePasswordBrokerManager;
use Laililmahfud\Adminportal\Notifications\VerificationEmailNotification;


class AuthGuardServiceProvider extends ServiceProvider
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
          $this->app->extend('auth.password', function ($service, $app) {
               return new CachePasswordBrokerManager($app);
          });

          Event::listen(Login::class, function ($event) {
               if (portal('authentication.provider') == 'session') {
                    AdminSessionGuard::loginAdmin($event->user);
               }
          });

          Event::listen(Logout::class, function ($event) {
               if (portal('authentication.provider') == 'session') {
                    AdminSessionGuard::logoutAdmin();
               }
          });

          Event::listen(Registered::class, function ($event) {
               if (portal('authentication.verification')) {
                    $event->user->notify(new VerificationEmailNotification());
               }
          });

          Event::listen(RefreshSession::class, function ($event) {
               if (portal('authentication.provider') == 'session') {
                    AdminSessionGuard::refreshAdmin($event->user);
               }
          });

          Auth::extend('admin', function ($app, $name, $config) {
               $admniGuard = new AdminSessionGuard(
                    $name,
                    Auth::createUserProvider($config['provider']),
                    $app['session.store']
               );

               $admniGuard->setCookieJar($app['cookie']);

               return $admniGuard;
          });
          $this->configureAuthGuards();

          $this->defineGate();

          Blade::if('itcan', function ($ability, $argument) {
               $permission = request()->admin(true)?->permission;
               if(!$permission){
                    return false;
               }
               if($permission?->is_superadmin){
                    return true;
               }
               return in_array($ability.":" . $argument, $permission->permissions);
          });

     }

     private function configureAuthGuards()
     {
          Config::set('auth.guards.admin', [
               'driver' => 'admin',
               'provider' => 'admin',
          ]);

          Config::set('auth.providers.admin', [
               'driver' => 'eloquent',
               'model' => config('adminportal.authentication.model'),
          ]);

          Config::set('auth.passwords.admin', [
               'provider' => 'admin',
               'expire' => 120
          ]);
     }

     private function defineGate()
     {
          Gate::define('create', function ($admin, $scope) {
               $permission = $admin->permission;
               if ($permission->is_superadmin) {
                    return true;
               }
               return in_array("create:" . $scope, $permission->permissions);
          });

          Gate::define('update', function ($admin, $scope) {
               $permission = $admin->permission;
               if ($permission->is_superadmin) {
                    return true;
               }
               return in_array("update:" . $scope, $permission->permissions);
          });

          Gate::define('delete', function ($admin, $scope) {
               $permission = $admin->permission;
               if ($permission->is_superadmin) {
                    return true;
               }
               return in_array("delete:" . $scope, $permission->permissions);
          });

          Gate::define('view', function ($admin, $scope) {
               $permission = $admin->permission;
               if ($permission->is_superadmin) {
                    return true;
               }
               return in_array("view:" . $scope, $permission->permissions);
          });

          Gate::define('bulk-action', function ($admin, $scope) {
               $permission = $admin->permission;
               if ($permission->is_superadmin) {
                    return true;
               }
               return in_array("bulk-action:" . $scope, $permission->permissions);
          });
     }

}