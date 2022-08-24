<template>
    <div class="d-flex justify-content-between">
        <h2 class="color text-white">Hourly</h2>
        <div>
            <button
                @click="this.isSummaryWasClicked =
                    !this.isSummaryWasClicked">
                Summary
            </button>
            <button
                @click="this.isSummaryWasClicked =
                    !this.isSummaryWasClicked">
                Details</button>
        </div>
    </div>

    <div v-if="isSummaryWasClicked" class="daily-container d-flex flex-row">
        <div class="me-4" v-for="(singleHour, key, index) in this.hourlyForecastData">



            <!--{{this.getDayOfMonthFromDateTimestamp(singleHour.dt)}}<br>
            -->
            <img v-bind:src="'https://openweathermap.org/img/wn/' + singleHour.weather[0].icon + '@2x.png'" /><br>
            <span class="single-day-details">{{ singleHour.main.temp }}°<br></span>
            <span class="single-day-details">{{ singleHour.weather[0].description }}<br></span>
            <span class="single-day-details">{{ singleHour.main.humidity }}%<br></span>
            <span class="single-day-details"><b>{{ this.getHourFromDateTimestamp(singleHour.dt) }}</b><br></span>

        </div>
    </div>
    <div v-if="!isSummaryWasClicked" class="daily-container d-flex flex-row">

        <!--<area-chart :stacked="true" :library="chartOptions" :points="false" curve="false"
                    :legend="false" :discrete="true" :data="hourlyForecastDataChart"></area-chart>
                    -->
        <apexchart class="col-10" type="area" width="100%" :options="chartOptions" :series="series"></apexchart>
        <!--<HourlyCharComponent></HourlyCharComponent>-->
    </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";

export default {
    name: "HourlyForecastComponent",
    components: {
        apexchart: VueApexCharts,
    },
    data() {
        return {
            hourlyForecastData: Array,
            isSummaryWasClicked: Boolean,
            hourlyForecastDataChart: Array,
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
            return new Date(unixTimestamp * 1000).getHours() - 2 + ':00'
        },

        prepareHourlyForecastData(hourlyForecastData) {
            //console.log(hourlyForecastData)
            const hoursData = []
            const tempsData = []
            hourlyForecastData.forEach(singleHour => {
                console.log(Math.round(singleHour.main.temp))
                console.log(singleHour.weather[0].icon)
                console.log(this.getHourFromDateTimestamp(singleHour.dt))
                hoursData.push(this.getHourFromDateTimestamp(singleHour.dt))
                tempsData.push(Math.round(singleHour.main.temp) + '°')
            })

            return [hoursData, tempsData]
        }

    }
}
</script>

<style scoped>
</style>
