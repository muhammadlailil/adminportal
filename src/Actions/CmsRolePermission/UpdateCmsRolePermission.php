<?php
namespace Laililmahfud\Adminportal\Actions\CmsRolePermission;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Models\CmsRolePermission;

class UpdateCmsRolePermission
{
     public function handle(Request $request,$uuid)
     {
          return CmsRolePermission::where('uuid',$uuid)->update([
               'name' => $request->name,
               'alias' => $request->alias,
               'is_superadmin' => $request->is_superadmin,
               'permissions' => $request->permissions,
          ]);
     }
}