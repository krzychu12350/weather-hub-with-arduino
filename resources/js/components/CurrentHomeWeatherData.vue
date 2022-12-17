<template>
    <h2
        class="color text-white mt-4 mb-4"
    >
        Home Weather Data
    </h2>
    <div class="row justify-content-md-center justify-content-lg-start">
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Temperature" :value=this.temperature
                                            iconClass="fa-solid fa-droplet"></CurrentWeatherDataLogComponent>
        </div>
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Humidity" :value=this.humidity></CurrentWeatherDataLogComponent>
        </div>
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Pressure" :value=this.pressure></CurrentWeatherDataLogComponent>
        </div>
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Light intensity"
                                            :value=this.lightIntensity></CurrentWeatherDataLogComponent>
        </div>
    </div>
    <!-- fa-solid fa-droplet  fa-solid fa-temperature-full
    test
    {{this.temperature}}
    {{this.humidity}}
    -->
</template>

<script>
import CurrentWeatherDataLogComponent from "./CurrentWeatherDataLogComponent.vue";
import axios from "axios";
import api from '../services/api';
import authHeader from "../services/auth-header";
import WeatherService from "../services/weather-service";
import UserService from "../services/user-service";

export default {
    name: "CurrentHomeWeatherData",
    data() {
        return {
            temperature: String,
            humidity: String,
            pressure: String,
            lightIntensity: String,
        }
    },
    components: {
        CurrentWeatherDataLogComponent
    },
    mounted() {
        this.fetchCurrentLocalWeatherData()
    },
    methods: {
        async fetchCurrentLocalWeatherData() {


            let localWeatherData = await WeatherService.getLocalWeatherDataLogs();
            console.log(localWeatherData);

            this.temperature = localWeatherData.temperature_at_home + "°";
            this.humidity = localWeatherData.humidity_at_home + "%";
            this.pressure = localWeatherData.pressure_at_home + " hPa";
            this.lightIntensity = localWeatherData.light_intensity_at_home + " lux";

            /*
            return api.get('/current-home-weather-data', authHeader())
                .then(response => {
                    console.log(response.data.data);
                    this.temperature = response.data.data.temperature_at_home + "°";
                    this.humidity = response.data.data.humidity_at_home + "%";
                    this.pressure = response.data.data.pressure_at_home + " hPa";
                    this.lightIntensity = response.data.data.light_intensity_at_home + " lux";
                    //console.log(this.temperature);
                    return response.data.data;
                })
                .catch(e => {
                        console.log(e)
                    }
                );
        */

        }
    }
}
</script>

<style scoped>

</style>
