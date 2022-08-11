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
import store from "./store/store";

import ToastPlugin from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

export const app = createApp(App)
    .use(router)
    .use(store)
    .use(VueAxios, axios)
    .use(ToastPlugin)
    .mount("#app")

let instance = app.$toast.open('You did it!');

// Force dismiss specific toast
instance.dismiss();

// Dismiss all opened toast immediately
app.$toast.clear();
