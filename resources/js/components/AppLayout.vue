<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <!-- Left side - Logo and Navigation -->
          <div class="flex items-center gap-8">
            <!-- Logo -->
            <div class="flex-shrink-0">
              <span class="text-xl font-bold">MyApp</span>
            </div>

            <!-- Navigation Links -->
            <div class="flex gap-4">
              <router-link
                to="/"
                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
              >
                Dashboard
              </router-link>
              <router-link
                to="/posts"
                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
              >
                Posts
              </router-link>
              <router-link
                to="/reports"
                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700"
              >
                Reports
              </router-link>
            </div>
          </div>

          <!-- Right side - User info and Logout -->
          <div class="flex items-center gap-4">
            <!-- User name -->
            <span class="text-sm">{{ user.name }}</span>

            <!-- Logout button -->
            <button
              @click="logout"
              class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-md text-sm font-medium"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 py-8">
      <!-- This is where page content will appear -->
      <slot />
    </main>
  </div>
</template>

<script>
export default {
  name: 'AppLayout',
  data() {
    return {
      user: {}, // Will store user info
    }
  },
  mounted() {
    // Get user info from localStorage when component loads
    const userJson = localStorage.getItem('user')
    if (userJson) {
      this.user = JSON.parse(userJson)
    }
  },
  methods: {
    logout() {
      // Remove token and user from localStorage
      localStorage.removeItem('token')
      localStorage.removeItem('user')

      // Redirect to login
      this.$router.push('/login')
    },
  },
}
</script>
