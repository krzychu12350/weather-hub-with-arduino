import axios from 'axios';
import Globals from "../globals";
import authHeader from "./auth-header";
import ToastService from "./toast-service";
class WeatherService {
    getCurrentForecast(placeId) {
        return axios.get(Globals.OPEN_WEATHER_MAP_API_URL + 'weather?appid=' +
            Globals.OPEN_WEATHER_MAP_APP_ID + '&id=' + placeId + '&units=' +
            Globals.UNIT_OF_MEASUREMENT)
            /*
            .then((response) => {
                this.weatherData = response.data
                this.locality = this.weatherData.name
                this.temp = this.weatherData.main.temp
                this.icon = 'https://openweathermap.org/img/wn/' + this.weatherData.weather[0].icon + '@2x.png'
                this.description = this.weatherData.weather[0].description
                this.currentDate = this.createDate(this.weatherData.dt, "long")
            })
            .catch(err => console.log(err.message))
            .finally(() => (this.loading = false))


             */
    }
    getFiveDaysForecast(placeId) {
        return axios.get(Globals.OPEN_WEATHER_MAP_API_URL + 'forecast?appid=' +
            Globals.OPEN_WEATHER_MAP_APP_ID + '&id=' + placeId + '&units=' +
            Globals.UNIT_OF_MEASUREMENT)
    }
}
export default new WeatherService();
