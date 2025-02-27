<?php
namespace Laililmahfud\Adminportal\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laililmahfud\Adminportal\Notifications\VerificationEmailNotification;

class AdminProfileController
{
     public function __construct()
     {
          view()->share([
               'pageTitle' => 'Account',
               'pageDescription' => 'Manage your account settings.',
               'breadcrumb' => breadcrumb(action: 'Profile', title: 'Account'),
          ]);
     }
     public function index(Request $request)
     {
          return view("portal::default.profile.index");
     }

     public function update(Request $request)
     {
          try {

               $request->validate([
                    'name' => 'required|max:100',
                    'email' => [
                         'required',
                         'email',
                         Rule::unique('cms_admins')->ignore($request->admin()->id),
                    ]
               ]);

               $request->admin()->fill($request->only(['name', 'email']));

               if ($request->admin()->isDirty('email')) {
                    $request->admin()->email_verified_at = null;
                    $request->admin()->notify(new VerificationEmailNotification());
               }

               $request->admin()->save();

               return back()->withToast([
                    'title' => 'Congratulation !',
                    'message' => __('adminportal.alert.profile_updated'),
                    'variant' => 'success'
               ]);
          } catch (\Illuminate\Validation\ValidationException $e) {
               return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput()
                    ->with('active', 'profile');
          }
     }

     public function updatePassword(Request $request)
     {
          try {
               
               if (!Hash::check($request->current_password, $request->admin()->password)) {
                    throw ValidationException::withMessages(['current_password' => __('validation.current_password')]);
               }

               $request->validate([
                    'current_password' => ['required'],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
               ]);


               $request->admin()->update([
                    'password' => Hash::make($request->password),
               ]);

               return back()->withToast([
                    'title' => 'Congratulation !',
                    'message' => __('adminportal.alert.password_updated'),
                    'variant' => 'success'
               ])
               ->with('active', 'password');
          } catch (\Illuminate\Validation\ValidationException $e) {
               return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput()
                    ->with('active', 'password');
          }
     }
}