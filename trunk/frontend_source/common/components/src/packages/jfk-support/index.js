import JfkSupport from './src/main'
JfkSupport.name = 'JfkSupport'
/* istanbul ignore next */
JfkSupport.install = function (Vue) {
  Vue.component(JfkSupport.name, JfkSupport)
}

export default JfkSupport
