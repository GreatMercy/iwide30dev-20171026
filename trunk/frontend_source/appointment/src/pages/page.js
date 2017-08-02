let showErrorOnDevelop = function (err, page) {
  if (process.env.NODE_ENV === 'development') {
    console.error(page, err)
  }
}

// 首页
const index = (r) => {
  import(/* webpackChunkName: "index" */ './index/index').then(function (home) {
    r(home.default)
  }).catch(function (err) {
    showErrorOnDevelop(err, 'index')
  })
}

// 商品详情
const detail = (r) => {
  import(/* webpackChunkName: "detail" */ './detail/index').then(function (home) {
    r(home.default)
  }).catch(function (err) {
    showErrorOnDevelop(err, 'detail')
  })
}

// 订单列表
const orderList = (r) => {
  import(/* webpackChunkName: "detail" */ './orderList/index').then(function (home) {
    r(home.default)
  }).catch(function (err) {
    showErrorOnDevelop(err, 'orderList')
  })
}

// 提交订单
const order = (r) => {
  import(/* webpackChunkName: "order" */ './order/index').then(function (home) {
    r(home.default)
  }).catch(function (err) {
    showErrorOnDevelop(err, 'order')
  })
}

// 订单列表
const orderDetail = (r) => {
  import(/* webpackChunkName: "orderDetail" */ './orderDetail/index').then(function (home) {
    r(home.default)
  }).catch(function (err) {
    showErrorOnDevelop(err, 'orderDetail')
  })
}

const cart = (r) => {
  import(/* webpackChunkName: "orderDetail" */ './cart/index').then(function (home) {
    r(home.default)
  }).catch(function (err) {
    showErrorOnDevelop(err, 'cart')
  })
}

export default {
  index,
  detail,
  orderList,
  order,
  orderDetail,
  cart
}
