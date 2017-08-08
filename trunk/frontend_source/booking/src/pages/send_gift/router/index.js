import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import info from '../module/gift_info'
import theme from '../module/gift_themes.vue'

const routes = [
  {
    path: '/',
    redirect: '/info'
  }, {
    path: '/info',
    component: info
  }, {
    path: '/themes',
    component: theme
  }
]

const router = new VueRouter({
  mode: 'hash',
  routes
})
export default router
