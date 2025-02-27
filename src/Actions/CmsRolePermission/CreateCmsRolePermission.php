<?php
namespace Laililmahfud\Adminportal\Actions\CmsRolePermission;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Models\CmsRolePermission;

class CreateCmsRolePermission
{
     public function handle(Request $request)
     {
          return CmsRolePermission::create([
               'name' => $request->name,
               'alias' => $request->alias,
               'is_superadmin' => $request->is_superadmin,
               'permissions' => $request->permissions,
          ]);
     }
}