import Vue from 'vue'
// import store from './store'
// import router from './router'
import App from './App'

export default () => {
  new Vue({ // eslint-disable-line no-new
    el: '#app',
    render: r => r(App)
  })
}
