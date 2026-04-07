<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-8">
                        <div>
                            <span class="text-xl font-bold">MyApp</span>
                        </div>

                        <div class="flex gap-4">
                            <router-link
                                :to="{ name: 'home' }"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                            >
                                Dashboard
                            </router-link>
                            <router-link
                                :to="{ name: 'posts' }"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                            >
                                Posts
                            </router-link>

                            <router-link
                                :to="{ name: 'about' }"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                            >
                                About us
                            </router-link>

                            <router-link
                                v-show="isAuthorized"
                                :to="{ name: 'reports' }"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                            >
                                Reports
                            </router-link>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <router-link
                            :to="{ name: 'Notification-List', params: { count: this.notificationCount } }"
                            class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                        >
                            <button
                                
                                class="relative inline-flex items-center justify-center rounded-2xl w-12 h-12 bg-gray-200 hover:bg-gray-300 transition-colors duration-150 focus:outline-none active:scale-95"
                            >
                                <!-- Bell icon -->
                                <svg
                                    class="w-5 h-5 text-gray-800 stroke-current"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                >
                                    <path
                                        d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"
                                    />
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                </svg>

                                <!-- Badge -->
                                <span
                                    class="absolute top-1 right-1 min-w-[18px] h-[18px] flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-medium px-1 border-2 border-white leading-none"
                                >
                                    {{ notificationCount }}
                                </span>
                            </button>
                        </router-link>

                        <span class="text-sm">{{ user.name }}</span>

                        <button
                            @click="handleLogout"
                            :disabled="loading"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-md text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {{ loading ? "Loging out" : "Logout" }}
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 py-8">
            <slot />
        </main>
    </div>
</template>

<script>
export default {
    name: "AppLayout",
    data() {
        return {
            user: {},
            loading: false,
            notificationCount: 0,
            
        };
    },
    mounted() {
        const userJson = localStorage.getItem("user");
        if (userJson) {
            this.user = JSON.parse(userJson);
        } else {
            this.$router.push({ name: "login" });
        }

        this.handleNotification();
    },
    computed: {
        isAuthorized() {
            return this.user.role === "admin" || this.user.role === "moderator";
        },
    },
    methods: {
        async handleLogout() {
            this.loading = true;
            try {
                const token = localStorage.getItem("token");

                const response = await fetch("/api/v1/logout", {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    localStorage.removeItem("token");
                    localStorage.removeItem("user");

                    this.$router.push({ name: "login" });
                } else {
                    console.error("Logout failed:", data.message);
                }
            } catch (err) {
                console.error("Logout error:", err);

                localStorage.removeItem("token");
                localStorage.removeItem("user");
                this.$router.push({ name: "login" });
            } finally {
                this.loading = false;
            }
        },

        async handleNotification() {
            try {
                const token = localStorage.getItem("token");

                const response = await fetch("/api/v1/notifications/count", {
                    method: "GET",
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    this.notificationCount = data.notificationsCount;
                } else {
                    console.error("Logout failed:", data.message); // we need to add the message in the backend
                }
            } catch (err) {
                console.error("Logout error:", err);
            }
        },
        // async goToNotificationsList() {
        //     this.$router.push({ name: "post-details", params: { id: postId } });
        // },
    },
};
</script>
