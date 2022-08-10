import { createWebHistory, createRouter } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import SidebarComponent from "../components/SidebarComponent.vue";
import Register from "../components/SearchEngineComponent.vue";

const routes = [
    /*
    {
        path: "/",
        name: "Home",
        component: Home,
    },
     */
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
});

export default router;
