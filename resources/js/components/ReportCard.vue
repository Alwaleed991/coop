<template>
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mt-6 hover:shadow-lg transition">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">
                    Report #{{ report.id }}
                </h3>
                <span
                    class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded-full"
                    :class="{
                        'bg-red-100 text-red-800': report.category === 'spam',
                        'bg-orange-100 text-orange-800':
                            report.category === 'offensive',
                        'bg-yellow-100 text-yellow-800':
                            report.category === 'harassment',
                        'bg-purple-100 text-purple-800':
                            report.category === 'misinformation',
                        'bg-pink-100 text-pink-800':
                            report.category === 'violence',
                        'bg-gray-100 text-gray-800':
                            report.category === 'other',
                    }"
                >
                    {{ report.category }}
                </span>
            </div>
            <span class="text-xs text-gray-500">{{ report.created_at }}</span>
        </div>

        <div class="mb-4">
            <p class="text-sm font-semibold text-gray-700 mb-1">Reason:</p>
            <p class="text-sm text-gray-600 italic">
                {{ report.reason }}
            </p>
        </div>

        <div class="mb-4">
            <p class="text-sm text-gray-700">
                <span class="font-semibold">Reported by:</span>
                {{ report.reporter.name }}
            </p>
        </div>

        <div class="mb-4 bg-gray-50 p-3 rounded">
            <p class="text-sm text-gray-700 mb-1">
                <span class="font-semibold">Reported content:</span>
                {{ report.reportable.type }} #{{ report.reportable.id }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-semibold">Author:</span>
                {{ report.reportable.author.name }}
            </p>
        </div>

        <div class="flex gap-2">
            <button
                class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                View Post
            </button>
            <button
                class="px-4 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700"
            >
                Resolve
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ReportCard",
    props: {
        report: {
            type: Object,
            required: true,
        },
    },
};
</script>
