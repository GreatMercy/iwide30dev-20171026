/**
 * 关于浏览器的公共方法
 * @author huanghaojun
 * @email  yellowhaojun@gmail.com
 * */

/**
 * 获取 url 中的参数
 * @param {string} name 获取参数的名称
 */
const getQueryString = (name) => {
  let reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)')
  let r = window.location.search.substr(1).match(reg)
  if (r !== null) {
    return decodeURIComponent(r[2])
  } else {
    return null
  }
}

/**
 * 设置title
 * @param {string} title 需要设置的标题
 */
const setTitle = (title) => {
  document.title = title
  let mobile = navigator.userAgent.toLowerCase()
  if (/iphone|ipad|ipod/.test(mobile)) {
    let iframe = document.createElement('iframe')
    iframe.style.visibility = 'hidden'
    let iframeCallback = function () {
      setTimeout(function () {
        iframe.removeEventListener('load', iframeCallback)
        document.body.removeChild(iframe)
      }, 0)
    }
    iframe.addEventListener('load', iframeCallback)
    document.body.appendChild(iframe)
  }
}

/**
 * 获取hash
 * */
const getHash = () => {
  let location = window.location.hash
  location.substr(0, location.length - 1)
  return location || ''
}

/**
 * hash 发生改变
 * @param {function} fn hash 发生改变时候执行的操作
 * */
const hashChange = (fn) => {
  if (('onhashchange' in window) && ((typeof document.documentMode === 'undefined') || document.documentMode === 8)) {
    window.onhashchange = function () {
      let location = window.location.hash
      fn(location.substr(1, location.length))
    }
  } else {
    let location = window.location
    let oldHash = location.hash
    setInterval(function () {
      let newHash = location.hash
      if (newHash === oldHash) {
      } else {
        fn(oldHash.substr(1, location.length))
      }
    })
  }
}

export { getQueryString, setTitle, hashChange, getHash }
