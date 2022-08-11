import axios from 'axios';
import authHeader from './auth-header';
//const API_URL = 'http://localhost:8080/api/auth/';
const API_URL = 'http://localhost:8000/api/';

class AuthService {
    login(user) {
        //console.log('auhserice:' + user.email)
        return axios
            .post(API_URL + 'login', {
                //username: user.username,
                email: user.email,
                password: user.password
            })
            .then(response => {
                console.log("Recived token " + response.data.access_token)
                if (response.data.access_token) {
                    localStorage.setItem('user', JSON.stringify(response.data));
                    console.log('dane usera' + localStorage.getItem('user'))
                }

                return response.data;
            });
    }

    logout() {
        localStorage.removeItem('user');
    }

    register(user) {
        return axios.post(API_URL + 'register', {
            //username: user.username,
            name: user.name,
            email: user.email,
            password: user.password,
            password_confirmation: user.password_confirmation

        });
    }
}

export default new AuthService();
