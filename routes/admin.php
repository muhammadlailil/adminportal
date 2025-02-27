<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use Laililmahfud\Adminportal\Http\Controllers\Admin\AdminProfileController;
use Laililmahfud\Adminportal\Http\Crud\ModuleRegistry;
use Laililmahfud\Adminportal\Http\Controllers\Auth\AdminRegisterController;
use Laililmahfud\Adminportal\Http\Controllers\Auth\AdminForgotPasswordController;
use Laililmahfud\Adminportal\Http\Controllers\Auth\AdminEmailVerificationController;
use Laililmahfud\Adminportal\Http\Controllers\Auth\AdminAuthenticateSessionController;


Route::middleware(['admin-guest'])->as('auth.')->group(function () {
     if (portal('authentication.login.route') == 'admin.auth.login') {
          Route::get('login', [AdminAuthenticateSessionController::class, 'index'])->name('login');
     }
     if (portal('authentication.login.action') == 'admin.auth.login.attempt') {
          Route::post('login', [AdminAuthenticateSessionController::class, 'attempt'])->middleware(portal('authentication.login.rate_limit'))->name('login.attempt');
     }

     if (portal('authentication.register.enable')) {
          if (portal('authentication.register.route') == 'admin.auth.register') {
               Route::get('register', [AdminRegisterController::class, 'index'])->name('register');
          }

          if (portal('authentication.register.action') == 'admin.auth.register.attempt') {
               Route::post('register', [AdminRegisterController::class, 'store'])->middleware(portal('authentication.register.rate_limit'))->name('register.attempt');
          }
     }

     if (portal('authentication.forgot_password.enable')) {
          if (portal('authentication.forgot_password.route') == 'admin.auth.forgot-password') {
               Route::get('forgot-password', [AdminForgotPasswordController::class, 'index'])->name('forgot-password');
          }
          if (portal('authentication.forgot_password.action') == 'admin.auth.forgot-password.attempt') {
               Route::post('forgot-password', [AdminForgotPasswordController::class, 'store'])->middleware(portal('authentication.forgot_password.rate_limit'))->name('forgot-password.attempt');
               Route::get('reset-password/{uuid}/{token}', [AdminForgotPasswordController::class, 'edit'])->name('reset-password');
               Route::post('reset-password', [AdminForgotPasswordController::class, 'update'])->middleware(['throttle:5,1'])->name('reset-password.attempt');
          }

     }


});

Route::controller(AdminEmailVerificationController::class)
     ->as('verification.')
     ->prefix('email/verify')
     ->group(function () {
          Route::get('{uuid}/{hash}', 'store')->name('verify');
          Route::get('', 'index')->middleware(['admin-auth'])->name('notice');
          Route::post('', 'update')->middleware(['throttle:2,1'])->name('update');
     });
Route::post('logout', [AdminAuthenticateSessionController::class, 'destroy'])->middleware(['admin-auth'])->name('auth.logout');
Route::middleware(['admin-auth', 'admin-verified'])->group(function () {

     Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
     Route::controller(AdminProfileController::class)
          ->prefix('profile')
          ->as('profile.')
          ->group(function () {
               Route::get('/', 'index')->name('index');
               Route::post('/update', 'update')->name('update');
               Route::post('/update/password', 'updatePassword')->name('update-password');
          });

     foreach (app(ModuleRegistry::class)->routes() as $route) {
          Route::resource($route['url'], $route['controller'])->only($route['resources']);
          foreach ($route['additionals'] as $routeAdditional) {
               Route::{$routeAdditional['method']}($routeAdditional['url'], [$route['controller'], $routeAdditional['action']])->name($routeAdditional['name']);
          }
     }

});

