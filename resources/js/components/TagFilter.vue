<template>
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <!-- Title -->
        <h3 class="text-sm font-medium text-gray-700 mb-3">Filter by Tag</h3>

        <!-- Search Input Container -->
        <div class="relative">
            <!-- Search Input -->
            <input
                v-model="keyStrokes"
                type="text"
                placeholder="Type to search tags..."
                class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
            />

            <!-- Dropdown -->
            <div
                v-if="isMatch.length > 0"
                class="absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200 max-h-60 overflow-auto"
            >
                <!-- Tag options -->
                <div
                    v-for="tag in isMatch"
                    :key="tag.id"
                    @click="addToSelectedTags(tag)"
                    class="px-4 py-2 hover:bg-indigo-50 cursor-pointer text-sm text-gray-900"
                >
                    {{ tag.name }}
                </div>
            </div>
        </div>

        <!-- Active Filter Badge -->
        <div v-if="selectedTags.length > 0" class="mt-3 flex justify-between">
            <div>
                Filtering by:
                <span
                    v-for="tag in selectedTags"
                    class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm ml-2"
                >
                    {{ tag.name }}
                    <button
                        type="button"
                        @click="removeFromSelectedTags(tag)"
                        class="hover:text-indigo-600 font-bold"
                    >
                        ×
                    </button>
                </span>
            </div>

            <button
                @click="fetchFilterdPosts"
                :disabled="loading"
                class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md text-sm font-medium disabled:opacity-50 text-white disabled:cursor-not-allowed"
            >
                {{ loading ? 'Filtring' : 'Filter' }}
            </button>
            
        </div>

        <div
            v-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 mt-2"
        >
            <p class="text-red-800">{{ error }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "TagFilter",
    data() {
        return {
            keyStrokes: "",
            allTags: [],
            selectedTags: [],
            error: "",
            loading: false
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

            return matchTags;
        },
    },
    methods: {
        async getAllTags() {
            try {
                const token = localStorage.getItem("token");

                const response = await fetch("http://coop.test/api/v1/tags", {
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
                }
            } catch (err) {
                console.error("Get tags error:", err);
            }
        },
        async fetchFilterdPosts() {
            this.error = "";
            this.loading = true;
            try {
                const token = localStorage.getItem("token");

                const response = await fetch("http://coop.test/api/v1/filter", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                    body: JSON.stringify({
                        selectedTags: this.selectedTags,
                    }),
                });

                const data = await response.json();

                if (response.ok) {
                    this.$emit("filterSuccess", data);
                } else {
                    this.error = "Failed to Filter";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Posts error:", err);
            }finally{
                this.loading = false;
            }
        },

        addToSelectedTags(tag) {
            if (this.selectedTags.find((t) => t.id === tag.id)) {
                this.keyStrokes = "";
                return;
            }

            this.keyStrokes = "";
            this.selectedTags = [tag, ...this.selectedTags];
        },

        removeFromSelectedTags(tag) {
            this.selectedTags = this.selectedTags.filter(
                (t) => t.id !== tag.id,
            );
        },
    },
};
</script>
