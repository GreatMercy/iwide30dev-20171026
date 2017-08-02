// api v1版本
let API_URL_SUFFIX = '/index.php/iapi'
let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}/soma`

// 商品相关部分
let API_PACKAGE_V1 = `${API_URL_SUFFIX_V1}/package`
// 秒杀相关
let API_KILLSEC_V1 = `${API_URL_SUFFIX_V1}/killsec`
// 订单相关
let API_ORDER_V1 = `${API_URL_SUFFIX_V1}/order`
// 赠送礼物相关
let API_PRESENTS_V1 = `${API_URL_SUFFIX_V1}/presents`
const v1 = {
  // 请求商品列表
  GET_PACKAGE_LISTS: `${API_PACKAGE_V1}/list`,
  // 请求商品详情
  GET_PACKAGE_INFO: `${API_PACKAGE_V1}/info`,
  // 请求推荐商品
  GET_PACKAGE_RECOMMENDATION: `${API_PACKAGE_V1}/recommended`,
  // 获取商品规格
  GET_PACKAGE_SPEC: `${API_PACKAGE_V1}/spec`,
  // 获取时间多规格
  GET_PACKAGE_TICK_TIME: `${API_PACKAGE_V1}/ticket_time`,
  // 订阅秒杀提醒
  POST_KILLSEC_NOTICE: `${API_KILLSEC_V1}/notice`,
  // 秒杀库存
  GET_KILLSEC_STOCK: `${API_KILLSEC_V1}/stock`,
  // 获取秒杀资格
  GET_KILLSEC_ROB: `${API_KILLSEC_V1}/rob`,
  // 订单列表
  GET_ORDER_LIST: `${API_ORDER_V1}/index`,
  // 下单
  POST_ORDER: `${API_ORDER_V1}/index`,
  // 请求赠送礼物内容
  GET_PRESENTS_PACKAGE: `${API_PRESENTS_V1}/package`,
  // 赠送礼物
  POST_PRESENTS_SEND_OUT: `${API_PRESENTS_V1}/send_out`,
  // 请求我收到的礼物列表
  GET_PRESENTS_RECEIVED: `${API_PRESENTS_V1}/received`,
  // 请求我送出的礼物列表
  GET_PRESENTS_SEND_LIST: `${API_PRESENTS_V1}/sent_list`,
  // 请求购买成功页二维码&再次购买链接
  GET_PACKAGE_SUCCESS_PAY: `${API_PACKAGE_V1}/success_pay`,
  // 请求礼物列表
  GET_PRESENTS_LIST: `${API_PRESENTS_V1}/received_list`,
  // 请求回退礼物详情的超链接
  POST_PRESENTS_GIFT_RETURN_JUMP: `${API_PRESENTS_V1}/gift_return_jump`,
  // 请求转赠成功
  GET_PRESENTS_SEND_SUCCESS: `${API_PRESENTS_V1}/gift_send_success`
}
export {
  v1
}
