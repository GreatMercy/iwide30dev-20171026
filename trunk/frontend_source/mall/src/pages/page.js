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
const home = (r) => {
  require.ensure([], function (require) {
    let index = require('./home/index')
    r(index.default)
  }, showLoadError, 'home')
}
const detail = (r) => {
  import(/* webpackChunkName: "home" */ './detail/index').then(function (detail) {
    r(detail.default)
  }).catch(function (err) {
    showLoadError(err, 'detail')
  })
}
const reserve = (r) => {
  import(/* webpackChunkName: "home" */ './reserve/index').then(function (reserve) {
    r(reserve.default)
  }).catch(function (err) {
    showLoadError(err, 'reserve')
  })
}
const orderDetail = (r) => {
  import(/* webpackChunkName: "orderDetail" */ './orderDetail/index').then(function (orderDetail) {
    r(orderDetail.default)
  }).catch(function (err) {
    showLoadError(err, 'orderDetail')
  })
}
/* ---------------- 转赠礼物相关页面开始 ---------------- */
// 转赠礼物
const sendGift = (r) => {
  import(/* webpackChunkName: "home" */'./send_gift/index').then(function (sendGift) {
    r(sendGift.default)
  }).catch(function (err) {
    showLoadError(err, 'sendGift')
  })
}
// 礼物（可领取）
const gift = (r) => {
  import(/* webpackChunkName: "home" */'./gift/index').then(function (gift) {
    r(gift.default)
  }).catch(function (err) {
    showLoadError(err, 'gift')
  })
}
// 礼物（已被领取）
const giftInvalid = (r) => {
  import(/* webpackChunkName: "home" */'./gift_invalid/index').then(function (giftInvalid) {
    r(giftInvalid.default)
  }).catch(function (err) {
    showLoadError(err, 'giftInvalid')
  })
}

// 收礼人 礼物列表
const giftList = (r) => {
  import(/* webpackChunkName: "home" */'./gift_list/index').then(function (giftReceivedList) {
    r(giftReceivedList.default)
  }).catch(function (err) {
    showLoadError(err, 'giftList')
  })
}

/* ---------------- 转赠礼物相关页面结束 ---------------- */

// 客房预定
const booking = (r) => {
  import(/* webpackChunkName: "home" */ './booking/index').then(function (booking) {
    r(booking.default)
  }).catch(function (err) {
    showLoadError(err, 'booking')
  })
}

// 到店用卷
const coupon = (r) => {
  import(/* webpackChunkName: "home" */ './coupon/index').then(function (coupon) {
    r(coupon.default)
  }).catch(function (err) {
    showLoadError(err, 'coupon')
  })
}

const success = (r) => {
  import(/* webpackChunkName: "home" */ './success/index').then(function (success) {
    r(success.default)
  }).catch(function (err) {
    showLoadError(err, 'success')
  })
}

const test = (r) => {
  import(/* webpackChunkName: "home" */ './test/index').then(function (gift) {
    r(gift.default)
  }).catch(function (err) {
    showLoadError(err, 'gift')
  })
}
const invalid = (r) => {
  import(/* webpackChunkName: "invalid" */ './invalid/index').then(function (invalid) {
    r(invalid.default)
  }).catch(function (err) {
    showLoadError(err, 'invalid')
  })
}
const sendSuccess = (r) => {
  import(/* webpackChunkName: "sendSuccess" */ './sendSuccess/index').then(function (sendSuccess) {
    r(sendSuccess.default)
  }).catch(function (err) {
    showLoadError(err, 'sendSuccess')
  })
}
// 订单中心
const orderCenter = (r) => {
  import(/* webpackChunkName: "orderDetails" */ './order_center/index').then(function (orderDetails) {
    r(orderDetails.default)
  }).catch(function (err) {
    showLoadError(err, 'orderCenter')
  })
}
const orderDetails = (r) => {
  import(/* webpackChunkName: "orderDetails" */ './order_detail/index').then(function (orderDetails) {
    r(orderDetails.default)
  }).catch(function (err) {
    showLoadError(err, 'orderDetails')
  })
}
// 礼物详情页
const giftOrderDetail = (r) => {
  import(/* webpackChunkName: "giftOrderDetail" */ './giftOrderDetail/index').then(function (giftOrderDetail) {
    r(giftOrderDetail.default)
  }).catch(function (err) {
    showLoadError(err, 'giftOrderDetail')
  })
}
export default {
  home,
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
  test
}
