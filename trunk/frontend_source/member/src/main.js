// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import JfkUi from 'jfk-ui/lib/jfk-ui.js'
Vue.use(JfkUi)
import '../../common/postcss/fonts/number/style.css'
import '@/styles/postcss/reset.postcss'
import '@/styles/postcss/common.postcss'

import Promise from 'promise-polyfill'
import pages from '@/pages/page'

if (process.env.NODE_ENV === 'development') {
  // require('./mock/index')
  require.ensure([], function (require) {
    let formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
    let params = formatUrlParams.default(location.href)
    if (params.theme === '1') {
      require('@/styles/postcss/theme/light.postcss')
    } else {
      require('@/styles/postcss/theme/dark.postcss')
    }
  })
} else {
  require('@/styles/postcss/theme/dark.postcss')
}

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

