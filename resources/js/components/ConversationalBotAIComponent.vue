<template>
    <div id="app">
        <button @click="sendData">Play command</button>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import alanBtn from "@alan-ai/alan-sdk-web";
import WeatherService from "../services/weather-service";



const alan = alanBtn({
    key: "36ccd1114056b44e4a4b815d1b7346612e956eca572e1d8b807a3e2338fdd0dc/stage",

    /*
        onCommand: (commandData) => {
          if (commandData.command === 'goBack') {
            // Call client code that will react to the received command
            console.log(commandData);
            alert("dupaaaaaaaa")

          }
        }

     */
    onCommand: (commandData) => {
        if (commandData.command === "temperatureInside")
            readTemperatureInside();

        if (commandData.command === "weatherInside")
            setTimeout(readWeatherDataInside(), 1000);

        if (commandData.command === "humidityInside")
            setTimeout(readHumidityInside(), 1000);

        if (commandData.command === "pressureInside")
            setTimeout(readPressureInside(), 1000);

        if (commandData.command === "lightIntensityInside")
            setTimeout(readLightIntensityInside(), 1000);


    },
});


async function readWeatherDataInside() {
    //console.log(temperature)
    const localWeatherData = await WeatherService.getLocalWeatherDataLogs();
    let temp = await ref(localWeatherData.temperature_at_home);
    let humidity = ref(localWeatherData.humidity_at_home);
    let pressure = ref(localWeatherData.pressure_at_home);
    let lightIntensity = ref(localWeatherData.light_intensity_at_home);
    console.log(pressure.value);
    //console.log(alan);
    await alan.activate();
    // Calling the project API method on button click
    alan.callProjectApi(
        "weatherInside",
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
    // Calling the project API method on button click
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
    // Calling the project API method on button click
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
    // Calling the project API method on button click
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
    // Calling the project API method on button click
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
