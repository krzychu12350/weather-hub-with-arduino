import { createWebHistory, createRouter } from "vue-router";
import Home from "../views/Home.vue";
import AuthenticationPage from "../views/AuthenticationPage.vue";
import AddingFavouritePlacePage from "../views/AddingFavouritePlacePage.vue";
import SettingsPage from "../views/SettingsPage.vue";
import SelectPrimaryPlacePage from "../views/SelectPrimaryPlacePage.vue";

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
        path: "/add-favourite",
        name: "AddingFavouritePlacePage",
        component: AddingFavouritePlacePage,
    },
    {
        path: "/settings",
        name: "SettingsPage",
        component: SettingsPage,
    },
    {
        path: "/select-primary-place",
        name: "SelectPrimaryPlacePage",
        component: SelectPrimaryPlacePage,
    },
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
