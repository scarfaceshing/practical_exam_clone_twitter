<template>
    <div class="container">
        <section
            class="bg-gray-800 flex flex-col items-center justify-center mx-auto h-full"
        >
            <h1 class="text-7xl text-black mb-5 font-black">Twitter</h1>
            <form
                @submit.prevent="login"
                class="bg-gray-300 rounded-lg grid grid-cols-1 space-y-5 py-5 px-5 w-96"
            >
                <div>
                    <label
                        for="username"
                        class="block text-lg mb-2 font-medium text-gray-500"
                        >Username</label
                    >
                    <input
                        type="text"
                        name="username"
                        v-model="username"
                        class="w-full rounded-lg text-lg border border-gray-100"
                    />
                </div>
                <div class="mb-3">
                    <label
                        for="password"
                        class="block text-lg mb-2 font-medium text-gray-500"
                        >Password</label
                    >
                    <input
                        type="password"
                        name="password"
                        v-model="password"
                        class="w-full rounded-lg text-lg border border-gray-100"
                    />
                </div>
                <div>
                    <Button :is-loading="isSubmiting" title="Sign in" />
                </div>
                <div>
                    <p class="font-sm text-gray-500">
                        Don’t have an account yet?&nbsp;
                        <a
                            href="javascript:void(0)"
                            @click.prevent="$router.push('/register')"
                            class="font-sm text-blue-700"
                            >Sign up</a
                        >
                    </p>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
import HTTP from "../http";
import Button from "../components/Button.vue";
import Cookies from "../cookies";

const URL = "api/login";
const SUCCESS_STATUS = 200;
const TWITTER_URL = "/api/v1/twitter";

export default {
    components: {
        Button,
    },
    data() {
        return {
            username: "",
            password: "",
            isSubmiting: false,
        };
    },

    mounted() {
        const isAuth = this.$cookies.isKey("session");

        if (isAuth) this.$router.push({ name: "twitter" });
    },

    methods: {
        login() {
            this.isSubmiting = true;

            const data = {
                username: this.username,
                password: this.password,
            };

            const http = HTTP.post(URL, data);

            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    const token = response.data.token;
                    Cookies.saveToken(token);
                    this.$router.push("/twitter");
                    this.isSubmiting = false;
                }
            }).catch((error) => {
                if (error.response) {
                    this.validate = error.response.data;
                    this.isSubmiting = false;
                }
            });
        },
    },
};
</script>
