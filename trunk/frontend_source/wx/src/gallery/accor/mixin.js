import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
import data from '@/gallery/accor/data.js'
import Vue from 'vue'
Vue.mixin({
  beforeCreate () {
    let params = formatUrlParams(location.href)
    if (params.brandname) {
      this.brandname = params.brandname
    } else {
      let tkid = params.tkid
      let d = data[tkid]
      if (d) {
        this.brandname = d.brandname
      }
    }
  }
})
