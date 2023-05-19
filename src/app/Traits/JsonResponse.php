<?php
namespace Laililmahfud\Adminportal\Traits;

use Laililmahfud\Adminportal\Api\Error;
use Illuminate\Support\Facades\Validator;
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

    public function forbidden($message, $err = Error::FORBIDDEN)
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

    public function validates($rules, $message = [], $attributes = [])
    {
        $validator = Validator::make(request()->all(), $rules, $message, $attributes);
        if ($validator->fails()) {
            response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()
            ], 422)->send();
            exit();
        }
    }

    public function validateException($message = [])
    {
        return response()->json([
            'status' => 422,
            'message' => collect($message)->first(),
            'error' => $message
        ], 422);
        exit();
    }
}
