<?php

use GuzzleHttp\Exception\GuzzleException;

require 'vendor/autoload.php';
require_once "config.php";

class OpenWeatherMapApi
{

    function getLocationDetails(String $location): ?array
    {
        $API_URI = sprintf(API_LOCATION_DETAILS, $location, API_KEY);

        try {
            $client = new GuzzleHttp\Client();
            $res = $client->get($API_URI);
            $response = json_decode($res->getBody());

            if (!$response) {
                $_SESSION['error'] = "Не можу отримати дані по цьому місту. Спробуйте, будь ласка, ще раз!";
                header("Location: ".BASE_URL);
                return null;
            }

            $lat = $response["0"]->lat;
            $lon = $response["0"]->lon;

            if (str_contains(json_encode($response["0"]),"local_names")) {
                if (str_contains(json_encode($response["0"]->local_names), "uk")) {
                    $cityName = $response["0"]->local_names->uk;
                }
                if (str_contains(json_encode($response["0"]->local_names), "en")) {
                    $cityNameEn = $response["0"]->local_names->en;
                }
                if (str_contains(json_encode($response["0"]->local_names), "eu")) {
                    $cityNameEn = $response["0"]->local_names->eu;
                }

            } else {
                $cityName = $response["0"]->name;
                $cityNameEn = $response["0"]->name;
            }

            return [$lat, $lon, $cityName, $cityNameEn];
        } catch (GuzzleException $e) {
            $_SESSION['error'] = "Не можу отримати дані по цьому місту. Спробуйте, будь ласка, ще раз!";
            header("Location: ".BASE_URL);
            return null;
        }

    }

    function getWeatherForLocation(String $lat, String $lon) {

        $part = "hourly,minutely";
        $units = "metric";
        $API_URI = sprintf(API_WEATHER_LOCATION, $lat, $lon, $part, API_KEY, $units);

        $client = new GuzzleHttp\Client();

        try {
            $res = $client->get($API_URI);
            return json_decode($res->getBody());
        } catch (GuzzleException $e) {
            $_SESSION['error'] = "Не можу отримати дані по цьому місту. Спробуйте, будь ласка, ще раз!";
            header("Location: ".BASE_URL);
            return null;
        }
    }
}