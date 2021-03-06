import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/index'

/* eslint-disable no-new */
export default () => {
  new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App}
  })
}
