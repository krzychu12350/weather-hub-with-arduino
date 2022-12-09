<template>
    <h2
        class="color text-white mt-4 mb-4"
    >
        Home Weather Data
    </h2>
    <div class="row justify-content-md-center justify-content-lg-start">
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Temperature" :value=this.temperature iconClass="fa-solid fa-droplet"/>
        </div>
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Humidity" :value=this.humidity />
        </div>
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Pressure" value="1020 hPa"/>
        </div>
        <div class="col-11 col-md-5 col-lg-2 me-4">
            <CurrentWeatherDataLogComponent name="Light intensity" value="100 lux"/>
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
import authHeader from "../services/auth-header";

export default {
    name: "CurrentHomeWeatherData",
    data() {
        return {
            temperature: String,
            humidity: String,
        }
    },
    components: {
        CurrentWeatherDataLogComponent
    },
    mounted() {
        this.getWeatherDataLogsForFavouritePlaces()
    },
    methods: {
         async getWeatherDataLogsForFavouritePlaces() {
            return axios.get('http://192.168.1.69:8000/api/current-home-weather-data', authHeader())
                .then(response => {
                    console.log(response.data.data);
                    this.temperature = response.data.data.temperature_at_home + "°";
                    this.humidity = response.data.data.humidity_at_home + "%";
                    //console.log(this.temperature);
                    return response.data.data;

                })
                .catch(e => {
                        console.log(e)
                    }
                );
        }
    }
}
</script>

<style scoped>

</style>
