<template>
    <form @submit.prevent="handleSubmit">
        <div class="space-y-12">
            <hr class="mt-10" />
            <div class="border-b border-gray-900/10 pb-12 mt-10">
                <h2 class="text-base/7 font-semibold text-gray-900">
                    Add a Comment
                </h2>
                <p class="mt-1 text-sm/6 text-gray-600">
                    Share your thoughts on this post.
                </p>

                <div
                    class="mt-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                >
                    <div class="col-span-full">
                        <label
                            for="body"
                            class="block text-sm/6 font-medium text-gray-900"
                        >
                            Comment
                        </label>
                        <div class="mt-2">
                            <textarea
                                v-model="body"
                                id="body"
                                rows="4"
                                required
                                placeholder="Write your comment..."
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            ></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="error" class="mt-6 rounded-md bg-red-50 p-4">
            <p class="text-sm text-red-800">{{ error }}</p>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button
                type="submit"
                :disabled="loading"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ loading ? "Saving..." : "Post Comment" }}
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: "CommentForm",
    props: {
        postId: {
            type: [Number, String],
            required: true,
        },
    },
    data() {
        return {
            body: "",
            loading: false,
            error: "",
        };
    },
    methods: {
        async handleSubmit() {
            this.error = "";
            this.loading = true;

            try {
                const token = localStorage.getItem("token");

                const response = await fetch(
                    `/api/v1/posts/${this.postId}/comments`,
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            Accept: "application/json",
                            Authorization: `Bearer ${token}`,
                        },
                        body: JSON.stringify({
                            body: this.body,
                        }),
                    },
                );

                const data = await response.json();

                if (response.ok) {
                    this.$emit("success", data);
                    this.body = "";
                } else {
                    this.error = data.message;
                }
            } catch (err) {
                this.error = "Network error. Please try again.";
                console.error("Comment error:", err);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

