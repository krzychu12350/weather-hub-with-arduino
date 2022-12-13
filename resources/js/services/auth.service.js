import api from "./api";
import TokenService from "./token.service";

const API_URL = 'http://192.168.43.141/api/';

class AuthService {
    login(user) {
        return api.post('http://192.168.43.141:8000/api/login', {
            email: user.email,
            password: user.password
        })
            .then(response => {
                if (response.data.access_token)
                    TokenService.setUser(response.data);

                return response.data;
            });
    }

    logout() {
        return api.post('http://192.168.43.141:8000/api/logout')
            .then(response => {
                return response.data;
            });
    }

    register(user) {
        return api.post(API_URL + 'register', {
            name: user.name,
            email: user.email,
            password: user.password,
            password_confirmation: user.password_confirmation

        });
    }
}

export default new AuthService();
