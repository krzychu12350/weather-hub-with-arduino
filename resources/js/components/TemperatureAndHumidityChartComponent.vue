<template>
    <apexchart class="col-10" type="area" :options="chartOptions" :series="series"></apexchart>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";

export default {
    name: "TemperatureAndHumidityChartComponent",
    components: {
        apexchart: VueApexCharts,
    },
    created() {
        this.updateChart()
    },
    methods: {
        updateChart() {
            this.series = [
                {
                name: 'temps',
                data: [100, 200, 300]
                },
                {
                    name: 'values of humadity',
                    data: [80, 50, 40]
                },
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
                    categories: ['11', '12', '13'],
                    //categories: hours,
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
    }
}
</script>

<style scoped>

</style>
