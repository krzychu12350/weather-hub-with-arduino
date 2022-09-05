<template>
    <!--<div class=" d-flex align-items-center justify-content-center vh-100">-->
        <TopBarComponent :nameOfTheSubpage="'Forecast'"></TopBarComponent>
        <!--<img :src="imageUrl">-->
        <div :style="{ backgroundImage: 'url(' + this.imageUrl + ')' }" v-if="renderComponent" class="col-12 primary-container w-100 min-vh-100 d-flex">
            <!--<div class="row min-vh-100">-->

                <div class="col-3 col-md-2 col-lg-1">
                    <SidebarComponent></SidebarComponent>
                </div>



                <div class="col-9 col-md-10 col-lg-11 mt-2">
                   <!-- <TopBarComponent class=""></TopBarComponent>-->
                    <!--<SearchEngineComponent @get-forecast-for-selected-place="getForecastForSearchedPlace"/>
                    <SearchEngineComponent />-->

                    <!--<TestSearch></TestSearch>-->


                    <CurrentWeatherDataComponent></CurrentWeatherDataComponent>

                    <section id="favourite-places" class="me-4">
                        <h2 class="color text-white mt-4 mb-4">Your favourite places</h2>
                        <div class="row justify-content-md-center justify-content-lg-start">
                            <div class="col-12 col-md-5 col-lg-2 me-4" v-for="favouritePlace in favouritePlaces">
                                <FavouritePlaceComponent
                                    @click="getWeatherDataForSelectedPlace(favouritePlace.id)"
                                    v-bind:isUserFavouritePlace="true"
                                    v-bind:placeId="favouritePlace.id"
                                    v-bind:place="favouritePlace.name"
                                    v-bind:country="favouritePlace.country"
                                    v-bind:currentWeatherData="this.getForecastFavouritePlace(favouritePlace.id)"
                                ></FavouritePlaceComponent>
                            </div>
                            <div class="col-12 col-md-5 col-lg-2 me-4">
                                <FavouritePlaceComponent
                                    v-bind:isUserFavouritePlace="false"
                                    v-bind:place="'Add new place'"
                                ></FavouritePlaceComponent>
                            </div>
                        </div>
                    </section>



                    <!--
                        <button v-on:click="show = !show">
                            Toggle transition
                        </button>
                        Duration:
                        <input v-model="duration" type="range" min="100" max="3000">
                        {{duration}}ms

                    <button @click="isHumAndTempsCharVisible = !isHumAndTempsCharVisible">
                        Toggle transition
                    </button>
                           -->

                            <!--<div v-if="isHumAndTempsCharVisible" class="box"></div>-->

                    <!--<TemperatureAndHumidityChartComponent
                    v-if="isHumAndTempsCharVisible"
                    :triggerData="this.chartData">
                    </TemperatureAndHumidityChartComponent>
                    -->
                    <fade-transition mode="out-in" :duration="500">

                        <div v-if="isHumAndTempsCharVisible">
                            <HorizontalLineComponent/>
                            <TemperatureAndHumidityChartComponent
                                :triggerData="this.chartData">
                            </TemperatureAndHumidityChartComponent>
                        </div>
                        <div v-else>
                            <section id="daily-forecast" class="">
                                <HorizontalLineComponent/>
                                <DailyForecastComponent></DailyForecastComponent>
                                <HorizontalLineComponent/>
                                <HourlyForecastComponent></HourlyForecastComponent>
                            </section>
                        </div>
                    </fade-transition>



                </div>
                <!--
                <div class="weather-details col-4">


                    <section class="primary-place-forecast">

                        <div v-if="loading" class="d-flex justify-content-center align-items-center min-vh-100">
                            <div>
                                <MoonLoader :color="'#0096FF'"></MoonLoader>
                                <h3>Loading...</h3>
                            </div>
                        </div>
                        <div class="container d-flex align-items-center flex-column">
                            <div class="m-1">
                                <h1>{{ this.locality }}</h1>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-1">
                                <img class="image " :src=this.icon>
                                <h1>{{ this.temp }}° C</h1>
                            </div>
                            <div class="d-flex justify-content-center flex-column">
                                <span>{{ this.description }}</span><br/>
                                <span>{{ this.currentDate }}</span>
                            </div>
                        </div>
                    </section>

                </div>
                -->
            </div>
       <!-- </div>-->
  <!--  </div>-->
</template>

