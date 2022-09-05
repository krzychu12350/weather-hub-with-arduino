<template>
    <section class="primary-place-forecast me-4">

        <div v-if="loading" class="d-flex justify-content-center align-items-center min-vh-100">
            <div>
                <MoonLoader :color="'#0096FF'"></MoonLoader>
                <h3>Loading...</h3>
            </div>
        </div>
        <div class="container d-flex align-items-center flex-column text-center">
            <div class="m-1">
                <h2 class="place-location">{{ this.place }}, {{ this.country }}</h2>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-1">
                <img class="image " :src=this.icon>
                <span class="current-temp">{{ this.temp }}°</span>
                <div class="d-flex flex-column ms-4">
                    <div id="metric-unit" class="mb-1" @click="setUnitOfMeasurement('metric')">
                        <span class="temp-unit">C</span>
                    </div>
                    <div id="imperial-unit" @click="setUnitOfMeasurement('imperial')">
                        <span class="temp-unit">F</span>
                    </div>
                </div>

            </div>
            <span class="description">{{ this.description }}</span><br/>
            <span class="current-date"><b>{{ this.currentDate }}</b></span>
            <span class="lastUpdateTime text-white mt-2">Last update at {{ this.lastUpdateDate }}</span>
            <div class="d-flex justify-content-center flex-row mt-3">
                <div class="d-flex flex-column mb-2 me-4">
                    <span class="weather-detail flex-column">
                        Temp min
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-temperature-full"
                            color="white"
                            size="sm"/>
                        {{ this.tempMin }}° C
                    </span>

                    <span class="weather-detail">
                        Temp min
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-temperature-full"
                            color="white"
                            size="sm"/>
                        {{ this.tempMax }}° C
                    </span>

                    <span class="weather-detail">Pressure {{ this.pressure }}hPa</span>

                    <span class="weather-detail">
                        Humidity
                         <font-awesome-icon
                             class="temp-icon"
                             icon="fa-solid fa-droplet"
                             color="white"
                             size="sm"/>
                        {{ this.humidity }}%
                    </span>
                </div>
                <div class="d-flex flex-column mb-2 me-4">
                    <span class="weather-detail">
                        Wind speed
                             <font-awesome-icon
                                 class="temp-icon"
                                 icon="fa-solid fa-wind"
                                 color="white"
                                 size="sm"/>
                        {{ this.windSpeed }} m/s
                    </span><br/>
                    <!-- Wind direction  degrees (meteorological) -->

                    <span class="weather-detail"> Wind direction {{ this.windDeg }}</span><br/>

                    <span class="weather-detail"> Wind gust {{ this.windGust }} m/s</span><br/>
                </div>
                <div class="d-flex flex-column mb-2 me-4">
                    <span class="weather-detail">
                        Visibility
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-eye"
                            color="white"
                            size="sm"/>
                        {{ this.visibility }} km
                    </span>

                    <span class="weather-detail">
                        Cloudy:
                             <font-awesome-icon
                                 class="temp-icon"
                                 icon="fa-solid fa-cloud"
                                 color="white"
                                 size="sm"/>
                        {{ this.cloudy }}%
                    </span><br/>

                    <span class="weather-detail">
                        Sunrise
                             <font-awesome-icon
                                 class="temp-icon"
                                 icon="fa-solid fa-moon"
                                 color="white"
                                 size="sm"/>
                        {{ this.sunrise }}
                    </span>

                    <span class="weather-detail">
                        Sunset
                               <font-awesome-icon
                                   class="temp-icon"
                                   icon="fa-solid fa-sun"
                                   color="white"
                                   size="sm"/>
                        {{ this.sunset }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
import WeatherService from "../services/weather-service";
import UserService from "../services/user-service";
import * as iso from "iso-3166-1";
import Globals from "../globals";

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
            lastUpdateDate: Date,
            activeUnit: true,
        }
    },
    async mounted() {
        //this.getForecast()
        //this.retrieveFavouritePlaces()
        this.placeId = await this.getUserPrimaryPlaceId()
        console.log("current " + this.placeId)

    },
    async created() {
        await this.getForecast(this.placeId)
        await  this.updateIntervalCurrentWeather(this.placeId)
        //this.retrieveFavouritePlaces()
        this.emitter.on('passSearchedPlaceId', (evt) => {
            //alert(evt.value);
            this.placeId = evt.value
            this.getForecast(evt.value)
        })

    },
    methods: {
        getUserPrimaryPlaceId() {
            return UserService.getUserProfileData()
                .then(response => {
                    //this.favouritePlaces = response.data.data.favourite_places;
                    return response.data.data.primary_place_id
                    //console.log("global" + Globals.PRIMARY_PLACE_ID)
                })
                .catch(e => {
                    console.log(e);
                });
        },
        setUnitOfMeasurement(unitName) {
            Globals.UNIT_OF_MEASUREMENT = unitName
            this.emitter.emit('rerenderPage')
        },
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
            await WeatherService.getCurrentForecast(placeId)
                .then((response) => {
                    this.weatherData = response.data
                    this.place = this.weatherData.name
                    this.country = iso.whereAlpha2(this.weatherData.sys.country).country

                   // alert(this.weatherData.weather[0].icon)
                    this.emitter.emit('passCurrentWeatherIcon', {icon: this.weatherData.weather[0].icon})

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
                    this.visibility = this.weatherData.visibility / 1000

                    this.cloudy = this.weatherData.clouds.all
                    this.sunrise = this.createTimeFromUnixTimestamp(this.weatherData.sys.sunrise)
                    this.sunset = this.createTimeFromUnixTimestamp(this.weatherData.sys.sunset)
                    let currentTime = new Date();
                    this.lastUpdateDate = currentTime.toLocaleTimeString("default",
                        {hour: '2-digit', minute: '2-digit'});
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
                {hour: '2-digit', minute: '2-digit'});
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
        },
        async updateIntervalCurrentWeather (placeId) {
            this.callIntervalMethod = setInterval(async () => {
                await this.getForecast(placeId)
            },  1800000)
        },

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

<style lang="scss">
.place-location {
    color: #FFFFFF;
    font-size: 3em;
}
.current-temp {
    color: #FFFFFF;
    font-size: 4em;
}
.description {
    color: #FFFFFF;
    font-size: 2em;
    font-weight: normal;
}
.current-date {
    color: #FFFFFF;
    font-size: 1.25em;
}
.weather-detail {
    color: #FFFFFF;
    font-size: 1em;
}
.temp-unit {
    color: #FFFFFF;
    font-size: 1.5em;
}
#metric-unit:hover, #imperial-unit:hover {
    cursor: pointer;
    opacity: 0.5;
    font-weight: bold;
    //border: 2px solid white;
}
</style>
