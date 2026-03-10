<template>
    <div>
        <form @submit.prevent="fetchPosts" class="relative">
            <div
                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
            >
                <svg
                    class="w-5 h-5 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />
                </svg>
            </div>
            <input 
                required
                v-model="keyWord"
                type="search"
                placeholder="Search posts..."
                class="block w-full rounded-full bg-white pl-10 pr-4 py-3 text-sm text-gray-900 shadow-md border border-gray-200 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            />
        </form>
        <div
            v-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 mt-6"
        >
            <p class="text-red-800">{{ error }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchBar",
    data() {
        return {
            keyWord: "",
            error: "",
        };
    },
    methods: {
        async fetchPosts() {
            this.error = "";

            try {
                const token = localStorage.getItem("token");

                const response = await fetch("/api/v1/search", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                    body: JSON.stringify({
                        keyWord: this.keyWord,
                    }),
                });

                const data = await response.json();

                if (response.ok) {
                    this.$emit("searchSuccess", data);
                } else {
                    this.error = "Failed to Search";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Posts error:", err);
            }
        },
    },
};
</script>

