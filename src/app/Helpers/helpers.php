<?php

use Laililmahfud\Adminportal\Helpers\AdminPortal;

// for development only, remove this
if (!function_exists('portal_config')) {
    function portal_config($config)
    {
        return config("adminportal.{$config}");
    }
}


if (!function_exists('admin')) {
    function admin()
    {
        return AdminPortal::user();
    }
}

if(!function_exists('return_url')){
    function return_url(){
        return request('return_url') ? urldecode(request('return_url')) : null;
    }
}

if (!function_exists('urlFilterColumn')) {
    function urlFilterColumn($key,$value)
    {
        $params = request()->all();
        $mainpath = request()->url();

        if (@$params['filter_column']) {
            unset($params['filter_column']);
        }

        $params['filter_column'][$key] = $value;

        if (isset($params)) {
            return $mainpath.'?'.http_build_query($params);
        } else {
            return $mainpath.'?filter_column['.$key.']='.$value;
        }
    }
}

if (!function_exists('input_query')) {
    function input_query($exclude = [])
    {
        @$get = $_GET;
        $inputhtml = '';
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
                    $value = urldecode($part[1]);
                    $inputhtml .= "<input type='hidden' name='$name' value='$value'/>\n";
                }
            }
        }
        return $inputhtml;
    }
}

if(!function_exists('adminroute')){
    function adminroute($route,$id){
        return route($route,[$id,'return_url'=>urlencode(request()->fullUrl())]);
    }
}
if (!function_exists('activeMenu')) {
    function activeMenu($menu)
    {
        $admin = config('adminportal.admin_path');
        return (request()->is("{$admin}/{$menu}*")) ? 'active' : '';
    }
}


if (!function_exists('listIcons')) {
    function listIcons()
    {
        $file = file_get_contents(__DIR__ . '/../../resources/list-icon.json');
        return json_decode($file, true);
    }
}
if(!function_exists('adminurl')){
    function adminurl($url){
        return url(portal_config('admin_path')."/".$url);
    }
}