<script>
import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
import SidebarComponent from "../components/SidebarComponent.vue";
import SearchEngineComponent from "../components/SearchEngineComponent.vue";
import UserService from '../services/user-service';
import FavouritePlaceComponent from "../components/FavouritePlaceComponent.vue";
import CurrentWeatherDataComponent from "../components/CurrentWeatherDataComponent.vue";
import DailyForecastComponent from "../components/DailyForecastComponent.vue";
import HourlyForecastComponent from "../components/HourlyForecastComponent.vue";
import TemperatureAndHumidityChartComponent from "../components/TemperatureAndHumidityChartComponent.vue";
import FadeTransition from "../components/FadeTransition.vue";
import TopBarComponent from "../components/TopBarComponent.vue";
import WeatherService from "../services/weather-service";
import Globals from "../globals";
import moment from "moment";
import { nextTick, ref } from 'vue';
import HorizontalLineComponent from "../components/HorizontalLineComponent.vue";
import {useRouter} from "vue-router";
import ToastService from "../services/toast-service";
export default {
    name: "Home",
    components: {
        TopBarComponent,
        TemperatureAndHumidityChartComponent,
        HourlyForecastComponent,
        DailyForecastComponent,
        FavouritePlaceComponent,
        MoonLoader,
        SidebarComponent,
        SearchEngineComponent,
        CurrentWeatherDataComponent,
        FadeTransition,
        HorizontalLineComponent,
    },
    setup() {
        const router = useRouter()
        if(!Globals.PRIMARY_PLACE_ID) router.push({ name: 'SelectPrimaryPlacePage'})

        const renderComponent = ref(true);

        const forceRerender = async () => {
            // Remove MyComponent from the DOM
            renderComponent.value = false;

            // Wait for the change to get flushed to the DOM
            await nextTick();

            // Add the component back in
            renderComponent.value = true;
        };
        return { renderComponent, forceRerender }
    },
  data() {
      return {
          favouritePlaces: Array,
          isHumAndTempsCharVisible: false,
          callIntervalMethod: null,
          weatherDataLogs: Array,
          toBeWatched: false,
          chartData: Array,
          weatherDataOfFavPlace: Object,
          imageUrl: new URL("../assets/images/weather-conditions/" +
              Globals.CURRENT_WEATHER_ICON + "-bg-img.jpg", import.meta.url).href,
          }
      },
    async created() {
        await this.retrieveFavouritePlaces()
        await this.retrieveWeatherDataLogs()

        this.emitter.on('showValOfHumidityAndTempsChart', (evt) => {
            //alert(evt.placeId + 'home vue');
            this.isHumAndTempsCharVisible = !this.isHumAndTempsCharVisible
            //console.log(this.processSpecificPlaceWeatherLogs(evt.placeId))
            if (this.isHumAndTempsCharVisible) {
                this.chartData = this.processSpecificPlaceWeatherLogs(evt.placeId)
            }
            //console.log(chartData)
            //this.emitter.emit('passChartData', {chartData})

        })
        this.emitter.on('rerenderPage', () => {

            this.forceRerender()
        })

    },
    mounted() {
        this.emitter.on('passCurrentWeatherIcon', (evt) => {
            //alert(evt.value);
            //console.log(evt.icon)
            Globals.CURRENT_WEATHER_ICON = evt.icon
            const icon = evt.icon
            //const icon = "04d"
            this.imageUrl = new URL("../assets/images/weather-conditions/" + icon + "-bg-img.jpg", import.meta.url).href
        })
    },
    beforeUnmount () {
        clearInterval(this.callIntervalMethod)
    },
    methods: {
        filterWeatherDataLogs (weatherDataLogs, placeId) {
            //console.log(placeId)
            //console.log(weatherDataLogs.find(place => place.id === placeId))
            //console.log(weatherDataLogs.find(place => place.id === placeId))
            const result = Array.isArray(weatherDataLogs) ? weatherDataLogs.find(place => place.id === placeId) : 0;
            //console.log(result)
            return result

            //return weatherDataLogs

        },
        processSpecificPlaceWeatherLogs (placeId) {
            let place = JSON.parse(JSON.stringify(this.filterWeatherDataLogs(this.weatherDataLogs, placeId)))
            //console.log(place[0].weather_data_logs)
            let seriesOfTemperatures = place.weather_data_logs.map(singleLog => singleLog.temperature);
            let seriesOfHumidity = place.weather_data_logs.map(singleLog => singleLog.humidity);
            //let seriesOfCreatedAt = place.weather_data_logs.map(singleLog => singleLog.created_at);
            let seriesOfCreatedAt = place.weather_data_logs
                .map(singleLog =>  moment(singleLog.created_at).format("MM/DD/YYYY hh:mm"));

            //console.log(seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt)
            if(Globals.UNIT_OF_MEASUREMENT === 'imperial')
                seriesOfTemperatures = seriesOfTemperatures.map(value => (value * 1.8) + 32)

            return [seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt]
        },
        async retrieveFavouritePlaces() {
            UserService.getUserProfileData()
                .then(response => {
                    //console.log(response.data.data.name)
                    ToastService.showToast("Hello " + response.data.data.name +
                        ", check out the latest weather forecast right now !!!", 'info')
                    this.favouritePlaces = response.data.data.favourite_places;
                    //console.log(this.favouritePlaces)
                })
                .catch(e => {
                    console.log(e);
                });
        },
        async retrieveWeatherDataLogs () {
            this.weatherDataLogs = await UserService.getWeatherDataLogsForFavouritePlaces()
            this.callIntervalMethod = setInterval(async () => {
                //console.log("Działa powtarzanie")
                this.weatherDataLogs = await UserService.getWeatherDataLogsForFavouritePlaces()
                console.log(this.weatherDataLogs)
            },  1830000)

        },
        //1830000
        //3000
        getWeatherDataForSelectedPlace(placeId) {
            this.emitter.emit('passSearchedPlaceId',
                {'value': placeId})
        },
        getForecastFavouritePlace(placeId) {
            return WeatherService.getCurrentForecast(placeId)
                .then((response) => {

                    return response.data
                    //console.log(this.weatherDataOfFavPlace)
                })
                .catch(err => console.log(err.message))
        },

    },
}
</script>

<style>

/*
//https://openweathermap.org/weather-conditions
//01d
//02d
//03d
//04d
//09d
//10d
//11d
//13d
//50d

//01n
//02n
//03n
//04n
//09n
//10n
//11n
//13n
//50n
*/

.primary-container {
    background-size: cover;
    background-repeat: no-repeat;
    /*
    background-image: url('../assets/images/cloudy-night-sky-moon.jpg');
    */
}
</style>
