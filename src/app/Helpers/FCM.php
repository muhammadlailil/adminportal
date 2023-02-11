<?php

namespace Laililmahfud\Adminportal\Helpers;

use Illuminate\Support\Facades\Http;

class FCM
{
    protected static $firebaseUrl = "https://fcm.googleapis.com/fcm/send";
    protected static $firebaseKey;
    protected static $regids = [];
    protected static $platform;

    public function __construct()
    {
        self::$firebaseKey  =  config('app.fcm_key');
    }

    public static function ios($regids = [])
    {
        self::$platform = "ios";
        self::$regids = $regids;
        return new static();
    }

    public static function android($regids = [])
    {
        self::$platform = "android";
        self::$regids = $regids;
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
    public static function send($data)
    {
        if (count(self::$regids)) {
            $regids = array_values(array_unique(self::$regids));

            $postData = [
                'registration_ids' => $regids,
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
