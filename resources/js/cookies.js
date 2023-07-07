import VueCookies from "vue-cookies";
const cookies = VueCookies;
const SESSION_NAME = "session";

export default {
    saveToken(token) {
        cookies.set(SESSION_NAME, token);
    },
    getToken() {
        if (cookies.isKey(SESSION_NAME)) {
            const token = cookies.get(SESSION_NAME);

            if (token) {
                return token;
            }
        }
    },

    checkToken() {
        return cookies.isKey(SESSION_NAME);
    },

    removeToken() {
        return cookies.remove(SESSION_NAME);
    },
};
