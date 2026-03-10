<template>
    <AppLayout>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Post Details</h1>

        <!-- Updated welcome message - more generic -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 flex justify-between">
            <div>
                <h2 class="text-xl font-semibold mb-2">
                    {{ isMyPost ? "Your Post" : "Post by " + post.author }}
                </h2>
                <p class="text-gray-600">
                    {{
                        isMyPost
                            ? "Here you can view, edit, and delete your post."
                            : "View this post and leave a comment below. Please if you note any thing suspesues please dont hasitate to Report the Post"
                    }}
                </p>
            </div>

            <button
                class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700"
                @click="goToReportCreate"
            >
                Report
            </button>
        </div>

        <!-- Error message -->
        <div
            v-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4"
        >
            <p class="text-red-800">{{ error }}</p>
        </div>

        <div
            v-if="successMessage"
            class="rounded-md bg-green-50 border border-green-200 p-4 mb-6 mt-6"
        >
            <p class="text-sm text-green-800 mt-2">{{ successMessage }}</p>
        </div>

        <!-- Loading state -->
        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">Loading post...</p>
        </div>

        <!-- Post content -->
        <div v-else class="mt-6">
            <PostCard :post="post" />
        </div>

        <!-- Edit/Delete buttons - ONLY if it's MY post -->
        <div v-if="isMyPost">
            <button
                @click="showForm = !showForm"
                :class="{
                    'mt-6 mb-6 flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs': true,
                    'bg-red-600 hover:bg-red-700': showForm === true,
                    'bg-indigo-600 hover:bg-indigo-500': showForm === false,
                }"
            >
                {{ showForm ? "Cancel" : "Edit Your Post" }}
            </button>

            <div v-if="showForm" class="bg-white rounded-lg shadow p-6 mb-6">
                <PostForm @success="handlePostEdited" :post="post" />
            </div>

            <button
                @click="DeleteUserPost"
                :disabled="loading"
                class="mt-6 mb-6 flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ loading ? "Deleting..." : "Delete Your Post" }}
            </button>
        </div>

        <div>
            <CommentForm :postId="post.id" @success="CreateUserComment" />
        </div>

        <div class="mb-6">
            <CommentCard
                v-for="comment in comments"
                :comment="comment"
                :key="comment.id"
                @delete="DeleteUserComment"
            />
        </div>

        <div v-if="comments.length === 0" class="text-center py-8">
            <p class="text-gray-600">No Comments yet!</p>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import PostForm from "@/components/PostForm.vue";
import PostCard from "@/components/PostCard.vue";
import CommentCard from "@/components/CommentCard.vue";
import CommentForm from "@/components/CommentForm.vue";

export default {
    name: "PostDetails",
    components: {
        AppLayout,
        PostForm,
        PostCard,
        CommentCard,
        CommentForm,
    },
    data() {
        return {
            showForm: false,
            post: {},
            comments: [],
            newComment: "",
            loading: false,
            error: "",
            successMessage: "",
        };
    },
    computed: {
        isMyPost() {
            const user = JSON.parse(localStorage.getItem("user"));
            return this.post?.user_id === user?.id;
        },
    },
    mounted() {
        const postId = this.$route.params.id;
        this.fetchUserPost(postId);
        this.fetchPostCommets(postId);
    },
    methods: {
        handlePostEdited(data) {
            this.$router.push({
                name: "home",
                query: { success: data.message },
            });
        },

        async fetchUserPost(postId) {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const response = await fetch(
                    `/api/v1/posts/${postId}`,
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
                    this.error = "Failed to load post";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Fetch post error:", err);
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
                    `/api/v1/posts/${this.post.id}`,
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
                    this.$router.push({
                        name: "home",
                        query: { success: data.message },
                    });
                } else {
                    this.error = "Failed to delete post";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Delete error:", err);
            } finally {
                this.loading = false;
            }
        },
        async fetchPostCommets(postId) {
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const response = await fetch(
                    `/api/v1/posts/${postId}/comments`,
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
                    this.comments = data.data;
                } else {
                    this.error = "Failed to load the comments";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Fetch post error:", err);
            }
        },
        async DeleteUserComment(commentId) {
            if (!confirm("Are you sure you want to delete this comment?")) {
                return;
            }

            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const response = await fetch(
                    `/api/v1/comments/${commentId}`,
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
                    this.successMessage = data.message;
                    await this.fetchPostCommets(this.post.id);
                    setTimeout(() => {
                        this.successMessage = "";
                    }, 3000);
                } else {
                    this.error = "Failed to delete post";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Delete error:", err);
            }
        },
        async CreateUserComment(data) {
            this.successMessage = data.message;
            this.fetchPostCommets(data.data.post_id);
            setTimeout(() => {
                this.successMessage = "";
            }, 3000);
        },
        async goToReportCreate(){
             this.$router.push({ name: "report-form", params: { type:"Post" , id: this.post.id } });
        }
    },
};
</script>

