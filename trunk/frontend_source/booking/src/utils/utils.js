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

// 时间转换时间
export function formatDate (time, str) {
  let timeStr = str !== undefined ? str : '-'
  let newDate = new Date()
  newDate.setTime(time * 1000)
  let newTime = newDate.toLocaleDateString().replace(/\//g, timeStr)
  let dateArr = newTime.split('-')
  if (dateArr[1] < 10) {
    dateArr[1] = '0' + dateArr[1]
  }
  if (dateArr[2] < 10) {
    dateArr[2] = '0' + dateArr[2]
  }
  newTime = dateArr.join('-')
  return newTime
}
