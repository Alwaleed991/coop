import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Home from '@/views/Home.vue'
import Register from '@/views/Register.vue'
import PostsList from '../views/PostsList.vue'

const router = createRouter({
  history: createWebHistory('/'),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/posts',
      name: 'posts',
      component: PostsList,
    },
  ],
})

export default router
