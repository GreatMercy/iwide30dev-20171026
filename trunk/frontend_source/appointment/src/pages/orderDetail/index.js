import Vue from 'vue'
import App from './index.vue'
import store from '@/store/index'

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  template: '<App/>',
  components: {App}
})
