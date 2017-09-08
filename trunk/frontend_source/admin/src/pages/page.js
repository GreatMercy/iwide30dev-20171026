let showLoadError = function (err) {
  if (process.env.NODE_ENV === 'development') {
    return console.error(err)
  }
  return console.error(err.message)
}
/* ---------------- 订房相关模块开始 ---------------- */
// 添加价格代码
const bookingPrices = (r) => {
  require.ensure([], function (require) {
    let prices = require('./booking/prices/index')
    r(prices.default)
  }, showLoadError, 'booking_prices')
}
// 订房套餐产品
const bookingPackageProducts = (r) => {
  require.ensure([], function (require) {
    let packageProducts = require('./booking/package_products/index')
    r(packageProducts.default)
  }, showLoadError, 'booking_package-products')
}
/* ---------------- 订房相关模块结束 ---------------- */
/* ---------------- 会员相关模块开始 ---------------- */
const coupon = (r) => {
  require.ensure([], function (require) {
    let coupon = require('./user/coupon/index')
    r(coupon.default)
  }, showLoadError, 'user_coupon')
}

const couponList = (r) => {
  require.ensure([], function (require) {
    let couponList = require('./user/couponlist/index')
    r(couponList.default)
  }, showLoadError, 'user_coupon-list')
}

const couponDetail = (r) => {
  require.ensure([], function (require) {
    let couponDetail = require('./user/coupondetail/index')
    r(couponDetail.default)
  }, showLoadError, 'user_coupon-detail')
}
/* ---------------- 会员相关模块结束 ---------------- */
/* ---------------- 分销相关模块开始 ---------------- */
const account = (r) => {
  require.ensure([], function (require) {
    let account = require('./distribution/account/index')
    r(account.default)
  }, showLoadError, 'distribution_account')
}

const editAccount = (r) => {
  require.ensure([], function (require) {
    let editAccount = require('./distribution/edit_account/index')
    r(editAccount.default)
  }, showLoadError, 'distribution_edit-account')
}

const iwidePay = (r) => {
  require.ensure([], function (require) {
    let iwidePay = require('./distribution/iwide_pay/index')
    r(iwidePay.default)
  }, showLoadError, 'distribution_iwide-pay')
}

const tradeRecord = (r) => {
  require.ensure([], function (require) {
    let tradeRecord = require('./distribution/trade_record/index')
    r(tradeRecord.default)
  }, showLoadError, 'distribution_trade-record')
}

const settleRecord = (r) => {
  require.ensure([], function (require) {
    let settleRecord = require('./distribution/settle_record/index')
    r(settleRecord.default)
  }, showLoadError, 'distribution_settle-record')
}

const financeBill = (r) => {
  require.ensure([], function (require) {
    let financeBill = require('./distribution/finance_bill/index')
    r(financeBill.default)
  }, showLoadError, 'distribution_finance-bill')
}
const splitDetail = (r) => {
  require.ensure([], function (require) {
    let splitDetail = require('./distribution/split_detail/index')
    r(splitDetail.default)
  }, showLoadError, 'distribution_split-detail')
}
const editRule = (r) => {
  require.ensure([], function (require) {
    let editRule = require('./distribution/edit_rule/index')
    r(editRule.default)
  }, showLoadError, 'distribution_edit-rule')
}
const addRule = (r) => {
  require.ensure([], function (require) {
    let addRule = require('./distribution/add_rule/index')
    r(addRule.default)
  }, showLoadError, 'distribution_add-rule')
}
const refundRecord = (r) => {
  require.ensure([], function (require) {
    let refundRecord = require('./distribution/refund_record/index')
    r(refundRecord.default)
  }, showLoadError, 'distribution_refund-record')
}
/* ---------------- 分销相关模块结束 ---------------- */
/* ---------------- 商城相关模块开始 ---------------- */
// 邮寄订单列表
const post = (r) => {
  require.ensure([], function (require) {
    let mallPost = require('./mall/post/index')
    r(mallPost.default)
  }, showLoadError, 'mall_post')
}

// 邮寄导入报表发货
const delivery = (r) => {
  require.ensure([], function (require) {
    let mallDelivery = require('./mall/delivery/index')
    r(mallDelivery.default)
  }, showLoadError, 'mall_delivery')
}

// 物流工具
const logistics = (r) => {
  require.ensure([], function (require) {
    let mallLogistics = require('./mall/logistics/index')
    r(mallLogistics.default)
  }, showLoadError, 'mall_logistics')
}

