<template>
        <div
            class="card card-01 d-flex justify-content-center cursor-pointer p-1"
             :key="placeId"
        >
            <!--
            <img class="card-img-top"
                 src="https://images.pexels.com/photos/247599/pexels-photo-247599.jpeg?h=350&auto=compress&cs=tinysrgb"
                 alt="Card image cap">
                 -->
            <div v-if="isUserFavouritePlace && routeName !== 'Home'" class="d-flex justify-content-end">
                <box-icon
                    @click="deleteFavouritePlace(this.placeId)"
                    type="regular"
                    name="x"
                    color="white"
                ></box-icon>
            </div>
            <div
                @click="routeToAddingFavouritePlacePage"
                v-if="!isUserFavouritePlace"
                class="text-center">
                <box-icon
                    type="regular"
                    name="plus"
                    color="white"
                ></box-icon>
            </div>
            <!--
                 data-bs-toggle="modal"
                 data-bs-target="#exampleModal"
             -->

            <span class="place-name text-center">{{ place }}<br>{{ this.decodeAlphaTwo(country) }}</span>
            <div v-if="!!this.weatherData" class="d-flex justify-content-around">
                <div class="d-flex flex-column">
                    <span class="current-temp">
                        <font-awesome-icon class="temp-icon" icon="fa-solid fa-temperature-full" color="white" size="sm"/>
                        <!--
                        <img class="weather-icon"
                            :src="'https://openweathermap.org/img/wn/' +
                            `${this.weatherData.weather[0].icon}` +
                            '@2x.png'">
                        -->
                       {{this.weatherData.main.temp.toFixed(0)}}°
                    </span>
                        <span class="description">
                        <i>{{this.weatherData.weather[0].description}}</i>
                    </span>
                </div>


                <div class="d-flex flex-column">
                    <!--
                    <div>
                        <span class="place-name">{{this.weatherData.main.temp_min.toFixed(0)}}°</span>
                        <span class="place-name">{{this.weatherData.main.temp_max.toFixed(0)}}°</span>
                    </div>
                    -->
                   <div>
                       <font-awesome-icon class="small-icon" icon="fa-solid fa-cloud" color="white" size="sm"/>
                       <span class="cloudy">{{this.weatherData.clouds.all}}%</span>
                   </div>
                    <div>
                        <font-awesome-icon icon="fa-solid fa-wind" color="white" size="sm"/>
                        <span class="wind-speed">{{this.weatherData.wind.speed}}m/s</span>
                    </div>
                </div>

            </div>
            <box-icon
                v-if="isUserFavouritePlace && routeName === 'Home'"
                :class="[isArrowClicked ? 'rotate-arrow' : 'red']"
                @click="showChart(placeId)"
                type="regular"
                name="down-arrow-alt"
                color="white"
            ></box-icon>





                <!--
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                    content.</p>
                <a href="#" class="btn btn-default text-uppercase">Explore</a>

                <div class="card-body">
                </div>
                    -->

        </div>


</template>

<script>
import UserService from '../services/user-service';
import {useRouter} from 'vue-router';
import {computed} from "vue";
import * as iso from "iso-3166-1";

export default {
    name: "FavouritePlaceComponent",
    props: {
        placeId: {
            type: Number,
            required: false,
        },
        place: {
            type: String,
            required: true,
        },
        country: {
            type: String,
            required: false,
        },
        isUserFavouritePlace:{
            type: Boolean,
            required: true,
        },
        currentWeatherData: {
            type: Object,
            required: false,
        },

    },
    emits: ['refreshUserFavouritePlaces'],
    setup(props) {
        const routeName = computed(() => {
            return useRouter().currentRoute.value.name;
        })
        return {routeName}
    },
    data() {
        return {
            //isUserFavouritePlace: true,
            isArrowClicked: false,
            currentTemp: Number,
            weatherData: null
        }
    },
    async created() {
        this.weatherData = await this.currentWeatherData


    },
    methods: {
        decodeAlphaTwo(alphaTwo) {
            if(alphaTwo)
                return iso.whereAlpha2(alphaTwo).country

        },
        addFavouritePlace(favouritePlace) {
           alert('dziala dodawanie' + favouritePlace)
            //UserService.deleteUserFavouritePlace(placeId)
        },
        deleteFavouritePlace(placeId) {
            //alert('dziala usuwanie' + placeId)
            UserService.deleteUserFavouritePlace(placeId)
            //this.$refs.FavouritePlacesPage.retrieveFavouritePlaces()
            this.$emit("refreshUserFavouritePlaces")
        },
        routeToAddingFavouritePlacePage() {
            this.$router.push('add-favourite')
        },
        showChart(placeId) {
            //alert(placeId)
           // alert(event.target)
            //event.target.css('background-color', 'red')
            //this.arrowDirection = "down-arrow-alt"
            this.isArrowClicked = !this.isArrowClicked
            this.emitter.emit('showValOfHumidityAndTempsChart',
                {placeId})
        },
        getWeatherDataForSelectedPlace(placeId) {
            this.emitter.emit('passSearchedPlaceId',
                {'value': placeId})
        },
    }
}
</script>

