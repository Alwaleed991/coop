<template>
  <form @submit.prevent="handleSubmit">
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base/7 font-semibold text-gray-900">
          {{ post ? 'Edit Post' : 'Create New Post' }}
        </h2>
        <p class="mt-1 text-sm/6 text-gray-600">
          Please provide the Title and the Body of the post.
        </p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">
              Post Title
            </label>
            <div class="mt-2">
              <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                <input
                  v-model="title"
                  id="title"
                  type="text"
                  required
                  placeholder="Enter post title..."
                  class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                />
              </div>
            </div>
          </div>

          <div class="col-span-full">
            <label for="body" class="block text-sm/6 font-medium text-gray-900">
              Post Body
            </label>
            <div class="mt-2">
              <textarea
                v-model="body"
                id="body"
                rows="6"
                required
                placeholder="Write your post content..."
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
              ></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Tags section - commented for later -->
      <!-- 
      <div class="border-b border-gray-900/10 pb-12">
        <h3 class="text-base/7 font-semibold text-gray-900">Tags</h3>
        <p class="mt-1 text-sm/6 text-gray-600">Select tags for your post.</p>
        
        <div class="mt-6 space-y-6">
          TODO: Tags checkboxes will go here
        </div>
      </div>
      -->
    </div>

    <div v-if="error" class="mt-6 rounded-md bg-red-50 p-4">
      <p class="text-sm text-red-800">{{ error }}</p>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <button
        type="submit"
        :disabled="loading"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        {{ loading ? 'Saving...' : (post ? 'Update Post' : 'Create Post') }}
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: 'PostForm',
  props: {
    post: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      title: this.post?.title || '',
      body: this.post?.body || '',
      loading: false,
      error: ''
    }
  },
  methods: {
    async handleSubmit() {
      this.error = ''
      this.loading = true

      try {
        const token = localStorage.getItem('token')
        
        const url = this.post ? `http://coop.test/api/v1/posts/${this.post.id}` : 'http://coop.test/api/v1/posts'
        
        const method = this.post ? 'PATCH' : 'POST'

        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({
            title: this.title,
            body: this.body
          })
        })

        const data = await response.json()

        if (response.ok) {
          this.$emit('success', data)
          if (!this.post) {
            this.title = ''
            this.body = ''
          }
        } else {
          this.error = data.message || 'Failed to save post'
        }
      } catch (err) {
        this.error = 'Network error. Please try again.'
        console.error('Post error:', err)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>