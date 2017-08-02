import Vue from 'vue'
import App from './index.vue'
import store from '@/store/index'
import Router from 'vue-router'
import main from './modules/main.vue'
import calendar from './modules/calendar.vue'
Vue.use(Router)
const router = new Router({
  routes: [{
    path: '/',
    component: main
  }, {
    path: '/calendar',
    component: calendar
  }]
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: {App}
})
