import "bootstrap"
import "bootstrap/dist/css/bootstrap.min.css"
import 'boxicons'
import mitt from 'mitt';
const emitter = mitt();
import {createApp} from 'vue'
import App from './App.vue'
import router from "./router/router";
import axios from 'axios'
import VueAxios from 'vue-axios'
import store from "./store/store";
import ToastPlugin, {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueApexCharts from "vue3-apexcharts";
import vClickOutside from "click-outside-vue3"
import setupInterceptors from './services/setupInterceptors';
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {fas, faUserSecret} from '@fortawesome/free-solid-svg-icons'
import {far} from "@fortawesome/free-regular-svg-icons";
library.add(faUserSecret)
library.add(fas)
library.add(far)

import alanBtn from "@alan-ai/alan-sdk-web";

axios.defaults.withCredentials = false
axios.defaults.baseURL = 'http://localhost:8000/'
setupInterceptors(store);



export const app = createApp(App)
    .use(router)
    .use(store)
    .use(VueAxios, axios)
    .use(vClickOutside)
    .use(VueApexCharts)
    .component('font-awesome-icon',
        FontAwesomeIcon)
    .use(ToastPlugin)

app.config.globalProperties.emitter = emitter
app.mount("#app")

const $toast = useToast();
let instance = $toast.success('You did it!');
instance.dismiss();
$toast.clear();
