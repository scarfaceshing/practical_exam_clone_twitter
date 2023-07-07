<template>
    <div class="container">
        <section
            class="bg-gray-800 flex flex-col items-center justify-center mx-auto h-full"
        >
            <h1 class="text-7xl text-black mb-5 font-black">Twitter</h1>
            <form
                @submit.prevent="register"
                class="bg-gray-300 rounded-lg grid grid-cols-1 space-y-5 py-5 px-5 w-96"
            >
                <div>
                    <label
                        for="name"
                        class="block text-lg mb-2 font-medium text-gray-500"
                        >Name</label
                    >
                    <input
                        type="text"
                        name="name"
                        v-model="name"
                        class="w-full rounded-lg text-lg border border-gray-100"
                    />
                    <p
                        class="text-red-500"
                        v-for="(error, index) in validate['name']"
                        v-bind:key="index"
                    >
                        {{ error }}
                    </p>
                </div>
                <div>
                    <label
                        for="email"
                        class="block text-lg mb-2 font-medium text-gray-500"
                        >Email</label
                    >
                    <input
                        type="text"
                        name="name"
                        v-model="email"
                        class="w-full rounded-lg text-lg border border-gray-100"
                    />
                    <p
                        class="text-red-500"
                        v-for="(error, index) in validate['email']"
                        v-bind:key="index"
                    >
                        {{ error }}
                    </p>
                </div>
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
                    <p
                        class="text-red-500"
                        v-for="(error, index) in validate['username']"
                        v-bind:key="index"
                    >
                        {{ error }}
                    </p>
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
                    <p
                        class="text-red-500"
                        v-for="(error, index) in validate['password']"
                        v-bind:key="index"
                    >
                        {{ error }}
                    </p>
                </div>
                <div class="">
                    <Button :is-loading="isSubmiting" title="Sign up" />
                </div>
                <div>
                    <p class="font-sm text-gray-500">
                        Login to your account?&nbsp;
                        <a
                            href="javascript:void(0)"
                            @click.prevent="$router.push('/login')"
                            class="font-sm text-blue-700"
                            >Sign in</a
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

const SUCCESS_STATUS = 200;
const URL = "api/register";

export default {
    components: {
        Button,
    },
    data() {
        return {
            name: "",
            email: "",
            username: "",
            password: "",
            validate: [],
            isSubmiting: false,
        };
    },

    methods: {
        register() {
            this.isSubmiting = true;

            const data = {
                name: this.name,
                username: this.username,
                email: this.email,
                password: this.password,
            };

            const http = HTTP.post(URL, data, null);

            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    this.$router.push({ name: "login" });
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
