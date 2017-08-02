import Vue from 'vue'
import store from './store'
import App from './App'

export default () => {
  new Vue({ // eslint-disable-line no-new
    el: '#app',
    store,
    render: r => r(App)
  })
}
