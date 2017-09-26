export function findIndex (data, cb, index) {
  let len = data.length
  let i = Math.min(index || 0, len)
  while (i < len) {
    if (cb(data[i])) {
      return i
    }
    i++
  }
  return -1
}

export function showFullLayer (options = {}, title = '', href = location.href, cb) {
  let config = Object.assign({t: Date.now()}, options)
  window.history.pushState(config, title, href)
  window.addEventListener('popstate', function () {
    setTimeout(function () {
      cb && cb()
    }, 100)
  })
}
