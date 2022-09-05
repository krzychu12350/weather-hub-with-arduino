import axios from 'axios';
import authHeader from './auth-header';
import ToastService from "./toast-service";
import api from "./api";
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
                ToastService.showToast(response.data.message, "success")
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
                ToastService.showToast(response.data.message, "success")
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
    async updateUserPrimaryPlace(placeId) {
        return axios.put('http://localhost:8000/api/update-primary-place', {
            primary_place_id: placeId}, authHeader())
            .then(response => {
                ToastService.showToast(response.data.message, "success")
                return response.data;
            })
            .catch(e => {
                    console.log(e)
                }
            );
    }
}

export default new UserService();
