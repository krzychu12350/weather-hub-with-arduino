<template>
    <section class="primary-place-forecast">

        <div v-if="loading" class="d-flex justify-content-center align-items-center min-vh-100">
            <div>
                <MoonLoader :color="'#0096FF'"></MoonLoader>
                <h3>Loading...</h3>
            </div>
        </div>
        <div class="container d-flex align-items-center flex-column">
            <div class="m-1">
                <h1>{{ this.place }}  {{ this.country }}</h1>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-1">
                <img class="image " :src=this.icon>
                <h1>{{ this.temp }}° C</h1>
            </div>
            <div class="d-flex justify-content-center flex-column">
                <span>{{ this.description }}</span><br/>
                <span>{{ this.currentDate }}</span>
                <span>Temp min: {{ this.tempMin }}° C</span><br/>
                <span>Temp max: {{ this.tempMax }}° C</span><br/>
                <span>Temp pressure: {{ this.pressure }} hPa</span><br/>
                <span>Temp humidity: {{ this.humidity }}%</span>

                <span> Wind speed: {{ this.windSpeed }} m/s</span>
                <span> Wind direction: {{ this.windDeg }} degrees (meteorological)</span>
                <span> Wind gust: {{ this.windGust }} m/s</span>

                <span> Visibility: {{ this.visibility }} km</span>

                <span> Cloudy: {{ this.cloudy }}%</span>
                <span> Sunrise: {{ this.sunrise }}</span>
                <span> Sunset: {{ this.sunset }}</span>


            </div>
        </div>
    </section>
</template>

<script>
import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
import UserService from '../services/user-service';
import WeatherService from "../services/weather-service";

export default {
    name: "CurrentWeatherDataComponent",
    components: {
        MoonLoader,
    },
    data() {
        return {
            placeId: '763829',
            /*api: 'https://api.openweathermap.org/data/2.5/weather?id=' + this.placeId +
                '&appid=7aef87c2b6d81812c53c536b5a1d715c&lang=en&units=metric',*/
            //api: Globals.API_URL + '&id=' + this.placeId + '&units=metric',
            weatherData: {},
            loading: false,
            place: String,
            country: String,
            temp: null,
            icon: "",
            description: "",
            currentDate: "",
            //favouritePlaces: null,
            tempMin: Number,
            tempMax: Number,
            pressure: Number,
            humidity: Number,
            windSpeed: Number,
            windDeg: Number,
            windGust: Number,
            visibility: Number,

            cloudy: Number,
            sunrise: Number,
            sunset: Number,
        }
    },
    mounted() {
        //this.getForecast()
        //this.retrieveFavouritePlaces()
    },
    created() {
        this.getForecast(this.placeId)
        //this.retrieveFavouritePlaces()
        this.emitter.on('passSearchedPlaceId', (evt) => {
            //alert(evt.value);
            this.placeId = evt.value
            this.getForecast(evt.value)
        })

    },
    methods: {
        async getForecastForSelectedPlace(placeId) {
            this.placeId = placeId
            await this.getForecast()
            //console.log(this.placeId+ 'efqfeqfqf')
        },

        async getForecast(placeId) {
            //this.placeId = s
            //console.log(this.placeId+ 'efqfeqfqf')
            this.loading = true
            /*
            this.axios.get('https://api.openweathermap.org/data/2.5/weather?id=' + this.placeId +
                '&appid=7aef87c2b6d81812c53c536b5a1d715c&lang=en&units=metric')
            */
            WeatherService.getCurrentForecast(placeId)
                .then((response) => {
                    this.weatherData = response.data
                    this.place = this.weatherData.name
                    this.country = this.weatherData.sys.country
                    this.icon = 'https://openweathermap.org/img/wn/' + this.weatherData.weather[0].icon + '@2x.png'
                    this.description = this.weatherData.weather[0].description
                    this.currentDate = this.createDate(this.weatherData.dt, "long")

                    this.temp = this.weatherData.main.temp.toFixed()
                    this.tempMin = this.weatherData.main.temp_min.toFixed()
                    this.tempMax = this.weatherData.main.temp_max.toFixed()
                    this.pressure = this.weatherData.main.pressure
                    this.humidity = this.weatherData.main.humidity

                    this.windSpeed = this.weatherData.wind.speed
                    this.windDeg = this.weatherData.wind.deg
                    this.windGust = this.weatherData.wind.gust
                    this.visibility = this.weatherData.visibility/1000

                    this.cloudy = this.weatherData.clouds.all
                    this.sunrise = this.createTimeFromUnixTimestamp(this.weatherData.sys.sunrise)
                    this.sunset = this.createTimeFromUnixTimestamp(this.weatherData.sys.sunset)
                })
                .catch(err => console.log(err.message))
                .finally(() => (this.loading = false))
        },

        createDate(dt, type) {
            let day = new Date(dt * 1000);
            if (type === "long") {
                let options = {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                };
                return day.toLocaleString("en-us", options); // Friday, January 15, 2021
            } else {
                return day.toLocaleString("en-us", {weekday: "long"}); // Friday
            }
        },
        createTimeFromUnixTimestamp(unixTimestamp) {
            // Timestamp in seconds
            //var unixTimestamp = 1651822834;

            /* Create a new JavaScript Date object based on Unix timestamp.
            Multiplied it by 1000 to convert it into milliseconds */
            return new Date(unixTimestamp * 1000).toLocaleTimeString("default",
              {hour: '2-digit', minute:'2-digit'});
            /*
            // Generate date string
            console.log(date.toLocaleDateString("en-US"));   // Prints: 5/6/2022
            console.log(date.toLocaleDateString("en-GB"));   // Prints: 06/05/2022
            console.log(date.toLocaleDateString("default")); // Prints: 5/6/2022

            // Generate time string
            console.log(date.toLocaleTimeString("en-US"));   // Prints: 1:10:34 PM
            console.log(date.toLocaleTimeString("it-IT"));   // Prints: 13:10:34
            console.log(date.toLocaleTimeString("default")); // Prints: 1:10:34 PM

             */
        }

        /*
        async retrieveFavouritePlaces() {
            UserService.getUserFavouritePlaces()
                .then(response => {
                    this.favouritePlaces = response.data.data.favourite_places;
                    //console.log(this.favouritePlaces)
                })
                .catch(e => {
                    console.log(e);
                });
        },
        */
    }
}
</script>

<style scoped>

</style>
