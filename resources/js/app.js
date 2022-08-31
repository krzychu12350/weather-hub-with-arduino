import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import 'boxicons'
//import "bootstrap/dist/css/bootstrap.min.css"
//import "bootstrap/dist/js/bootstrap.js"
import {createApp} from 'vue'
import App from './App.vue'
import router from "./router/router";
import axios from 'axios'
import VueAxios from 'vue-axios'
import store from "./store/store";

import mitt from 'mitt';
const emitter = mitt();
axios.defaults.withCredentials = false
axios.defaults.baseURL = 'http://localhost:8000/'
//axios.defaults.baseURL = 'http://127.0.0.1:8000/'
import ToastPlugin, {useToast} from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

import VueApexCharts from "vue3-apexcharts";

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import {fas, faUserSecret} from '@fortawesome/free-solid-svg-icons'
import {far} from "@fortawesome/free-regular-svg-icons";

/* add icons to the library */
library.add(faUserSecret)
library.add(fas)
library.add(far)

import vClickOutside from "click-outside-vue3"

export const app = createApp(App)
    .use(router)
    .use(store)
    .use(VueAxios, axios)
    //.use(VueChartkick)
    .use(vClickOutside)
    .use(VueApexCharts)
    .component('font-awesome-icon', FontAwesomeIcon)
    .use(ToastPlugin)

app.config.globalProperties.emitter = emitter
app.mount("#app")

app.config.globalProperties.emitter = emitter
const $toast = useToast();
let instance = $toast.success('You did it!');

// Force dismiss specific toast
instance.dismiss();

// Dismiss all opened toast immediately
$toast.clear();
