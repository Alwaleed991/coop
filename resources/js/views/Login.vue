<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Log in to your account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form @submit.prevent="handleLogin" class="space-y-6">
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

        <div v-if="error" class="rounded-md bg-red-50 p-4">
          <p class="text-sm text-red-800">{{ error }}</p>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ loading ? 'Signing in...' : 'Sign in' }}
          </button>
        </div>
      </form>
      <p class="mt-6 text-center text-sm text-gray-500">
        Don't have an account?
        <router-link :to="{ name: 'register' }" class="font-semibold text-indigo-600 hover:text-indigo-500">
          Register
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      email: '', 
      password: '', 
      error: '',
      loading: false, 
    }
  },
  methods: {
    async handleLogin() {
      this.error = ''
      this.loading = true
// if your page was loaded from: http://localhost:8000/login When the browser sees: fetch('/api/v1/login') it automatically converts it to: http://localhost:8000/api/v1/login So the browser adds the host and port automatically. Example If the current page is: http://localhost:8000/login and you run: fetch('/api/v1/login') the browser sends the request to: http://localhost:8000/api/v1/login
      try {
        const response = await fetch('/api/v1/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        })

        const data = await response.json()

        if (response.ok) {
          localStorage.setItem('token', data.token)

          localStorage.setItem('user', JSON.stringify(data.user))

          this.$router.push({ name: 'home' })
        } else {
          this.error = data.message 
        }
      } catch (err) {
        this.error = 'Network error. Please check the backend and try again.'
        console.error('Login error:', err)
      } finally {
        this.loading = false
      }
    },
  },
}
</script>

