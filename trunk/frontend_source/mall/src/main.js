// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueLazyload from 'vue-lazyload'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import JfkUi from 'jfk-ui/lib/jfk-ui.js'
// import VueTouch from 'vue-touch'
Vue.use(VueLazyload)
Vue.use(VueAwesomeSwiper)
Vue.use(JfkUi)
// Vue.use(VueTouch, {name: 'v-touch'})

import Promise from 'promise-polyfill'
import 'swiper/dist/css/swiper.css'
import pages from './pages/page'
import '@/styles/postcss/reset.postcss'
// 注意字体图标样式与common样式的前后顺序
if (process.env.INTER_ID === 'accor') {
  require('../../common/postcss/fonts/accor_number/style.css')
  require('@/assets/fonts/accor/iconfont.css')
  require('@/styles/postcss/common_accor.postcss')
  let namespace = require('@/gallery/accor/namespace.js').default
  Vue.use(namespace)
} else {
  require('../../common/postcss/fonts/number/style.css')
  require('@/assets/fonts/default/iconfont.css')
  require('@/styles/postcss/common.postcss')
  let namespace = require('@/gallery/default/namespace.js').default
  Vue.use(namespace)
}
if (process.env.NODE_ENV === 'development') {
  // require('./mock/index')
  require.ensure([], function (require) {
    let formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
    let params = formatUrlParams.default(location.href)
    let referrerParams = formatUrlParams.default(document.referrer)
    if (process.env.INTER_ID === 'accor') {
      referrerParams.theme = '1'
      referrerParams.brandname = referrerParams.brandname || params.brandname || 'mercure'
    }
    if (params.theme === '1') {
      if (process.env.INTER_ID === 'accor') {
        require('@/styles/postcss/theme/light_accor.postcss')
      } else {
        require('@/styles/postcss/theme/light.postcss')
      }
    } else if (referrerParams.theme === '1') {
      // 通过组装的方式生成新的路径，如果直接拼接，防止页面路由把hash拼错
      let href = location.origin + location.pathname
      if (location.search) {
        href += location.search + '&theme=1'
      } else {
        href += '?theme=1'
      }
      if (process.env.INTER_ID === 'accor' && href.indexOf('brandname') === -1) {
        href += '&brandname=' + referrerParams.brandname
      }
      href += location.hash
      // 替换掉当前的路径
      location.replace(href)
    } else {
      require('@/styles/postcss/theme/dark.postcss')
    }
  })
}
// Vue.config.productionTip = false

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

