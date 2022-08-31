<template>
    <!--
    <ul v-for="item in this.triggerData[0]">
        <li>{{ item }}</li>
    </ul>
    -->
    <h2 class="color text-white">Graph of temperature and humidity over time</h2>

    <apexchart class="col-10" height=500px type="area" :options="chartOptions" :series="series"></apexchart>
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
        this.updateChart(this.seriesOfTemperatures, this.seriesOfHumidity, this.seriesOfCreatedAt)
    },
    props: ['triggerData'],
    data () {
        return {
            Trigger: false,
            showMenuBar: false,
            seriesOfTemperatures: Array,
            seriesOfHumidity: Array,
            seriesOfCreatedAt: Array,

            chartOptions: {
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
                    //categories: ['11', '12', '13'],
                    categories: ['2022-08-24T23:28:45.000000Z', '2022-08-24T23:29:40.000000Z',
                        '2022-08-25T15:24:25.000000Z', '2022-08-25T17:04:12.000000Z', '2022-08-25T17:04:47.000000Z',
                        '2022-08-25T17:09:02.000000Z', '2022-08-25T17:11:02.000000Z', '2022-08-25T17:12:02.000000Z',
                        '2022-08-25T17:27:02.000000Z', '2022-08-25T17:28:02.000000Z', '2022-08-25T17:30:02.000000Z',
                        '2022-08-25T17:35:01.000000Z'],
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
            },
            series: [
                {
                    name: 'temps',
                    data: [78, 56, 56, 21, 21, 21, 21, 21, 21, 21, 21, 21],
                },
                {
                    name: 'values of humidity',
                    data: [78, 56, 56, 21, 21, 21, 21, 21, 21, 21, 21, 21],
                },
            ]


        }
    },
    /*
    created() {
        //this.updateChart()
    },

     */
    //created() {

        //tego nie trzeba jak są dane w data return
        //await this.updateChart()
        /*
        this.emitter.on('passChartData',  async (evt) => {

            console.log('w wykresie')
            console.log(evt.chartData)
            //console.log(evt.chartData[0])
            //.log(evt.chartData[1])
            //console.log(evt.chartData[2])

            this.seriesOfTemperatures = evt.chartData[0]
            //console.log(this.seriesOfTemperatures)
            this.seriesOfHumidity = evt.chartData[1]
            this.seriesOfCreatedAt = evt.chartData[2]
            console.log('koniec wykresie')
            //this.updateChart(this.seriesOfTemperatures, evt.chartData[1], evt.chartData[2])
        })
        */

   // },
    beforeUnmount () {
        //console.warn('unmount chart')
        //this.emitter.off('passChartData')
    },
    methods: {
        updateChart(seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt) {
            //console.log('update CHart func')
            //console.log(seriesOfTemperatures, seriesOfHumidity, seriesOfCreatedAt)
            this.series = [
                {
                    name: 'temps',
                    data: seriesOfTemperatures,
                },
                {
                    name: 'values of humidity',
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
                            fontSize: '16px',
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

<style scoped>

</style>
