import JfkBanner from './src/main'

/* istanbul ignore next */
JfkBanner.install = function (Vue) {
  Vue.component(JfkBanner.name, JfkBanner)
}

export default JfkBanner
