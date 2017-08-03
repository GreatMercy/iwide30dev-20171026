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
/* ---------------- 商城相关模块结束 ---------------- */

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
  refundRecord
}