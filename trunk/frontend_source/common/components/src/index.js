import JfkBanner from './packages/jfk-banner/index.js'
import JfkPopup from './packages/jfk-popup/index.js'
import JfkInfiniteScroll from './packages/jfk-infinite-scroll/index.js'
import JfkLoadmore from './packages/jfk-loadmore/index.js'
import JfkSupport from './packages/jfk-support/index.js'
import JfkToast from './packages/jfk-toast/index.js'
import JfkMessageBox from './packages/jfk-message-box/index.js'
import JfkRecommendation from './packages/jfk-recommendation/index.js'
import JfkCalendar from './packages/jfk-calendar/index.js'
import JfkInputNumber from './packages/jfk-input-number/index.js'
import JfkNotification from './packages/jfk-notification/index.js'
import JfkPicker from './packages/jfk-picker/index.js'
import JfkShare from './packages/jfk-share/index.js'
import JfkSticky from './packages/jfk-sticky/index.js'
import JfkRater from './packages/jfk-rater/index.js'
import jfkTextSplit from './packages/jfk-text-split/index'

const components = [
  JfkBanner,
  JfkLoadmore,
  JfkSupport,
  JfkPopup,
  JfkRecommendation,
  JfkCalendar,
  JfkInputNumber,
  JfkNotification,
  JfkPicker,
  JfkRater,
  jfkTextSplit
]
const install = function (Vue) {
  if (install.installed) {
    return
  }
  components.map(component => {
    Vue.component(component.name, component)
  })
  Vue.use(JfkInfiniteScroll)
  Vue.use(JfkSticky)
  Vue.prototype.$jfkToast = JfkToast
  Vue.prototype.$jfkAlert = JfkMessageBox.alert
  Vue.prototype.$jfkConfirm = JfkMessageBox.confirm
  Vue.prototype.$jfkPrompt = JfkMessageBox.prompt
  Vue.prototype.$jfkShare = JfkShare
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
  JfkSticky,
  JfkLoadmore,
  JfkSupport,
  JfkToast,
  JfkMessageBox,
  JfkRecommendation,
  JfkCalendar,
  JfkInputNumber,
  JfkNotification,
  JfkPicker,
  JfkShare,
  JfkSticky,
  JfkRater,
  jfkTextSplit
}
