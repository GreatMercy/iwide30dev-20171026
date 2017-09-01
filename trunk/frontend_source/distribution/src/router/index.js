import Vue from 'vue'
import Router from 'vue-router'
// import Hello from '@/components/Hello'
import rewardList from '@/components/rewardList'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'rewardList',
      component: rewardList
    }
  ]
})
