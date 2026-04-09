<template>
    <AppLayout>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Notifications</h1>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-2">
                Welcome to the awesome notifications page
            </h2>
            <p class="text-gray-600">Here you can see all your notifications</p>
        </div>

        <div
            v-if="successMessage"
            class="rounded-md bg-green-50 border border-green-200 p-4 mb-6 mt-6"
        >
            <p class="text-sm text-green-800 mt-2">{{ successMessage }}</p>
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
            <div>
                <div
                    class="w-full bg-white rounded-2xl border border-gray-200 overflow-hidden"
                >
                    <div
                        class="flex items-center justify-between px-4 py-3 border-b border-gray-100"
                    >
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-900"
                                >Notifications</span
                            >
                            <span
                                class="bg-indigo-100 text-indigo-700 text-[11px] font-medium px-2 py-0.5 rounded-full"
                                >{{ this.$route.params.count }} new</span
                            >
                        </div>
                        <button
                            @click="CrearAllNotifications"
                            class="text-xs text-indigo-500 hover:text-indigo-700 transition-colors"
                        >
                            Clear All Notifications
                        </button>
                    </div>
                    <NotificationCard
                        :notificationData="notificationData"
                    ></NotificationCard>
                </div>
            </div>
        </div>
        <div
            v-if="!loading && notificationData.length === 0"
            class="text-center py-8"
        >
            <p class="text-gray-600">
                You can take a brake there is no notifications yet!
            </p>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import NotificationCard from "@/components/NotificationCard.vue";

export default {
    name: "Notification-List",
    components: {
        AppLayout,
        NotificationCard,
    },
    data() {
        return {
            notificationData: [],
            loading: false,
            error: "",
            successMessage: "",
        };
    },
    mounted() {
        this.fetchNotifications();
    },
    methods: {
        async fetchNotifications() {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");

                const response = await fetch(`/api/v1/notifications`, {
                    method: "GET",
                    headers: {
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    this.notificationData = data.notifications;
                } else {
                    this.error = "Failed to load Notifications";
                }
            } catch (err) {
                this.error =
                    "Network error. Please check the backend and try again.";
                console.error("Posts error:", err);
            } finally {
                this.loading = false;
            }
        },
        async CrearAllNotifications() {
            this.error = "";

            try {
                const token = localStorage.getItem("token");

                const response = await fetch(
                    `/api/v1/notifications/mark/read`,
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
                    this.$router.push({
                        name: "home",
                        query: { success: data.message },
                    });
                } else {
                    this.error = "Failed to clear the Notifications";
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
