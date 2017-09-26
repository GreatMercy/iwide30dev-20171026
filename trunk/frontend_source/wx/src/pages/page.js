let showLoadError = function (err) {
  if (process.env.NODE_ENV === 'development') {
    return console.error(err)
  }
  return console.error(err.message)
}
// 首页
const index = (r) => {
  require.ensure([], function (require) {
    let index = require('./index/index')
    r(index.default)
  }, showLoadError, 'index')
}
// 绑定微信
const bindWx = (r) => {
  require.ensure([], function (require) {
    let bindWx = require('./wx_bind/index')
    r(bindWx.default)
  }, showLoadError, 'bindWx')
}
// 微信授权登陆
const wxLogin = (r) => {
  require.ensure([], function (require) {
    let wxLogin = require('./wx_login/index')
    r(wxLogin.default)
  }, showLoadError, 'wxLogin')
}
export default {
  index,
  bindWx,
  wxLogin
}
