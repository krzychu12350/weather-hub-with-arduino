import axios from 'axios';
import api from "./api";
import authHeader from './auth-header';
import ToastService from "./toast-service";

class UserService {
    async getUserProfileData() {
        return api.get('/profile',
            authHeader())
    }

    async addUserFavouritePlace(place) {
        return api
            .post('/favourite-places', {
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
        return api
            .delete('/favourite-places/' + placeId
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
        return api.get('/weather-data-logs', authHeader())
            .then(response => {
                return response.data.data.favourite_places;
            })
            .catch(e => {
                    console.log(e)
                }
            );
    }

    async updateUserPrimaryPlace(placeId) {
        return api.put('/update-primary-place', {
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
        return api.delete('/user-delete', authHeader())
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
