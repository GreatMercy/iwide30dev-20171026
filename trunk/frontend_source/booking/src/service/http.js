import * as apiConfig from './api'
import ajax from '@/utils/http'

/**
 * 获取酒店评论详情
 * @param  {Number} data.h  酒店id
 */
const getCommentContent = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_COMMENT_CONTENT || apiConfig.v1.GET_COMMENT_CONTENT
  return ajax.get(url, data, config)
}
/**
 * 获取酒店详情
 * @param  {Number} data.h  酒店id
 */
const getHotelIntDetail = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_INT_DETAIL || apiConfig.v1.GET_HOTEL_INT_DETAIL
  return ajax.get(url, data, config)
}
/**
 * 获取酒店相册
 * @param  {Number} data.h  酒店id
 */
const getHotelAlbum = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_ALBUM || apiConfig.v1.GET_HOTEL_ALBUM
  return ajax.get(url, data, config)
}
/**
 * 订单详情取消订单
 * @param  {Number} data.oid       请求参数
 */
const getCancelOrder = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_CANCEL_ORDER || apiConfig.v1.GET_CANCEL_ORDER
  return ajax.get(url, data, config)
}
/**
 * 获取商品首页信息
 * @param  {Object} data    请求参数
 * @param  {Number} [data.page] 页数
 * @param  {Number} [data.page_size=20] 每一页的个数
 * @param  {Number} [data.show_ads_cat=2] 是否显示广告与分类 1显示 2不显示
 * @param  {Number} [data.fcid] 分类ID
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] API版本
 * @return {Object}         首页信息
 */
const getPackageLists = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PACKAGE_LISTS || apiConfig.v1.GET_PACKAGE_LISTS
  return ajax.get(url, data, config)
}
/**
 * 获取商品首页banner
 * @param  {Object} data    请求参数
 * @param  {Object} [config]  axios配置
 */
const getBannerList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BANNER_LIST || apiConfig.v1.GET_BANNER_LIST
  return ajax.get(url, data, config)
}
/**
 * 获取订单列表
 * @param  {Object} data    请求参数
 * @param  {Object} config  请求参数
 */
const getOrderData = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_ORDER_DATA || apiConfig.v1.GET_ORDER_DATA
  return ajax.get(url, data, config)
}
/**
 * 获取百度api搜索地址
 * @param  {Object} data    请求参数
 * @param  {Object} [config]  axios配置
 */
const getBaiduSearchPlaceList = (data, config) => {
  let url = apiConfig.v1.GET_BAIDUSEARCH_LIST
  return ajax.get(url, data, config)
}

/**
 * 异步获取酒店列表
 * @param  {Object} data    请求参数
 * @param  {Object} [config]  axios配置
 */
const getAjaxHotelList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_AJAX_HOTEL_LIST || apiConfig.v1.GET_AJAX_HOTEL_LIST
  return ajax.get(url, data, config)
}

/**
 * 获取房态列表（酒店预订）
 * @param  {Object} data    请求参数
 * @param  {Object} [config]  axios配置
 */
const getHotelIndex = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_INDEX || apiConfig.v1.GET_HOTEL_INDEX
  return ajax.get(url, data, config)
}

/**
 *   获取微信配置
 *
 */
const GetWeixinConfig = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_WEIXIN_CONFIG || apiConfig.v1.GET_WEIXIN_CONFIG
  return ajax.get(url, data, config)
}
/**
 * 获取订单详情
 * @param  无    请求参数
 */
const getOrderDetail = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_ORDER_DETAIL || apiConfig.v1.GET_ORDER_DETAIL
  return ajax.get(url, data, config)
}
/**
 * 获取酒店详情
 * @params 请求参数
 * @params  {Number} data.h 酒店id
 * @params  {Number} data.r 房型id
 */
const getHotelDetail = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_DETAIL || apiConfig.v1.GET_HOTEL_DETAIL
  return ajax.post(url, data, config)
}
/**
 * 获取酒店详情
 * @data 请求参数
 * @data.h 酒店id
 * @data.r 房型id
 */
const getBookroomDetail = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BOOKROOM_DETAIL || apiConfig.v1.GET_BOOKROOM_DETAIL
  return ajax.post(url, data, config)
}
/**
 * 填写订单优惠券接口
 * @data 请求参数
 * @data.h 酒店id
 * @data.r 房型id
 */
const getBookroomCoupon = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BOOKROOM_COUPON || apiConfig.v1.GET_BOOKROOM_COUPON
  return ajax.post(url, data, config)
}
/**
 * 填写订单积分接口
 * @data 请求参数
 * @data.h 酒店id
 * @data.r 房型id
 */
const getBookroomBonus = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BOOKROOM_BONUS || apiConfig.v1.GET_BOOKROOM_BONUS
  return ajax.post(url, data, config)
}
/**
 * 填写订单判断积分支付
 * @data 请求参数
 * @data.h 酒店id
 * @data.r 房型id
 */
const getPointpaySet = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_POINTPAY_SET || apiConfig.v1.GET_POINTPAY_SET
  return ajax.post(url, data, config)
}
/**
 * 提交订单接口
 * @data 请求参数
 * @data.h 酒店id
 * @data.r 房型id
 */
const postSaveOrder = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_SAVE_ORDER || apiConfig.v1.POST_SAVE_ORDER
  return ajax.post(url, data, config)
}
/**
 * 获取订单详情
 * @param  {Object}  data    请求参数
 * @param  {Number} [data.oid] 订单id
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] API版本
 * @return {Object}         首页信息
 */
const getCommentOrderDetail = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].TO_COMMENT || apiConfig.v1.TO_COMMENT
  return ajax.get(url, data, config)
}
/**
 * 提交评价
 * @param  {Object}  data    请求参数
 * @param  {Number} [data.hotel_id] 酒店id
 * @param  {Number} [data.orderid]  订单编号
 * @param  {String} [data.content]  内容
 * @param  {Object} [data.img_url]  图片列表
 * @param  {Number} [data.service_score]  服务分数
 * @param  {Number} [data.net_score]      网络分数
 * @param  {Number} [data.facilities_score]  设施分数
 * @param  {Number} [data.clean_score]    卫生分数
 * @param  {String} [data.hotel_name]     酒店名称
 * @param  {String} [data.room_name]      房间名称
 * @param  {Object} [data.sign]     标签
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] API版本
 * @return {Object}         首页信息
 */
const submitComment = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].NEW_COMMENT_SUB || apiConfig.v1.NEW_COMMENT_SUB
  return ajax.post(url, data, config)
}
export {
  getCommentContent,
  getHotelIntDetail,
  getHotelAlbum,
  getCancelOrder,
  getPackageLists,
  getBannerList,
  getOrderData,
  getBaiduSearchPlaceList,
  getAjaxHotelList,
  GetWeixinConfig,
  getHotelIndex,
  getOrderDetail,
  getHotelDetail,
  getBookroomDetail,
  getBookroomCoupon,
  getBookroomBonus,
  getPointpaySet,
  postSaveOrder,
  getCommentOrderDetail,
  submitComment
}
