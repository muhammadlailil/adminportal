<?php

use Laililmahfud\Adminportal\Helpers\AdminPortal;
use Laililmahfud\Adminportal\Models\CmsNotification;

if (!function_exists('portalconfig')) {
    function portalconfig($config,$default = "")
    {
        return config("adminportal.{$config}") ?: $default;
    }
}


if (!function_exists('admin')) {
    function admin()
    {
        return AdminPortal::user();
    }
}


if (!function_exists('Notification')) {
    function Notification($receivers)
    {
        return CmsNotification::setReceivers($receivers);
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
        $mainPath = request()->url();

        if (@$params['filter_column']) {
            unset($params['filter_column']);
        }

        $params['filter_column'][$key] = $value;

        if (isset($params)) {
            return $mainPath.'?'.http_build_query($params);
        } else {
            return $mainPath.'?filter_column['.$key.']='.$value;
        }
    }
}

if (!function_exists('input_query')) {
    function input_query($exclude = [])
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
                    $value = urldecode($part[1]);
                    $inputHtml .= "<input type='hidden' name='$name' value='$value'/>\n";
                }
            }
        }
        return $inputHtml;
    }
}

if(!function_exists('adminRoute')){
    function adminRoute($route,$id){
        return route($route,[$id,'return_url'=>urlencode(request()->fullUrl())]);
    }
}
if (!function_exists('activeMenu')) {
    function activeMenu($menu)
    {
        $admin = config('adminportal.admin_path');
        $admin = ($admin) ? "{$admin}/":"";
        return (request()->is("{$admin}{$menu}*")) ? 'active' : '';
    }
}


if (!function_exists('listIcons')) {
    function listIcons()
    {
        $file = file_get_contents(__DIR__ . '/../../resources/list-icon.json');
        return json_decode($file, true);
    }
}
if(!function_exists('adminUrl')){
    function adminUrl($url){
        return url(portalconfig('admin_path')."/".$url);
    }
}

if (!function_exists('canDo')) {
    function itcan($action)
    {
        if($action=='view admin.notification'){
            return true;
        }
        $role = admin()->role;
        if($role->is_superadmin){
            return true;
        }
        $permission = $role->permissions;
        return in_array($action,$permission);
    }
}

if (!function_exists('redirect_if')) {
    function redirect_if($if,$action)
    {
        if($if){
            throw new \Illuminate\Http\Exceptions\HttpResponseException(call_user_func($action));
        }
    }
}