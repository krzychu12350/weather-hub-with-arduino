<template>
    <!--<div class=" d-flex align-items-center justify-content-center vh-100">-->
        <div class="col-12 primary-container">
            <div class="row min-vh-100">

                <div class="col-1">
                    <SidebarComponent></SidebarComponent>
                </div>
                <div class="col-7">
                    <h2 class="color text-dark">Your favourite places</h2>

                    <div class="d-flex mt-4">
                        <div class="col-2 me-4" v-for="favouritePlace in favouritePlaces">
                            <FavouritePlaceComponent
                                v-bind:isUserFavouritePlace="true"
                                v-bind:placeId="favouritePlace.id"
                                v-bind:place="favouritePlace.name"
                                @refresh-user-favourite-places="retrieveFavouritePlaces"
                            ></FavouritePlaceComponent>
                        </div>
                        <div class="col-2 me-4">
                             <FavouritePlaceComponent
                                 v-bind:isUserFavouritePlace="false"
                                 v-bind:place="'Add new place'"
                             ></FavouritePlaceComponent>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content border-0">
                            <div class="modal-header d-flex justify-content-center">
                                <h5 id="exampleModalLabel">Add new favourite place</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center">
                                <SearchEngineComponent/>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="button">Add place</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    <!--</div>-->
</template>

<script>
import SidebarComponent from "../components/SidebarComponent.vue";
import FavouritePlaceComponent from "../components/FavouritePlaceComponent.vue";
import SearchEngineComponent from "../components/SearchEngineComponent.vue";
import UserService from "../services/user-service";
export default {
    name: "FavouritePlacesPage",
    components: {
        FavouritePlaceComponent,
        SidebarComponent,
        SearchEngineComponent
    },
    data() {
        return {
            favouritePlaces: null,
            modalShow: false,
        }
    },
    created() {
        this.retrieveFavouritePlaces()
    },
    methods: {
         async retrieveFavouritePlaces() {
            UserService.getUserFavouritePlaces()
                .then(response => {
                    this.favouritePlaces = response.data.data.favourite_places;
                })
                .catch(e => {
                    console.log(e);
                });
        },
    },
}
</script>

<style scoped>
.modal-title {
    text-align: center;
}
</style>
