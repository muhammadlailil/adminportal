<?php

namespace Laililmahfud\Adminportal\Helpers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class FCM
{
    protected static $firebaseUrl = "https://fcm.googleapis.com/fcm/send";
    protected static $firebaseKey;
    protected static $regIds = [];
    protected static $platform;

    public function __construct()
    {
        self::$firebaseKey  =  config('app.fcm_key');
    }

    public static function ios($regIds = [])
    {
        self::$platform = "ios";
        self::$regIds = $regIds;
        return new static();
    }

    public static function android($regIds = [])
    {
        self::$platform = "android";
        self::$regIds = $regIds;
        return new static();
    }

    /**
     * Usage example
     * 
     * FCM::ios(['',''])->send([
     *      'title' => 'Halo selamat pagi!',
     *      'message' => 'Jangan lupa untuk mengerjakan tugas hari ini'
     * ]);
     * FCM::android(['',''])->send([
     *      'title' => 'Halo selamat pagi!',
     *      'message' => 'Jangan lupa untuk mengerjakan tugas hari ini'
     * ]);
     * 
     */

    /**
     * dispatch function to send fcm notification as queue
     */
    public static function dispatch($data)
    {
        Bus::chain([
            function () use ($data) {
                self::send($data);
            },
        ])->dispatch();
    }
    public static function send($data)
    {
        if (count(self::$regIds)) {
            $regIds = array_values(array_unique(self::$regIds));

            $postData = [
                'registration_ids' => $regIds,
                'data' => $data,
                'content_available' => true,
                'priority' => 'high',
            ];

            if (self::$platform == "ios") {
                $postData['notification'] = [
                    'sound' => 'default',
                    'title' => trim(strip_tags($data['title'])),
                    'body' => trim(strip_tags($data['message'])),
                ];
            }
            $response = Http::withHeaders([
                'Authorization' => "key=" . self::$firebaseKey
            ])->post(self::$firebaseUrl, $postData);
            return  $response->json();
        }
    }
}
