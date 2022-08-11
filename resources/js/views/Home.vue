<template>
    <div class=" d-flex align-items-center justify-content-center vh-100">
        <div class="col-10 primary-container">
            <div class="row h-100">
                <div class="col-1">
                    <SidebarComponent></SidebarComponent>
                </div>
                <div class="col-7">
                    <SearchEngineComponent/>
                </div>
                <div class="weather-details col-4">
                    <section class="home">

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
            </div>
        </div>
    </div>
</template>

<script>
import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
import SidebarComponent from "../components/SidebarComponent.vue";
import SearchEngineComponent from "../components/SearchEngineComponent.vue";

export default {
    name: "Home",
    components: {
        MoonLoader,
        SidebarComponent,
        SearchEngineComponent
    },
    data() {
        return {
            api: 'https://api.openweathermap.org/data/2.5/weather?id=763829&appid=7aef87c2b6d81812c53c536b5a1d715c&lang=en&units=metric',
            weatherData: {},
            loading: false,
            locality: "",
            temp: null,
            icon: "",
            description: "",
            currentDate: "",
        }
    },
    mounted() {
        this.getForecast()
    },
    methods: {
        getForecast() {
            this.loading = true
            this.axios.get(this.api)
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
        logOut() {
            this.$store.dispatch('auth/logout');
            this.$router.push('/login');
        }
    }
}
</script>

<style lang="scss">

.weather-details {
    background-image: url('../assets/images/cloudy-sky-day.jpg');
    background-repeat: no-repeat;
    background-size: cover;
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
.primary-container {
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
    0 10px 10px rgba(0, 0, 0, 0.22);
    overflow: hidden;
    height: 800px;
}
</style>
