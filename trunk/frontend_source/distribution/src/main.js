// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
// import Axios from 'axios'
// Vue.use(Axios)
import App from './App'
import router from './router'
import JfkUi from 'jfk-ui/lib/jfk-ui.js'
Vue.use(JfkUi)
import Promise from 'promise-polyfill'
window.Promise = Promise
import '@/assets/iconfonts/iconfont.css'
import '@/styles/postcss/reset.postcss'
import '@/styles/postcss/main.postcss'
import '../../common/postcss/modules/loading/common.postcss'
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
