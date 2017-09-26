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

export function formatUrlParams (url) {
  let search = url.split('?')[1]
  let params = {}
  if (search) {
    search = search.replace(/#.+$/, '')
    if (search.length > 1) {
      let querys = search.split('&')
      let len = querys.length
      let i = 0
      while (i < len) {
        let query = querys[i].split('=')
        let key = query[0].replace(/\[\]$/, '')
        let val = decodeURIComponent(query[1])
        params[key] = val
        i++
      }
    }
  }
  return params
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
