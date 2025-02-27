<?php

namespace Laililmahfud\Adminportal\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminGuestMiddleware
{
     /**
      * Handle an incoming request.
      *
      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
      */
     public function handle(Request $request, Closure $next)
     {
          if ($request->admin()){{
               return redirect(url(portal('home_page')));
          }}

          return $next($request);
     }
}
