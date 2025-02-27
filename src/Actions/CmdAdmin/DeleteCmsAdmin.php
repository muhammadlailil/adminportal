<?php
namespace Laililmahfud\Adminportal\Actions\CmdAdmin;

use Laililmahfud\Adminportal\Models\CmsAdmin;

class DeleteCmsAdmin
{
     public function handle($uuid)
     {
          return CmsAdmin::query()
               ->where('uuid', $uuid)
               ->firstOrFail()
               ->delete();
     }
}