<?php
namespace Laililmahfud\Adminportal\Api;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;

class JwtToken
{
    protected static $algorithm = 'HS256';
    private static $expired = "+1 days";
    private static $data = [];

    public static function setData($data){
        self::$data = $data;
        return new static();
    }

    public static function setExpired($expired){
        self::$expired = $expired;
        return new static();
    }
    

    public static function getToken(){
        $token = request()->header('authorization');
        return str_replace('Bearer ','',$token);;
    }

    public static function build()
    {
        $iss = config('app.name');
        $secretKey = portalconfig('api.jwt_secret_key');
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

    public static function decode($token = null){
        $secretKey = portalconfig('api.jwt_secret_key');
        $token = $token ?: self::getToken();
        return JWT::decode($token, new Key($secretKey, self::$algorithm));
    }

    public static function isBlacklist($token = null){
        $token = $token ?: self::getToken();
        $blacklistDir = storage_path('blacklist-token');
        $file = "{$blacklistDir}/".date('Ymd');
        if (file_exists($file)) {
            $blackListToken = file_get_contents($file);
            return str_contains($blackListToken,$token);
        }
        return false;
    }

    public static function blacklist($token =  null){
        $token = $token ?: self::getToken();

        $blacklistDir = storage_path('blacklist-token');
        if (!file_exists($blacklistDir)) {
            @mkdir($blacklistDir, 0755);
        }
        $file = "{$blacklistDir}/".date('Ymd');
        $lastContent = "";
        if (file_exists($file)) {
            $lastContent = file_get_contents($file);
        }
        $lastContent .= $token."\r\n";
        file_put_contents($file, $lastContent);
    }

}
