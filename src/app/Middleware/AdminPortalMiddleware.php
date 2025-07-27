<?php
namespace Laililmahfud\Adminportal\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPortalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!admin()->user) {
            return to_route('admin.auth.index')->with(['message' => 'Please login first !']);
        }

        return $next($request);
    }
}
