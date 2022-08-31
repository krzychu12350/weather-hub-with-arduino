<template>
    <div class="col-11 mb-4">
        <div class="d-flex justify-content-between">
            <h2 class="color text-white">Hourly</h2>
            <div class="gap-2 justify-content-md-end">
                <button
                    class="switch-button"
                    @click="this.isSummaryWasClicked =
                        !this.isSummaryWasClicked">
                    Summary
                </button>
                <button
                    class="switch-button"
                    @click="this.isSummaryWasClicked =
                        !this.isSummaryWasClicked">
                    Details
                </button>
            </div>
        </div>
        <div v-if="isSummaryWasClicked">
            <div v-if="this.windowWidth <= 1025" class="hourly-container ms-2 col-11">
                <Carousel :settings="settings" :breakpoints="breakpoints" :items-to-show="3" :autoplay="8000" :wrap-around="false">
                    <Slide v-for="(singleHour, key, index) in this.hourlyForecastData" :key="key">
                        <div class="carousel__item me-4">
                            <img v-bind:src="'https://openweathermap.org/img/wn/' + singleHour.weather[0].icon + '@2x.png'" /><br>
                            <span class="single-day-details">{{ singleHour.main.temp }}°<br></span>
                            <span class="single-day-details">{{ singleHour.weather[0].description }}<br></span>
                            <span class="single-day-details">{{ singleHour.main.humidity }}%<br></span>
                            <span class="single-day-details"><b>{{ this.getHourFromDateTimestamp(singleHour.dt) }}</b><br></span>

                            <!--
                            <div class="carousel__item">

                                <div class="card" style="width: 230px">
                                    <img
                                        :src="`https://picsum.photos/500/300?image=${n * 5 + 10}`"
                                        class="card-img-top"
                                        alt="..."
                                    />
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            This is a longer card with supporting text below as a natural
                                            lead-in to additional content. This content is a little bit
                                            longer.
                                        </p>
                                    </div>
                                </div>


                         {{this.getDayOfMonthFromDateTimestamp(singleHour.dt)}}<br>
                            -->
                        </div>
                    </Slide>
                    <template #addons>
                        <Navigation />
                    </template>
                </Carousel>
            </div>

            <div v-else class="hourly-container d-flex flex-row col-11">
                <div class="me-4" v-for="(singleHour, key, index) in this.hourlyForecastData" :key="key">
                    <img v-bind:src="'https://openweathermap.org/img/wn/' + singleHour.weather[0].icon + '@2x.png'" /><br>
                    <span class="single-day-details">{{ singleHour.main.temp }}°<br></span>
                    <span class="single-day-details">{{ singleHour.weather[0].description }}<br></span>
                    <span class="single-day-details">{{ singleHour.main.humidity }}%<br></span>
                    <span class="single-day-details"><b>{{ this.getHourFromDateTimestamp(singleHour.dt) }}</b><br></span>
                </div>
            </div>



        </div>
        <div v-if="!isSummaryWasClicked" class="hourly-chart-container d-flex justify-content-center d-lg-block">

            <!--<area-chart :stacked="true" :library="chartOptions" :points="false" curve="false"
                        :legend="false" :discrete="true" :data="hourlyForecastDataChart"></area-chart>
                        -->
            <apexchart class="col-10 h-50" height="400" type="area" width="100%" :options="chartOptions" :series="series"></apexchart>
            <!--<HourlyCharComponent></HourlyCharComponent>-->
        </div>
    </div>


</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import {Carousel, Navigation, Slide} from "vue3-carousel";
import 'vue3-carousel/dist/carousel.css';



export default {
    name: "HourlyForecastComponent",
    components: {
        apexchart: VueApexCharts,
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
            hourlyForecastData: Array,
            isSummaryWasClicked: Boolean,
            hourlyForecastDataChart: Array,
            windowWidth: window.innerWidth,
            /*
            chartOptions: {
                layout: {
                    padding: {
                        left: 100,
                        right: 5,
                        top: 50,
                        bottom: 2
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            display: false
                        },
                        gridLines: {
                            lineWidth: 0
                        }
                    },
                    y: {
                        ticks: {
                            display: false
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }
                }
            },
            */

            series: [],
            chartOptions: {}

        }
    },
    created() {
        this.emitter.on('loadHourlyForecastForSpecificDay', (evt) => {
            //console.log('day: ' + evt.day);
            //console.log('weather data: ' + evt.weatherData)
            this.hourlyForecastData = evt.weatherData
            this.hourlyForecastDataChart = this.prepareHourlyForecastData(this.hourlyForecastData)
            this.updateChart(this.hourlyForecastDataChart[0], this.hourlyForecastDataChart[1])
            //console.log(this.hourlyForecastDataChart[0])
            //this.retrieveForecastForFiveDays(evt.value)
        })


    },
    methods: {
        updateChart(hours, temps) {
            this.series = [{
                name: 'temps',
                data: temps
            }
            ]
            this.chartOptions = {
                fill: {
                    type: 'solid',
                    opacity: 0.3,
                    colors: ['#fff']
                },
                grid: {
                    show: false,
                },
                chart: {
                    height: 350,
                    type: 'area',
                    sparkline: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                    selection: {
                        enabled: false,
                    },
                    zoom: {
                        enabled: false,
                    },
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    width: 1,
                    curve: 'smooth',
                    colors: ['rgba(255,255,255,0.52)'],
                },
                xaxis: {
                    tooltip: {
                        enabled: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    //type: 'datetime',
                    //categories: ['11', '12', '13', '14', '15', '16', '17'],
                    categories: hours,
                    labels: {
                        show: true,
                        style: {
                            fontSize: '16px',
                            fontFamily: 'Arial, sans-serif',
                            colors: ['#fff','#fff','#fff','#fff', '#fff','#fff', '#fff','#fff'],

                        },
                    },
                },
                yaxis: {
                    show: false,
                    tooltip: {
                        enabled: false,
                        x: {
                            show: false,
                        },
                    },

                },
                tooltip: {
                    enabled: false,
                    x: {
                        show: false,
                    }
                },
            }

        },
        getHourFromDateTimestamp(unixTimestamp) {
            //return new Date(unixTimestamp * 1000).getHours() - 2 + ':00'
            const anHour = new Date(unixTimestamp * 1000)
            anHour.setHours(anHour.getHours() - 2)
            return anHour.toLocaleTimeString('en-US', {
                // en-US can be set to 'default' to use user's browser settings
                hour: '2-digit',
                minute: '2-digit',
            });



        },

        prepareHourlyForecastData(hourlyForecastData) {
            //console.log(hourlyForecastData)
            const hoursData = []
            const tempsData = []
            //console.log(hourlyForecastData)
            if (Array.isArray(hourlyForecastData)) {
            hourlyForecastData.forEach(singleHour => {
                //console.log(Math.round(singleHour.main.temp))
                //console.log(singleHour.weather[0].icon)
                //console.log(this.getHourFromDateTimestamp(singleHour.dt))
                hoursData.push(this.getHourFromDateTimestamp(singleHour.dt))
                tempsData.push(Math.round(singleHour.main.temp) + '°')
            })
            }
            //console.log(hoursData)
            //console.log(tempsData)
            return [hoursData, tempsData]
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
.switch-button {
    padding: 5px 5px;
    font-size: 10px;
}

</style>