<style scoped>
.temp-icon {
    margin-right: 0.5rem;
}
.weather-icon {
    width: 0px;
}
.small-icon {
    font-size: 1rem;
}
.current-temp {
    font-size: 1.5em;
    color: #FFFFFF;
}
.rotate-arrow {
    transform: rotate(180deg);
}
.place-name {
    font-size: 1.25em;
    color: white;
}
.description {
    font-size: 0.75em;
    color: white;
}
.cloudy, .wind-speed{
    margin-left: 1em;
    font-size: 1rem;
    color: white;
}
.card{
    box-shadow:2px 2px 20px rgba(0,0,0,0.3); margin-bottom:30px;
    min-height: 10em;
    /*
    background: linear-gradient(to right, #08C8F6, #2698f8);


    background-image: url('../assets/images/stars-night.gif');
    */
    background-color: transparent;
    background-repeat: no-repeat;
    background-size: cover;

    border: 2px solid white;
    cursor: pointer;
}
.card:hover{
    transform: scale(1.05);
    transition: all 1s ease;
    /*
    z-index: 999;

     */
}
.card-01 .card-body{
    position:relative; padding-top:40px;
}
.card-01 .badge-box{
    position:absolute;
    top:-20px; left:50%; width:100px; height:100px;margin-left:-50px; text-align:center;
}
.card-01 .badge-box i{
    background:#006EFF; color:#fff; border-radius:50%;  width:50px; height:50px; line-height:50px; text-align:center; font-size:20px;
}
.card-01 .height-fix{
    height:455px; overflow:hidden;
}

.card-01 .height-fix .card-img-top{width:auto!imporat;}

.profile-box{
    background-size:cover; float:left; width:100%; text-align:center; padding:30px 0; position:relative; overflow:hidden;
}

.profile-box:before{
    filter: blur(10px);background:url("https://images.pexels.com/photos/195825/pexels-photo-195825.jpeg?h=350&auto=compress&cs=tinysrgb") no-repeat; background-size:cover; width:120%; position:absolute; content:""; height:120%; left:-10%;top:0;z-index:0;
}

.profile-box img{
    width:170px; height:170px; position:relative; border:5px solid #fff;
}

.social-box i {
    border:1px solid #006EFF; color:#006EFF; width:30px; height:30px; border-radius:50%;line-height:30px;
}

.social-box i:hover{
    background:#DFC717; color:#fff;
}

.social-box a{margin: 0 5px;}

.video-foreground{float:left;width:100%; height:500px;}

.card-01.height-fix .card-img-overlay{
    top:unset;
    color:#fff;
    background: -moz-linear-gradient(top, rgba(26,96,111,0) 0%, rgba(26,96,111,0) 1%, rgba(24,87,104,0.91) 31%, rgba(21,65,89,0.91) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, rgba(26,96,111,0) 0%,rgba(26,96,111,0) 1%,rgba(24,87,104,0.91) 31%,rgba(21,65,89,0.91) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, rgba(26,96,111,0) 0%,rgba(26,96,111,0) 1%,rgba(24,87,104,0.91) 31%,rgba(21,65,89,0.91) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#001a606f', endColorstr='#e8154159',GradientType=0 );
}
.card-01.height-fix .fa{color: #fff;font-size: 22px;margin-right: 18px;};

/*flipper-card*/
.card-flipper {
    position: relative;
    float: left;
    width: 100%;
    text-align: center;
}

.card__front,
.card__back {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.card__back .card{
    width:100%;
    height:65vh;
}

.card__front,
.card__back {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition: -webkit-transform 0.3s;
    transition: transform 0.3s;
}

.card__front {
    background-color: #ff5078;
}

.card__back {
    background-color: #1e1e1e;
    -webkit-transform: rotateY(-180deg);
    transform: rotateY(-180deg);
}
.card-flipper.effect__hover{position:relative;}
.card-flipper.effect__hover:hover .card__front {
    -webkit-transform: rotateY(-180deg);
    transform: rotateY(-180deg);
}

.card-flipper.effect__hover:hover .card__back {
    -webkit-transform: rotateY(0);
    transform: rotateY(0);
}

.card-flipper.effect__random.flipped .card__front {
    -webkit-transform: rotateY(-180deg);
    transform: rotateY(-180deg);
}

.card-flipper.effect__random.flipped .card__back {
    -webkit-transform: rotateY(0);
    transform: rotateY(0);
}
</style>
