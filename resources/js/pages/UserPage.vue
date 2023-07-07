<template>
    <div class="bg-black min-h-screen">
        <div class="container mx-auto bg-black flex justify-center">
            <div class="bg-white w-1/2 space-y-5 rounded-xl p-5">
                <div class="-my-5">
                    <a
                        href="javascript:void(0)"
                        @click="$router.push({ name: 'twitter' })"
                        class="hover:underline"
                        >Back</a
                    >
                </div>
                <div class="mb-5">
                    <h1 class="text-5xl text-center">Profile</h1>
                </div>
                <div>
                    <label class="text-3xl">Username:</label>
                    <span class="text-3xl">{{
                        this.userDetails.username
                    }}</span>
                </div>
                <div>
                    <label class="text-3xl">Email:</label>
                    <span class="text-3xl">{{ this.userDetails.email }}</span>
                </div>
                <div>
                    <span class="text-3xl">Name:</span>
                    <span class="text-3xl">{{ this.userDetails.name }}</span>
                </div>
                <div>
                    <span class="text-3xl">Followers:</span>
                    <span class="text-3xl">1</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HTTP from "../http";

const USER_URL = "/api/v1/user";
const SUCCESS_STATUS = 200;

export default {
    data() {
        return {
            userDetails: [],
        };
    },

    methods: {
        fetchUser() {
            const http = HTTP.get(`${USER_URL}/${this.username}`);

            http.then((response) => {
                const { data, status } = response;
                if (status === SUCCESS_STATUS) {
                    this.userDetails = data;
                }
            }).catch((error) => {
                if (error.response) {
                    console.log(error);
                }
            });
        },
    },

    created() {
        this.username = this.$route.params.username;
    },

    mounted() {
        this.fetchUser();
    },
};
</script>
