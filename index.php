<?php

session_start();

require_once "api/OpenWeatherMapApi.php";
require_once "api/UnsplashApi.php";
require_once "config.php";

if (isset($_GET['location'])) {
    $locationDetails = (new OpenWeatherMapApi()) -> getLocationDetails($_GET['location']);
    $cityImage = (new UnsplashApi()) -> getCityPicture($locationDetails[3]);
} else {
    $locationDetails = (new OpenWeatherMapApi()) -> getLocationDetails(defaultLocation);
    $cityImage = (new UnsplashApi()) -> getCityPicture(defaultLocationEn);
}

$weatherData = (new OpenWeatherMapApi()) -> getWeatherForLocation($locationDetails[0], $locationDetails[1]);
$cityName = $locationDetails[2];

if ($cityImage === null) {
    $cityImage = 'images/banner.png';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">

    <title>Погода [Денис Ставський]</title>

    <!-- Loading third party fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet" type="text/css">
    <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Loading main css file -->
    <link rel="stylesheet" href="css/style.css">

    <script src="js/ie-support/html5.js"></script>
    <script src="js/ie-support/respond.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>

    <script>
        $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");
        });
    </script>
</head>


<body>
    <div class="se-pre-con"></div>
	<div class="site-content">
		<div class="site-header">
			<div class="container">
				<a href="/weatherphp" class="branding">
					<img src="images/logo.png" alt="" class="logo">
					<div class="logo-type">
						<h1 class="site-title">Погода <span class="currentCity"></span></h1>
						<small class="site-description"></small>
					</div>
				</a>
			</div>
		</div>

        <?php
            if ( isset($_SESSION['error']) ) {
                error_log($_SESSION['error']);
                echo('<p style="color: red; text-align: center; font-size: 1.3em;">'.htmlentities($_SESSION['error'])."</p>");
                unset($_SESSION['error']);
            }
        ?>

		<div class="hero" data-bg-image="<?php echo $cityImage;?>">
			<div class="container">
				<form action="" class="find-location" method="get">
					<label for="desiredLocation"></label>
					<input type="text" placeholder="Введіть назву міста..." id="desiredLocation" value="" name="location"
																autocomplete="off" minlength="2">
					<input class="btn" type="submit" value="Знайти" onclick="location.reload();">
				</form>
			</div>
            <div class="forecast-table">
                <div class="container">
                    <div class="forecast-container" id="forecastDays">
                        <div class="today forecast">
                            <div class="forecast-header">
                                <div class="day" id="currentDay"></div>
                                <div class="date" id="currentDate"></div>
                            </div>
                            <div class="forecast-content">
                                <div class="location currentCity"></div>
                                <div class="degree">
                                    <div class="num"><span id="temperature"></span><sup>o</sup>C</div>
                                    <div class="forecast-icon">
                                        <img src="images/icons/icon-1.svg" alt="" width=90 id="currentDayIcon">
                                    </div>
                                </div>
                                <span><img src="images/icon-umberella.png" alt=""><span id="humidity"></span></span>
                                <span><img src="images/icon-wind.png" alt=""><span id="currentWindSpeed"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>

	</div>
	<footer class="site-footer">
		<div class="container">
			<p class="colophon">2022 Денис Ставський</p>
		</div>
	</footer>

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/plugins.js"></script>
	<script src="js/app.js"></script>
	<script src="js/weather.js"></script>

	<script>
        let weatherData = (<?php echo json_encode($weatherData); ?>);
        let cityName = "<?php echo $cityName ?>";

        parseCurrentWeather(weatherData, cityName);
	</script>
	</body>
</html>