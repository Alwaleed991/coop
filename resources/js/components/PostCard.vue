<template>
    <div class="bg-white rounded-lg shadow p-6 mb-4 hover:shadow-lg transition">
        <p class="text-sm text-gray-500 mb-2">{{ post.created_at }}</p>
        <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ post.title }}</h2>
        <p class="text-sm text-blue-700 mb-3">By {{ post.author }}</p>
        <p class="text-gray-900 mb-4">{{ post.body }}</p>

        <div class="flex gap-2">
            <span
                v-for="tag in post.tags"
                :key="tag.id"
                class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
            >
                {{ tag.name }}
            </span>
        </div>

        <div>
            <img
                v-for="image in post.images"
                :key="image.id"
                :src="`http://localhost:8000/storage/${image.imageUrl}`"
                alt=""
            />
        </div>

        <div v-show="type === 'trash'" class="mt-4 flex justify-end">
            <button
                @click.stop="handlePostRestore(post.id)"
                class="px-4 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700 mr-3"
            >
                Restore
            </button>
            <button
                @click.stop="handlePostDeletion(post.id)"
                class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700"
            >
                Permanent Deletion
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostCard",
    props: {
        post: {
            type: Object,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        data(){
            loading = false,
            error = ''
        }
    },
    methods: {
        async handlePostDeletion(postId) {
            if (!confirm("If you delete this post it will be deleted permanently!")) {
                return;
            }

            this.loading = true;
            this.error = "";
            
            try {
                const token = localStorage.getItem("token");
                const response = await fetch(`/api/v1/posts/${postId}/force-delete`, {
                    method: "Delete",
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    this.$emit("deleted", { postId, message: data.message });
                } else {
                    this.error = "Failed to permanently delete the posts";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Posts error:", err);
            } finally {
                this.loading = false;
            }
        },
        async handlePostRestore(postId) {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                const response = await fetch(`/api/v1/posts/${postId}/restore`, {
                    method: "PATCH",
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    this.$emit("restored", { postId, message: data.message });
                } else {
                    this.error = "Failed to restore posts";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Posts error:", err);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
