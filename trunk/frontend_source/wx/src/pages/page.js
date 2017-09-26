let showLoadError = function (err) {
  if (process.env.NODE_ENV === 'development') {
    return console.error(err)
  }
  return console.error(err.message)
}
// 绑定微信
const bindWx = (r) => {
  require.ensure([], function (require) {
    let packageList = require('./wx_bind/index')
    r(packageList.default)
  }, showLoadError, 'bindWx')
}

export default {
  bindWx
}
