// 根据指定的索引值取对应的变量值
// nth-list([1, 2, 3], 0) => 1
let reg = /\s*,\s*|\s+/
module.exports = function (string, index = 0) {
  if (!string) {
    throw Error('nth-list 需要传入一个源字符串string')
  }
  let arr = string.split(reg)
  let len = arr.length
  if (index < 0) {
    index = len + index
  }
  if (index >= len) {
    index = len - 1
  }
  return arr[index]
}