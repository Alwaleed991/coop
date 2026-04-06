<template>
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
        <p class="text-xs text-gray-400 tracking-wide mb-1">{{ label }}</p>
        <p
            class="text-3xl font-semibold text-gray-900 dark:text-white font-mono tracking-tight"
        >
            {{ value }}
        </p>
    </div>
</template>

<script>
export default {
    name: "StatusCard",
};
</script>
