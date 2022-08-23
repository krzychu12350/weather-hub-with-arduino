import axios from 'axios';
import Globals from "../globals";
class WeatherService {
    getCurrentForecast(placeId) {
        return axios.get(Globals.API_URL + 'weather?appid=' + Globals.APP_ID + '&id=' + placeId + '&units=metric',)
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
        return axios.get(Globals.API_URL + 'forecast?appid=' + Globals.APP_ID + '&id=' + placeId + '&units=metric',)
    }
}
export default new WeatherService();
