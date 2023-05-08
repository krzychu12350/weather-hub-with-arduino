import axios from 'axios';
import authHeader from './auth-header';

class CityService {
    async searchCity(cityName) {

        return axios.get('http://localhost:8000/api/cities', {
            params: {
                name: cityName
            }
        })
    }
}

export default new CityService();
