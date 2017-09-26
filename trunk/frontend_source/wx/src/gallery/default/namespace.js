export default {
  install: function (Vue, options) {
    Vue.prototype.$pageNamespace = function (params) {
      document.body.classList.add('is-default')
    }
  }
}
