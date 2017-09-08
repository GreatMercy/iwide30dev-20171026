import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import booking from '../module/main.vue'
import order from '../module/order.vue'
import choose from '../module/choose.vue'

const routes = [
  {
    path: '/',
    redirect: '/main'
  }, {
    path: '/main',
    component: booking
  }, {
    path: '/order',
    component: order
  }, {
    path: '/choose',
    component: choose
  }
]

const router = new VueRouter({
  mode: 'hash',
  routes
})
export default router
