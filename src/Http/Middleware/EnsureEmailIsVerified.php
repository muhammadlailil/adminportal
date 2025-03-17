<?php

namespace Laililmahfud\Adminportal\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
     /**
      * Handle an incoming request.
      *
      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
      */
     public function handle(Request $request, Closure $next)
     {
          if ($request->admin()->hasAttribute('email_verified_at') && !$request->admin()->email_verified_at) {
               return to_route('admin.verification.notice');
          }

          return $next($request);
     }
}
