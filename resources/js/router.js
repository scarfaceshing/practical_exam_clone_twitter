import Login from "./components/Login";
import Register from "./components/Register";

const routes = {
    mode: "history",
    routes: [
        {
            path: "/",
            component: Login,
        },
        {
            path: "/login",
            name: "login",
            component: Login,
        },
        {
            path: "/register",
            name: "register",
            component: Register,
        },
    ],
};

export default routes;
