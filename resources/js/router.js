import Vue from "vue";
import Login from "./components/Login";
import Register from "./components/Register";
import Twitter from "./components/Twitter";
import VueRouter from "vue-router";
import Cookies from "./cookies";

const cookies = Cookies;
Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: Login,
        },
        {
            path: "*",
            component: Login,
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            beforeEnter: (to, from, next) => {
                const isAuth = cookies.checkToken();

                if (to.name === "login" && isAuth) next({ name: "twitter" });

                next();
            },
        },
        {
            path: "/register",
            name: "register",
            component: Register,
        },
        {
            path: "/twitter",
            name: "twitter",
            component: Twitter,
            beforeEnter: (to, from, next) => {
                const isAuth = cookies.checkToken();

                if (to.name !== "login" && !isAuth) next({ name: "login" });

                next();
            },
        },
    ],
});

export default router;
