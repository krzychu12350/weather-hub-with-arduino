import { createWebHistory, createRouter } from "vue-router";
import Home from "../views/Home.vue";
import AuthenticationPage from "../views/AuthenticationPage.vue";
import FavouritePlacesPage from "../views/FavouritePlacesPage.vue";
import AddingFavouritePlacePage from "../views/AddingFavouritePlacePage.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/auth",
        name: "AuthenticationPage",
        component: AuthenticationPage,
    },
    {
        path: "/favourites",
        name: "FavouritePlacesPage",
        component: FavouritePlacesPage,
    },
    {
        path: "/add-favourite",
        name: "AddingFavouritePlacePage",
        component: AddingFavouritePlacePage,
    },

    /*
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
     */
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
});

router.beforeEach((to, from, next) => {
    const publicPages = ['/auth'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('user');
    if (authRequired && !loggedIn) {
        next('/auth');
    } else {
        next();
    }
});

export default router;
