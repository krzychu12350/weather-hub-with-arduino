import axios from 'axios';
import api from './api'
import authHeader from './auth-header';
import Globals from "../globals";

class WeatherService {
    getCurrentForecast(placeId) {
        return axios.get(Globals.OPEN_WEATHER_MAP_API_URL + 'weather?appid=' +
            Globals.OPEN_WEATHER_MAP_APP_ID + '&id=' + placeId + '&units=' +
            Globals.UNIT_OF_MEASUREMENT)
    }

    getFiveDaysForecast(placeId) {
        return axios.get(Globals.OPEN_WEATHER_MAP_API_URL + 'forecast?appid=' +
            Globals.OPEN_WEATHER_MAP_APP_ID + '&id=' + placeId + '&units=' +
            Globals.UNIT_OF_MEASUREMENT)
    }

    getLocalWeatherDataLogs() {
        return api.get('/current-home-weather-data').then(response => {
            return response.data.data
        })
            .catch(e => {
                console.log(e);
            });
    }

    getLast24HoursIndoorWeatherData() {
        return api.get('/esp-data').then(response => {
            return response.data.data
        })
            .catch(e => {
                console.log(e);
            });
    }
}

export default new WeatherService();
