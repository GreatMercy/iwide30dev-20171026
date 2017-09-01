import Vue from 'vue'
import Router from 'vue-router'
import home from '@/components/home'
import List from '@/components/list'
import brand from '@/components/brand'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: home
    },
    {
      path: '/list',
      name: 'list',
      component: List
    },
    {
      path: '/brand',
      name: 'brand',
      component: brand
    }
  ]
})
