import Vue from 'vue'
import App from './App.vue'
import router from './router'
// Vue.config.productionTip = false
// window.eventBus = new Vue()
/* eslint-disable no-new */
export default () => {
  new Vue({
    el: '#app',
    template: '<App/>',
    router,
    components: { App }
  })
}
