let showLoadError = function (err) {
  if (process.env.NODE_ENV === 'development') {
    return console.error(err)
  }
  return console.error(err.message)
}
const index = (r) => {
  require.ensure([], function (require) {
    let index = require('./index/index')
    r(index.default)
  }, showLoadError, 'index')
}
const detail = (r) => {
  require.ensure([], function (require) {
    let detail = require('./detail/index')
    r(detail.default)
  }, showLoadError, 'detail')
}
const reserve = (r) => {
  require.ensure([], function (require) {
    let reserve = require('./reserve/index')
    r(reserve.default)
  }, showLoadError, 'reserve')
}
const orderDetail = (r) => {
  require.ensure([], function (require) {
    let orderDetail = require('./orderDetail/index')
    r(orderDetail.default)
  }, showLoadError, 'orderDetail')
}
/* ---------------- 转赠礼物相关页面开始 ---------------- */
// 转赠礼物
const sendGift = (r) => {
  require.ensure([], function (require) {
    let sendGift = require('./send_gift/index')
    r(sendGift.default)
  }, showLoadError, 'sendGift')
}
// 礼物（可领取）
const gift = (r) => {
  require.ensure([], function (require) {
    let gift = require('./gift/index')
    r(gift.default)
  }, showLoadError, 'gift')
}
// 礼物（已被领取）
const giftInvalid = (r) => {
  require.ensure([], function (require) {
    let giftInvalid = require('./gift_invalid/index')
    r(giftInvalid.default)
  }, showLoadError, 'giftInvalid')
}

// 收礼人 礼物列表
const giftList = (r) => {
  require.ensure([], function (require) {
    let giftList = require('./gift_list/index')
    r(giftList.default)
  }, showLoadError, 'giftList')
}

/* ---------------- 转赠礼物相关页面结束 ---------------- */

// 客房预定
const booking = (r) => {
  require.ensure([], function (require) {
    let booking = require('./booking/index')
    r(booking.default)
  }, showLoadError, 'booking')
}

// 到店用卷
const coupon = (r) => {
  require.ensure([], function (require) {
    let coupon = require('./coupon/index')
    r(coupon.default)
  }, showLoadError, 'coupon')
}

const success = (r) => {
  require.ensure([], function (require) {
    let success = require('./success/index')
    r(success.default)
  }, showLoadError, 'success')
}

const invalid = (r) => {
  require.ensure([], function (require) {
    let invalid = require('./invalid/index')
    r(invalid.default)
  }, showLoadError, 'invalid')
}
const sendSuccess = (r) => {
  require.ensure([], function (require) {
    let sendSuccess = require('./sendSuccess/index')
    r(sendSuccess.default)
  }, showLoadError, 'sendSuccess')
}
// 订单中心
const orderCenter = (r) => {
  require.ensure([], function (require) {
    let orderCenter = require('./order_center/index')
    r(orderCenter.default)
  }, showLoadError, 'orderCenter')
}
const orderDetails = (r) => {
  require.ensure([], function (require) {
    let orderDetail = require('./order_detail/index')
    r(orderDetail.default)
  }, showLoadError, 'orderDetail')
}
// 礼物详情页
const giftOrderDetail = (r) => {
  require.ensure([], function (require) {
    let giftOrderDetail = require('./giftOrderDetail/index')
    r(giftOrderDetail.default)
  }, showLoadError, 'giftOrderDetail')
}
// 申请退款
const refund = (r) => {
  require.ensure([], function (require) {
    let refund = require('./refund/index')
    r(refund.default)
  }, showLoadError, 'refund')
}
// 退款详情
const refundDetail = (r) => {
  require.ensure([], function (require) {
    let refundDetail = require('./refund_detail/index')
    r(refundDetail.default)
  }, showLoadError, 'refundDetail')
}
// 提交发票
const invoice = (r) => {
  require.ensure([], function (require) {
    let invoice = require('./invoice/index')
    r(invoice.default)
  }, showLoadError, 'invoice')
}
// 订房列表
const reservationList = (r) => {
  require.ensure([], function (require) {
    let reservation = require('./reservation_list/index')
    r(reservation.default)
  }, showLoadError, 'reservationList')
}
// 订房
const reservation = (r) => {
  require.ensure([], function (require) {
    let reservation = require('./reservation/index')
    r(reservation.default)
  }, showLoadError, 'reservation')
}
// 物流详情
const logisticsDetail = (r) => {
  require.ensure([], function (require) {
    let logisticsDetail = require('./logistics_detail/index')
    r(logisticsDetail.default)
  }, showLoadError, 'logisticsDetail')
}
// 邮寄后置
const post = (r) => {
  require.ensure([], function (require) {
    let post = require('./post/index')
    r(post.default)
  }, showLoadError, 'post')
}
// 领取礼包
const giftPackage = (r) => {
  require.ensure([], function (require) {
    let giftPackage = require('./gift_package/index')
    r(giftPackage.default)
  }, showLoadError, 'giftPackage')
}
// 扫码领取
const scanReceive = (r) => {
  require.ensure([], function (require) {
    let scanReceive = require('./scan_receive/index')
    r(scanReceive.default)
  }, showLoadError, 'scanReceive')
}
// 礼包列表
const packageList = (r) => {
  require.ensure([], function (require) {
    let packageList = require('./package_list/index')
    r(packageList.default)
  }, showLoadError, 'packageList')
}

export default {
  index,
  detail,
  reserve,
  orderDetail,
  sendGift,
  success,
  gift,
  giftInvalid,
  giftList,
  invalid,
  sendSuccess,
  orderDetails,
  orderCenter,
  booking,
  coupon,
  giftOrderDetail,
  refund,
  refundDetail,
  invoice,
  reservation,
  reservationList,
  logisticsDetail,
  post,
  giftPackage,
  scanReceive,
  packageList
}
