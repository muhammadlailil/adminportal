<?php
namespace Laililmahfud\Adminportal\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Models\CmsRolePermission;

class AdminRegisterController
{
     public function index(Request $request)
     {
          return view('portal::auth.register');
     }

     public function store(Request $request)
     {
          $request->validate([
               'name' => ['required', 'string', 'max:255'],
               'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . CmsAdmin::class],
               'password' => ['required', 'confirmed', Rules\Password::defaults()],
          ]);

          $rolePermission = CmsRolePermission::where('is_superadmin', false)->firstOrFail();

          $user = CmsAdmin::create([
               'name' => $request->name,
               'email' => $request->email,
               'password' => Hash::make($request->password),
               'role_permission_id' => $rolePermission->id
          ]);

          event(new Registered($user));

          Auth::guard('admin')->login($user);

          return redirect(url(portal('home_page')));
     }

}