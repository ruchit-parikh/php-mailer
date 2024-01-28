import { createRouter, createWebHistory } from 'vue-router'
import SubscribersIndex from '../views/subscribers/Index.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'subscribers',
      component: SubscribersIndex
    },
    {
      path: '/create',
      name: 'subscribers.create',
      component: () => import('../views/subscribers/Store.vue')
    },
  ]
})

export default router