// 物流列表
const logisticsList = (r) => {
  require.ensure([], function (require) {
    let mallLogisticsList = require('./mall/logistics_list/index')
    r(mallLogisticsList.default)
  }, showLoadError, 'mall_logistics-list')
}

// 商品列表
const mallPackage = (r) => {
  require.ensure([], function (require) {
    let mallPackage = require('./mall/package/index')
    r(mallPackage.default)
  }, showLoadError, 'mall_package')
}
// 礼包配送
const giftPackage = (r) => {
  require.ensure([], function (require) {
    let giftPackage = require('./mall/gift_package/index')
    r(giftPackage.default)
  }, showLoadError, 'mall_gift-package')
}
/* ---------------- 商城相关模块结束 ---------------- */
/* ---------------- 系统相关模块开始 ---------------- */

// 角色列表
const roleList = (r) => {
  require.ensure([], function (require) {
    let roleList = require('./system/role_list/index')
    r(roleList.default)
  }, showLoadError, 'role_list')
}
// 新增角色
const addRole = (r) => {
  require.ensure([], function (require) {
    let addRole = require('./system/add_role/index')
    r(addRole.default)
  }, showLoadError, 'role_list')
}
// 账号列表
const accountList = (r) => {
  require.ensure([], function (require) {
    let accountList = require('./system/account_list/index')
    r(accountList.default)
  }, showLoadError, 'account_list')
}
// 新增账号
const addAccount = (r) => {
  require.ensure([], function (require) {
    let addAccount = require('./system/add_account/index')
    r(addAccount.default)
  }, showLoadError, 'add_account')
}
// 权限清单
const authorityList = (r) => {
  require.ensure([], function (require) {
    let authorityList = require('./system/authority_list/index')
    r(authorityList.default)
  }, showLoadError, 'authority_list')
}
// 新版登陆页面
const login = (r) => {
  require.ensure([], function (require) {
    let login = require('./system/login/index')
    r(login.default)
  }, showLoadError, 'login')
}
// 绑定微信登陆
const bindWx = (r) => {
  require.ensure([], function (require) {
    let bindWx = require('./wx/wx_bind/index')
    r(bindWx.default)
  }, showLoadError, 'bindWx')
}
// 权限模块列表
const authorityModule = (r) => {
  require.ensure([], function (require) {
    let authorityModule = require('./system/authority_module/index')
    r(authorityModule.default)
  }, showLoadError, 'authorityModule')
}
/* ---------------- 系统相关模块结束 ---------------- */
/* ---------------- 统计示例相关模块开始 ---------------- */
const statisticsExample = (r) => {
  require.ensure([], function (require) {
    let statisticsExample = require('./statistics/example')
    r(statisticsExample.default)
  }, showLoadError, 'statistics_example')
}
/* ---------------- 统计示例相关模块结束 ---------------- */
/* ---------------- 分账相关模块开始 ---------------- */
const refund = (r) => {
  require.ensure([], function (require) {
    let statisticsExample = require('./distribution/refund/index')
    r(statisticsExample.default)
  }, showLoadError, 'refund')
}
const fundOverview = (r) => {
  require.ensure([], function (require) {
    let statisticsExample = require('./distribution/fundOverview/index')
    r(statisticsExample.default)
  }, showLoadError, 'fundOverview')
}
const accountVerification = (r) => {
  require.ensure([], function (require) {
    let statisticsExample = require('./distribution/accountVerification/index')
    r(statisticsExample.default)
  }, showLoadError, 'accountVerification')
}
const transferAudit = (r) => {
  require.ensure([], function (require) {
    let statisticsExample = require('./distribution/transferAudit/index')
    r(statisticsExample.default)
  }, showLoadError, 'transferAudit')
}
/* ---------------- 统计示例相关模块结束 ---------------- */
export default {
  bookingPrices,
  bookingPackageProducts,
  coupon,
  couponList,
  couponDetail,
  account,
  iwidePay,
  tradeRecord,
  settleRecord,
  financeBill,
  editAccount,
  splitDetail,
  post,
  logisticsList,
  logistics,
  delivery,
  editRule,
  mallPackage,
  addRule,
  refundRecord,
  roleList,
  addRole,
  accountList,
  addAccount,
  authorityList,
  login,
  bindWx,
  statisticsExample,
  refund,
  authorityModule,
  fundOverview,
  accountVerification,
  transferAudit,
  giftPackage
}
