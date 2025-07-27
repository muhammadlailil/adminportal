<?php
namespace Laililmahfud\Adminportal\Traits;

use Laililmahfud\Adminportal\Api\Error;
use Laililmahfud\Adminportal\Api\JwtToken;

trait JsonResponse
{
    public function sendSuccess($data, $message = "success")
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
            'data' => $data,
        ]);
        exit();
    }

    public function sendMessage($message)
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
        exit();
    }

    public function unauthorized($message, $err = Error::UNAUTHORIZED)
    {
        return response()->json([
            'status' => 401,
            'error' => $err,
            'message' => $message,
        ], 401);
        exit();
    }

    public function badRequest($message, $err = Error::BAD_REQUEST)
    {
        return response()->json([
            'status' => 400,
            'error' => $err,
            'message' => $message,
        ], 400);
        exit();
    }

    public function forbidden($message, $err = Error::FORBIDEN)
    {
        return response()->json([
            'status' => 403,
            'error' => $err,
            'message' => $message,
        ], 403);
        exit();
    }

    public function auth(){
        try{
            $decodedToken = JwtToken::decode();
            return $decodedToken->data;
        }catch(\Exception $e){}
        return null;
    }
}
