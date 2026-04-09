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

        <div
            v-if="successMessage"
            class="rounded-md bg-green-50 border border-green-200 p-4 mb-6 mt-6"
        >
            <p class="text-sm text-green-800 mt-2">{{ successMessage }}</p>
        </div>

        <div class="mb-6">
            <SearchBar @searchSuccess="fetchSearchPosts" />
        </div>

        <div class="mb-6">
            <TagFilter @filterSuccess="fetchFiltredPosts" />
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
                :type="'list'"
                @click="goToPostDetails(post.id)"
            />

            <div class="flex justify-center mt-6">
                <vue-awesome-paginate
                    :total-items="totalItems"
                    :items-per-page="5"
                    :max-pages-shown="5"
                    v-model="currentPage"
                    @click="fetchPosts"
                />
            </div>
            <!-- when you @click its activated and call fetchPosts AND ALSO pass the currentPage to the parameter behind the sens thank to vue-awesome-paginate -->
        </div>

        <div v-if="!loading && posts.length === 0" class="text-center py-8">
            <p class="text-gray-600">No posts yet!</p>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import PostCard from "@/components/PostCard.vue";
import SearchBar from "@/components/SearchBar.vue";
import TagFilter from "@/components/TagFilter.vue";

export default {
    name: "PostsList",
    components: {
        AppLayout,
        PostCard,
        SearchBar,
        TagFilter,
    },
    data() {
        return {
            posts: [],
            loading: false,
            error: "",
            currentPage: 1,
            totalItems: 0,
            successMessage: "",
        };
    },
    mounted() {
        this.fetchPosts();
        if (this.$route.query.success) {
            this.successMessage = this.$route.query.success;
            setTimeout(() => {
                this.successMessage = "";
                this.$route.query.success = "";
            }, 3000);
        }
    },
    methods: {
        async fetchPosts(page = 1) {
            // note for me/ this is defalte parameter so if you did not pass any thing the page will be 1 and this will happen in the first call (mounted) but in the second call and go on
            // new
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");

                const response = await fetch(
                    `/api/v1/posts?page=${page}`, // see the post man to understant how this works
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
                    this.totalItems = data.meta.total; // postman again
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
        async fetchSearchPosts(data) {
            this.posts = data.data;
        },
        async fetchFiltredPosts(data) {
            this.posts = data.data;
        },
    },
};
</script>

