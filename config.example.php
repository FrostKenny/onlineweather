<?php

const BASE_URL = "/weatherphp/";

// OpenWeather API
const defaultLocation = 'Київ';
const defaultLocationEn = "Kyiv";
const API_KEY = '';
const API_LOCATION_DETAILS = 'https://api.openweathermap.org/geo/1.0/direct?q=%s&limit=1&appid=%s';
const API_WEATHER_LOCATION = 'https://api.openweathermap.org/data/2.5/onecall?lat=%s&lon=%s&exclude=%s&appid=%s&units=%s&lang=uk';

// Unsplash API
const UNSPLASH_API_KEY = '';
const UNSPLASH_API_ENDPOINT = 'https://api.unsplash.com/search/photos?query=%s&client_id=%s&orientation=landscape&per_page=1000';

