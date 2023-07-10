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
        self::$firebaseKey  =  config('services.firebase.fcm_key');
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
        $regIds = self::$regIds;
        $platform = self::$platform;
        $firebaseKey = self::$firebaseKey;
        $firebaseUrl = self::$firebaseUrl;
        Bus::chain([
            function () use ($data, $regIds, $platform, $firebaseKey, $firebaseUrl) {
                self::sendFirebaseNotification(
                    $data,
                    $regIds,
                    $platform,
                    $firebaseKey,
                    $firebaseUrl
                );
            },
        ])->dispatch();
    }
    public static function send($data)
    {
        self::sendFirebaseNotification(
            data: $data,
            regIds: self::$regIds,
            platform: self::$platform,
            firebaseKey: self::$firebaseKey,
            firebaseUrl: self::$firebaseUrl
        );
    }

    public static function sendFirebaseNotification($data, $regIds, $platform, $firebaseKey, $firebaseUrl)
    {
        if (count($regIds)) {
            $regIds = array_values(array_unique($regIds));

            $postData = [
                'registration_ids' => $regIds,
                'data' => $data,
                'content_available' => true,
                'priority' => 'high',
            ];

            if ($platform == "ios") {
                $postData['notification'] = [
                    'sound' => 'default',
                    'title' => trim(strip_tags($data['title'])),
                    'body' => trim(strip_tags($data['message'])),
                ];
            }
            $response = Http::withHeaders([
                'Authorization' => "key=" . $firebaseKey
            ])->post($firebaseUrl, $postData);
            return  $response->body();
        }
    }
}
