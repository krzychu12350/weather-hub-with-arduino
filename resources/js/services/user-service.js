import axios from 'axios';
import authHeader from './auth-header';
import ToastService from "./toast-service";

class UserService {
    async getUserProfileData() {
        return axios.get('http://localhost:8000/api/profile',
            authHeader())
    }

    async addUserFavouritePlace(place) {
        return axios
            .post('http://localhost:8000/api/favourite-places', {
                id: place.id,
                name: place.name,
                state: place.state,
                country: place.country,
            }, authHeader())
            .then(response => {
                ToastService.showToast(response.data.message, "success")
                return response.data;
            })
            .catch(e => {
                    console.log(e)
                }
            );
    }

    async deleteUserFavouritePlace(placeId) {
        return axios
            .delete('http://localhost:8000/api/favourite-places/' + placeId
                , authHeader())
            .then(response => {
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
            primary_place_id: placeId
        }, authHeader())
            .then(response => {
                ToastService.showToast(response.data.message, "success")
                return response.data;
            })
            .catch(e => {
                    console.log(e)
                }
            );
    }

    async deleteUserAccount() {
        return axios.delete('http://localhost:8000/api/user-delete', authHeader())
            .then(response => {
                ToastService.showToast(response.data.message, "success")
                return response.data;
            })
            .catch(e => {
                console.log(e)
            });
    }
}

export default new UserService();
