let showLoadError = function (err) {
  if (process.env.NODE_ENV === 'development') {
    return console.error(err)
  }
  return console.error(err.message)
}
// 首页
const home = (r) => {
  require.ensure([], function (require) {
    let home = require('./index/index')
    r(home.default)
  }, showLoadError, 'home')
}
// 登录
const login = (r) => {
  require.ensure([], function (require) {
    let login = require('./login/index')
    r(login.default)
  }, showLoadError, 'login')
}
// 注册
const register = (r) => {
  require.ensure([], function (require) {
    let register = require('./register/index')
    r(register.default)
  }, showLoadError, 'register')
}
// 重置密码
const resetpassword = (r) => {
  require.ensure([], function (require) {
    let resetpassword = require('./resetpassword/index')
    r(resetpassword.default)
  }, showLoadError, 'resetpassword')
}
// 余额
const balance = (r) => {
  require.ensure([], function (require) {
    let balance = require('./balance/index')
    r(balance.default)
  }, showLoadError, 'balance')
}
// 充值页面
const buydeposit = (r) => {
  require.ensure([], function (require) {
    let buydeposit = require('./buydeposit/index')
    r(buydeposit.default)
  }, showLoadError, 'buydeposit')
}
// 储值支付
const balancepay = (r) => {
  require.ensure([], function (require) {
    let balancepay = require('./balancepay/index')
    r(balancepay.default)
  }, showLoadError, 'balancepay')
}
// 设置储值密码
const balancesetpsw = (r) => {
  require.ensure([], function (require) {
    let balancesetpsw = require('./balancesetpsw/index')
    r(balancesetpsw.default)
  }, showLoadError, 'balancesetpsw')
}
// 设置储值密码
const okpay = (r) => {
  require.ensure([], function (require) {
    let okpay = require('./okpay/index')
    r(okpay.default)
  }, showLoadError, 'okpay')
}
// 设置储值密码
const nopay = (r) => {
  require.ensure([], function (require) {
    let nopay = require('./nopay/index')
    r(nopay.default)
  }, showLoadError, 'nopay')
}
// 积分
const bouns = (r) => {
  require.ensure([], function (require) {
    let bouns = require('./bouns/index')
    r(bouns.default)
  }, showLoadError, 'bouns')
}
// 个人信息
const info = (r) => {
  require.ensure([], function (require) {
    let info = require('./info/index')
    r(info.default)
  }, showLoadError, 'info')
}
// 购卡列表
const depositcard = (r) => {
  require.ensure([], function (require) {
    let depositcard = require('./depositcard/index')
    r(depositcard.default)
  }, showLoadError, 'depositcard')
}
// 购卡内容页
const depositcardinfo = (r) => {
  require.ensure([], function (require) {
    let depositcardinfo = require('./depositcardinfo/index')
    r(depositcardinfo.default)
  }, showLoadError, 'depositcardinfo')
}
// 优惠券猎猎捕
const card = (r) => {
  require.ensure([], function (require) {
    let card = require('./card/index')
    r(card.default)
  }, showLoadError, 'card')
}
// 优惠券内容页
const cardinfo = (r) => {
  require.ensure([], function (require) {
    let cardinfo = require('./cardinfo/index')
    r(cardinfo.default)
  }, showLoadError, 'cardinfo')
}
// 购卡内容页
const getcard = (r) => {
  require.ensure([], function (require) {
    let getcard = require('./getcard/index')
    r(getcard.default)
  }, showLoadError, 'getcard')
}
export default {
  home,
  login,
  resetpassword,
  register,
  balance,
  bouns,
  buydeposit,
  balancepay,
  balancesetpsw,
  okpay,
  nopay,
  info,
  depositcard,
  depositcardinfo,
  card,
  cardinfo,
  getcard
}
