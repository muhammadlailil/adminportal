<?php
namespace Laililmahfud\Adminportal\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Api\Error;
use Laililmahfud\Adminportal\Api\JwtToken;
use Laililmahfud\Adminportal\Traits\JsonResponse;

class ApiPortalMiddleware
{
    use JsonResponse;
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$role=null)
    {
        $token = JwtToken::getToken();
        
        $isBlacklistToken = (portalconfig('api.validate_blacklist') && JwtToken::isBlacklist());
        if($isBlacklistToken || !$token){
            return $this->unauthorized('Your token was not found !');
        }
        
        try{
            $decodedToken = JwtToken::decode($token);
            $user = $decodedToken->data;

            if($role && in_array(@$user->role,  explode('|',$role)))  return $this->forbidden("You don't have access to this endpoint");

            return $next($request);
        }catch(\Exception $e){
            if($e instanceof ExpiredException)  return $this->unauthorized("Your token was expired !",Error::EXPIRED_TOKEN);

            return $this->unauthorized('Your token was invalid',Error::INVALID_LOGIN);
        }
        return $next($request);
    }
}
