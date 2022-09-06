<template>
    <TopBarComponent :nameOfTheSubpage="'Settings'"/>
    <div
        :style="{ backgroundImage: 'url(' + this.imageUrl + ')' }"
        class="col-12 primary-container w-100 min-vh-100 d-flex"
    >
        <div class="col-3 col-md-2 col-lg-1">
            <SidebarComponent/>
        </div>
        <div class="col-lg-10">
            <h3
                class="color text-white mt-4 mb-4"
            >
                Your primary place
            </h3>
            <div class="col-lg-2">
                <FavouritePlaceComponent
                    :isUserFavouritePlace="true"
                    :placeId="this.placeId"
                    :place="this.place"
                    :country="this.country"
                    :currentWeatherData="this.getForecastFavouritePlace(this.placeId)"
                ></FavouritePlaceComponent>
            </div>
            <HorizontalLineComponent/>
            <h3 class="color text-white"
            >
                Your account
            </h3>
            <a
                href="#"
                data-bs-toggle="modal"
                data-bs-target="#deleting-confirmation"
            >
                <button
                    class="delete-button mt-2"
                >
                    Delete account
                </button>
            </a>
        </div>
    </div>
</template>

<script>
import SidebarComponent from "../components/SidebarComponent.vue";
import SearchEngineComponent from "../components/SearchEngineComponent.vue";
import TopBarComponent from "../components/TopBarComponent.vue";
import Globals from "../globals";
import WeatherService from "../services/weather-service";
import FavouritePlaceComponent from "../components/FavouritePlaceComponent.vue";
import HorizontalLineComponent from "../components/HorizontalLineComponent.vue";
import {useRouter} from "vue-router/dist/vue-router";

export default {
    name: "SettingsPage",
    components: {
        SidebarComponent,
        SearchEngineComponent,
        TopBarComponent,
        FavouritePlaceComponent,
        HorizontalLineComponent,
    },
    data() {
        return {
            currentWeatherDataOfPrimaryPlace: Object,
            placeId: Number(Globals.PRIMARY_PLACE_ID),
            place: "",
            country: "",
            imageUrl: new URL("../assets/images/weather-conditions/" +
                Globals.CURRENT_WEATHER_ICON + "-bg-img.jpg", import.meta.url).href
        }
    },
    setup() {
        const router = useRouter()
        if (!Globals.PRIMARY_PLACE_ID) router.push({name: 'SelectPrimaryPlacePage'})
    },
    async created() {
        this.currentWeatherDataOfPrimaryPlace = await this.getForecastFavouritePlace(this.placeId)
        this.place = this.currentWeatherDataOfPrimaryPlace.name
        this.country = this.currentWeatherDataOfPrimaryPlace.sys.country
    },
    methods: {
        getForecastFavouritePlace(placeId) {
            return WeatherService.getCurrentForecast(placeId)
                .then((response) => {
                    return response.data
                })
                .catch(err => console.log(err.message))
        },
    }
}
</script>

<style scoped>
.delete-button {
    background-color: transparent;
    border: 2px solid white;
}
</style>
