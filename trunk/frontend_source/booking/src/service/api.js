// api v1版本
let API_URL_SUFFIX = '/index.php/iapi'
let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}/soma`

// 商品相关部分
let API_PACKAGE_V1 = `${API_URL_SUFFIX_V1}/package`
// 酒店相关
let API_HOTEL_V1 = `${API_URL_SUFFIX}/hotel`
const v1 = {
  // 获取评论内容
  GET_COMMENT_CONTENT: `${API_HOTEL_V1}/hotel/hotel_comment`,
  // 获取酒店详情
  GET_HOTEL_INT_DETAIL: `${API_HOTEL_V1}/hotel/hotel_detail`,
  // 获取酒店相册
  GET_HOTEL_ALBUM: `${API_HOTEL_V1}/hotel/hotel_photo`,
  // 取消订单
  GET_CANCEL_ORDER: `${API_HOTEL_V1}/hotel/cancel_main_order`,
  // 请求商品列表
  GET_PACKAGE_LISTS: `${API_PACKAGE_V1}/list`,
  // 请求首页banner
  GET_BANNER_LIST: `${API_HOTEL_V1}/hotel/search`,
  // 异步获取酒店列表
  GET_AJAX_HOTEL_LIST: `${API_HOTEL_V1}/check/ajax_hotel_list`,
  // 请求百度搜索地址
  GET_BAIDUSEARCH_LIST: `http://api.map.baidu.com/place/v2/search`,
  // 获取微信配置
  GET_WEIXIN_CONFIG: `${API_HOTEL_V1}/weixin/js/config/location`,
  // 请求房态列表（酒店预订）
  GET_HOTEL_INDEX: `${API_HOTEL_V1}/hotel/index`,
  // 我的订单 -->获取订单列表
  GET_ORDER_DATA: `${API_HOTEL_V1}/hotel/myorder`,
  // 我的订单 -->订单详情
  GET_ORDER_DETAIL: `${API_HOTEL_V1}/hotel/orderdetail`,
  // 获取房型信息详情
  GET_HOTEL_DETAIL: `${API_HOTEL_V1}/hotel/return_room_detail`,
  // 填写订单信息页接口
  GET_BOOKROOM_DETAIL: `${API_URL_SUFFIX}/hotel/hotel/bookroom`,
  // 填写订单优惠券接口
  GET_BOOKROOM_COUPON: `${API_URL_SUFFIX}/hotel/hotel/return_usable_coupon`,
  // 填写订单积分接口
  GET_BOOKROOM_BONUS: `${API_URL_SUFFIX}/hotel/hotel/return_point_set`,
  // 填写订单判断积分支付接口
  GET_POINTPAY_SET: `${API_URL_SUFFIX}/hotel/hotel/return_pointpay_set`,
  // 提交订单接口
  POST_SAVE_ORDER: `${API_HOTEL_V1}/hotel/saveorder`,
  // 提交订单接口
  TO_COMMENT: `${API_HOTEL_V1}/hotel/to_comment`,
  // 提交评论接口
  NEW_COMMENT_SUB: `${API_HOTEL_V1}/hotel/new_comment_sub`
}
export {
  v1
}
