// 20170502 => 2017-05-02
let dateReg1 = /^(\d{4})(\d{2})(\d{2})$/
export function dateStrToStr1 (str) {
  return str.replace(dateReg1, '$1-$2-$3')
}
// 0030 => 00:30
let timeReg1 = /^(\d{2})(\d{2})$/
export function timeStrToStr1 (str) {
  return str.replace(timeReg1, '$1:$2')
}
// 18 => 18:00
let timeReg2 = /^(\d{1,2})$/
export function timeStrToStr2 (str) {
  return str.replace(timeReg2, '$1:00')
}
// 18:00 => 18
let timeReg3 = /(\d{1,2}):00$/
export function timeStrToStr3 (str) {
  return str.replace(timeReg3, '$1')
}

export const moneyReg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/

export function stringIsValidMoney (str) {
  return moneyReg.test(str)
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
/**
 * 将对象object中的对象的key按提供的keys索引集合筛选
 * @param {Array} keys 待去除的key
 * @param {Object} object 待去除的对象
 * @returns {Array} 返回筛选后的keys索引集合
 * @example
 * omitKeys(['wexin'], {wexin:1, online: 2}) => [online]
 */
export const omitKeys = function (keys, object) {
  let result = []
  for (var key in object) {
    if (keys.indexOf(key) === -1) {
      result.push(key)
    }
  }
  return result
}

export const arrSplice = Array.prototype.splice

/**
 * 将一个数组按提供的起始位置及长度填充到源数组中，并返回新的填充完毕的数组
 * @param {number} start 待填充的起始位置
 * @param {number} len 待填充的长度
 * @param {array} arr 待填充的数组
 * @param {array} fillArr 填充进去的数组
 * @returns {array} 返回新的填充完毕的数组
 * @example
 *  arrayFillWithArray(5, 5, [1,2], [6,7,8,9,10]) => [1,2,undefined, undefined,undefined,6,7,8,9,10]
 */
export const arrayFillWithArray = function (start, len, arr, fillArr) {
  let _arr = arr.concat()
  let _fillArr = len < fillArr.length ? fillArr.slice(0, len) : fillArr.concat()
  let end = start + len
  if (_arr[end - 1] === undefined) {
    _arr[end - 1] = 0
  }
  _fillArr.unshift(start, len)
  arrSplice.apply(_arr, _fillArr)
  return _arr
}

// 时间转换时间
export function formatDate (time, str) {
  let timeStr = str !== undefined ? str : '-'
  let newDate = new Date()
  newDate.setTime(time * 1000)
  let newTime = newDate.toLocaleDateString().replace(/\//g, timeStr)
  return newTime
}
