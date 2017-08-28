import JfkSticky from './src/main'

/* istanbul ignore next */
JfkSticky.install = function (Vue) {
  Vue.component(JfkSticky.name, JfkSticky)
}

export default JfkSticky