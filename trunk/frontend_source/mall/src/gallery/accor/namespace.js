import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
import data from '@/gallery/accor/data.js'
export default {
  install: function (Vue, options) {
    Vue.prototype.$pageNamespace = function (params) {
      if (!params) {
        params = formatUrlParams(location.href)
      }
      if (params.brandname) {
        this.pageNamespace = `is-${params.brandname} is-accor`
      } else {
        let tkid = params.tkid
        let d = data[tkid]
        if (d) {
          this.pageNamespace = `is-${d.brandname} is-accor`
        } else {
          this.pageNamespace = 'is-accor'
        }
      }
    }
  }
}
