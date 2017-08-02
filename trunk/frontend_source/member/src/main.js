// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import '@/styles/postcss/reset.postcss'
import '@/assets/css/index.css'
import '@/assets/css/mycss.css'

import Promise from 'promise-polyfill'
import pages from '@/pages/page'

if (!window.Promise) {
  window.Promise = Promise
}

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

