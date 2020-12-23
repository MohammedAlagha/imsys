<?php
namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Weather
{
    const URL = 'https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$key}&units=metric';

    public static function get($city)
    {
        $key = Config::get('services.openweathermap.key');
        $url = str_replace(['{$city}', '{$key}'], [$city, $key], self::URL);
        try {
            $response = Http::get($url);
            return $response->json();
        } catch (ConnectionException $e) {

        }
        return false;
    }
}