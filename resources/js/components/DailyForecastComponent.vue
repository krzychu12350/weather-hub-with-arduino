<template>
    <h2 class="color text-white">Daily</h2>
    <div
        v-if="this.windowWidth <= 1025"
        class="daily-container col-11"
    >
        <Carousel
            :settings="settings"
            :breakpoints="breakpoints"
            :items-to-show="3"
            :autoplay="12000"
            :wrap-around="true"
        >
            <Slide
                @click="showHourlyForecastForSpecificDay(singleDay[1])"
                v-for="singleDay in this.singleDaysForecastData"
            >
                <div
                    class="carousel__item"
                >
                    <SingleDayComponent
                        :dayOfWeek=singleDay[0]
                        :dayOfMonth=singleDay[1]
                        :maxDailyTemp=singleDay[2]
                        :minDailyTemp=singleDay[3]
                        :iconOfDay= singleDay[4]
                        :descriptionOfDay=singleDay[5]
                    ></SingleDayComponent>
                </div>
            </Slide>
            <template #addons>
                <Navigation />
            </template>
        </Carousel>
    </div>
    <div
        v-else
        class="daily-container col-11
        d-flex flex-row"
    >
        <div
            @click="showHourlyForecastForSpecificDay(singleDay[1])"
            v-for="singleDay in singleDaysForecastData"
        >
            <SingleDayComponent
                :dayOfWeek=singleDay[0]
                :dayOfMonth=singleDay[1]
                :maxDailyTemp=singleDay[2]
                :minDailyTemp=singleDay[3]
                :iconOfDay= singleDay[4]
                :descriptionOfDay=singleDay[5]
            ></SingleDayComponent>
        </div>
    </div>
</template>

<script>
import SingleDayComponent from "./SingleDayComponent.vue";
import WeatherService from "../services/weather-service";
import {Carousel, Navigation, Slide} from "vue3-carousel";
import 'vue3-carousel/dist/carousel.css';
export default {
    name: "DailyForecastComponent",
    components: {
        SingleDayComponent,
        Carousel,
        Slide,
        Navigation,
    },
    setup() {
        return {
            settings: {
                itemsToShow: 1,
                snapAlign: "center"
            },
            breakpoints: {
                // 700px and up
                700: {
                    itemsToShow: 3,
                    snapAlign: "center"
                },
                // 768 and up
                768: {
                    itemsToShow: 3,
                    snapAlign: "center"
                },
                // 1024 and up
                1024: {
                    itemsToShow: 5,
                    snapAlign: "center"
                }
            }
        };
    },
    data() {
        return {
            fiveDaysForecastData: Array,
            placeId: '763829',
            startDate: Date,
            endDate: Date,
            singleDaysForecastData: Array,
            windowWidth: window.innerWidth,
        }
    },
    created() {
        this.retrieveForecastForFiveDays(this.placeId)
        this.emitter.on('passSearchedPlaceId', (evt) => {
            this.retrieveForecastForFiveDays(evt.value)
        })
    },
    methods: {
        showHourlyForecastForSpecificDay(dayOfMonth) {
            this.emitter.emit('loadHourlyForecastForSpecificDay', {'day': dayOfMonth,
                'weatherData': this.fiveDaysForecastData[dayOfMonth]})
        },
        async retrieveForecastForFiveDays(placeId) {
            WeatherService.getFiveDaysForecast(placeId)
                .then(response => {
                    this.fiveDaysForecastData =
                        this.groupFiveDaysForecastBySingleDay(response.data.list)
                    this.singleDaysForecastData =
                        this.processDataForEverySingleDay(this.fiveDaysForecastData)
                    this.showHourlyForecastForSpecificDay(this.singleDaysForecastData[0][1])
                })
                .catch(e => {
                    console.log(e);
                });

        },
        getDayOfMonthFromDateTimestamp(unixTimestamp) {
            return new Date(unixTimestamp * 1000).getDate()
        },
        getDayOfWeekFromDateTimestamp(unixTimestamp) {
            return new Date(unixTimestamp * 1000).toLocaleString('en-us', {weekday:'short'})
        },
        groupFiveDaysForecastBySingleDay(fiveDaysForecastData) {
            return fiveDaysForecastData.reduce((hour, day) => {
                let singleDay =
                    this.getDayOfMonthFromDateTimestamp(day.dt)
                hour[singleDay] = hour[singleDay] ?? [];
                hour[singleDay ].push(day);
                return hour;
            }, [])
        },
        sortDays (fiveDaysForecastData) {
            return fiveDaysForecastData.sort((day) => {
                return day[0].dt
            }).reverse()
        },
        processDataForEverySingleDay(fiveDaysForecastData) {
            let days = []
            this.sortDays(fiveDaysForecastData)
            this.sortDays(fiveDaysForecastData)
            fiveDaysForecastData.forEach(singleDay => {
                let dayOfMonth =
                    this.getDayOfMonthFromDateTimestamp(singleDay[0].dt)
                let dayOfWeek =
                    this.getDayOfWeekFromDateTimestamp(singleDay[0].dt)
                let maxDailyTemp =
                    Math.max(
                        ...singleDay.map(singleHour => {
                            return singleHour.main.temp
                        }),
                    );
                let minDailyTemp =
                    Math.min(
                        ...singleDay.map(singleHour => {
                            return singleHour.main.temp
                        }),
                    );
                let dailyIcon =
                    singleDay[Math.floor(singleDay.length/2)].weather[0].icon
                let dailyDescription =
                    singleDay[Math.floor(singleDay.length/2)].weather[0].description
                days.push([dayOfWeek, dayOfMonth, maxDailyTemp,
                    minDailyTemp, dailyIcon, dailyDescription])
                })

            return days
        },
        onResize() {
            this.windowWidth = window.innerWidth
        },
    },
    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
        })
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.onResize);
    },
}
</script>

<style lang="scss">

.single-day-container:hover {
    background-color: red;
    cursor: pointer;
}

.carousel__icon {
    fill: #FFFFFF !important;
}

.carousel__prev, .carousel__next {
    background-color: transparent;
}

.carousel__prev:hover, .carousel__next:hover {
   border: 1px solid #FFFFFF;
}
</style>
