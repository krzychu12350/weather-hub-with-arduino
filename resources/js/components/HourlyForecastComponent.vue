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
        <div
            v-if="isSummaryWasClicked"
        >
            <div
                v-if="this.windowWidth <= 1025"
                class="hourly-container col-12"
            >
                <Carousel
                    :settings="settings"
                    :breakpoints="breakpoints"
                    :items-to-show="3"
                    :autoplay="8000"
                    :wrap-around="true"
                >
                    <Slide
                        v-for="(singleHour, key) in this.hourlyForecastData"
                        :key="key"
                    >
                        <div class="carousel__item me-4">
                            <img
                                :src="'https://openweathermap.org/img/wn/' +
                                singleHour.weather[0].icon + '@2x.png'"
                            /><br>
                            <span class="single-day-details">
                                <font-awesome-icon
                                    class="temp-icon"
                                    icon="fa-solid fa-temperature-full"
                                    color="white"
                                    size="sm"/>
                                {{ singleHour.main.temp.toFixed(0) }}°
                                <br></span>
                            <span class="single-day-details">
                                {{ singleHour.weather[0].description }}<br>
                            </span>
                            <span class="single-day-details">
                                {{ singleHour.main.humidity }}%
                                <br></span>
                            <span class="single-day-details">
                                <b>
                                    {{ this.getHourFromDateTimestamp(singleHour.dt) }}
                                </b>
                                <br></span>
                        </div>
                    </Slide>
                    <template #addons>
                        <Navigation/>
                    </template>
                </Carousel>
            </div>
            <div
                v-else
                class="hourly-container d-flex flex-row col-11"
            >
                <div
                    class="me-4"
                    v-for="(singleHour, key) in this.hourlyForecastData"
                    :key="key"
                >
                    <img
                        :src="'https://openweathermap.org/img/wn/' +
                        singleHour.weather[0].icon + '@2x.png'"
                    /><br>
                    <span class="single-day-details">
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-temperature-full"
                            color="white"
                            size="sm"/>
                        {{ singleHour.main.temp.toFixed(0) }}°
                        <br>
                    </span>
                    <span class="single-day-details">
                        {{ singleHour.weather[0].description }}
                        <br>
                    </span>
                    <span class="single-day-details">
                        <font-awesome-icon
                            class="temp-icon"
                            icon="fa-solid fa-droplet"
                            color="white"
                            size="sm"/>
                        {{ singleHour.main.humidity }}%
                        <br>
                    </span>
                    <span class="single-day-details">
                        <b>
                            {{ this.getHourFromDateTimestamp(singleHour.dt) }}
                        </b>
                        <br>
                    </span>
                </div>
            </div>
        </div>
        <div
            v-if="!isSummaryWasClicked"
            class="hourly-chart-container d-flex
            justify-content-center d-lg-block"
        >
            <apexchart
                class="col-10 h-50"
                height="400"
                type="area"
                width="100%"
                :options="chartOptions"
                :series="series"
            />
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
                // 768px and up
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
            hourlyForecastData: Array,
            isSummaryWasClicked: Boolean,
            hourlyForecastDataChart: Array,
            windowWidth: window.innerWidth,
            series: [],
            chartOptions: {}

        }
    },
    created() {
        this.emitter.on('loadHourlyForecastForSpecificDay', (evt) => {
            this.hourlyForecastData = evt.weatherData
            this.hourlyForecastDataChart = this.prepareHourlyForecastData(this.hourlyForecastData)
            this.updateChart(this.hourlyForecastDataChart[0], this.hourlyForecastDataChart[1])
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
                    categories: hours,
                    labels: {
                        show: true,
                        style: {
                            fontSize: '16px',
                            fontFamily: 'Arial, sans-serif',
                            colors: ['#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff'],

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
            const anHour = new Date(unixTimestamp * 1000)
            anHour.setHours(anHour.getHours() - 2)
            return anHour.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
            });
        },
        prepareHourlyForecastData(hourlyForecastData) {
            const hoursData = []
            const tempsData = []
            if (Array.isArray(hourlyForecastData)) {
                hourlyForecastData.forEach(singleHour => {
                    hoursData.push(this.getHourFromDateTimestamp(singleHour.dt))
                    tempsData.push(Math.round(singleHour.main.temp) + '°')
                })
            }
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
    margin-right: 0.5em;
    font-size: 0.75rem;
    background-color: transparent;
    border: 2px solid white;
}

</style>
