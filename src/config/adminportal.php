<?php

return [
    /*
     | --------------------------------------------
     | Route prefix url for admin panel
     | --------------------------------------------
     */
    'admin_path' => 'my-admin',

    /*
     | --------------------------------------------
     | Your aplication icon
     | --------------------------------------------
     */
    'app_icon' => 'adminportal/img/app-logo.png',

    /*
     | --------------------------------------------
     | Your aplication favicon
     | --------------------------------------------
     */
    'app_favicon' => 'adminportal/img/favicon.svg',

    /*
     | --------------------------------------------
     | Your aplication default avatar image
     | --------------------------------------------
     */
    'default_avatar' => 'adminportal/img/avatar.jpg',

    /*
     | --------------------------------------------
     | Configuration for login view
     | --------------------------------------------
     | view_path => the base resource path of login view
     | banner => image banner for login if you use default view
     | banner_title => banner title for login if you use default view
     | banner_description => banner description for login if you use default view
     */
    'login' => [
        'view_path' => 'portalmodule::auth.login',
        'banner' => 'adminportal/img/login-banner.svg',
        'banner_title' => 'Welcome Back !',
        'banner_description' => "Use your access in the ".config('app.name')." application and login to your dashboard account.",
        'forgot_password' => 'admin/auth/forgot-password',
        'register' => 'admin/auth/register',
    ],

    /*
     | --------------------------------------------
     | For the sidebar admin color
     | --------------------------------------------
     */
    'theme_color' => '#0A0A0A',

    /*
     | --------------------------------------------
     | For auth session management
     | --------------------------------------------
     */
    'auth' => [
        'session_name_prefix' => 'admin.auth',
    ],


    /*
     | --------------------------------------------
     | For display dropdown notification on header
     | --------------------------------------------
     */
    'nofitication' => true,

     /*
     | --------------------------------------------
     | For display interval notification request
     | set null or 0 to disable interval request
     | value in seconds
     | --------------------------------------------
     */
    'nofitication_interval' => 120,

    /*
     | --------------------------------------------
     | Route name for display all notification list
     | --------------------------------------------
     */
    'nofitication_path' => 'admin.notification.index',

    /*
     | --------------------------------------------
     | For display alert after action
     | popup | alert
     | --------------------------------------------
     */
    'alert_message_type' => 'popup',
    


    /*
     | --------------------------------------------
     | For API Configuration
     | --------------------------------------------
     */

    'api' => [
        'secret_key' => env('API_SECRET_KEY'),
        'jwt_secret_key' => env('JWT_SECRET_KEY'),
        'expired_duration_get_token' => "+1 hours"
    ]
    
];