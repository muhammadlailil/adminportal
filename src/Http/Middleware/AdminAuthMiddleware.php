<?php

namespace Laililmahfud\Adminportal\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthMiddleware
{
     /**
      * Handle an incoming request.
      *
      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
      */
     public function handle(Request $request, Closure $next)
     {
          if (!$request->admin()) {
               return to_route(portal('authentication.login.route'));
          }

          return $next($request);
     }
}
