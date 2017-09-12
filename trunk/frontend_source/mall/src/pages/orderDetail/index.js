
import Vue from 'vue'
import App from './orderDetail.vue'

/* eslint-disable no-new */
export default () => {
  new Vue({
    el: '#app',
    template: '<App/>',
    components: { App }
  })
}
