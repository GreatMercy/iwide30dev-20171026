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
const pay = (r) => {
  import(/* webpackChunkName: "home" */ './pay/index').then(function (pay) {
    r(pay.default)
  }).catch(function (err) {
    showLoadError(err, 'pay')
  })
}
const orderDetail = (r) => {
  import(/* webpackChunkName: "orderDetail" */ './orderDetail/index').then(function (orderDetail) {
    r(orderDetail.default)
  }).catch(function (err) {
    showLoadError(err, 'orderDetail')
  })
}
// 转赠礼物
const sendGift = (r) => {
  import(/* webpackChunkName: "home" */ './send_gift/index').then(function (sendGift) {
    r(sendGift.default)
  }).catch(function (err) {
    showLoadError(err, 'sendGift')
  })
}
// 收礼列表
const giftList = (r) => {
  import(/* webpackChunkName: "home" */ './gift_list/index').then(function (giftList) {
    r(giftList.default)
  }).catch(function (err) {
    showLoadError(err, 'giftList')
  })
}
// 礼物详情
const giftDetail = (r) => {
  import(/* webpackChunkName: "home" */ './gift_detail/index').then(function (giftList) {
    r(giftList.default)
  }).catch(function (err) {
    showLoadError(err, 'giftDetail')
  })
}
const success = (r) => {
  import(/* webpackChunkName: "home" */ './success/index').then(function (success) {
    r(success.default)
  }).catch(function (err) {
    showLoadError(err, 'success')
  })
}
// 接收礼物
const gift = (r) => {
  import(/* webpackChunkName: "home" */ './gift/index').then(function (gift) {
    r(gift.default)
  }).catch(function (err) {
    showLoadError(err, 'gift')
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
export default {
  home,
  index,
  detail,
  pay,
  orderDetail,
  sendGift,
  success,
  gift,
  giftList,
  giftDetail,
  invalid,
  sendSuccess,
  orderDetails,
  orderCenter,
  test
}
