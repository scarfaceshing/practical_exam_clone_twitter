<template>
    <div class="bg-black min-h-screen">
        <div class="container mx-auto bg-black">
            <div class="flex justify-between">
                <h1 class="text-4xl text-white">Twitter</h1>
                <div class="space-x-4">
                    <button
                        type="button"
                        class="text-white"
                        @click="goToProfile"
                    >
                        Profile
                    </button>
                    <button type="button" class="text-white" @click="logout">
                        Logout
                    </button>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-1 w-5/12">
                    <form @submit.prevent="postTweet">
                        <div class="grid grid-cols-12 gap-2">
                            <textarea
                                name="twitter"
                                placeholder="What's happening?!"
                                v-model="tweet"
                                class="mb-1 col-span-9 rounded-lg bg-transparent text-white border-transparent focus:border-transparent focus:ring-0 focus:ring-transparent focus:outline-0"
                            >
                            </textarea>
                            <label>
                                <span
                                    class="mt-2 cols-span-2 text-base leading-normal"
                                >
                                    <PhotoIcon />
                                </span>
                                <input
                                    type="file"
                                    class="hidden"
                                    name="file"
                                    @change="uploadFile"
                                />
                            </label>
                            <Button
                                :is-loading="isSubmiting"
                                className="rounded-3xl col-span-2 bg-blue-500 text-white py-2 w-full font-lg mt-2"
                                title="Tweet"
                            />
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="grid grid-cols-1">
                    <img
                        v-if="imagePlaceholder"
                        :src="imagePlaceholder"
                        class="h-72 w-72"
                        onerror="this.style.display='none'"
                    />
                </div>
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-1">
                    <div v-for="(data, index) in tweets" :key="index">
                        <Tweet
                            :tweet-data="data"
                            @edit="edit"
                            v-if="reloadComponent"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const ALLOWED_FILE = ["png", "jpg", "bmp"];
import Button from "../components/Button";
import HTTP from "../http";
import Cookies from "../cookies";
import Tweet from "../components/Tweet";
import PhotoIcon from "../icons/PhotoIcon";

const TWITTER_URL = "/api/v1/twitter";
const USER_URL = "/api/v1/user";
const LOGOUT_URL = "/api/v1/logout";
const SUCCESS_STATUS = 200;

export default {
    components: {
        Button,
        Tweet,
        PhotoIcon,
    },
    data() {
        return {
            imagePlaceholder: "",
            file: "",
            tweet: "",
            isSubmiting: false,
            tweets: [],
            username: "",
            reloadComponent: true,
        };
    },

    mounted() {
        this.fetchTweet();
    },

    methods: {
        edit(value) {
            const index = this.tweets.indexOf(value);
            const toggle = !this.tweets[index].isEditing;
            this.tweets[index].isEditing = toggle;

            this.reloadComponent = false;
            this.$nextTick(() => {
                this.reloadComponent = true;
            });
        },
        logout() {
            const data = {};

            const http = HTTP.post(LOGOUT_URL, data, null);

            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    Cookies.removeToken();
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

        fetchTweet() {
            const http = HTTP.get(TWITTER_URL);
            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    this.tweets = response.data;

                    this.tweets = this.tweets.map((item) => {
                        item.isEditing = false;
                        item.isUpdated = false;

                        return item;
                    });
                }
            }).catch((error) => {
                if (error.response) {
                    console.log(error.response);
                }
            });
        },

        goToProfile() {
            const http = HTTP.get(USER_URL);

            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    const { username } = response.data;

                    this.$router.push({
                        name: "user",
                        params: { username: username },
                    });
                }
            }).catch((error) => {
                if (error.response) {
                    console.log(error.response);
                }
            });
        },

        postTweet() {
            let formData = new FormData();
            this.isSubmiting = true;

            const headers = {
                "Content-type": "multipart/form-data",
            };

            formData.append("tweet", this.tweet);
            formData.append("file", this.file);

            const http = HTTP.post(TWITTER_URL, formData, headers);

            http.then((response) => {
                if (response.status === SUCCESS_STATUS) {
                    this.fetchTweet();
                    this.isSubmiting = false;
                }
            }).catch((error) => {
                if (error.response) {
                    this.validate = error.response.data;
                    this.isSubmiting = false;
                }
            });

            this.imagePlaceholder = "";
            this.tweet = "";
            this.file = "";
        },
    },
};
</script>
