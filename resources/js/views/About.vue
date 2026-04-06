<template>
    <AppLayout>
        <div
            class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto py-8"
        >
            <!-- Users -->
            <div
                class="relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 overflow-hidden hover:-translate-y-1 transition-transform duration-200"
            >
                <div
                    class="absolute top-0 left-0 w-1 h-full bg-blue-500 rounded-l-2xl"
                ></div>
                <div
                    class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950 flex items-center justify-center mb-4"
                >
                    <svg
                        class="w-5 h-5 text-blue-700 dark:text-blue-400"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24"
                    >
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <p class="text-xs text-gray-400 tracking-wide mb-1">
                    Total users
                </p>
                <p
                    class="text-3xl font-semibold text-gray-900 dark:text-white font-mono tracking-tight"
                >
                    {{ users }}
                </p>
            </div>

            <!-- Posts -->
            <div
                class="relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 overflow-hidden hover:-translate-y-1 transition-transform duration-200"
            >
                <div
                    class="absolute top-0 left-0 w-1 h-full bg-emerald-500 rounded-l-2xl"
                ></div>
                <div
                    class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950 flex items-center justify-center mb-4"
                >
                    <svg
                        class="w-5 h-5 text-emerald-700 dark:text-emerald-400"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                        />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <p class="text-xs text-gray-400 tracking-wide mb-1">
                    Total posts
                </p>
                <p
                    class="text-3xl font-semibold text-gray-900 dark:text-white font-mono tracking-tight"
                >
                    {{ posts }}
                </p>
            </div>

            <!-- Comments -->
            <div
                class="relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 overflow-hidden hover:-translate-y-1 transition-transform duration-200"
            >
                <div
                    class="absolute top-0 left-0 w-1 h-full bg-pink-500 rounded-l-2xl"
                ></div>
                <div
                    class="w-11 h-11 rounded-xl bg-pink-50 dark:bg-pink-950 flex items-center justify-center mb-4"
                >
                    <svg
                        class="w-5 h-5 text-pink-700 dark:text-pink-400"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
                        />
                    </svg>
                </div>
                <p class="text-xs text-gray-400 tracking-wide mb-1">
                    Total comments
                </p>
                <p
                    class="text-3xl font-semibold text-gray-900 dark:text-white font-mono tracking-tight"
                >
                    {{ comments }}
                </p>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";

export default {
    name: "About",
    components: {
        AppLayout,
    },
    data() {
        return {
            loading: false,
            error: "",
            users: 0,
            posts: 0,
            comments: 0,
        };
    },
    mounted() {
        this.fetchStatus();
    },
    methods: {
        async fetchStatus() {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");

                const response = await fetch(`/api/v1/status`, {
                    method: "GET",
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    this.users = data.userCount;
                    this.posts = data.postCount;
                    this.comments = data.commentCount;
                } else {
                    this.error = "Failed to load stats";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Stats error:", err);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
