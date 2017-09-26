import sticky from './src/main'

sticky.name = 'sticky'
sticky.install = function (Vue) {
  Vue.directive(sticky.name, sticky)
}
export default sticky
