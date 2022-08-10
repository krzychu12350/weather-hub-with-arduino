//import './bootstrap';
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'boxicons'
//import "bootstrap/dist/css/bootstrap.min.css"
//import "bootstrap/dist/js/bootstrap.js"
import {createApp} from 'vue'
import App from './App.vue'
import router from "./router/router";
import axios from 'axios'
import VueAxios from 'vue-axios'


export const app = createApp(App)
app.use(router)
app.use(VueAxios, axios)
app.mount("#app")

