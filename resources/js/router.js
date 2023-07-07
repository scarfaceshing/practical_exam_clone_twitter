import Vue from "vue";
import LoginPage from "./pages/LoginPage";
import RegisterPage from "./pages/RegisterPage";
import TwitterPage from "./pages/TwitterPage";
import UserPage from "./pages/UserPage";
import VueRouter from "vue-router";
import Cookies from "./cookies";

const cookies = Cookies;
Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: LoginPage,
        },
        {
            path: "*",
            component: LoginPage,
        },
        {
            path: "/login",
            name: "login",
            component: LoginPage,
            beforeEnter: (to, from, next) => {
                const isAuth = cookies.checkToken();

                if (to.name === "login" && isAuth) next({ name: "twitter" });

                next();
            },
        },
        {
            path: "/register",
            name: "register",
            component: RegisterPage,
            beforeEnter: (to, from, next) => {
                const isAuth = cookies.checkToken();

                if (to.name === "login" && isAuth) next({ name: "twitter" });

                next();
            },
        },
        {
            path: "/twitter",
            name: "twitter",
            component: TwitterPage,
            beforeEnter: (to, from, next) => {
                const isAuth = cookies.checkToken();

                if (to.name !== "login" && !isAuth) next({ name: "login" });

                next();
            },
        },
        {
            path: "/user/:username",
            name: "user",
            component: UserPage,
            beforeEnter: (to, from, next) => {
                const isAuth = cookies.checkToken();

                if (to.name !== "login" && !isAuth) next({ name: "login" });

                next();
            },
        },
    ],
});

export default router;
