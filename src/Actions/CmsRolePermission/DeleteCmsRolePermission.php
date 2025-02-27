<?php
namespace Laililmahfud\Adminportal\Actions\CmsRolePermission;

use Laililmahfud\Adminportal\Models\CmsRolePermission;

class DeleteCmsRolePermission
{
     public function handle($uuid)
     {
          return CmsRolePermission::query()
               ->where('uuid', $uuid)
               ->delete();
     }
}