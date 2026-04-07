<template>
    <div v-for="notification in notificationData" :key="notification.id">
        <div class="divide-y divide-gray-100">
            <div
                class="flex gap-3 px-4 py-3 bg-indigo-50/40 hover:bg-gray-50 cursor-pointer transition-colors border-l-[3px] border-l-indigo-500"
            >
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-800">
                        <span class="font-medium">{{
                            notification.data.commenter
                        }}</span>
                        <span class="text-gray-500"> commented on </span>
                        <span class="font-medium text-indigo-600">{{
                            notification.data.post_title
                        }}</span>
                    </p>
                    <p
                        class="mt-1 text-xs text-gray-400 bg-white border-l-2 border-gray-200 pl-2 py-0.5 truncate"
                    >
                        {{ notification.data.comment_body }}
                    </p>
                    <p class="mt-1.5 text-[11px] text-gray-400">
                        {{ notification.created_at }}
                    </p>
                </div>
            </div>
        </div>
        <hr style="border: none; height: 1px; background-color: #ccc" />
    </div>
</template>

<script>
export default {
    name: "CommentCard",
    props: {
        notificationData: {
            type: Array,
            required: true,
        },
    },
};
</script>
