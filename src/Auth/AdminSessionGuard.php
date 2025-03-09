<?php

namespace Laililmahfud\Adminportal\Auth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Cache;
use Laililmahfud\Adminportal\Models\CmsAdmin;

class AdminSessionGuard extends SessionGuard
{
     public function user()
     {
          if ($this->loggedOut) {
               return null;
          }

          if (session()->has('auth_admin')) {
               return json_decode(session('auth_admin'));
          }

          if (!is_null($this->user)) {
               return $this->user;
          }


          if(!$id = $this->session->get($this->getName())){
               return null;
          }

          $this->user = CmsAdmin::find($id);
          return $this->user;
     }


     public static function loginAdmin(CmsAdmin $cmsAdmin)
     {
          session()->put('auth_admin', $cmsAdmin->toJson());
     }

     public static function refreshAdmin(CmsAdmin $cmsAdmin)
     {
          session()->put('auth_admin', $cmsAdmin->toJson());
     }

     public static function logoutAdmin()
     {
          session()->forget('auth_admin');
     }
}
