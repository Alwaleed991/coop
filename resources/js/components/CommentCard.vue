<template>
    <div
        class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow mt-6"
    >
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                ></div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ comment.author }}</p>
                    <p class="text-xs text-gray-500">{{ comment.created_at }}</p>
                </div>
            </div>

            <div class="flex gap-2">
                <button
                    v-if="!isMyComment"
                    @click="goToReportCreate"
                    class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                >
                    Report
                </button>
                <button
                    v-if="isMyComment"
                    @click="$emit('delete', comment.id)"
                    class="text-xs text-red-600 hover:text-red-800 font-medium"
                >
                    Delete
                </button>
            </div>
        </div>

        <p class="text-gray-800 text-sm leading-relaxed">
            {{ comment.body }}
        </p>
    </div>
</template>

<script>
export default {
    name: "CommentCard",
    props: {
        comment: {
            type: Object,
            required: true,
        },
    },
    computed: {
        isMyComment() {
            const user = JSON.parse(localStorage.getItem("user"));
            return this.comment.user_id === user.id;
        },
    },
    methods: {
        async goToReportCreate() {
            this.$router.push({
                name: "report-form",
                params: { type: "Comment", id: this.comment.id},
            });
        },
    },
};
</script>
