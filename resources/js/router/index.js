import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import Home from '@/views/Home.vue'
import Register from '@/views/Register.vue'
import PostsList from '@/views/PostsList.vue'
import PostDetails from '@/views/PostDetails.vue'
import Report from '@/views/Report.vue'
import CreateReport from '@/views/CreateReport.vue'

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
    {
      path: '/posts/:id',
      name: 'post-details',
      component: PostDetails,
    },
    {
      path: '/reports',
      name: 'reports',
      component: Report,
    },
    {
      path: '/reports/:type/:id',
      name: 'report-form',
      component: CreateReport,
    },
  ],
})

export default router
