import Vue from 'vue'
import VueRouter from 'vue-router'

import config from './config'
// import { HOTEL_COUPON_EDIT_URL } from '@/config/cou'

Vue.use(VueRouter)

const Choice = r => require.ensure([], () => r(require('../module/choice')), 'user_coupon-choice')
const Setup = r => require.ensure([], () => r(require('../module/setup')), 'user_coupon-setup')

const routes = [
  {
    path: '/',
    redirect: `/${config[0].path}`
  },
  {
    path: `/${config[0].path}`,
    name: config[0].path,
    meta: config[0].meta,
    component: Choice
  },
  {
    path: `/${config[1].path}`,
    name: config[1].path,
    meta: config[1].meta,
    component: Setup
  }
]

const router = new VueRouter({
  mode: 'hash',
  base: `/`,
  linkActiveClass: 'v-list-active',
  routes
})
router.beforeEach((to, from, next) => {
  document.title = '优惠券 - ' + to.meta.title
  next()
})

export default router
