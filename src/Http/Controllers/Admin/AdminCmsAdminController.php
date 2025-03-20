<?php
namespace Laililmahfud\Adminportal\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laililmahfud\Adminportal\Actions;
use Laililmahfud\Adminportal\Http\Crud;
use Laililmahfud\Adminportal\Repositories\CmsAdminRepository;
use Laililmahfud\Adminportal\Repositories\CmsRolePermissionRepository;

class AdminCmsAdminController extends Crud\AdminModule
{
     protected static string $policy = "user-admin";
     protected static string $icon = "user-admin";
     protected static string $url = "user-admin";
     protected static string $title = "Users Admin";
     protected static string $resourcePath = "portal::admin.user-admin";
     protected static string $repository = CmsAdminRepository::class;
     protected static bool $hideNavigation = true;

     public static function action(Crud\Action $action): Crud\Action
     {
          return $action
               ->crud(
                    create: Actions\CmsAdmin\CreateCmsAdmin::class,
                    // update: Actions\CmsAdmin\UpdateCmsAdmin::class,
                    update: fn(Request $request, $id) => app(CmsAdminRepository::class)->update($request, $id),
                    delete: Actions\CmsAdmin\DeleteCmsAdmin::class,
               )
               ->import(
                    Crud\Import::make(Actions\CmsAdmin\ImportCmsAdmin::class)->csv(sample: url('import-format/format-import-cms-admin.csv'))
               )
               ->export([
                    Crud\Export::csv(Actions\CmsAdmin\ExportCmsAdmin::class),
                    // Crud\Export::pdf(ExportUser::class),
                    // Crud\Export::xls(ExportUser::class),
               ])
               ->bulkActions([
                    Crud\BulkAction::make("Update Status")
                         ->icon('checkup-list')
                         ->dialog('update-status')
                         ->do(function (Request $request) {
                              app(self::$repository)->updateStatusByListId($request->id, $request->status);
                         }),
                    Crud\BulkAction::make("Delete")
                         ->icon('trash')
                         ->danger()
                         ->do(function (Request $request) {
                              app(self::$repository)->deleteByListId($request->id);
                         }),
               ])
               ->filter()
               ->usePopupForm();
     }

     public static function table(Crud\Table $table): Crud\Table
     {
          return $table
               ->columns([
                    Crud\Column::make('cms_admins.name')
                         ->label('Name')
                         ->sortable(),
                    Crud\Column::make('cms_admins.email')
                         ->label('Email')
                         ->sortable(),
                    Crud\Column::make('cms_role_permissions.name')
                         ->label('Privilege')
                         ->sortable(),
                    Crud\Column::make('cms_admins.status')
                         ->label('Status')
                         ->sortable()
               ])
               ->perPage(10);
     }

     public static function rules(Crud\Rules $rules): Crud\Rules
     {
          return $rules
               ->make([
                    'name' => 'required|max:100',
                    'role_permission_id' => 'required|exists:cms_role_permissions,id',
               ])
               ->create([
                    'email' => 'required|email|unique:cms_admins,email'
               ])
               ->update([
                    'email' => [
                         'required',
                         'email',
                         Rule::unique('cms_admins')->ignore(id_from_uuid(request()->route('user_admin'))),
                    ]
               ]);
     }

     public static function shared(Crud\SharedProp $share): Crud\SharedProp
     {
          return $share
               ->index(function () {
                    return [
                         'permissions' => app(CmsRolePermissionRepository::class)->findAll()
                    ];
               });
     }

     public static function expose(){
          return config('adminportal.cms_admin_module');
     }
     /*
      |
      |  #[Route(url: '/approve', method: 'POST', name: 'approve')]
      |  public function approve(Request $request)
      |  {
      |      return 'approve';
      |  }
      |
      |  public static function navigationBadge()
      |  {
      |       return 2;
      |  }
      |
      */

}