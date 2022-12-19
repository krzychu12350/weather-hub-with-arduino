<template>
</template>

<script setup>
import { ref } from 'vue'
import alanBtn from "@alan-ai/alan-sdk-web";
import WeatherService from "../services/weather-service";
import globals from "../globals";


const alan = alanBtn({
    key: globals.ALAN_STUDIO_KEY,
    onCommand: (commandData) => {
        if (commandData.command === "temperatureInside")
            readTemperatureInside();

        if (commandData.command === "weather")
            readWeatherDataInside()

        if (commandData.command === "humidityInside")
            readHumidityInside()

        if (commandData.command === "pressureInside")
            readPressureInside()

        if (commandData.command === "lightIntensityInside")
           readLightIntensityInside()
    },
});


async function readWeatherDataInside() {
    let localWeatherData = await WeatherService.getLocalWeatherDataLogs();
    let temp = await ref(localWeatherData.temperature_at_home);
    let humidity = ref(localWeatherData.humidity_at_home);
    let pressure = ref(localWeatherData.pressure_at_home);
    let lightIntensity = ref(localWeatherData.light_intensity_at_home);
    await alan.activate();
    alan.callProjectApi(
        "weather",
        {
            temp: temp.value,
            humidity: humidity.value,
            pressure: pressure.value,
            lightIntensity: lightIntensity.value
        },
        function (error, result) {
            console.log(result);
        }
    );
}

async function readTemperatureInside() {
    const localWeatherData = await WeatherService.getLocalWeatherDataLogs();
    let temp = await ref(localWeatherData.temperature_at_home);
    await alan.activate();
    alan.callProjectApi(
        "temperatureInside",
        {
            temp: temp.value,
        },
        function (error, result) {
            console.log(result);
        }
    );
}

async function readHumidityInside() {
    const localWeatherData = await WeatherService.getLocalWeatherDataLogs();
    let humidity = ref(localWeatherData.humidity_at_home);
    await alan.activate();
    alan.callProjectApi(
        "humidityInside",
        {
            humidity: humidity.value,
        },
        function (error, result) {
            console.log(result);
        }
    );
}

async function readPressureInside() {
    const localWeatherData = await WeatherService.getLocalWeatherDataLogs();
    let pressure = ref(localWeatherData.pressure_at_home);
    await alan.activate();
    alan.callProjectApi(
        "pressureInside",
        {
            pressure: pressure.value,
        },
        function (error, result) {
            console.log(result);
        }
    );
}

async function readLightIntensityInside() {
    const localWeatherData = await WeatherService.getLocalWeatherDataLogs();
    let lightIntensity = ref(localWeatherData.light_intensity_at_home);
    await alan.activate();
    alan.callProjectApi(
        "lightIntensityInside",
        {
            lightIntensity: lightIntensity.value,
        },
        function (error, result) {
            console.log(result);
        }
    );
}

</script>
