<template>
    <AppLayout>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Welcome back!</h2>
            <p class="text-gray-600">You're successfully logged in.</p>
        </div>

        <div
            v-if="successMessage"
            class="rounded-md bg-green-50 border border-green-200 p-4 mb-6 mt-6"
        >
            <p class="text-sm text-green-800 mt-2">{{ successMessage }}</p>
        </div>

        <div
            v-else-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 mt-6"
        >
            <p class="text-red-800">{{ error }}</p>
        </div>

        <button
            @click="showForm = !showForm"
            :class="{
                'mt-6 mb-6 flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs': true,
                'bg-red-600 hover:bg-red-700': showForm === true,
                'bg-indigo-600 hover:bg-indigo-500': showForm === false,
            }"
        >
            {{ showForm ? "Cancel" : "+ Create New Post" }}
        </button>

        <div v-if="showForm" class="bg-white rounded-lg shadow p-6 mb-6">
            <PostForm @success="handlePostCreated" />
        </div>

        <div>
            <PostCard
                v-for="post in posts"
                :key="post.id"
                :post="post"
                @click="goToPostDetails(post.id)"
            />
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import PostForm from "@/components/PostForm.vue";
import PostCard from "@/components/PostCard.vue";

export default {
    name: "Home",
    components: {
        AppLayout,
        PostForm,
        PostCard,
    },
    data() {
        return {
            showForm: false,
            successMessage: "",
            posts: [],
            loading: false,
            error: "",
            user: {},
        };
    },
    mounted() {
        this.fetchUserPosts();
    },
    methods: {
        handlePostCreated(data) {
            this.successMessage = data.message;
            this.showForm = false;
            this.fetchUserPosts() //to refresh the list!
            setTimeout(() => {
                this.successMessage = "";
            }, 3000);
        },
        async fetchUserPosts() {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const userJson = localStorage.getItem("user");
                if (userJson) {
                    this.user = JSON.parse(userJson);
                }
                const response = await fetch(
                    `http://coop.test/api/v1/users/${this.user.id}/posts`,
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
                    this.posts = data.data;
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
        goToPostDetails(postId) {
            this.$router.push({ name: "post-details", params: { id: postId } });
        },
    },
};
</script>
