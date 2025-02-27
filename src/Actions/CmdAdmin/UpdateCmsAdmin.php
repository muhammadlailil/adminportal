<?php
namespace Laililmahfud\Adminportal\Actions\CmdAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laililmahfud\Adminportal\Models\CmsAdmin;

class UpdateCmsAdmin
{
     public function handle(Request $request, $uuid)
     {
          $props = [
               'name' => $request->name,
               'email' => $request->email,
               'role_permission_id' => $request->role_permission_id,
               'status' => $request->status,
          ];

          $props = array_merge($props, $request->filled('password') ? ['password' => Hash::make($request->password)] : []);

          return CmsAdmin::query()
               ->where('uuid', $uuid)
               ->update($props);
     }
}