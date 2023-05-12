<?php

namespace Laililmahfud\Adminportal\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Illuminate\Validation\ValidationException;
use Laililmahfud\Adminportal\Helpers\AdminPortal;

class AdminMainController extends Controller
{
    public function getLogin(Request $request)
    {
        if (admin()->user) {
            return to_route('admin.dashboard');
        }
        return view(portalconfig('login.view_path'));
    }

    public function postLogin(Request $request)
    {
        if (portalconfig('login.url') != 'admin/auth/login') abort(404);

        $request->validate([
            'email' => 'required|email|exists:cms_admin,email|min:10|max:50',
            'password' => 'required|min:8|max:50|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
        ]);

        $user = CmsAdmin::with('roles')->active()->whereEmail($request->email)->first();
        if (!$user)
            throw ValidationException::withMessages(['email' => 'The users email account is not active ']);

        if (!Hash::check($request->password, $user->password))
            throw ValidationException::withMessages(['password' => 'The password you entered does not match ']);

        AdminPortal::login($user);

        return to_route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        AdminPortal::logout();

        return to_route('admin.auth.index');
    }

    public function profile(Request $request)
    {
        if (portalconfig('profile_url') != 'admin/profile') abort(404);
        return view('portalmodule::profile.index');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8|max:50|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
            'password' => 'required|min:8|confirmed|max:50|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
            'password_confirmation' => 'required|min:8|max:50,regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
        ]);
        if (!Hash::check($request->old_password, CmsAdmin::findOrFail(admin()->user->id)->value('password')))
            throw ValidationException::withMessages(['old_password' => 'The password you entered does not match ',]);

            CmsAdmin::findOrFail(admin()->user->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with(['success' => 'Password updated successfully']);
    }
}
