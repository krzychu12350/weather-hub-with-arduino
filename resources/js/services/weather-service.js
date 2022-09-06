import axios from 'axios';
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
}

export default new WeatherService();
