import Vue from 'vue'
import VueRouter from 'vue-router'
import config from './config'
import { PANCAKE_EDIT_URL } from '@/service/pancake/config'
Vue.use(VueRouter)

const Info = r => require.ensure([], () => r(require('../module/info')), 'pancake_info-info')
const Prize = r => require.ensure([], () => r(require('../module/prize')), 'pancake_info-prize')
const Share = r => require.ensure([], () => r(require('../module/share')), 'pancake_info-share')

const routes = [
  {
    path: '/',
    redirect: `${config[0].path}`
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
    component: Prize
  },
  {
    path: `${config[2].path}`,
    name: config[2].path,
    meta: config[2].meta,
    component: Share
  }
]

const router = new VueRouter({
  mode: 'hash',
  base: `${PANCAKE_EDIT_URL}/`,
  linkActiveClass: 'v-list-active',
  routes
})

router.beforeEach((to, from, next) => {
  document.title = '博饼 - ' + to.meta.title
  next()
})

export default router
