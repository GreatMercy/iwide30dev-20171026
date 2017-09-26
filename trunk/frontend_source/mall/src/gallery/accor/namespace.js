import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
// import data from '@/gallery/accor/data.js'
export default {
  install: function (Vue, options) {
    Vue.prototype.$pageNamespace = function (params) {
      if (!params) {
        params = formatUrlParams(location.href)
      }
      let pageNamespace = []
      if (params.brandname) {
        pageNamespace = [`is-${params.brandname}`, 'is-accor']
      } else {
        pageNamespace = ['is-accor']
      }
      let $body = document.body
      pageNamespace.forEach(function (c) {
        $body.classList.add(c)
      })
    }
  }
}
