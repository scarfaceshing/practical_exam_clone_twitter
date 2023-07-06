<template>
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
                <button
                    type="submit"
                    class="w-full bg-gray-500 py-2 rounded-lg text-white"
                >
                    Sign in
                </button>
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
</template>

<script>
import Auth from "../auth";

export default {
    data() {
        return {
            username: "",
            password: "",
        };
    },

    methods: {
        login() {
            Auth.login(this.username, this.password);
        },
    },
};
</script>
