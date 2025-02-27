<?php
namespace Laililmahfud\Adminportal\Actions\CmdAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laililmahfud\Adminportal\Models\CmsAdmin;

class CreateCmsAdmin
{
     public function handle(Request $request)
     {
          return CmsAdmin::create([
               'name' => $request->name,
               'email' => $request->email,
               'role_permission_id' => $request->role_permission_id,
               'status' => $request->status,
               'email_verified_at' => now(),
               'password' => Hash::make($request->password)
          ]);
     }
}