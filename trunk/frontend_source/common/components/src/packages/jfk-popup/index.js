import JfkPopup from './src/main'

/* istanbul ignore next */
JfkPopup.install = function (Vue) {
  Vue.component(JfkPopup.name, JfkPopup)
}

export default JfkPopup