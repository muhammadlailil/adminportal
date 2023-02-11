<?php
namespace Laililmahfud\Adminportal\Api;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;

class JwtToken
{
    protected static $algorithm = 'HS256';
    private static $expired = "+12 hours";
    private static $data = [];

    public static function setData($data){
        self::$data = $data;
        return new static();
    }

    public static function setExpired($expired){
        self::$expired = $expired;
        return new static();
    }

    public static function build()
    {
        $iss = config('app.name');
        $secretKey = portal_config('api.jwt_secret_key');
        $expired = new \DateTime(date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . self::$expired)));
        $expired = $expired->getTimestamp();

        $token = JWT::encode([
            'exp' => $expired,
            'iss' => $iss,
            'iat' => now()->getTimestamp(),
            'nbf' => now()->getTimestamp(),
            'jti' => Str::random(15),
            'data' => self::$data,
        ], $secretKey, self::$algorithm);

        return [
            'token' => $token,
            'expiredAt' => $expired
        ];
    }

    public static function decode(){
        $secretKey = portal_config('api.jwt_secret_key');
        $token = self::getToken();
        return JWT::decode($token, new Key($secretKey, self::$algorithm));
    }

    public static function getToken(){
        $token = request()->header('authorization');
        return str_replace('Bearer ','',$token);;
    }
}
