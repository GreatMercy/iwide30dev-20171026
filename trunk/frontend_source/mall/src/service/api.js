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
// 地址相关
let API_EXPRESS_V1 = `${API_URL_SUFFIX_V1}/express`
// 退款相关
let API_REFUND_V1 = `${API_URL_SUFFIX_V1}/refund`
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
  // 获取使用券
  GET_PACKAGE_COUPONS: `${API_PACKAGE_V1}/coupons`,
  // 获取活动
  GET_PACKAGE_RULE: `${API_PACKAGE_V1}/rule`,
  // 订阅秒杀提醒
  POST_KILLSEC_NOTICE: `${API_KILLSEC_V1}/notice`,
  // 秒杀库存
  GET_KILLSEC_STOCK: `${API_KILLSEC_V1}/stock`,
  // 获取秒杀资格
  GET_KILLSEC_ROB: `${API_KILLSEC_V1}/rob`,
  // 准备下单数据
  GET_ORDER_PAY: `${API_ORDER_V1}/pay`,
  // 订单列表
  GET_ORDER_LIST: `${API_ORDER_V1}/index`,
  // 下单
  POST_ORDER_CREATE: `${API_ORDER_V1}/create`,
  // 订单详情页
  GET_ORDER_DETAIL: `${API_ORDER_V1}/detail`,
  // 微信订房 - 选酒店方型
  GET_HOTEL_LIST: `${API_ORDER_V1}/wx_select_hotel`,
  // 微信订房 - 价格日历 - 信息
  GET_HOTEL_INFO: `${API_ORDER_V1}/select_hotel_info`,
  // 微信订房 - 价格日历 - 日历可预订时间
  GET_HOTEL_TIME: `${API_ORDER_V1}/select_hotel_time`,
  // 微信订房 - 下单
  POST_HOTEL_BOOKING: `${API_ORDER_V1}/booking`,
  // 赠送内容
  GET_PRESENTS_PACKAGE: `${API_PRESENTS_V1}/package`,
  // 确定赠送
  POST_PRESENTS_SEND_OUT: `${API_PRESENTS_V1}/send_out`,
  // 请求我收到的礼物列表
  GET_PRESENTS_RECEIVED: `${API_PRESENTS_V1}/received`,
  // 请求我送出的礼物列表
  GET_PRESENTS_SEND_LIST: `${API_PRESENTS_V1}/sent_list`,
  // 请求购买成功页二维码&再次购买链接
  GET_PACKAGE_SUCCESS_PAY: `${API_PACKAGE_V1}/success_pay`,
  // 请求接收人礼物列表
  GET_PRESENTS_RECEIVED_LIST: `${API_PRESENTS_V1}/received_list`,
  // 请求回退礼物详情的超链接
  POST_PRESENTS_GIFT_RETURN_JUMP: `${API_PRESENTS_V1}/gift_return_jump`,
  // 请求转赠成功
  GET_PRESENTS_SEND_SUCCESS: `${API_PRESENTS_V1}/gift_send_success`,
  // 礼物的信息（可领取）
  GET_PRESENTS_VALIDATE_GIFT_ORDER: `${API_PRESENTS_V1}/validate_gift_order`,
  // 礼物的信息（不可领取）
  GET_PRESENTS_INVALID_GIFT_ORDER: `${API_PRESENTS_V1}/invalidate_gift_order`,
  // 打开礼物
  POST_PRESENTS_RECEIVE_PROCESS: `${API_PRESENTS_V1}/receive_process`,
  // 删除礼物订单
  DELETE_PRESENTS_GIFT_ORDER: `${API_PRESENTS_V1}/gift_order`,
  // 请求订单中心我的礼物列表
  GET_PRESENTS_MINE_LIST: `${API_PRESENTS_V1}/mine_list`,
  // 收到的赠送订单详情
  GET_PRESENTS_RECEIVED_GIFT_DETAIL: `${API_PRESENTS_V1}/received_gift_detail`,
  // 删除订单
  DELETE_ORDER: `${API_ORDER_V1}/index`,
  // 保存地址数据
  POST_EXPRESS_SAVE: `${API_EXPRESS_V1}/save`,
  // 获取地址数据
  GET_EXPRESS_TREE: `${API_EXPRESS_V1}/tree`,
  // 请求客房预定信息
  GET_ORDER_PACKAGE_BOOKING: `${API_ORDER_V1}/package_booking`,
  // 请求到店用卷信息
  GET_ORDER_PACKAGE_USAGE: `${API_ORDER_V1}/package_usage`,
  // 请求退款内容
  GET_REFUND: `${API_REFUND_V1}/index`,
  // 提交退款申请
  POST_REFUND_APPLY: `${API_REFUND_V1}/apply`,
  // 请求退款详情
  GET_REFUND_DETAIL: `${API_REFUND_V1}/detail`
}
export {
  v1
}
