<template>
    <h2
        class="color text-white"
    >
        Last 24 Hours Chart
    </h2>
    <apexchart
        class="col-10"
        height=500px
        type="area"
        :options="chartOptions"
        :series="series"
    />
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import WeatherService from "../services/weather-service";

export default {
    name: "IndoorWeatherChartComponent",
    components: {
        apexchart: VueApexCharts,
    },
    created() {
        this.fetchLast24HoursIndoorWeatherData();
    },
    data() {
        return {
            chartOptions: {},
            series: []
        }
    },
    methods: {
        updateChart(seriesOfTemperatures, seriesOfHumidity,
                    seriesOfPressure, seriesOfLightIntensity, seriesOfCreatedAt) {
            this.series = [
                {
                    name: 'temperature (in °C)',
                    data: seriesOfTemperatures,
                },
                {
                    name: 'humidity (in %)',
                    data: seriesOfHumidity,
                },

                {
                    name: 'pressure (in hPa)',
                    data: seriesOfPressure,
                },
                {
                    name: 'light intensity (in lx)',
                    data: seriesOfLightIntensity,
                },


            ];
            this.chartOptions = {
                fill: {
                    type: 'solid',
                    opacity: 0.3,
                    colors: ['#fff']
                },
                grid: {
                    show: false,
                },
                legend: {
                    show: true,
                    labels: {
                        colors: '#fff',
                    },
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
                    categories: seriesOfCreatedAt,
                    labels: {
                        show: true,
                        style: {
                            fontSize: '11px',
                            fontFamily: 'Arial, sans-serif',
                            colors: '#fff',
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
            };

        },
        async fetchLast24HoursIndoorWeatherData() {
            let last24HoursWeatherData = await WeatherService.getLast24HoursIndoorWeatherData();
            let seriesOfTemperaturesArray = [];
            let seriesOfHumidityArray = [];
            let seriesOfPressureArray = [];
            let seriesOfLightIntensityArray = [];
            let seriesOfCreatedAtArray = [];
            last24HoursWeatherData.forEach(singleLog => {
                console.log(singleLog.temperature_at_home);
                seriesOfTemperaturesArray.push(singleLog.temperature_at_home);
                seriesOfHumidityArray.push(singleLog.humidity_at_home);
                seriesOfPressureArray.push(singleLog.pressure_at_home);
                seriesOfLightIntensityArray.push(singleLog.light_intensity_at_home);
                seriesOfCreatedAtArray.push((singleLog.certain_hour));
            });
            this.updateChart(seriesOfTemperaturesArray, seriesOfHumidityArray,
                seriesOfPressureArray, seriesOfLightIntensityArray, seriesOfCreatedAtArray)
        },
    }
}
</script>
