export default {
  install: function (Vue, options) {
    Vue.prototype.$pageNamespace = function (params) {
      this.pageNamespace = 'is-default'
    }
  }
}
