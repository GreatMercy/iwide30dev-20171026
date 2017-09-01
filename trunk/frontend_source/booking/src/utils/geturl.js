// @ urlName 需要获取的url名字
export function getUrlParams (urlName) {
  // 获取url 参数{
  let url = location.href
  let paraString = url.substring(url.indexOf('?') + 1, url.length).split('&')
  let returnValue
  for (let i = 0; i < paraString.length; i++) {
    let tempParas = paraString[i].split('=')[0]
    let parasValue = paraString[i].split('=')[1]
    if (tempParas === urlName) returnValue = parasValue
  }
  if (typeof (returnValue) === 'undefined') {
    return ''
  } else {
    return returnValue
  }
}
// 输出过滤后的参数
export function logJSON (data) {
  function innerLog (data) {
    const temp = {}
    for (let p in data) {
      if (typeof data[p] === 'object') temp[p] = innerLog(data[p])
      else temp[p] = data[p]
    }
    return temp
  }
  console.log(innerLog(data))
}
