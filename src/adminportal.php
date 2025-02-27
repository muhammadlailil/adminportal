<?php

use Illuminate\Support\Facades\Auth;
use Laililmahfud\Adminportal\Http\Crud\ModuleRegistry;

if (!function_exists('portalconfig')) {
     function portalconfig($config, $default = "")
     {
          return config("adminportal.{$config}") ?: $default;
     }
}


if (!function_exists('portal')) {
     function portal($config, $default = "")
     {
          return portalconfig($config, $default);
     }
}


if (!function_exists('admin')) {
     function admin($key = null)
     {
          $admin = Auth::guard('admin')->user();
          if (!$key) {
               return $admin;
          }

          return $admin->{$key};
     }
}

if (!function_exists('input_hidden_query')) {
     function input_hidden_query($exclude = [])
     {
          @$get = $_GET;
          $inputHtml = '';
          if ($get) {
               if (is_array($exclude)) {
                    foreach ($exclude as $e) {
                         unset($get[$e]);
                    }
               }
               $string_parameters = http_build_query($get);
               $string_parameters_array = explode('&', $string_parameters);
               foreach ($string_parameters_array as $s) {
                    $part = explode('=', $s);
                    $name = urldecode($part[0]);
                    if ($name) {
                         $value = strip_tags(urldecode($part[1] ?? ''));
                         $inputHtml .= "<input type='hidden' name='$name' value='$value'/>\n";
                    }
               }
          }
          return $inputHtml;
     }
}


if (!function_exists('route_from_current')) {
     function route_from_current($key = null, ...$props)
     {
          $routes = request()->route()->getName();
          $routes = explode(".", $routes);
          $routes[count($routes) - 1] = $key;
          return route(implode(".", $routes), $props);
     }
}

if (!function_exists('is_active_menu')) {
     function is_active_menu($url)
     {
          return (request()->is("{$url}*")) ? true : false;
     }
}

if (!function_exists('is_active_main_menu')) {
     function is_active_main_menu($childrens)
     {
          foreach($childrens as $child){
               if(request()->is("{$child->url}*")){
                    return true;
               }
          }
          return false;
     }
}


if (!function_exists('breadcrumb')) {
     function breadcrumb($title = null,$action = null)
     {
          if(!$title && !$action){
               return [
                    [
                         'label' => 'Dashboard',
                         'url' => url(portal('home_page'))
                    ]
               ];
          }
          return [
               [
                    'label' => 'Dashboard',
                    'url' => url(portal('home_page'))
               ],
               [
                    'label' => $title,
                    'url' => route_from_current('index')
               ],
               [
                    'label' => $action,
                    'url' => null
               ]
          ];
     }
}


if (!function_exists('navigations')) {
     function navigations()
     {
          return app(ModuleRegistry::class)->navigations();
     }
}
