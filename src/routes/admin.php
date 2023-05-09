<?php

use Illuminate\Support\Facades\Route;
use Laililmahfud\Adminportal\Models\CmsModuls;
use App\Http\Controllers\Admin\AdminIndexController;
use Laililmahfud\Adminportal\Controllers\Admin\AdminMainController;
use Laililmahfud\Adminportal\Controllers\Admin\AdminUsersController;
use Laililmahfud\Adminportal\Controllers\Admin\AdminModulsController;
use Laililmahfud\Adminportal\Controllers\Admin\AdminNotificationController;
use Laililmahfud\Adminportal\Controllers\Admin\AdminRolePermissionController;

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'controller' => AdminMainController::class], function () {
    Route::get('login', 'getLogin')->name('index');
    Route::post('login', 'postLogin')->name('login');
});

Route::middleware(['portal-admin'])->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('dashboard');
    Route::controller(AdminMainController::class)->group(function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/change-password', 'changePassword')->name('change-password');
        Route::post('/logout', 'logout')->name('auth.logout');
    });
    Route::resource('/portal/user-admin', AdminUsersController::class)->except(['show']);
    Route::post("/portal/user-admin/bulk-action", [AdminUsersController::class, "bulkAction"])->name("user-admin.bulk-action");
    Route::get("/portal/user-admin/datatable", [AdminUsersController::class, "datatable"])->name("user-admin.datatable");

    Route::resource('/portal/role-permission', AdminRolePermissionController::class)->except(['show']);
    Route::post("/portal/role-permission/bulk-action", [AdminRolePermissionController::class, "bulkAction"])->name("role-permission.bulk-action");

    Route::group(['prefix'=>'notification-admin','as'=>'notification.','controller'=>AdminNotificationController::class],function(){
        Route::get('/','index')->name('index');
        Route::get('/read/{id}','read')->name('read');
        Route::get('/list','list')->name('list');
    });

    Route::group(['as' => 'cms-moduls.', 'prefix' => 'app-moduls', 'controller' => AdminModulsController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/builder', 'builder')->name('builder');
        Route::get('/load-columns/{table}', 'loadColumns')->name('load-columns');
        Route::post('/build-module', 'buildModule')->name('build-module');
        Route::post('/sorting-menu', 'sortingMenu')->name('sort-menu');
        Route::post('/create', 'create')->name('create');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    try {
        //loop cms modul
        $moduls = CmsModuls::whereType('module')->whereNotNull('path')->whereNotIn('path', ['#', 'javascript:;'])->get();
        foreach ($moduls as $row) {
            $actions = $row->actions ?: [];

            Route::resource($row->path, "\App\Http\Controllers\Admin\\$row->controller")->except($row->except_route);
            if (count($actions)) {
                $name = explode("/", $row->path);
                $name = $name[count($name) - 1];
                if (in_array("export", $actions)) {
                    Route::post("{$row->path}/export", ["\App\Http\Controllers\Admin\\$row->controller", "export"])->name("{$name}.export");
                }
                if (in_array("import", $actions)) {
                    Route::post("{$row->path}/import", ["\App\Http\Controllers\Admin\\$row->controller", "import"])->name("{$name}.import");
                }
                if (in_array("bulk-action", $actions)) {
                    Route::post("{$row->path}/bulk-action", ["\App\Http\Controllers\Admin\\$row->controller", "bulkAction"])->name("{$name}.bulk-action");
                }
                
                if (in_array("datatable", $actions)) {
                    Route::get("{$row->path}/datatable", ["\App\Http\Controllers\Admin\\$row->controller", "datatable"])->name("{$name}.datatable");
                }
            }
        }
    } catch (Exception $e) {
    }
});