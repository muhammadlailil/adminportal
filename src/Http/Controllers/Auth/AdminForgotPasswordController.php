<?php
namespace Laililmahfud\Adminportal\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Auth\CacheTokenRepository;

class AdminForgotPasswordController
{
     public function index(Request $request)
     {
          return view('portal::auth.forgot-password');
     }

     public function store(Request $request)
     {
          $request->validate(['email' => 'required|email']);

          $status = Password::broker('admin')->sendResetLink(
               $request->only('email')
          );

          return $status === Password::RESET_LINK_SENT
               ? back()->with(['success' => __($status)])
               : back()->withErrors(['email' => __($status)]);
     }

     public function edit(Request $request, $uuid, $token)
     {
          if (!app(CacheTokenRepository::class)->existsToken($request->email, $token)) {
               return to_route('admin.auth.forgot-password');
          }

          return view('portal::auth.reset-password', [
               'email' => $request->email,
               'token' => $token
          ]);
     }

     public function update(Request $request)
     {
          $request->validate([
               'email' => 'required|email',
               'password' => 'required|min:8|confirmed',
               'token' => 'required'
          ]);

          $status = Password::broker('admin')->reset(
               $request->only('email', 'password', 'password_confirmation', 'token'),
               function (CmsAdmin $user, string $password) {
                    $user->forceFill([
                         'password' => Hash::make($password),
                    ])->save();
               }
          );

          return $status === Password::PASSWORD_RESET
               ? redirect()->route(portal('authentication.login.route'))->withToast(['message' => __($status)])
               : back()->withErrors(['email' => [__($status)]]);
     }

}