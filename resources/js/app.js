require("./bootstrap");
import "../css/app.css";

import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import App from "./components/App";
import routes from "./router";

const router = new VueRouter(routes);

const app = new Vue({
    el: "#app",
    components: { App },
    router,
});
