<?php

return [
     /*
     | --------------------------------------------
     | Route prefix url for admin panel
     | --------------------------------------------
     |
     */
     'admin_path' => 'admin',

     /*
     | --------------------------------------------
     | Route name for home page after login
     | --------------------------------------------
     */
     'home_page' => 'admin/dashboard',

     /*
     | --------------------------------------------
     | Enable disable dark mode
     | --------------------------------------------
     */
    'darkmode' => true,
     
     /*
     | --------------------------------------------
     | Application logo and favicon
     | --------------------------------------------
     */
     'logo' => 'adminportal/app_logo.png',
     'favicon' => 'adminportal/favicon.ico',

     /*
     | --------------------------------------------
     | Controller resource location for adminportal
     | --------------------------------------------
     */
     'controllers' => [
          'path' => base_path('app/Http/Controllers/Admin'),
          'namespace' => 'App\Http\Controllers\Admin'
     ],


     /*
      | --------------------------------------------
      | Toast position
      | --------------------------------------------
      |
      | Available :  bottom-right | bottom-left | bottom-center | top-right | top-left | top-center 
      */
     'toast' => 'top-right',


     /*
     | --------------------------------------------
     | Configuration for authentication page
     | --------------------------------------------
     | 
     */
     'authentication' => [
          'model' => Laililmahfud\Adminportal\Models\CmsAdmin::class,
          'verification' => true,
          'login' => [
               'route' => 'admin.auth.login',
               'action' => 'admin.auth.login.attempt',
               'rate_limit' => [
                    'throttle:5,1'
               ]
          ],
          'register' => [
               'enable' => true,
               'route' => 'admin.auth.register',
               'action' => 'admin.auth.register.attempt',
               'rate_limit' => [
                    'throttle:5,1'
               ]
          ],
          'forgot_password' => [
               'enable' => true,
               'route' => 'admin.auth.forgot-password',
               'action' => 'admin.auth.forgot-password.attempt',
               'rate_limit' => [
                    'throttle:1,2'
               ]
          ]
     ],


];