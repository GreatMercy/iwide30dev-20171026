import './pay'
import Vue from 'vue'
import App from './pay.vue'

console.log('pay')
/* eslint-disable no-new */
export default () => {
  new Vue({
    el: '#app',
    template: '<App/>',
    components: { App }
  })
}
