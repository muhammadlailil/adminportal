<?php
namespace Laililmahfud\Adminportal\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Enums\UserStatus;

class CmsAdminRepository extends AdminRepository
{
     public function __construct(
          public $model = CmsAdmin::class
     ) {
     }

     public function datatable(Request $request, $limit)
     {
          return $this->model::query()
               ->join('cms_role_permissions', 'cms_role_permissions.id', 'cms_admins.role_permission_id')
               ->select([
                    'cms_admins.*',
                    'cms_role_permissions.name as permission_name'
               ])
               ->search([
                    'cms_admins.name',
                    'cms_admins.email',
                    'cms_role_permissions.name'
               ])
               ->filter([
                    'permission_id' => function ($query, $permissionId) {
                         $query->whereIn('cms_admins.role_permission_id', $permissionId);
                    }
               ])
               ->sorting("cms_admins.created_at")
               ->paginate($limit);
     }

     public function update(Request $request,$id)
     {
          $props = [
               'name' => $request->name,
               'email' => $request->email,
               'role_permission_id' => $request->role_permission_id,
               'status' => $request->status,
          ];

          $props = array_merge($props, $request->filled('password') ? ['password' => Hash::make($request->password)] : []);

          return $this->model::query()
               ->where('id', $id)
               ->update($props);
     }
     public function deleteByListId(array $id)
     {
          return $this->model::query()
               ->whereIn('id', $id)
               ->delete();
     }

     public function updateStatusByListId(array $id, $status)
     {
          return $this->model::query()
               ->whereIn('id', $id)
               ->update([
                    'status' => UserStatus::from($status)
               ]);
     }
}