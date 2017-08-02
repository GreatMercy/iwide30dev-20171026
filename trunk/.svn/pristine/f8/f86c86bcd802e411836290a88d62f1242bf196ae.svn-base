import Vue from 'vue'
import VueRouter from 'vue-router'

import config from './config'
import { HOTEL_PRICE_EDIT_URL } from '@/config/env'

Vue.use(VueRouter)

const Info = r => require.ensure([], () => r(require('../module/info')), 'booking_prices-info')
const Good = r => require.ensure([], () => r(require('../module/good')), 'booking_prices-good')
const Policy = r => require.ensure([], () => r(require('../module/policy')), 'booking_prices-policy')
const Preview = r => require.ensure([], () => r(require('../module/preview')), 'booking_prices-preview')

const routes = [
  {
    path: '/',
    redirect: `/${config[0].path}`
  },
  {
    path: `/${config[0].path}`,
    name: config[0].path,
    meta: config[0].meta,
    component: Info
  },
  {
    path: `/${config[1].path}`,
    name: config[1].path,
    meta: config[1].meta,
    component: Good
  },
  {
    path: `/${config[2].path}`,
    name: config[2].path,
    meta: config[2].meta,
    component: Policy
  },
  {
    path: `/${config[3].path}`,
    name: config[3].path,
    meta: config[3].meta,
    component: Preview
  }
]

const router = new VueRouter({
  mode: 'hash',
  base: `${HOTEL_PRICE_EDIT_URL}/`,
  linkActiveClass: 'v-list-active',
  routes
})
router.beforeEach((to, from, next) => {
  document.title = '价格码 - ' + to.meta.title
  next()
})

export default router
