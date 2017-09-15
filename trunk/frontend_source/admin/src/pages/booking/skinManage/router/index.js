import Vue from 'vue'
import Router from 'vue-router'
import selectSkin from '../module/selectSkin'
import editSkin from '../module/editSkin'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'selectSkin',
      component: selectSkin
    },
    {
      path: '/editSkin',
      name: 'editSkin',
      component: editSkin
    }
  ]
})
