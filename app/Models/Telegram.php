<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

class Telegram
{
    protected static $botToken;
    private static $chat_id = '52369916';
    protected static function getToken()
    {
        if (!self::$botToken) {
            self::$botToken = env('TELEGRAM_BOT_TOKEN');
        }
        return self::$botToken;
    }

    public static function sendMessage($chatID=null, $message)
    {
        $token = self::getToken();
        $text = urlencode($message);
        if(!$chatID){
            $chatID = self::$chat_id;
        }
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.telegram.org/bot$token/sendmessage?chat_id=$chatID&text=$text&parse_mode=HTML",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);;
    }

    public static function sendPhoto($chatID=null, $caption, $photo)
    {
        $token = self::getToken();
        if(!$chatID){
            $chatID = self::$chat_id;
        }
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.telegram.org/bot$token/sendPhoto",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => [
                "chat_id"    => $chatID,
                "parse_mode" => "HTML",
                "caption"    => $caption,
                "photo"      => new \CURLFILE($photo),
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
    public static function sendLocation($chatID = null, $latitude, $longitude, $caption = null)
    {
        $token = self::getToken();
        if (!$chatID) {
            $chatID = self::$chat_id;
        }

        $curl = curl_init();

        $postData = [
            "chat_id"   => $chatID,
            "latitude"  => $latitude,
            "longitude" => $longitude,
        ];

        // Optionally add a caption if provided
        if ($caption) {
            $postData["caption"] = $caption;
            $postData["parse_mode"] = "HTML";
        }

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.telegram.org/bot$token/sendLocation",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            Log::error('Telegram sendLocation error: ' . curl_error($curl));
        }

        curl_close($curl);

        return json_decode($response, true);
    }
}
