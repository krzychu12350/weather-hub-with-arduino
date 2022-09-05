<template>
    <h2 class="color text-white">Daily</h2>
    <div v-if="this.windowWidth <= 1025" class="daily-container col-11">


        <!--
        <SingleDayComponent></SingleDayComponent>
        <SingleDayComponent></SingleDayComponent>
        <SingleDayComponent></SingleDayComponent>
        <SingleDayComponent></SingleDayComponent>
        <SingleDayComponent></SingleDayComponent>
        -->

            <!--
            dayOfWeek: String,
            dayOfMonth: Number,
            maxDailyTemp: Number,
            minDailyTemp: Number,
            iconOfDay: String
            descriptionOfDay: String

            ---------
            {{ singleDay[0] }}
            {{ singleDay[1] }}
            {{ singleDay[2] }}
            {{ singleDay[3] }}
            {{ singleDay[5] }}
            {{ singleDay[6] }}
            -->

        <Carousel :settings="settings" :breakpoints="breakpoints" :items-to-show="3" :autoplay="6000" :wrap-around="true">
            <Slide
                @click="showHourlyForecastForSpecificDay(singleDay[1])"
                   v-for="singleDay in this.singleDaysForecastData">
                <div
                    class="carousel__item">
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



            <!--
            <div v-for="singleHour in singleDay">
                {{singleHour.dt_txt}}
                {{singleHour.main.temp}}
                {{singleHour.weather[0].description}}
            </div>
            -->

    </div>
    <div v-else class="daily-container col-11 d-flex flex-row">
        <div class=""  @click="showHourlyForecastForSpecificDay(singleDay[1])" v-for="singleDay in singleDaysForecastData">
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
import {orderBy} from "lodash";
import moment from "moment";
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
            // carousel settings
            settings: {
                itemsToShow: 1,
                snapAlign: "center"
            },
            // breakpoints are mobile first
            // any settings not specified will fallback to the carousel settings
            breakpoints: {
                // 700px and up
                700: {
                    itemsToShow: 3,
                    snapAlign: "center"
                },
                768: {
                    itemsToShow: 4,
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
            //alert(evt.value);
            this.retrieveForecastForFiveDays(evt.value)
            //this.showHourlyForecastForSpecificDay(1)

        })

        //this.showHourlyForecastForSpecificDay(singleDay[1])


    },
    methods: {
        showHourlyForecastForSpecificDay(dayOfMonth) {
            //console.log(this.fiveDaysForecastData)
            this.emitter.emit('loadHourlyForecastForSpecificDay', {'day': dayOfMonth,
                'weatherData': this.fiveDaysForecastData[dayOfMonth]})
        },
        async retrieveForecastForFiveDays(placeId) {
            WeatherService.getFiveDaysForecast(placeId)
                .then(response => {
                    //this.favouritePlaces = response.data.data.favourite_places;
                    //console.log(this.favouritePlaces)

                    //this.fiveDaysForecastData = response.data.list
                    //console.log(this.fiveDaysForecastData)
                    //this.getMaxDate(this.fiveDaysForecastData)
                    this.fiveDaysForecastData = this.groupFiveDaysForecastBySingleDay(response.data.list)
                    this.singleDaysForecastData = this.processDataForEverySingleDay(this.fiveDaysForecastData)
                    //console.log(this.singleDaysForecastData[0][1])
                    this.showHourlyForecastForSpecificDay(this.singleDaysForecastData[0][1])
                })
                .catch(e => {
                    console.log(e);
                });

        },
        getDayOfMonthFromDateTimestamp(unixTimestamp) {
            //return new Date(unixTimestamp * 1000).toLocaleDateString("default", {})
            return new Date(unixTimestamp * 1000).getDate()
        },
        getDayOfWeekFromDateTimestamp(unixTimestamp) {
            //return new Date(unixTimestamp * 1000).toLocaleDateString("default", {})
            return new Date(unixTimestamp * 1000).toLocaleString('en-us', {weekday:'short'})
        },
        groupFiveDaysForecastBySingleDay(fiveDaysForecastData) {
            //console.log(groupBySingleDays);
            return fiveDaysForecastData.reduce((hour, day) => {
                //day.dt = this.createDateFromDateTimestamp(day.dt)
                let singleDay = this.getDayOfMonthFromDateTimestamp(day.dt)
                //const {dt} = day
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
            //console.log(fiveDaysForecastData)


            fiveDaysForecastData.forEach(singleDay => {
                //console.log(singleDay)
                //console.log("SingleDay ")
                //console.log("Start day")
                let dayOfMonth = this.getDayOfMonthFromDateTimestamp(singleDay[0].dt)
                //console.log(dayOfMonth)
                let dayOfWeek = this.getDayOfWeekFromDateTimestamp(singleDay[0].dt)
                //console.log(dayOfWeek)
                let maxDailyTemp =
                    Math.max(
                        ...singleDay.map(singleHour => {
                          //console.log(element.dt_txt)
                            //console.log(element.main.temp)
                            return singleHour.main.temp

                        }),
                    );
                let minDailyTemp =
                    Math.min(
                        ...singleDay.map(singleHour => {
                            //console.log(element.dt_txt)
                            //console.log(element.main.temp)
                            return singleHour.main.temp

                        }),
                    );

                //getDayOfWeekFromDateTimestamp
                //TO FIX

                let dailyIcon = singleDay[Math.floor(singleDay.length/2)].weather[0].icon
                //console.log(singleDay.length)
                //console.log(singleDay[Math.floor(singleDay.length/2)])
                let dailyDescription = singleDay[Math.floor(singleDay.length/2)].weather[0].description
                //console.log(dailyDescription)

                //singleDay.reduce((a, b) => a + b, 0) / arr.length;
                //sum += singleHour.main.temp
                //console.log(singleDay.reduce((sum) => sum += main.temp))

                //console.log("Min daily temp " + minDailyTemp)
                //console.log("Max daily temp " + maxDailyTemp)

                //console.log("End day")
                days.push([dayOfWeek, dayOfMonth, maxDailyTemp, minDailyTemp, dailyIcon, dailyDescription])
                })
            //console.log(days)
            return days
        },
        onResize() {
            this.windowWidth = window.innerWidth
        },

        getMaxDate(fiveDaysForecastData) {
            //console.log(fiveDaysForecastData.reduce((first,second) => first > second ? first : second).dt)
            //console.log(fiveDaysForecastData.reduce((first,second) => first > second ? second: first).dt)
            //let maxDate = new Date(fiveDaysForecastData.reduce((first,second) => first > second ? first : second).dt * 1000);

            let minDate = new Date(
                Math.min(
                    ...fiveDaysForecastData.map(element => {
                        let d = new Date(element.dt * 1000);
                        return d.setHours(d.getHours() - 2);
                    }),
                ),
            );
            const maxDate = new Date(
                Math.max(
                    ...fiveDaysForecastData.map(element => {
                        let d = new Date(element.dt * 1000);
                        return d.setHours(d.getHours() - 2);
                    }),
                ),
            );

            //let minDate = new Date(fiveDaysForecastData.reduce((first,second) => first > second ? second: first).dt * 1000);
            //console.log(`Min date = ${minDate}`
            //console.log(`Max date = ${minDate.getDate()}`);
            //console.log(`Max date = ${maxDate.getDate()}`);
            //console.log(Math.max(...this.fiveDaysForecastData.map(e => e.dt)));

            /*
            while (minDate <= maxDate) {
                console.log("min date in while " + minDate);
                let i = minDate.setHours(minDate.getHours() + 3);
                let date =
                minDate = new Date(i);
                //console.log("New date " + minDate);
            }
             */



            /*
     for (let d = minDate; d <= maxDate; d.setDate(d.getDate() + 1)) {
         //daysOfYear.push(new Date(d));
         console.log("Following day" + d)
     }*/

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
