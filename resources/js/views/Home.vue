<template>
    <TopBarComponent :nameOfTheSubpage="'Forecast'"/>
    <div
        :style="{ backgroundImage: 'url(' + this.imageUrl + ')' }"
        class="col-12 primary-container w-100 min-vh-100 d-flex"
    >
        <div class="col-3 col-md-2 col-lg-1">
            <SidebarComponent/>
        </div>
        <div class="col-9 col-md-10 col-lg-11 mt-2">
            <CurrentWeatherDataComponent/>
            <section
                v-if="renderComponent"
                id="favourite-places"
                class="me-4"
            >
                <h2
                    class="color text-white mt-4 mb-4"
                >
                    Your favourite places
                </h2>
                <div
                    class="row justify-content-md-center justify-content-lg-start"
                >
                    <div
                        class="col-12 col-md-5 col-lg-2 me-4"
                        v-for="favouritePlace in favouritePlaces"
                    >
                        <FavouritePlaceComponent
                            :isUserFavouritePlace="true"
                            :placeId="favouritePlace.id"
                            :place="favouritePlace.name"
                            :country="favouritePlace.country"
                            :currentWeatherData="this.getForecastFavouritePlace(favouritePlace.id)"
                            @refresh-user-favourite-places="retrieveFavouritePlaces"
                        />
                    </div>
                    <div class="col-12 col-md-5 col-lg-2 me-4">
                        <FavouritePlaceComponent
                            :isUserFavouritePlace="false"
                            :place="'Add new place'"
                        />
                    </div>
                </div>
            </section>
            <fade-transition
                mode="out-in"
                :duration="500"
            >
                <div v-if="isHumAndTempsCharVisible">
                    <HorizontalLineComponent/>
                    <TemperatureAndHumidityChartComponent
                        id="temp-and-hum-chart"
                        v-if="renderComponent"
                        :triggerData="this.chartData"
                    />
                </div>
                <div v-else>
                    <section
                        id="daily-forecast"
                    >
                        <HorizontalLineComponent/>
                        <DailyForecastComponent
                            v-if="renderComponent"
                        />
                        <HorizontalLineComponent/>
                        <HourlyForecastComponent
                            v-if="renderComponent"
                        />
                    </section>
                </div>
            </fade-transition>
        </div>
    </div>
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
import {nextTick, ref} from 'vue';
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
        if (!Globals.PRIMARY_PLACE_ID)
            router.push({name: 'SelectPrimaryPlacePage'})

        const renderComponent = ref(true);

        const forceRerender = async () => {
            renderComponent.value = false;
            await nextTick();
            renderComponent.value = true;
        };

        return {renderComponent, forceRerender}
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
            this.isHumAndTempsCharVisible =
                !this.isHumAndTempsCharVisible
            if (this.isHumAndTempsCharVisible) {
                this.chartData =
                    this.processSpecificPlaceWeatherLogs(evt.placeId)
            }
        })

        this.emitter.on('rerenderPage', () => {
            this.forceRerender()
        })
    },
    mounted() {
        this.emitter.on('passCurrentWeatherIcon', (evt) => {
            Globals.CURRENT_WEATHER_ICON = evt.icon
            const icon = evt.icon
            this.imageUrl = new URL("../assets/images/weather-conditions/" +
                icon + "-bg-img.jpg", import.meta.url).href
        })
    },
    beforeUnmount() {
        clearInterval(this.callIntervalMethod)
    },
    methods: {
        filterWeatherDataLogs(weatherDataLogs, placeId) {
            return Array.isArray(weatherDataLogs)
                ? weatherDataLogs.find(place => place.id === placeId)
                : 0
        },
        processSpecificPlaceWeatherLogs(placeId) {
            let place = JSON.parse(JSON.stringify
            (this.filterWeatherDataLogs(this.weatherDataLogs, placeId)));
            let seriesOfTemperatures = place.weather_data_logs
                .map(singleLog => singleLog.temperature);
            let seriesOfHumidity = place.weather_data_logs
                .map(singleLog => singleLog.humidity);
            let seriesOfCreatedAt = place.weather_data_logs
                .map(singleLog => moment(singleLog.created_at)
                    .format('LLL'));
            if (Globals.UNIT_OF_MEASUREMENT === 'imperial')
                seriesOfTemperatures = seriesOfTemperatures
                    .map(value => ((value * 1.8) + 32).toFixed(0))
            return [seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt]
        },
        async retrieveFavouritePlaces() {
            UserService.getUserProfileData()
                .then(response => {
                    ToastService.showToast("Hello " +
                        response.data.data.name +
                        ", check out the latest weather " +
                        "forecast right now !!!", 'info')
                    this.favouritePlaces =
                        response.data.data.favourite_places;
                })
                .catch(e => {
                    console.log(e);
                });
        },
        async retrieveWeatherDataLogs() {
            this.weatherDataLogs =
                await UserService.getWeatherDataLogsForFavouritePlaces()
            this.callIntervalMethod = setInterval(async () => {
                this.weatherDataLogs =
                    await UserService.getWeatherDataLogsForFavouritePlaces()
            }, 1830000)

        },
        getForecastFavouritePlace(placeId) {
            return WeatherService.getCurrentForecast(placeId)
                .then((response) => {
                    return response.data
                })
                .catch(err => console.log(err.message))
        }

    }
}
</script>
