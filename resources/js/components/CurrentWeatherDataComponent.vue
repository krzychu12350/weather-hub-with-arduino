<template>
    <section
        class="primary-place-forecast me-4"
    >
        <div
            v-if="loading"
            class="col-lg-11 d-flex flex-column
            justify-content-center align-items-center
            min-vh-100"
        >
            <div
                class="me-2"
            >
                <MoonLoader
                    class="d-flex justify-content-center"
                    :color="'#ffffff'"
                />
            </div>
            <div>
                <h3
                    class="mt-2 text-white"
                >
                    Loading
                </h3>
            </div>
        </div>
        <div
            v-else
            class="container d-flex
            align-items-center
            flex-column text-center"
        >
            <div class="m-1">
                <h2
                    class="place-location"
                >
                    {{ this.place }}, {{ this.country }}
                </h2>
            </div>
            <div
                class="d-flex
                justify-content-center
                align-items-center
                mt-1"
            >
                <img
                    class="image "
                    :src=this.icon
                >
                <span
                    class="current-temp"
                >
                    {{ this.temp }}°
                </span>
                <div
                    class="d-flex
                    flex-column ms-4">
                    <div
                        id="metric-unit"
                        :class="{active: isActiveUnit}"
                        class="mb-1"
                         @click="setUnitOfMeasurement('metric')"
                    >
                        <span
                            class="temp-unit"
                        >
                            C
                        </span>
                    </div>
                    <div
                        id="imperial-unit"
                        :class="{active: !isActiveUnit}"
                         @click="setUnitOfMeasurement('imperial')"
                    >
                        <span
                            class="temp-unit">
                            F
                        </span>
                    </div>
                </div>

            </div>
            <span
                class="description"
            >
                {{ this.description }}
            </span><br/>
            <span
                class="current-date"
            >
                <b>{{ this.currentDate }}</b>
            </span>
            <span
                class="lastUpdateTime text-white mt-2"
            >
                Last update at {{ this.lastUpdateDate }}
            </span>
            <div
                class="d-flex justify-content-center
                flex-row mt-3"
            >
                <div class="d-flex flex-column
                col-3 col-md-4 mb-2 me-4"
                >
                    <span class="weather-detail
                    flex-column"
                    >
                        Temp min -
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-temperature-full"
                            color="white"
                            size="sm"/>
                        {{ this.tempMin }}°
                    </span>
                    <span class="weather-detail">
                        Temp max -
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-temperature-full"
                            color="white"
                            size="sm"/>
                        {{ this.tempMax }}°
                    </span>
                    <span class="weather-detail">
                        Pressure - {{ this.pressure }} hPa
                    </span>
                    <span class="weather-detail">
                        Humidity -
                         <font-awesome-icon
                             class="temp-icon"
                             icon="fa-solid fa-droplet"
                             color="white"
                             size="sm"/>
                        {{ this.humidity }}%
                    </span>
                </div>
                <div class="d-flex flex-column col-3 col-md-4 mb-2 me-4">
                    <span class="weather-detail">
                        Wind speed -<br>
                             <font-awesome-icon
                                 class="temp-icon"
                                 icon="fa-solid fa-wind"
                                 color="white"
                                 size="sm"/>
                        {{ this.windSpeed }} m/s
                    </span>
                    <span class="weather-detail">
                        Wind direction -
                        {{ this.convertDegreesToWindDirection(this.windDeg) }}
                    </span>
                    <span class="weather-detail">
                        Feels like -
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-temperature-full"
                            color="white"
                            size="sm"/>
                        {{ this.feelsLike }}°
                    </span>
                </div>
                <div
                    class="d-flex flex-column
                    col-3 col-md-4 mb-2 me-4"
                >
                    <span class="weather-detail">
                        Visibility -
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-eye"
                            color="white"
                            size="sm"/>
                        {{ this.visibility }} km
                    </span>
                    <span class="weather-detail">
                        Cloudy -
                             <font-awesome-icon
                                 class="temp-icon"
                                 icon="fa-solid fa-cloud"
                                 color="white"
                                 size="sm"/>
                        {{ this.cloudy }}%
                    </span>
                    <span class="weather-detail">
                        Sunset -
                               <font-awesome-icon
                                   class="temp-icon"
                                   icon="fa-solid fa-sun"
                                   color="white"
                                   size="sm"/>
                        {{ this.sunset }}
                    </span>
                    <span class="weather-detail">
                        Sunrise -
                             <font-awesome-icon
                                 class="temp-icon"
                                 icon="fa-solid fa-moon"
                                 color="white"
                                 size="sm"/>
                        {{ this.sunrise }}
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
import d2d from "degrees-to-direction";

