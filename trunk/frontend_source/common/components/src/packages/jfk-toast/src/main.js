import Vue from 'vue'
import toastVue from './main.vue';
const ToastConstructor = Vue.extend(toastVue)
let toastPool = []
let getAnInstance = () => {
  if (toastPool.length > 0) {
    let instance = toastPool[0]
    toastPool.splice(0, 1)
    return instance
  }
  return new ToastConstructor({
    el: document.createElement('div')
  })
}

let returnAnInstance = instance => {
  if (instance) {
    toastPool.push(instance)
  }
}

let removeDom = event => {
  if (event.target.parentNode) {
    event.target.parentNode.removeChild(event.target)
  }
}
ToastConstructor.prototype.close = function() {
  this.visible = false
  this.$el.addEventListener('transitionend', removeDom)
  this.closed = true
  returnAnInstance(this)
}
let Toast = (options = {}) => {
  let duration = options.duration || 3000
  let config = {
  message: typeof options === 'string' ? options : options.message,
  position: options.position || 'middle',
  className: options.className || '',
  iconClass: options.iconClass || '',
  iconType: options.iconType || '',
  modal: options.modal === undefined ? true : options.modal,
  isLoading: options.isLoading,
  zIndex: options.zIndex
}
  let instance = getAnInstance(config)
  Object.assign(instance, config)
  instance.closed = false
  clearTimeout(instance.timer)
  Object.assign(instance, config)
  document.body.appendChild(instance.$el)
  Vue.nextTick(function() {
    instance.visible = true
    instance.$el.removeEventListener('transitionend', removeDom)
    ~duration && (instance.timer = setTimeout(function() {
      if (instance.closed) return
      instance.close()
    }, duration))
  })
  return instance
}

export default Toast
