<?php

namespace Laililmahfud\Adminportal\Providers;

use ReflectionClass;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laililmahfud\Adminportal\Http\Crud\AdminModule;
use Laililmahfud\Adminportal\Http\Crud\ModuleRegistry;


class AdminModuleProvider extends ServiceProvider
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
          $namespace = portal('controllers.namespace');
          foreach (File::allFiles(portal('controllers.path')) as $file) {
               $class = $namespace . '\\' . str_replace('.php', '', $file->getRelativePathname());
               if (!class_exists($class)) {
                    continue;
               }
               if (is_subclass_of($class, AdminModule::class)) {
                    if ((new ReflectionClass($class))->isAbstract()) {
                         continue;
                    }
                    app(ModuleRegistry::class)->register($class);
               }
          }

          foreach (File::allFiles(__DIR__ . "/../Http/Controllers") as $file) {
               $class = 'Laililmahfud\Adminportal\Http\Controllers\\' . str_replace('.php', '', $file->getRelativePathname());
               if (!class_exists($class)) {
                    continue;
               }
               if (is_subclass_of($class, AdminModule::class)) {
                    if ((new ReflectionClass($class))->isAbstract()) {
                         continue;
                    }
                    app(ModuleRegistry::class)->register($class);
               }
          }
     }

}