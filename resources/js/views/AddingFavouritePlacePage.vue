<template>
    <div class="col-12 primary-container w-100 min-vh-100 d-flex">
        <div class="col-3 col-md-2 col-lg-1">
            <SidebarComponent></SidebarComponent>
        </div>
        <div class="col-9 col-md-10 col-lg-11 mt-2">
            <h2 class="color text-dark">Add favourite </h2>
            <h4 class="color text-dark">Add to Favourite Places</h4>
            <SearchEngineComponent></SearchEngineComponent>
        </div>
    </div>
</template>

<script>
import SidebarComponent from "../components/SidebarComponent.vue";
import SearchEngineComponent from "../components/SearchEngineComponent.vue";

export default {
    name: "AddingFavouritePlacePage",
    components: {
        SidebarComponent,
        SearchEngineComponent
    }
}
</script>

<style scoped>

</style>
