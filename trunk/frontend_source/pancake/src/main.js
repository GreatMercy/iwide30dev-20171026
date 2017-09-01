// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import JfkUi from 'jfk-ui/lib/jfk-ui.js'
Vue.use(JfkUi)
import '@/assets/fonts/iconfont.css'
import Promise from 'promise-polyfill'
import '@/styles/postcss/reset.postcss'
import '@/styles/postcss/common.postcss'
import '@/styles/postcss/theme/dark.postcss'
import pages from './pages/page'
Vue.config.productionTip = false

window.Promise = Promise

let call = function () {
  let config = arguments[0]
  if (typeof config === 'function') {
    config()
  }
  if (Object.prototype.toString.call(config) === '[object Object]' && typeof config.init === 'function') {
    config.init(config)
  }
}

document.addEventListener('DOMContentLoaded', function (event) {
  let scriptAreaElement = document.getElementById('scriptArea')
  let pageId = scriptAreaElement && scriptAreaElement.dataset.pageId || 'home'
  let pageConfig = pages[pageId]
  if (pageConfig) {
    pageConfig(call)
  }
})
