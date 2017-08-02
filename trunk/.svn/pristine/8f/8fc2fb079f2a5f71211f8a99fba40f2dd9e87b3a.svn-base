export default function formatUrlParams (url) {
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
