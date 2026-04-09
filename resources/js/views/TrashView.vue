<template>
    <AppLayout>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Trash can</h1>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-2">Welcome back!</h2>
            <p class="text-gray-600">
                Here you can preminitly delete your posts or restore it.
            </p>
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

        <div>
            <PostCard
                v-for="post in posts"
                :key="post.id"
                :post="post"
                :type="'trash'"
                @click="goToPostDetails(post.id)"
                @restored="onPostRestored"
                @deleted="onPostDeleted"
            />
        </div>

        <div class="flex justify-center mt-6">
            <vue-awesome-paginate
                :total-items="totalItems"
                :items-per-page="5"
                :max-pages-shown="5"
                v-model="currentPage"
                @click="fetchUserPosts"
            />
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import PostCard from "@/components/PostCard.vue";

export default {
    name: "Trash",
    components: {
        AppLayout,
        PostCard,
    },
    data() {
        return {
            successMessage: "",
            posts: [],
            loading: false,
            error: "",
            user: {},
            totalItems: 0,
            currentPage: 1,
        };
    },
    mounted() {
        this.fetchUserPosts();
    },
    methods: {
        onPostRestored({ postId, message }) {
            this.posts = this.posts.filter((p) => p.id !== postId);
            this.successMessage = message;
            setTimeout(() => {
                this.successMessage = "";
            }, 3000);
        },
        onPostDeleted({ postId, message }) {
            this.posts = this.posts.filter((p) => p.id !== postId);
            this.successMessage = message;
            setTimeout(() => {
                this.successMessage = "";
            }, 3000);
        },
        async fetchUserPosts(page = 1) {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const response = await fetch(
                    `/api/v1/posts/trashed?page=${page}`,
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
                    this.totalItems = data.meta.total;
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
