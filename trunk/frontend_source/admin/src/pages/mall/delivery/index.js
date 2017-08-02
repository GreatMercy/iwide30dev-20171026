import Vue from 'vue'
// import router from './router'
// import store from './store'
import App from './App'

export default () => {
  new Vue({ // eslint-disable-line no-new
    el: '#app',
    render: r => r(App)
  })
}
