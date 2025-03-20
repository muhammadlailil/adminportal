<?php
namespace Laililmahfud\Adminportal\Actions\CmsRolePermission;

use Laililmahfud\Adminportal\Models\CmsRolePermission;

class DeleteCmsRolePermission
{
     public function handle($id)
     {
          return CmsRolePermission::query()
               ->where('id', $id)
               ->delete();
     }
}