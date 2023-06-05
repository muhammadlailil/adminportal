<?php
namespace Laililmahfud\Adminportal\Controllers\Api;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Api\Error;
use Laililmahfud\Adminportal\Api\JwtToken;
use Laililmahfud\Adminportal\Controllers\ApiController;

/**
 * @group Authorization
 * @sorting 1
 * 
 */
class ApiTokenController extends ApiController
{
    public $apiSecretKey;
    
    public function __construct()
    {
        $this->apiSecretKey = portalconfig('api.secret_key');
    }

    /**
     * Get Token 
     * 
     * For first initial token to use for login <br> Authorization = base64encode( date('Y-m-d') | API_SECRET_KEY )
     * @sorting 1
     * @authenticated
     * @response {
     *  "status": 200,
     *  "message": "success",
     *  "data": {
     *      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NTUwM",
     *      "expiredAt": 1655031621
     *   }
     *  }
     */
    public function getToken(Request $request)
    {
        $token = JwtToken::getToken();
        $token = base64_decode($token);
        $tokens = explode('|', $token);
        if ($tokens[0] == date('Y-m-d') && $tokens[1] == $this->apiSecretKey) {
            $token = JwtToken::setData(['scope' => 'auth'])->setExpired(portalconfig('api.expired_duration_get_token'))->build();
            return $this->sendSuccess($token);
        }
        return $this->unauthorized("Token was invalid",Error::INVALID_TOKEN);
    }

    /**
     * Renew Token
     * 
     * Request renew token to extend the token expiration period 
     * @sorting 2
     * @authenticated
     * 
     * @header key string required
     * 
     * @response {
     *  "status": 200,
     *  "message": "success",
     *  "data": {
     *      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NTUwM",
     *      "expiredAt": 1655031621
     *   }
     *  }
     */
    public function renewToken(Request $request)
    {
        $newToken = null;
        if((portalconfig('api.validate_blacklist') && JwtToken::isBlacklist())){
            return $this->unauthorized('Your token was not found !');
        }
        try {
            $token = base64_decode($request->header('key'));
            $tokens = explode('|', $token);
            if ($tokens[0] != date('Y-m-d') || $tokens[1] != $this->apiSecretKey) {
                return $this->unauthorized("Token was invalid",Error::INVALID_TOKEN);
            }

            $payload = JwtToken::decode();
            $newToken = JwtToken::setData($payload->data)->build();
        } catch (\Exception$e) {
            if ($e->getMessage() == "Expired token") {
                $token = JwtToken::getToken();
                list($header, $payload, $signature) = explode(".", $token);
                $payload = json_decode(base64_decode($payload));
                $newToken = JwtToken::setData($payload->data)->build();
            }
        }
        if($newToken){
            return $this->sendSuccess($newToken);
        }
        return $this->unauthorized('Token was invalid', Error::INVALID_TOKEN);
    }
}
