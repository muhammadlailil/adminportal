<?php
namespace Laililmahfud\Adminportal\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Actions;
use Laililmahfud\Adminportal\Http\Crud;
use Laililmahfud\Adminportal\Http\Crud\ModuleRegistry;
use Laililmahfud\Adminportal\Repositories\CmsRolePermissionRepository;

class AdminCmsRolePermissionController extends Crud\AdminModule
{
     protected static string $policy = "cms-role-permission";
     protected static string $icon = "cms-role-permission";
     protected static string $url = "cms-role-permission";
     protected static string $title = "Roles & Permission";
     protected static string $resourcePath = "portal::admin.cms-role-permission";
     protected static string $repository = CmsRolePermissionRepository::class;
     protected static bool $hideNavigation = true;

     public static function action(Crud\Action $action): Crud\Action
     {
          return $action
               ->crud(
                    create: Actions\CmsRolePermission\CreateCmsRolePermission::class,
                    update: Actions\CmsRolePermission\UpdateCmsRolePermission::class,
                    delete: Actions\CmsRolePermission\DeleteCmsRolePermission::class,
               )
               ->bulkActions([
                    Crud\BulkAction::make("Delete")
                         ->icon('trash')
                         ->danger()
                         ->do(function (Request $request) {
                              app(self::$repository)->deleteByListId($request->id);
                         }),
               ]);
     }

     public static function table(Crud\Table $table): Crud\Table
     {
          return $table
               ->columns([
                    Crud\Column::make('name')
                         ->sortable(),
                    Crud\Column::make('alias')
                         ->sortable(),
                    Crud\Column::make('is_superadmin')
                         ->label('Superadmin?')
               ])
               ->perPage(10);
     }

     public static function rules(Crud\Rules $rules): Crud\Rules
     {
          return $rules
               ->make([
                    'name' => 'required|max:100',
                    'alias' => 'required|max:150',
                    'is_superadmin' => 'required',
               ]);
     }

     public static function shared(Crud\SharedProp $share): Crud\SharedProp
     {
          return $share
               ->all(function () {
                    $modules = [];
                    if (config('adminportal.cms_admin_module')) {
                         $modules = [
                              [
                                   'policy' => 'user-admin',
                                   'title' => 'User Admin',
                                   'permissions' => [
                                        'view:user-admin',
                                        'create:user-admin',
                                        'update:user-admin',
                                        'delete:user-admin',
                                        'import:user-admin',
                                        'export:user-admin',
                                        'bulk-action:delete-user-admin',
                                        'bulk-action:update-status-user-admin'
                                   ]
                              ]
                         ];
                    }
                    $modules = [
                         ...$modules,
                         ...app(ModuleRegistry::class)->modules(resolve: true)
                    ];
                    return [
                         'modules' => $modules
                    ];
               });
     }
}