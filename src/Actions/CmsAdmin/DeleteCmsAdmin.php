<?php
namespace Laililmahfud\Adminportal\Actions\CmsAdmin;

use Laililmahfud\Adminportal\Models\CmsAdmin;

class DeleteCmsAdmin
{
     public function handle($id)
     {
          return CmsAdmin::query()
               ->where('id', $id)
               ->firstOrFail()
               ->delete();
     }
}