import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import reservationForm from '../module/form'
import calendar from '../module/calendar'

const routes = [
  {
    path: '/',
    redirect: '/form'
  }, {
    path: '/form',
    component: reservationForm
  }, {
    path: '/calendar',
    component: calendar
  }
]

const router = new VueRouter({
  mode: 'hash',
  routes
})
export default router
