import { createWebHistory, createRouter } from "vue-router";
import Home from "../views/Home.vue";
import TestLoginPage from "../views/TestLoginPage.vue";
import AuthenticationPage from "../views/AuthenticationPage.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/login",
        name: "AuthenticationPage",
        component: AuthenticationPage,
    },
    /*
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
     */
    {
        path: "/test-login",
        name: "Test-Login",
        component: TestLoginPage,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
});

router.beforeEach((to, from, next) => {
    const publicPages = ['/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('user');
    if (authRequired && !loggedIn) {
        next('/login');
    } else {
        next();
    }
});

export default router;
