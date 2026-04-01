<template>
    <form @submit.prevent="handleSubmit">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">
                    {{ post ? "Edit Post" : "Create New Post" }}
                </h2>
                <p class="mt-1 text-sm/6 text-gray-600">
                    Please provide the Title and the Body of the  .
                </p>

                <div
                    class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                >
                    <div class="sm:col-span-4">
                        <label
                            for="title"
                            class="block text-sm/6 font-medium text-gray-900"
                        >
                            Post Title
                        </label>
                        <div class="mt-2">
                            <div
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600"
                            >
                                <input
                                    v-model="title"
                                    id="title"
                                    type="text"
                                    required
                                    placeholder="Enter post title..."
                                    class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label
                            for="body"
                            class="block text-sm/6 font-medium text-gray-900"
                        >
                            Post Body
                        </label>
                        <div class="mt-2">
                            <textarea
                                v-model="body"
                                id="body"
                                rows="6"
                                required
                                placeholder="Write your post content..."
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-900/10 pb-12">
                <h3 class="text-base/7 font-semibold text-gray-900">Tags</h3>
                <p class="mt-1 text-sm/6 text-gray-600">
                    Add tags to categorize your post.
                </p>

                <div class="mt-6">
                    <div class="relative">
                        <input
                            v-model="keyStrokes"
                            type="text"
                            placeholder="Type to search tags..."
                            class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />

                        <div
                            v-if="isMatch.length > 0"
                            class="absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200 max-h-60 overflow-auto"
                        >
                            <div
                                v-for="tag in isMatch"
                                :key="tag.id"
                                class="px-4 py-2 hover:bg-indigo-50 cursor-pointer text-sm text-gray-900"
                                @click="addToSelectedTags(tag)"
                            >
                                {{ tag.name }}
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 flex-wrap mt-4">
                        <span
                            v-for="tag in selectedTags"
                            :key="tag.id"
                            class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm"
                        >
                            {{ tag.name }}
                            <button
                                type="button"
                                class="hover:text-indigo-600 font-bold"
                                @click="removeFromSelectedTags(tag)"
                            >
                                ×
                            </button>
                        </span>
                    </div>
                </div>

                <p>add any attachment</p>

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
                {{
                    loading ? "Saving..." : post ? "Update Post" : "Create Post"
                }}
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: "PostForm",
    props: {
        post: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            title: this.post?.title || "",
            body: this.post?.body || "",
            loading: false,
            error: "",

            keyStrokes: "",
            allTags: [],
            selectedTags: this.post?.tags || [],
        };
    },
    mounted() {
        this.getAllTags();
    },
    computed: {
        isMatch() {
            if (!this.keyStrokes) {
                return [];
            }

            const matchTags = this.allTags.filter((tag) =>
                tag.name
                    .toLowerCase()
                    .startsWith(this.keyStrokes.toLowerCase()),
            );
            
            if(matchTags.length === 0){
                return [{
                    id: null,
                    name:this.keyStrokes 
                }];
            }
            else{
                return matchTags;
            }
        },
    },
    methods: {
        async handleSubmit() {
            this.error = "";
            this.loading = true;

            try {
                const token = localStorage.getItem("token");

                const url = this.post
                    ? `/api/v1/posts/${this.post.id}`
                    : "/api/v1/posts";

                const method = this.post ? "PATCH" : "POST";

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                    body: JSON.stringify({
                        title: this.title,
                        body: this.body,
                        tags: this.selectedTags
                    }),
                });

                const data = await response.json();

                if (response.ok) {
                    this.$emit("success", data);
                    if (!this.post) {
                        this.title = "";
                        this.body = "";
                    }
                } else {
                    this.error = data.message || "Failed to save post";
                }
            } catch (err) {
                this.error = "Network error. Please try again.";
                console.error("Post error:", err);
            } finally {
                this.loading = false;
            }
        },
        async getAllTags() {
            this.error = "";
            try {
                const token = localStorage.getItem("token");

                const response = await fetch("/api/v1/tags", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    this.allTags = data.data;
                } else {
                    this.error = data.message || "Failed to save post";
                }
            } catch (err) {
                this.error = "Network error. Please try again.";
                console.error("Post error:", err);
            }
        },

        addToSelectedTags(tag){
            if(this.selectedTags.find(t => t.id === tag.id )){
                this.keyStrokes = ''
                return
            }

            this.keyStrokes = ''
            this.selectedTags = [tag, ...this.selectedTags];
        },
        removeFromSelectedTags(tag){
            this.selectedTags = this.selectedTags.filter(t => t.id !== tag.id)
        }
    },
};
</script>

