import Vue from 'vue'
import App from './App.vue'

// Vue.config.productionTip = false
console.log('index')

/* eslint-disable no-new */
export default () => {
  new Vue({
    el: '#app',
    template: '<App/>',
    components: { App }
  })
}
