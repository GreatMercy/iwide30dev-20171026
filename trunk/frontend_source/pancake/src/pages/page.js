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
const rank = (r) => {
  require.ensure([], function (require) {
    let rank = require('./rank/index')
    r(rank.default)
  }, showLoadError, 'rank')
}
const record = (r) => {
  require.ensure([], function (require) {
    let record = require('./record/index')
    r(record.default)
  }, showLoadError, 'record')
}
const coupon = (r) => {
  require.ensure([], function (require) {
    let coupon = require('./coupon/index')
    r(coupon.default)
  }, showLoadError, 'coupon')
}
export default {
  index,
  rank,
  record,
  coupon
}
