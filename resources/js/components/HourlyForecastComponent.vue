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

        <area-chart :data="{'00:00': 21, '03:00': 5}"></area-chart>
    </div>
</template>

<script>
export default {
    name: "HourlyForecastComponent",
    data() {
        return {
            hourlyForecastData: Array,
            isSummaryWasClicked: Boolean,
            hourlyForecastDataChart: Array,
        }
    },
    created() {
        this.emitter.on('loadHourlyForecastForSpecificDay', (evt) => {
            console.log('day: ' + evt.day);
            console.log('weather data: ' + evt.weatherData)
            this.hourlyForecastData = evt.weatherData
            this.prepareHourlyForecastData(this.hourlyForecastData)
            console.log(this.hourlyForecastData)
            //this.retrieveForecastForFiveDays(evt.value)

        })
    },
    methods: {
        getHourFromDateTimestamp(unixTimestamp) {
            return new Date(unixTimestamp * 1000).getHours() - 2 + ':00'
        },

        prepareHourlyForecastData(hourlyForecastData) {
            //console.log(hourlyForecastData)
            hourlyForecastData.forEach(singleHour => {
                console.log(Math.round(singleHour.main.temp))
                console.log(singleHour.weather[0].icon)
                console.log(this.getHourFromDateTimestamp(singleHour.dt))
                hourlyWeatherData.push{this.getHourFromDateTimestamp(singleHour.dt), Math.round(singleHour.main.temp)}
            })

        }


    }
}
</script>

<style scoped>

</style>
