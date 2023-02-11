<?php

namespace Laililmahfud\Adminportal\Helpers;

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

            $fields = [
                'registration_ids' => $regids,
                'data' => $data,
                'content_available' => true,
                'priority' => 'high',
            ];

            if (self::$platform == "ios") {
                $fields['notification'] = [
                    'sound' => 'default',
                    'title' => trim(strip_tags($data['title'])),
                    'body' => trim(strip_tags($data['message'])),
                ];
            }

            $ch = curl_init(self::$firebaseUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization:key=' . self::$firebaseKey,
                'Content-Type:application/json',
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $chresult = curl_exec($ch);
            curl_close($ch);

            return $chresult;
        }
    }
}
