<template>
    <TopBarComponent :nameOfTheSubpage="'Favourite places'"></TopBarComponent>
    <div :style="{ backgroundImage: 'url(' + this.imageUrl + ')' }" class="col-12 primary-container w-100 min-vh-100 d-flex">
        <!--<div class="row min-vh-100">-->

        <div class="col-3 col-md-2 col-lg-1">
            <SidebarComponent></SidebarComponent>
        </div>



        <div class="col-9 col-md-10 col-lg-11 mt-2">
            <section id="favourite-places" class="me-4">
                <h2 class="color text-white mt-4 mb-4">Your favourite places</h2>
                <div class="row justify-content-md-center justify-content-lg-start">
                    <div class="col-12 col-md-5 col-lg-2 me-4" v-for="favouritePlace in favouritePlaces">
                        <FavouritePlaceComponent
                            v-bind:isUserFavouritePlace="true"
                            v-bind:placeId="favouritePlace.id"
                            v-bind:place="favouritePlace.name"
                            v-bind:country="favouritePlace.country"
                            v-bind:currentWeatherData="this.getForecastFavouritePlace(favouritePlace.id)"
                            @refresh-user-favourite-places="retrieveFavouritePlaces"
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
        </div>
    </div>
</template>

<script>
import SidebarComponent from "../components/SidebarComponent.vue";
import FavouritePlaceComponent from "../components/FavouritePlaceComponent.vue";
import SearchEngineComponent from "../components/SearchEngineComponent.vue";
import UserService from "../services/user-service";
import WeatherService from "../services/weather-service";
import TopBarComponent from "../components/TopBarComponent.vue";
import Globals from "../globals";
import {useRouter} from "vue-router/dist/vue-router";

export default {
    name: "FavouritePlacesPage",
    components: {
        FavouritePlaceComponent,
        SidebarComponent,
        SearchEngineComponent,
        TopBarComponent
    },
    data() {
        return {
            favouritePlaces: null,
            modalShow: false,
            imageUrl: new URL("../assets/images/weather-conditions/" +
                Globals.CURRENT_WEATHER_ICON + "-bg-img.jpg", import.meta.url).href
        }
    },
    setup () {
        const router = useRouter()
        if(!Globals.PRIMARY_PLACE_ID) router.push({ name: 'SelectPrimaryPlacePage'})
    },
    created() {
        this.retrieveFavouritePlaces()
    },
    methods: {
        async retrieveFavouritePlaces() {
            UserService.getUserProfileData()
                .then(response => {
                    this.favouritePlaces = response.data.data.favourite_places;
                })
                .catch(e => {
                    console.log(e);
                });
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

<style scoped>
.modal-title {
    text-align: center;
}
</style>
