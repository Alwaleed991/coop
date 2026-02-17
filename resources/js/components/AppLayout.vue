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
                                v-show="isAuthorized"
                                :to="{ name: 'reports' }"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
                            >
                                Reports
                            </router-link>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
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
        };
    },
    mounted() {
        const userJson = localStorage.getItem("user");
        if (userJson) {
            this.user = JSON.parse(userJson);
        } else {
            this.$router.push({ name: "login" });
        }
    },
    computed:{
        isAuthorized(){
           return this.user.role === 'admin' || this.user.role === 'moderator'
        }
    },
    methods: {
        async handleLogout() {
            this.loading = true;
            try {
                const token = localStorage.getItem("token");

                const response = await fetch("http://coop.test/api/v1/logout", {
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
    },
};
</script>
