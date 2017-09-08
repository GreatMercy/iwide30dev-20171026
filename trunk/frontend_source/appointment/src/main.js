import Promise from 'promise-polyfill'
import pages from './pages/page'
import '@scss/reset.scss'
import '@scss/icon.scss'
// import FastClick from 'fastclick'
// FastClick.attach(document.body)

// process.env.NODE_ENV === 'development' && require('./mock/index')

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
  let pageId = scriptAreaElement && scriptAreaElement.dataset.pageId || 'index'
  let pageConfig = pages[pageId]
  if (pageConfig) {
    pageConfig(call)
  }
})

