<template>
    <AppLayout>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Posts</h1>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-2">
                Welcome to the awesome posts page
            </h2>
            <p class="text-gray-600">
                Here you can see all posts and you can click on a post to
                reports or comment on it
            </p>
        </div>

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">Loading posts...</p>
        </div>

        <div
            v-else-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4"
        >
            <p class="text-red-800">{{ error }}</p>
        </div>

        <div v-else>
            <PostCard
                v-for="post in posts"
                :key="post.id"
                :post="post"
                @click="goToPostDetails(post.id)"
            />
        </div>

        <div v-if="!loading && posts.length === 0" class="text-center py-8">
            <p class="text-gray-600">No posts yet!</p>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import PostCard from "@/components/PostCard.vue";

export default {
    name: "PostsList",
    components: {
        AppLayout,
        PostCard,
    },
    data() {
        return {
            posts: [],
            loading: false,
            error: "",
        };
    },
    mounted() {
        this.handlePosts();
    },
    methods: {
        async handlePosts() {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");

                const response = await fetch("http://coop.test/api/v1/posts", {
                    method: "GET",
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

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
