require("./bootstrap");
import Vue from "vue";
import VueCookies from "vue-cookies";
import App from "./components/App";
import router from "./router";
import "../css/app.css";

Vue.use(VueCookies, { expires: "1D" });

const app = new Vue({
    el: "#app",
    components: { App },
    router,
});
