<?php
namespace Laililmahfud\Adminportal\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laililmahfud\Adminportal\Enums\UserStatus;

class AdminAuthenticateSessionController
{
     public function index(Request $request)
     {
          return view('portal::auth.login');
     }

     public function attempt(Request $request)
     {
          $request->validate([
               'email' => ['required', 'string', 'email'],
               'password' => ['required', 'string'],
          ]);

          $user = [
               'email' => $request->email,
               'password' => $request->password,
               'status' => UserStatus::Active
          ];
          if (!Auth::guard('admin')->attempt($user, $request->boolean('remember'))) {
               throw ValidationException::withMessages([
                    'email' => __('adminportal.auth.login.failed'),
               ]);
          }
          $request->session()->regenerate();

          return redirect(url(portal('home_page')));
     }

     public function destroy(Request $request)
     {
          Auth::guard('admin')->logout();

          $request->session()->regenerate();
          return to_route(portal('authentication.login.route'));
     }
}