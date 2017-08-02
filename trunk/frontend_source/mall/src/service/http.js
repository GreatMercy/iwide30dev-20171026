import * as apiConfig from './api'
import ajax from '@/utils/http'
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
 * 获取商品详情
 * @param  {Object} data    请求参数
 * @param  {String} data.pid 商品id
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] api版本
 * @return {Object}         返回商品详情
 */
const getPackageInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PACKAGE_INFO || apiConfig.v1.GET_PACKAGE_INFO
  return ajax.get(url, data, config)
}
/**
 * 获取推荐商品
 * @param  {Object} data    请求参数
 * @param  {Number} [data.page] 第几页
 * @param  {Number} [data.page_size] 每页有多少
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] api版本
 * @return {Object}         返回推荐商品
 */
const getPackageRecommendation = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PACKAGE_RECOMMENDATION || apiConfig.v1.GET_PACKAGE_RECOMMENDATION
  return ajax.get(url, data, config)
}
/**
 * 获取商品规格
 * @param  {Object} data    请求参数
 * @param  {String} data.pid 商品ID
 * @param  {Object} config  axios配置
 * @param  {String} [version='v1'] api版本
 * @return {Object}         返回商品规格
 */
const getPackageSpec = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PACKAGE_SPEC || apiConfig.v1.GET_PACKAGE_SPEC
  return ajax.get(url, data, config)
}
/**
 * 获取商品时间规格
 * @param  {Object} data    请求参数
 * @param  {String} data.pid 商品ID
 * @param  {String} data.bsn 业务类型
 * @param  {Object} config  axios配置
 * @param  {String} [version='v1'] api版本
 * @return {Object}         返回时间规格
 */
const getPackageTickTime = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PACKAGE_TICK_TIME || apiConfig.v1.GET_PACKAGE_TICK_TIME
  return ajax.get(url, data, config)
}
/**
 * 订阅秒杀提醒
 * @param  {Object} data    请求参数
 * @param  {Number} data.act_id 秒杀ID
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] api版本
 */
const postKillsecNotice = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_KILLSEC_NOTICE || apiConfig.v1.POST_KILLSEC_NOTICE
  return ajax.post(url, data, config)
}
/**
 * 获取秒杀库存数量
 * @param  {Object} data    请求参数
 * @param  {Number} data.act_id 秒杀ID
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] api版本
 */
const getKillsecStock = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_KILLSEC_STOCK || apiConfig.v1.GET_KILLSEC_STOCK
  return ajax.get(url, data, config)
}
/**
 * 获取秒杀资格
 * @param  {Object} data    请求参数
 * @param  {Number} data.act_id 秒杀ID
 * @param  {Number} data.inid 秒杀实例ID
 * @param  {Object} [config]  axios配置
 * @param  {String} [version='v1'] api版本
 */
const getKillsecRob = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_KILLSEC_ROB || apiConfig.v1.GET_KILLSEC_ROB
  return ajax.get(url, data, config)
}
/**
 * 获取赠送礼物内容
 * @param data 请求参数
 * @param  {Object} [config]  axios配置
 * @param {Number} data.aiid 资产ID
 * @param {Number} data.group 是否是群发，1是，2不是
 * @param {String} data.id 公众号ID
 * @param {String} data.bsn 业务类型
 * @param {Number} data.send_from 1表示来自礼物
 * @param {Number} data.send_order_id 订单ID
 * @param {String} [version='v1'] api版本
 */
const getPresentsPackage = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PRESENTS_PACKAGE || apiConfig.v1.GET_PRESENTS_PACKAGE
  return ajax.get(url, data, config)
}
/**
 * 赠送礼物
 * @param data 请求参数
 * @param {String} [version='v1'] api版本
 * @param {String} data.id 公众号ID
 * @param {String} data.msg 祝福语
 * @param {Number} data.tid 主题id
 * @param {Number} data.count_give 收礼人数
 * @param {Number} data.per_give 发出礼盒数，每人多少盒
 * @param {Number} data.is_group 是否是群发,1私人对私人 2群发礼物
 * @param {Number} data.send_from 1表示来自礼物
 * @param {Number} data.send_order_id 礼物源的订单号
 */
const postPresentsSendOut = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_PRESENTS_SEND_OUT || apiConfig.v1.POST_PRESENTS_SEND_OUT
  return ajax.post(url, data, config)
}
/**
 * 获取礼物列表
 * @param data 请求参数
 * @param  {Object} [config]  axios配置
 * @param {String} [version='v1'] api版本
 * @param {String} data.id 公众号ID
 * @param {String} data.gid 对应赠送礼物id
 */
const getPresentsList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PRESENTS_LIST || apiConfig.v1.GET_PRESENTS_LIST
  return ajax.get(url, data, config)
}
/**
 * 获取回退礼物详情的超链接
 * @param data 请求参数
 * @param  {Object} [config]  axios配置
 * @param {String} [version='v1'] api版本
 * @param {String} data.gid 赠送礼物的id
 */
const postPresentsReturnJump = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_PRESENTS_GIFT_RETURN_JUMP || apiConfig.v1.POST_PRESENTS_GIFT_RETURN_JUMP
  return ajax.post(url, data, config)
}
/**
 * 获取购买成功页二维码&链接
 * @param data 请求参数
 * @param {String} [version='v1'] api版本
 * @param {String} data.qr_code 二维码
 * @param {integer} data.subscribe_status 订阅状态 1：已关注 0：未关注
 */
const getSuccessPay = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PACKAGE_SUCCESS_PAY || apiConfig.v1.GET_PACKAGE_SUCCESS_PAY
  return ajax.get(url, data, config)
}
/**
 * 获取购买成功页二维码&链接
 * @param data 请求参数
 * @param {String} [version='v1'] api版本
 * @param {String} data.qr_code 二维码
 * @param {integer} data.subscribe_status 订阅状态 1：已关注 0：未关注
 */
const getSendSuccess = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PRESENTS_SEND_SUCCESS || apiConfig.v1.GET_PRESENTS_SEND_SUCCESS
  return ajax.get(url, data, config)
}

export {
  getPackageLists,
  getPackageInfo,
  getPackageRecommendation,
  getPackageSpec,
  getPackageTickTime,
  postKillsecNotice,
  getKillsecStock,
  getKillsecRob,
  getPresentsPackage,
  postPresentsSendOut,
  postPresentsReturnJump,
  getPresentsList,
  getSuccessPay,
  getSendSuccess
}
