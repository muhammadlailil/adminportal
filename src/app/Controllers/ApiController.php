<?php
namespace Laililmahfud\Adminportal\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function sendSuccess($data, $message="success")
    {
        response()->json([
            'status' => 200,
            'message' => $message,
            'data' => $data,
        ], 200)->send();
        exit();
    }

    public function sendMessage($message)
    {
        response()->json([
            'status' => 200,
            'message' => $message,
        ], 200)->send();
        exit();
    }

    public function unauthorized($message, $err)
    {
        response()->json([
            'status' => 401,
            'error' => $err,
            'message' => $message,
        ], 401)->send();
        exit();
    }

    public function badRequest($message,$err="bad_request")
    {
        response()->json([
            'status' => 400,
            'error' => $err,
            'message' => $message,
        ], 400)->send();
        exit();
    }

    public function forbidden($message,$err="forbidden")
    {
        response()->json([
            'status' => 403,
            'error' => $err,
            'message' => $message,
        ], 403)->send();
        exit();
    }
}
