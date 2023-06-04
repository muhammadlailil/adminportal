<?php
namespace Laililmahfud\Adminportal\Traits;

use Laililmahfud\Adminportal\Api\Error;
use Illuminate\Support\Facades\Validator;
use Laililmahfud\Adminportal\Api\JwtToken;

trait JsonResponse
{
    public function sendSuccess($data, $message = "success")
    {
        response()->json([
            'status' => 200,
            'message' => $message,
            'data' => $data,
        ])->send();
        exit();
    }

    public function sendMessage($message)
    {
        response()->json([
            'status' => 200,
            'message' => $message,
        ])->send();
        exit();
    }

    public function unauthorized($message, $err = Error::UNAUTHORIZED)
    {
        response()->json([
            'status' => 401,
            'error' => $err,
            'message' => $message,
        ], 401)->send();
        exit();
    }

    public function badRequest($message, $err = Error::BAD_REQUEST)
    {
        response()->json([
            'status' => 400,
            'error' => $err,
            'message' => $message,
        ], 400)->send();
        exit();
    }

    public function forbidden($message, $err = Error::FORBIDDEN)
    {
        response()->json([
            'status' => 403,
            'error' => $err,
            'message' => $message,
        ], 403)->send();
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
        response()->json([
            'status' => 422,
            'message' => collect($message)->first(),
            'error' => $message
        ], 422)->send();
        exit();
    }
}
