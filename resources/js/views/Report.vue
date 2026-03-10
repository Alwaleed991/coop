<template>
    <AppLayout>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Welcome back Admin!</h2>
            <p class="text-gray-600">You're successfully logged in.</p>
        </div>

        <!-- <div
            v-if="successMessage"
            class="rounded-md bg-green-50 border border-green-200 p-4 mb-6 mt-6"
        >
            <p class="text-sm text-green-800 mt-2">{{ successMessage }}</p>
        </div> not in used yet --> 

        <div
            v-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 mt-6"
        >
            <p class="text-red-800">{{ error }}</p>
        </div>


        <div class="mt-6">
            <ReportCard
                v-for="report in reports"
                :key="report.id"
                :report="report"
            />
        </div>
    </AppLayout>


    <!-- NOTE/ WE NEED EMPTY STATE AND LOADING STATE  -->



</template>

<script>
import AppLayout from "@/components/AppLayout.vue";
import ReportCard from "@/components/ReportCard.vue";

export default {
    name: "Report",
    components: {
        AppLayout,
        ReportCard
    },
    data() {
        return {
            reports: [],
            loading: false,
            error: "",
        };
    },
    mounted() {
        this.fetchReports();
    },
    methods: {
        async fetchReports() {
            this.loading = true;
            this.error = "";

            try {
                const token = localStorage.getItem("token");
                
                const response = await fetch(
                    `/api/v1/reports`,
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
                    this.reports = data.data;
                } else {
                    this.error = "Failed to load reports";
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

