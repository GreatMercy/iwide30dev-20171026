import Vue from 'vue'
import App from './success.vue'

console.log('success')
/* eslint-disable no-new */
export default () => {
  new Vue({
    el: '#app',
    data: {
      name: '购买成功'
    },
    template: '<App/>',
    components: { App }
  })
}
