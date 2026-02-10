<template>
  <AppLayout>
    <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
    <div class="bg-white rounded-lg shadow p-6">
      <h2 class="text-xl font-semibold mb-2">Welcome back!</h2>
      <p class="text-gray-600">You're successfully logged in.</p>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/components/AppLayout.vue'

export default {
  name: 'Home',
  components: {
    AppLayout,
  },
}
</script>
