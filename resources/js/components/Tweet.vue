<template>
    <div class="flex justify-center">
        <div class="bg-black w-3/5">
            <div class="flex justify-between text-neutral-500 mt-5 w-full">
                <span>
                    posted by:
                    <a
                        href="javascript:void(0)"
                        @click="
                            $router.push({
                                name: 'user',
                                params: { username: userName },
                            })
                        "
                        class="hover:underline"
                        >@{{ userName }}</a
                    >

                    at {{ tweetData.created_at }}
                </span>
                <span>
                    <a
                        href="javascript:void(0)"
                        v-if="!tweetData.isEditing"
                        @click="edit(tweetData)"
                        ><PenIcon
                    /></a>
                    <a href="javascript:void(0)" @click="edit(tweetData)" v-else
                        ><SaveIcon
                    /></a>
                </span>
            </div>
            <div
                v-if="!tweetData.isEditing"
                class="grid grid-cols-2 space-y-5 space-x-5 w-full"
            >
                <div class="w-1/8">
                    <h1 class="text-white text-3xl">{{ tweetData.tweet }}</h1>
                </div>
                <div v-if="tweetData.file_name" class="w-full h-72">
                    <img
                        :src="`${storage_path}/${tweetData.file_name}`"
                        class="w-full h-full"
                    />
                </div>
            </div>
            <div
                v-if="tweetData.isEditing"
                class="grid grid-cols-2 space-y-5 space-x-5 w-full"
            >
                <div>
                    <input type="text" :value="tweetData.tweet" />
                </div>
                <div
                    v-if="tweetData.file_name"
                    class="w-full h-72 bg-green-500 group"
                >
                    <span
                        class="absolute hidden group-hover:inline mt-28 ml-24 text-2xl font-bold"
                        >Upload photo</span
                    >
                    <img
                        :src="`${storage_path}/${tweetData.file_name}`"
                        class="group-hover:opacity-50 w-full h-full"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PenIcon from "../icons/PenIcon";
import SaveIcon from "../icons/SaveIcon";

const STORAGE_PATH = "/storage/twitter";

export default {
    components: {
        PenIcon,
        SaveIcon,
    },
    props: {
        tweetData: {
            type: Object,
        },
    },

    methods: {
        edit(data) {
            this.$emit("edit", data);
        },
    },

    computed: {
        userName() {
            return this.tweetData.users.username;
        },
    },

    created() {
        this.storage_path = STORAGE_PATH;
    },
};
</script>

<style></style>
