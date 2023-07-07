<template>
    <div class="bg-black h-full">
        <div class="container mx-auto h-full">
            <div class="flex justify-between">
                <h1 class="text-4xl text-white">Twitter</h1>
                <button type="button" class="text-white" @click="logout">
                    Logout
                </button>
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-1">
                    <div class="grid grid-cols-1">
                        <form
                            @submit.prevent="postTweet"
                            class="grid grid-cols-3 gap-x-3"
                        >
                            <input
                                type="text"
                                name="twitter"
                                placeholder="What's happening?!"
                                v-model="tweet"
                                class="text-3xl col-span-2 w-full mb-1 rounded-lg bg-transparent text-white border-transparent focus:border-transparent focus:ring-0 focus:ring-transparent focus:outline-0"
                            />
                            <label class="flex flex-col w-5">
                                <span class="mt-2 text-base leading-normal"
                                    ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6 text-white"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                                        />
                                    </svg>
                                </span>
                                <input
                                    type="file"
                                    class="hidden"
                                    @change="uploadFile"
                                />
                            </label>
                            <Button
                                :is-loading="isSubmiting"
                                className="rounded-3xl bg-blue-500 text-white py-2 w-24 font-lg mt-2"
                                title="Tweet"
                            />
                        </form>
                    </div>
                    <div class="grid grid-cols-1">
                        <img
                            v-if="imagePlaceholder"
                            :src="imagePlaceholder"
                            class="h-72 w-72"
                            onerror="this.style.display='none'"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const ALLOWED_FILE = ["png", "jpg", "bmp"];
import Button from "../components/Button.vue";
import HTTP from "../http";
import Cookies from "../cookies";

const TWITTER_URL = "/api/v1/twitter";
const LOGOUT_URL = "/api/v1/logout";
const SUCCESS_STATUS = 200;

export default {
    components: {
        Button,
    },
    data() {
        return {
            imagePlaceholder: "",
            file: "",
            tweet: "",
            isSubmiting: false,
        };
    },

    methods: {
        logout() {
            this.$cookies.remove("session");

            const data = {};

            const http = HTTP.post(LOGOUT_URL, data);

            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    Cookies.removeToken();
                    this.$router.push("/login");
                    this.isSubmiting = false;
                }
            }).catch((error) => {
                if (error.response) {
                    this.validate = error.response.data;
                    this.isSubmiting = false;
                }
            });
        },
        uploadFile(e) {
            const file = e.target.files[0];

            if (file) {
                const fileName = file.name;
                const fileExtension = fileName.split(".")[1];

                if (ALLOWED_FILE.includes(fileExtension)) {
                    this.imagePlaceholder = URL.createObjectURL(file);
                    this.file = file;
                }
            }
        },

        postTweet() {
            this.isSubmiting = true;

            const data = {
                tweet: this.tweet,
                file: this.file,
            };

            const http = HTTP.post(TWITTER_URL, data);

            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    console.log(response);
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

    created() {},
};
</script>
