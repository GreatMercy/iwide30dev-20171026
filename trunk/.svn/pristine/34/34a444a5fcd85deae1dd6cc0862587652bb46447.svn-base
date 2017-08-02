import JfkBanner from './packages/jfk-banner/index.js'
import JfkPopup from './packages/jfk-popup/index.js'
import JfkInfiniteScroll from './packages/jfk-infinite-scroll/index.js'
import JfkLoadmore from './packages/jfk-loadmore/index.js'
import JfkSupport from './packages/jfk-support/index.js'
import JfkToast from './packages/jfk-toast/index.js'
import JfkMessageBox from './packages/jfk-message-box/index.js'
import JfkRecommendation from './packages/jfk-recommendation/index.js'
import JfkCalendar from './packages/jfk-calendar/index.js'

const components = [
  JfkBanner,
  JfkLoadmore,
  JfkSupport,
  JfkPopup,
  JfkRecommendation,
  JfkCalendar
]
const install = function (Vue) {
  if (install.installed) {
    return
  }
  components.map(component => {
    Vue.component(component.name, component)
  })
  Vue.use(JfkInfiniteScroll)
  Vue.prototype.$jfkToast = JfkToast
  Vue.prototype.$jfkAlert = JfkMessageBox.alert
  Vue.prototype.$jfkConfirm = JfkMessageBox.confirm
  Vue.prototype.$jfkPrompt = JfkMessageBox.prompt
}

/* istanbul ignore if */
if (typeof window !== 'undefined' && window.Vue) {
  install(window.Vue)
}

export default {
  version: '1.0.0',
  install,
  JfkBanner,
  JfkPopup,
  JfkInfiniteScroll,
  JfkLoadmore,
  JfkSupport,
  JfkToast,
  JfkMessageBox,
  JfkRecommendation,
  JfkCalendar
}
