<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Register new account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <!-- Changed: form now uses @submit.prevent and calls handleLogin -->
      <form @submit.prevent="handleRegister" class="space-y-6">
        <!-- Email input - added v-model to bind data -->
        <div>
          <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
          <div class="mt-2">
            <input
              v-model="name"
              type="text"
              id="name"
              required
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            />
          </div>
        </div>
        <!-- Email input - added v-model to bind data -->
        <div>
          <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
          <div class="mt-2">
            <input
              v-model="email"
              type="email"
              id="email"
              required
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            />
          </div>
        </div>

        <!-- Password input - added v-model to bind data -->
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input
              v-model="password"
              type="password"
              id="password"
              required
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            />
          </div>
        </div>
        <!-- Password input - added v-model to bind data -->
        <div>
          <div class="flex items-center justify-between">
            <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900"
              >Password Confirmation</label
            >
          </div>
          <div class="mt-2">
            <input
              v-model="password_confirmation"
              type="password"
              id="password_confirmation"
              required
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            />
          </div>
        </div>

        <!-- Error message (shows when login fails) -->
        <div v-if="error" class="rounded-md bg-red-50 p-4">
          <p class="text-sm text-red-800">{{ error }}</p>
        </div>

        <!-- Submit button - disabled when loading -->
        <!-- if the disabled is false you can click the buttton -->
        <div>
          <button
            type="submit"
            :disabled="loading"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ loading ? 'Registering...' : 'Register' }}
          </button>
        </div>
      </form>
      <p class="mt-6 text-center text-sm text-gray-500">
        Alrady have an account?
        <router-link to="/login" class="font-semibold text-indigo-600 hover:text-indigo-500">
          Log in
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data() {
    return {
      name: '',
      email: '', // Stores the email input
      password: '', // Stores the password input
      password_confirmation: '',
      error: '', // Stores error message if login fails
      loading: false, // Shows loading state so that the user does not click meleon time
    }
  },
  methods: {
    async handleRegister() {
      // Clear any previous error
      this.error = ''
      this.loading = true

      try {
        // Call your Laravel API login endpoint
        const response = await fetch('http://coop.test/api/v1/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          }),
        })

        const data = await response.json()

        if (response.ok) {
          // register successful!
          // Save the token to localStorage
          localStorage.setItem('token', data.token)

          // Save user info (name, role, etc) - optional
          localStorage.setItem('user', JSON.stringify(data.user))

          // Redirect to the home page
          this.$router.push('/')
        } else {
          // Login failed - show error message
          this.error = data.message
        }
      } catch (err) {
        // Network error or other issue
        this.error = 'Network error. Please check the backend and try again.'
        console.error('Login error:', err)
      } finally {
        this.loading = false
      }
    },
  },
}
</script>
