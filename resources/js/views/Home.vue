<template>
    <!--<div class=" d-flex align-items-center justify-content-center vh-100">-->

        <div class="col-12 primary-container w-100 min-vh-100 d-flex">
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
                        <h2 class="color text-white">Your favourite places</h2>

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
                            <TemperatureAndHumidityChartComponent
                                :triggerData="this.chartData">
                            </TemperatureAndHumidityChartComponent>
                        </div>
                        <div v-else>
                            <section id="daily-forecast" class="">
                                <DailyForecastComponent></DailyForecastComponent>
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
            let seriesOfCreatedAt = place.weather_data_logs.map(singleLog => singleLog.created_at);
            //console.log(seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt)
            return [seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt]

        },
        async retrieveFavouritePlaces() {
            UserService.getUserProfileData()
                .then(response => {
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
    /*
    mounted() {
        this.retrieveFavouritePlaces()
    },

     */

    /*
  //api: 'https://api.openweathermap.org/data/2.5/weather?id=' + this.placeId +
  //    '&appid=7aef87c2b6d81812c53c536b5a1d715c&lang=en&units=metric',
  //api: Globals.API_URL + '&id=' + this.placeId + '&units=metric',
  weatherData: {},
  loading: false,
  locality: "",
  temp: null,
  icon: "",
  description: "",
  currentDate: "",
  favouritePlaces: null,

}
},
mounted() {
//this.getForecast()
//this.retrieveFavouritePlaces()
},
created() {
this.getForecast()
this.retrieveFavouritePlaces()
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
  this.axios.get(Globals.API_URL + '&id=' + this.placeId + '&units=metric')
      .then((response) => {
          this.weatherData = response.data
          this.locality = this.weatherData.name
          this.temp = this.weatherData.main.temp
          this.icon = 'https://openweathermap.org/img/wn/' + this.weatherData.weather[0].icon + '@2x.png'
          this.description = this.weatherData.weather[0].description
          this.currentDate = this.createDate(this.weatherData.dt, "long")
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

}
*/
}
</script>

<style lang="scss">
.primary-container {
    background-image: url('../assets/images/cloudy-night-sky-moon.jpg');
    background-repeat: no-repeat;
    background-size: cover;

}

.weather-details {
    /*
background-image: url('../assets/images/cloudy-sky-day.jpg');
background-repeat: no-repeat;
background-size: cover;

     */
//min-height: 100vh;
}

/*
.auth-container {
background-color: #fff;
border-radius: 10px;
box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
0 10px 10px rgba(0, 0, 0, 0.22);
position: relative;
overflow: hidden;
width: 768px;
max-width: 100%;
//min-height: 480px;
}
*/
/*
.weather-details {
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
    0 10px 10px rgba(0, 0, 0, 0.22);
    overflow: hidden;
    height: 800px;
    background-image: url('../assets/images/cloudy-sky-day.jpg');
    background-repeat: no-repeat;
    background-size: cover;
}

 */



.box {
    width: 200px;
    height: 200px;
    margin-top: 20px;
    background-color: rgb(108, 141, 213);
    box-shadow: rgba(108, 141, 213, 0.5) 0px 6px 20px;
    border-radius: 10px;
}
.red-box {
    @extend .box;
    background-color: rgb(251, 17, 116);
    box-shadow: rgba(251, 17, 116, 0.5) 0px 6px 20px;
}
</style>
