<template>
    <TopBarComponent :nameOfTheSubpage="'Add to Favourite Places'"></TopBarComponent>
    <div :style="{ backgroundImage: 'url(' + this.imageUrl + ')' }" class="col-12 primary-container w-100 min-vh-100 d-flex">
        <div class="col-3 col-md-2 col-lg-1">
            <SidebarComponent></SidebarComponent>
        </div>
        <div class="col-9 col-md-10 col-lg-11 mt-2 d-flex justify-content-center">
            <div class="d-flex flex-column align-items-center col-4">
                <h2 class="color text-white">Add favourite </h2>
                <SearchEngineComponent></SearchEngineComponent>
            </div>

        </div>
    </div>
</template>

<script>
import SidebarComponent from "../components/SidebarComponent.vue";
import SearchEngineComponent from "../components/SearchEngineComponent.vue";
import TopBarComponent from "../components/TopBarComponent.vue";
import Globals from "../globals";

export default {
    name: "AddingFavouritePlacePage",
    components: {
        SidebarComponent,
        SearchEngineComponent,
        TopBarComponent,
    },
    data() {
        return {
            imageUrl: new URL("../assets/images/weather-conditions/" +
                Globals.CURRENT_WEATHER_ICON + "-bg-img.jpg", import.meta.url).href
        }
    },
}
</script>

<style scoped>

</style>
