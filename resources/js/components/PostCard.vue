<template>
    <div class="bg-white rounded-lg shadow p-6 mb-4 hover:shadow-lg transition">
        <p class="text-sm text-gray-500 mb-2">{{ post.created_at }}</p>
        <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ post.title }}</h2>
        <p class="text-sm text-blue-700 mb-3">By {{ post.author }}</p>
        <p class="text-gray-900 mb-4">{{ post.body }}</p>

        
        
        <div class="flex gap-2">
            <span
                v-for="tag in post.tags"
                :key="tag.id"
                class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
            >
                {{ tag.name }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostCard",
    props: {
        post: {
            type: Object,
            required: true,
        },
    },
};
</script>
