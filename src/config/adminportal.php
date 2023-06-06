<?php

return [
    /*
     | --------------------------------------------
     | Route prefix url for admin panel
     | --------------------------------------------
     */
    'admin_path' => 'admin',

    /*
     | --------------------------------------------
     | Your application icon
     | --------------------------------------------
     */
    'app_icon' => 'adminportal/img/app-logo.png',

    /*
     | --------------------------------------------
     | Your application favicon
     | --------------------------------------------
     */
    'app_favicon' => 'adminportal/img/favicon.svg',

    /*
     | --------------------------------------------
     | Your application default avatar image
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
        
        'limiter' => ['throttle:60perMinute'],
        'url' => 'admin/auth/login',
        'forgot_password_url' => 'admin/auth/forgot-password',
        'register_url' => 'admin/auth/register',
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
        'logout_url' => 'admin/logout'
    ],

    /*
     | --------------------------------------------
     | For profile url location
     | --------------------------------------------
     */
    'profile_url' => 'admin/profile',


    /*
     | --------------------------------------------
     | For display dropdown notification on header
     | --------------------------------------------
     */
    'notification' => [
        'display' => true,
        'interval' => 120,
        'path' => 'admin.notification.index',
        'ajax_path' => 'notification-admin/list'
    ],

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
        'expired_duration_get_token' => "+1 hours",
        'validate_blacklist' => false
    ]
    
];