export default {
    name: "CurrentWeatherDataComponent",
    components: {
        MoonLoader,
    },
    data() {
        return {
            placeId: Number,
            weatherData: {},
            loading: false,
            place: String,
            country: String,
            temp: null,
            icon: "",
            description: "",
            currentDate: "",
            tempMin: Number,
            tempMax: Number,
            feelsLike: Number,
            pressure: Number,
            humidity: Number,
            windSpeed: Number,
            windDeg: Number,
            visibility: Number,
            cloudy: Number,
            sunrise: Number,
            sunset: Number,
            lastUpdateDate: Date,
            isActiveUnit: true,
        }
    },
    async created() {
        this.placeId = await this.getUserPrimaryPlaceId()
        Globals.PRIMARY_PLACE_ID = this.placeId
        if (!Globals.PRIMARY_PLACE_ID) {
            this.$router.push({name: 'SelectPrimaryPlacePage'})
        }
        await this.getForecast(this.placeId)
        await this.updateIntervalCurrentWeather(this.placeId)
        this.emitter.on('passSearchedPlaceId', (evt) => {
            this.getForecast(evt.value)
        })
    },
    methods: {
        getUserPrimaryPlaceId() {
            return UserService.getUserProfileData()
                .then(response => {
                    return response.data.data.primary_place_id
                })
                .catch(e => {
                    console.log(e);
                });
        },
        async setUnitOfMeasurement(unitName) {
            Globals.UNIT_OF_MEASUREMENT = unitName
            this.isActiveUnit = !this.isActiveUnit
            await this.getForecast(this.placeId)
            this.emitter.emit('rerenderPage')
        },
        async getForecast(placeId) {
            this.loading = true
            await WeatherService.getCurrentForecast(placeId)
                .then((response) => {
                    this.weatherData = response.data
                    this.place = this.weatherData.name
                    this.country =
                        iso.whereAlpha2(this.weatherData.sys.country).country
                    this.emitter.emit('passCurrentWeatherIcon',
                        {icon: this.weatherData.weather[0].icon})
                    this.icon = 'https://openweathermap.org/img/wn/' +
                        this.weatherData.weather[0].icon + '@2x.png'
                    this.description = this.weatherData.weather[0].description
                    this.currentDate = this.createDate(this.weatherData.dt, "long")
                    this.temp = this.weatherData.main.temp.toFixed()
                    this.tempMin = this.weatherData.main.temp_min.toFixed()
                    this.tempMax = this.weatherData.main.temp_max.toFixed()
                    this.feelsLike = this.weatherData.main.feels_like.toFixed()
                    this.pressure = this.weatherData.main.pressure
                    this.humidity = this.weatherData.main.humidity
                    this.windSpeed = this.weatherData.wind.speed
                    this.windDeg = this.weatherData.wind.deg
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
                return day.toLocaleString("en-us", options);
            } else {
                return day.toLocaleString("en-us", {weekday: "long"});
            }
        },
        createTimeFromUnixTimestamp(unixTimestamp) {
            return new Date(unixTimestamp * 1000).toLocaleTimeString("default",
                {hour: '2-digit', minute: '2-digit'});
        },
        async updateIntervalCurrentWeather(placeId) {
            this.callIntervalMethod = setInterval(async () => {
                await this.getForecast(placeId)
            }, 1800000)
        },
        convertDegreesToWindDirection(degrees) {
            return d2d(degrees)
        }
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
    font-size: 2em;
}

#metric-unit:hover, #imperial-unit:hover {
    cursor: pointer;
    opacity: 0.5;
    font-weight: bold;
}

@media (max-width: 1024px) {
    .place-location {
        color: #FFFFFF;
        font-size: 2em;
    }

    .current-temp {
        color: #FFFFFF;
        font-size: 3em;
    }

    .description {
        color: #FFFFFF;
        font-size: 2em;
        font-weight: normal;
    }

    .current-date {
        color: #FFFFFF;
        font-size: 1em;
    }

    .weather-detail {
        color: #FFFFFF;
        font-size: 0.9em;
    }

    .temp-unit {
        color: #FFFFFF;
        font-size: 1.5em;
    }

}

@media (max-width: 768px) {
    .place-location {
        color: #FFFFFF;
        font-size: 2em;
    }

    .current-temp {
        color: #FFFFFF;
        font-size: 3em;
    }

    .description {
        color: #FFFFFF;
        font-size: 1.5em;
        font-weight: normal;
    }

    .current-date {
        color: #FFFFFF;
        font-size: 0.75em;
    }

    .weather-detail {
        color: #FFFFFF;
        font-size: 0.75em;
    }

    .temp-unit {
        color: #FFFFFF;
        font-size: 1em;
    }
}

.active {
    font-weight: bold;
}
</style>
