import axios from 'axios';
import authHeader from './auth-header';
import ToastService from "./toast-service";
import api from "./api";
import TokenService from "./token.service";
//const API_URL = 'http://localhost:8080/api/auth/';
const API_URL = 'http://localhost:8000/api/';

class AuthService {
    login(user) {
        //console.log('auhserice:' + user.email)

        return api
            .post('http://localhost:8000/api/login', {
                //username: user.username,
                email: user.email,
                password: user.password
            })
            .then(response => {
                console.log(response)
                console.log("Recived token " + response.data.access_token)
                if (response.data.access_token) {
                    //localStorage.setItem('user', JSON.stringify(response.data));
                    TokenService.setUser(response.data);
                    //console.log('dane usera' + localStorage.getItem('user'))
                }
                return response.data;
            });
    }

    logout() {
        return api.post('http://localhost:8000/api/logout')
            .then(response => {
                return response.data;
            });
    }

    register(user) {
        return api.post(API_URL + 'register', {
            //username: user.username,
            name: user.name,
            email: user.email,
            password: user.password,
            password_confirmation: user.password_confirmation

        });
    }
}

export default new AuthService();
