<?php

namespace Laililmahfud\Adminportal\Helpers;

class FCM
{

    protected static $firebaseUrl = "https://fcm.googleapis.com/fcm/send";
    protected static $firebaseKey;
    protected static $regids = [];
    protected static $title;
    protected static $message;
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

    public static function setTitle($title)
    {
        self::$title = $title;
        return new static();
    }

    public static function setMessage($message)
    {
        self::$message = $message;
        return new static();
    }

    
    /**
     * Usage example
     * 
     * FCM::ios(['',''])->setTitle('Halo selamat pagi!')->setMessage('Jangan lupa untuk mengerjakan tugas hari ini')->send();
     * FCM::android(['',''])->setTitle('Halo selamat pagi!')->setMessage('Jangan lupa untuk mengerjakan tugas hari ini')->send();
     * 
     */
    public static function send()
    {
        if (count(self::$regids)) {
            $regids = array_values(array_unique(self::$regids));

            $fields = [
                'registration_ids' => $regids,
                'data' => [
                    'title' => self::$title,
                    'message' => self::$message
                ],
                'content_available' => true,
                'priority' => 'high',
            ];

            if (self::$platform == "ios") {
                $fields['notification'] = [
                    'sound' => 'default',
                    'title' => trim(strip_tags(self::$title)),
                    'body' => trim(strip_tags(self::$message)),
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
