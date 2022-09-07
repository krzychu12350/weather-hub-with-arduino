<template>
    <h2
        class="color text-white"
    >
        Graph of temperature and humidity over time
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

export default {
    name: "TemperatureAndHumidityChartComponent",
    components: {
        apexchart: VueApexCharts,
    },
    created() {
        this.seriesOfTemperatures = this.triggerData[0]
        this.seriesOfHumidity = this.triggerData[1]
        this.seriesOfCreatedAt = this.triggerData[2]
        this.updateChart(this.seriesOfTemperatures,
            this.seriesOfHumidity, this.seriesOfCreatedAt)
    },
    props: ['triggerData'],
    data() {
        return {
            Trigger: false,
            showMenuBar: false,
            seriesOfTemperatures: Array,
            seriesOfHumidity: Array,
            seriesOfCreatedAt: Array,
        }
    },
    methods: {
        updateChart(seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt) {
            this.series = [
                {
                    name: 'temperature',
                    data: seriesOfTemperatures,
                },
                {
                    name: 'humidity',
                    data: seriesOfHumidity,
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
    }
}
</script>
