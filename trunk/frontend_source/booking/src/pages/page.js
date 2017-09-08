let showLoadError = function (err) {
  if (process.env.NODE_ENV === 'development') {
    return console.error(err)
  }
  return console.error(err.message)
}
const index = (r) => {
  require.ensure([], function (require) {
    let index = require('./search/index')
    r(index.default)
  }, showLoadError, 'index')
}
// from xm
// 快速订房
const search = (r) => {
  require.ensure([], function (require) {
    let search = require('./search/index')
    r(search.default)
  }, showLoadError, 'search')
}
// 酒店相册
const hotelAlbum = (r) => {
  require.ensure([], function (require) {
    let hotelAlbum = require('./hotel_album/index')
    r(hotelAlbum.default)
  }, showLoadError, 'hotelAlbum')
}
// 酒店预订
const bookingHotel = (r) => {
  require.ensure([], function (require) {
    let bookingHotel = require('./booking_hotel/index')
    r(bookingHotel.default)
  }, showLoadError, 'bookingHotel')
}

// 房型描述
// const roomDesc = (r) => {
//   require.ensure([], function (require) {
//     let roomDesc = require('./room_desc/index')
//     r(roomDesc.default)
//   }, showLoadError, 'roomDesc')
// }

// 酒店详情介绍
const hotelDetailint = (r) => {
  require.ensure([], function (require) {
    let hotelDetailint = require('./hotel_detail_int/index')
    r(hotelDetailint.default)
  }, showLoadError, 'hotelDetailint')
}

// 选择商品
// const productChoose = (r) => {
//   require.ensure([], function (require) {
//     let productChoose = require('./product_choose/index')
//     r(productChoose.default)
//   }, showLoadError, 'productChoose')
// }

// 使用优惠券
const useCoupon = (r) => {
  require.ensure([], function (require) {
    let useCoupon = require('./use_coupon/index')
    r(useCoupon.default)
  }, showLoadError, 'useCoupon')
}

// 选择城市
const cityChoose = (r) => {
  require.ensure([], function (require) {
    let cityChoose = require('./city_choose/index')
    r(cityChoose.default)
  }, showLoadError, 'cityChoose')
}

// 发表评论
const comment = (r) => {
  require.ensure([], function (require) {
    let comment = require('./comment/index')
    r(comment.default)
  }, showLoadError, 'comment')
}

// 我的订单
const myorder = (r) => {
  require.ensure([], function (require) {
    let myorder = require('./myorder/index')
    r(myorder.default)
  }, showLoadError, 'myorder')
}

// 订单详情
const orderDetail = (r) => {
  require.ensure([], function (require) {
    let orderDetail = require('./order_detail/index')
    r(orderDetail.default)
  }, showLoadError, 'orderDetail')
}

// 提交订单
const submitOrder = (r) => {
  require.ensure([], function (require) {
    let submitOrder = require('./submit_order/index')
    r(submitOrder.default)
  }, showLoadError, 'submitOrder')
}

//评论内容
const commentContent = (r) => {
  require.ensure([], function (require) {
    let commentContent = require('./comment_content/index')
    r(commentContent.default)
  }, showLoadError, 'commentContent')
}

//房型详情
// const roomDel = (r) => {
//   require.ensure([], function (require) {
//     let roomDel = require('./room_del/index')
//     r(roomDel.default)
//   }, showLoadError, 'roomDel')
// }

//附近
const nearby = (r) => {
  require.ensure([], function (require) {
    let nearby = require('./nearby/index')
    r(nearby.default)
  }, showLoadError, 'nearby')
}
export default {
  index,
  search,
  hotelAlbum,
  bookingHotel,
  // roomDesc,
  hotelDetailint,
  // productChoose,
  useCoupon,
  cityChoose,
  comment,
  myorder,
  orderDetail,
  submitOrder,
  commentContent,
  // roomDel,
  nearby
}
