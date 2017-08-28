import Vue from 'vue'
import shareVue from './main.vue'
const shareConstructor = Vue.extend(shareVue)
let getAnInstance = () => {
  return new shareConstructor({
    el: document.createElement('div')
  })
}

let wxShare = (options = {}) => {
  let config = {
    shadeClose: options.shadeClose === undefined ? true : options.shadeClose
  }

  let instance = getAnInstance(config)
  Object.assign(instance, config)
  document.body.appendChild(instance.$el)
  return instance
}

export default wxShare

