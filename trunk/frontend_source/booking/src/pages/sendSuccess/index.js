import Vue from 'vue'
import App from './success.vue'

console.log('success')
/* eslint-disable no-new */
export default () => {
  new Vue({
    el: '#app',
    data: {
      name: '转赠成功'
    },
    template: '<App/>',
    components: { App }
  })
}
