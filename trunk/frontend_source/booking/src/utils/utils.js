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
