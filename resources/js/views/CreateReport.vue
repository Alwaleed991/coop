<template>
    <AppLayout>
        <form @submit.prevent="handleSubmit">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">
                        Report this {{ this.$route.params.type }}
                    </h2>
                    <p class="mt-1 text-sm/6 text-gray-600">
                        Help us understand why you're reporting this content.
                    </p>

                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                    >
                        <!-- Category Dropdown -->
                        <div class="sm:col-span-4">
                            <label
                                for="category"
                                class="block text-sm/6 font-medium text-gray-900"
                            >
                                Reason Category *
                            </label>
                            <div class="mt-2">
                                <select
                                    v-model="category"
                                    id="category"
                                    required
                                    class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                >
                                    <option value="">Select a reason</option>
                                    <option value="spam">Spam or scam</option>
                                    <option value="offensive">
                                        Offensive or abusive
                                    </option>
                                    <option value="harassment">
                                        Harassment or bullying
                                    </option>
                                    <option value="misinformation">
                                        False information
                                    </option>
                                    <option value="violence">
                                        Violence or dangerous content
                                    </option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Reason Text Area -->
                        <div class="col-span-full">
                            <label
                                for="reason"
                                class="block text-sm/6 font-medium text-gray-900"
                            >
                                Please explain *
                            </label>
                            <div class="mt-2">
                                <textarea
                                    v-model="reason"
                                    id="reason"
                                    rows="4"
                                    required
                                    placeholder="Please explain why you're reporting this content..."
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
                    class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {{ loading ? "Submitting..." : "Submit Report" }}
                </button>
            </div>
        </form>
    </AppLayout>
</template>

<script>
import AppLayout from "../components/AppLayout.vue";

export default {
    name: "ReportForm",

    components: {
        AppLayout,
    },

    data() {
        return {
            category: "",
            reason: "",
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
                    "/api/v1/reports",
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            Accept: "application/json",
                            Authorization: `Bearer ${token}`,
                        },
                        body: JSON.stringify({
                            reportable_type: this.$route.params.type,
                            reportable_id: this.$route.params.id,
                            category: this.category,
                            reason: this.reason,
                        }),
                    },
                );

                const data = await response.json();

                if (response.ok) {
                    this.$router.push({
                        name: "posts",
                        query: { success: data.message },
                    });
                    this.category = "";
                    this.reason = "";
                } else {
                    this.error = data.message || "Failed to submit report";
                }
            } catch (err) {
                this.error = "Network error. Please try again.";
                console.error("Report error:", err);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

