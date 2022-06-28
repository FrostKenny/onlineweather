IMG_ENDPOINT = `https://openweathermap.org/img/wn/{iconId}@{iconSize}x.png`;

async function parseCurrentWeather(weather, cityName) {
    const days = ["Неділя", "Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця", "Субота"];
    const months = ["Січня", "Лютого", "Березня", "Квітня", "Травня", "Червня", "Липня", "Серпня", "Вересня", "Жовтня", "Листопада", "Грудня"];

    //let location = weather.timezone.split("/")[1];
    let currentTemp = Math.round(weather.current.temp);
    let currentHumidity = weather.current.humidity;
    let currentWindSpeed = weather.current.wind_speed;
    let currentDate = new Date(weather.current.dt * 1000);

    let currentMonth = months[currentDate.getMonth()];
    let currentCalendarDay = currentDate.getDate();
    let currentDay = days[currentDate.getDay()];

    let weatherIcon = weather.current.weather[0].icon;
    let weatherCondition = weather.current.weather[0].description;

    //document.getElementById("location").innerHTML = location;
    document.getElementById("humidity").innerHTML = currentHumidity + "%";
    document.getElementById("temperature").innerHTML = currentTemp;
    document.getElementById("currentWindSpeed").innerHTML = currentWindSpeed + " km/h";

    document.getElementById("currentDay").innerHTML = currentDay;
    document.getElementById("currentDate").innerHTML = currentCalendarDay + " " + currentMonth;

    document.getElementById("currentDayIcon")
        .setAttribute(
            "src",
            IMG_ENDPOINT.replace("{iconId}", weatherIcon)
                .replace("{iconSize}", 4)
        );
    document.getElementById("currentDayIcon").setAttribute("alt", weatherCondition);
    document.getElementById("currentDayIcon").setAttribute("title", weatherCondition);

    let forecastDay;
    let forecastDegree;
    let forecastDegreeFeelsLike;

    let htmlDays = "";
    let forecastDays = weather.daily;

    for (let i = 1; i < forecastDays.length; i++) {
        let day = forecastDays[i];
        let forecastDate = new Date(day.dt * 1000);

        let forecastWeatherIcon = day.weather[0].icon;
        let forecastWeatherCondition = day.weather[0].description;
        let forecastApiIcon = IMG_ENDPOINT.replace("{iconId}", forecastWeatherIcon)
            .replace("{iconSize}", 4);

        forecastDay = days[forecastDate.getDay()];
        forecastDegree = Math.round(day.temp.day);
        forecastDegreeFeelsLike = Math.round(day.feels_like.day);

        let dayHtml = `
        <div class="forecast forecast-day">
            <div class="forecast-header">
                <div class="day">${forecastDay}</div>
            </div> <!-- .forecast-header -->
            <div class="forecast-content">
                <div class="forecast-icon">
                    <img src="${forecastApiIcon}" alt=${forecastWeatherCondition} width=48 title="${forecastWeatherCondition}">
                </div>
                <div class="degree">${forecastDegree}<sup>o</sup>C</div>
                <small>${forecastDegreeFeelsLike}<sup>o</sup></small>
            </div>
        </div>`;

        htmlDays += dayHtml;
    }

    document.getElementById("forecastDays").innerHTML += htmlDays;

    for (let element of document.getElementsByClassName("currentCity")) {
        element.innerHTML = cityName;
    }
}