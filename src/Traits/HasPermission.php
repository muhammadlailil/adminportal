<?php
namespace Laililmahfud\Adminportal\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Laililmahfud\Adminportal\Models\CmsRolePermission;

trait HasPermission
{
     public function role(): HasOne
     {
          return $this->hasOne(CmsRolePermission::class, 'id', 'role_permission_id');
     }
}