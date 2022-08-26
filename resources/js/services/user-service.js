import axios from 'axios';
import authHeader from './auth-header';
import ToastService from "./toast-service";
const API_URL = 'http://localhost:8080/api/';
const config = { headers: authHeader() };

class UserService {
    async getUserProfileData() {
        //return axios.get('http://localhost:8000/api/profile', config);

        return axios.get('http://localhost:8000/api/profile',
            authHeader())

  }
    async addUserFavouritePlace(place) {
        //console.log(favouriteplace)
        //console.log(JSON.parse(localStorage.getItem('user')).access_token)
        //console.log(authHeader())

        return axios
            .post('http://localhost:8000/api/favourite-places', {
                id: place.id,
                name: place.name,
                state: place.state,
                country: place.country,
            }, authHeader())
            .then(response => {
                //alert(response.data.message)
                ToastService.showSuccessToast(response.data.message)
                return response.data;
            })
            .catch(e => {
                    console.log(e)
                }
            );
    }
    async deleteUserFavouritePlace(placeId) {
       //alert('dziala usuwanieeeeeeeeeeeeeeeeeeeeeee' + placeId)
        return axios
            .delete('http://localhost:8000/api/favourite-places/' + placeId
                , authHeader())
            .then(response => {
                //alert(response.data.message)
                ToastService.showSuccessToast(response.data.message)
                return response.data;
            })
            .catch(e => {
                    console.log(e)
                }
            );
    }
    async getWeatherDataLogsForFavouritePlaces() {
        return axios.get('http://localhost:8000/api/weather-data-logs', authHeader())
            .then(response => {
                return response.data.data.favourite_places;
            })
            .catch(e => {
                    console.log(e)
                }
            );
    }
  getUserBoard() {
    return axios.get(API_URL + 'user', { headers: authHeader() });
  }

  getModeratorBoard() {
    return axios.get(API_URL + 'mod', { headers: authHeader() });
  }

  getAdminBoard() {
    return axios.get(API_URL + 'admin', { headers: authHeader() });
  }
}

export default new UserService();
