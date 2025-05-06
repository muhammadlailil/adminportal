<?php
namespace Laililmahfud\Adminportal\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Laililmahfud\Adminportal\Events\RefreshSession;
use Laililmahfud\Adminportal\Notifications\VerificationEmailNotification;

class AdminEmailVerificationController
{
     public function index(Request $request)
     {
          if (!$request->admin()) {
               return to_route(portal('authentication.login.route'));
          }

          if ($request->admin()->hasVerifiedEmail()) {
               return redirect(url(portal('home_page')));
          }

          return view('portal::auth.verification');
     }

     public function store(Request $request, $uuid, $hash)
     {
          if (!URL::hasValidSignature($request)) {
               return to_route('admin.verification.notice')->with('error', __('adminportal.label.link_verification_expired'));
          }
          $id = id_from_uuid($uuid);

          $user = app(config('adminportal.authentication.model'))->where('id', $id)->firstOrFail();

          if (!hash_equals((string) $hash, sha1($user->email))) {
               return abort(403);
          }

          if ($user->hasVerifiedEmail()) {
               return redirect(url(portal('home_page')));
          }


          if ($user->markEmailAsVerified()) {
               event(new RefreshSession($user));
          }

          return redirect(url(portal('home_page')));
     }

     public function update(Request $request)
     {
          $user = $request->admin();
          $user->notify(new VerificationEmailNotification());

          return to_route('admin.verification.notice');
     }
}