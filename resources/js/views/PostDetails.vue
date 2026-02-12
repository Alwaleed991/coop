<template>
    <AppLayout>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">PostDetails</h1>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Welcome back!</h2>
            <p class="text-gray-600">
                here you can see your post details and you can edit and delete
                them.
            </p>
        </div>

        <!-- <div
            v-if="successMessage"
            class="rounded-md bg-green-50 border border-green-200 p-4 mb-6 mt-6"
        >
            <p class="text-sm text-green-800 mt-2">
                {{
                    "The " +
                    successMessage +
                    " please head back to the dashbord"
                }}
            </p>
        </div> -->

        <!-- <div
            v-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 mt-6"
        >
            <p class="text-red-800">{{ error }}</p>
        </div> -->

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">Loading posts...</p>
        </div>

        <div v-else class="mt-6">
            <PostCard :post="post" />
        </div>

        <button
            @click="showForm = !showForm"
            :class="{
                'mt-6 mb-6 flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs': true,
                'bg-red-600 hover:bg-red-700': showForm === true,
                'bg-indigo-600 hover:bg-indigo-500': showForm === false,
            }"
        >
            {{ showForm ? "Cancel" : "+ Edit Your Post" }}
        </button>

        <div v-if="showForm" class="bg-white rounded-lg shadow p-6 mb-6">
            <PostForm @success="handlePostEdited" :post="post" />
        </div>

        <button
            @click="DeleteUserPost"
            :disabled="loading"
            class="mt-6 mb-6 flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs bg-red-600 hover:bg-red-700 disabled:cursor-not-allowed"
        >
            - Delete Your Post
        </button>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import PostForm from "@/components/PostForm.vue";
import PostCard from "@/components/PostCard.vue";

export default {
    name: "PostDetails",
    components: {
        AppLayout,
        PostForm,
        PostCard,
    },
    data() {
        return {
            showForm: false,
            successMessage: "",
            post: {},
            loading: false,
            error: "",
        };
    },
    mounted() {
        const postId = this.$route.params.id;
        this.fetchUserPost(postId);
    },
    methods: {
        handlePostEdited(data) {
            this.$router.push({ name: "home" }); // maby you can send the data.message to the home page
        },
        async fetchUserPost(postId) {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const response = await fetch(
                    `http://coop.test/api/v1/posts/${postId}`,
                    {
                        method: "GET",
                        headers: {
                            Accept: "application/json",
                            Authorization: `Bearer ${token}`,
                        },
                    },
                );

                const data = await response.json();

                if (response.ok) {
                    this.post = data.data;
                } else {
                    this.error = "Failed to load posts";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Posts error:", err);
            } finally {
                this.loading = false;
            }
        },

        async DeleteUserPost() {
            if (!confirm("Are you sure you want to delete this post?")) {
                return;
            }
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const response = await fetch(
                    `http://coop.test/api/v1/posts/${this.post.id}`,
                    {
                        method: "DELETE",
                        headers: {
                            Accept: "application/json",
                            Authorization: `Bearer ${token}`,
                        },
                    },
                );

                const data = await response.json();

                if (response.ok) {
                    this.$router.push({ name: "home" }); // maby you can send the data.message to the home
                } else {
                    this.error = "Failed to load posts";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again .";
                console.error("Posts error:", err);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
