<template>
    <!--<div class=" d-flex align-items-center justify-content-center vh-100">-->
        <div class="col-12 primary-container w-100">
            <div class="row min-vh-100">
                <div class="col-1">
                    <SidebarComponent></SidebarComponent>
                </div>
                <div class="col-11">
                    <h2 class="color text-dark">Add favourite </h2>
                    <div class="d-flex align-items-center flex-column">
                        <h4 class="color text-dark">Add to Favourite Places</h4>
                        <SearchEngineComponent></SearchEngineComponent>
                    </div>
                </div>
            </div>
        </div>
    <!--</div>-->
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
