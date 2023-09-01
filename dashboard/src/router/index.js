import { createRouter, createWebHistory } from 'vue-router'

const Home = () => import('../views/Home/index.vue')
const FeedBacks = () => import('../views/FeedBacks/index.vue')
const Credentials = () => import('../views/Credentials/index.vue')

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/feedbacks',
    name: 'feedbacks',
    component: FeedBacks,
    meta: {
      hasAuth: true
    }
  },
  {
    path: '/credentials',
    name: 'credentials',
    component: Credentials,
    meta: {
      hasAuth: true
    }
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
