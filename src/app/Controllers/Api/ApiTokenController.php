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
        $this->apiSecretKey = portal_config('api.secret_key');
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
            $token = JwtToken::setData(['scope' => 'auth'])->setExpired('+1 hours')->build();
            return $this->sendSuccess($token);
        }
        return $this->unauthorized("Token was invalid",Error::$INVALID_TOKEN);
    }

    /**
     * Renew Token
     * 
     * Request renew token to extend the token expiration period 
     * @sorting 2
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
    public function renewToken(Request $request)
    {
        $newToken = null;
        try {
            $payload = JwtToken::decode();
            $newToken = JwtToken::setData($payload->data)->build();

        } catch (\Exception$e) {
            if ($e->getMessage() == "Expired token") {
                list($header, $payload, $signature) = explode(".", $token);
                $payload = json_decode(base64_decode($payload));
                $newToken = JwtToken::setData($payload->data)->build();
            }
        }
        if($newToken){
            return $this->sendSuccess($newToken);
        }
        return $this->unauthorized('Token was invalid', Error::$INVALID_TOKEN);
    }
}
