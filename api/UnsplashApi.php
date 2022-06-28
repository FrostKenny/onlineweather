<?php

use GuzzleHttp\Exception\GuzzleException;

require 'vendor/autoload.php';
require_once "config.php";

class UnsplashApi
{
    function getCityPicture(String $cityName): ?string
    {
        $API_URI = sprintf(UNSPLASH_API_ENDPOINT, $cityName, UNSPLASH_API_KEY);

        try {
            $client = new GuzzleHttp\Client();
            $res = $client->get($API_URI);
            $response = json_decode($res->getBody());

            if (!$response || !str_contains(json_encode($response->results), "urls")) {
                return null;
            } else {
                $likedPhotos = [];

                foreach ($response->results as $arr) {
                    if ($arr->likes >= 20) {
                        $likedPhotos[] = $arr;
                    }
                }

                #print_r($likedPhotos);

                $arrayIdx = array_rand($likedPhotos, true);
                return $likedPhotos[$arrayIdx]->urls->regular;
            }

        } catch (GuzzleException) {
            return null;
        }
    }
}