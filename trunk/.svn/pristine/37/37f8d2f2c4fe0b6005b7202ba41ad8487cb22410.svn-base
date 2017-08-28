import * as apiConfig from './api'
import ajax from '@/utils/http'

/**
 * 查询申请退款的订单
 * @param {Object} data get请求参数
 * @param {string} data.order_no 订单号
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getRefundOrder = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_REFUND_ORDER || apiConfig['v1'].GET_REFUND_ORDER
  return ajax.get(url, data)
}

/**
 * 申请退款
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const postrefund = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_REFUND || apiConfig['v1'].POST_REFUND
  return ajax.post(url, data, config)
}

/**
 * 获取公众号数据
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.inter_id] 公众号ID
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getPublics = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PUBLICS || apiConfig['v1'].GET_PUBLICS
  return ajax.get(url, data)
}

/**
 * 获取酒店数据
 * @param {Object} data get请求参数 {很多参数}
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getHotels = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTELS || apiConfig['v1'].GET_HOTELS
  return ajax.get(url, data)
}

/**
 * 银行账户管理列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.hotel_id] 门店ID
 * @param {string} [data.status] 验证状态
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.start_time] 验证时间 - 开始时间
 * @param {string} [data.end_time] 验证时间 - 结束时间
 * @param {string} [data.offset] 当前页码 （默认为1）
 * @param {string} [data.limit] 显示数量/页 （默认为20）
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getBankCheckAccount = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BANK_CHECK_ACCOUNT || apiConfig['v1'].GET_BANK_CHECK_ACCOUNT
  return ajax.get(url, data)
}

/**
 * 发起校验
 * @param {Object} data get请求参数 {很多参数}
 * @param {int} data.id 账户ID
 * @param {string} data.status 状态 发起验证：send, 重新验证：re_send
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const postCheckAccount = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_CHECK_ACCOUNT || apiConfig['v1'].POST_CHECK_ACCOUNT
  return ajax.post(url, data, config)
}

/**
 * 资金概览
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.hotel_id] 酒店ID
 * @param {string} [data.start_time] 转账时间 - 开始时间 2017-08-08
 * @param {string} [data.end_time] 转账时间 - 结束时间 2017-08-08
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getCapitalOverview = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_CAPITAL_OVERVIEW || apiConfig['v1'].GET_CAPITAL_OVERVIEW
  return ajax.get(url, data, config)
}

/**
 * 资金概览列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.inter_id] 公众号ID
 * @param {string} [data.hotel_id] 酒店ID
 * @param {string} [data.start_time] 转账时间 - 开始时间 2017-08-08
 * @param {string} [data.end_time] 转账时间 - 结束时间 2017-08-08
 * @param {string} [data.offset] 当前页码 （默认为1）
 * @param {string} [data.limit] 显示数量/页 （默认为20）
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getCapitalList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_CAPITAL_LIST || apiConfig['v1'].GET_CAPITAL_LIST
  return ajax.get(url, data, config)
}

/**
 * 转账列表
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.status] 状态
 * @param {string} [data.start_time] 转账时间 - 开始时间 2017-08-08
 * @param {string} [data.end_time] 转账时间 - 结束时间 2017-08-08
 * @param {string} [data.offset] 当前页码 （默认为1）
 * @param {string} [data.limit] 显示数量/页 （默认为20）
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getTransferAccounts = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_TRANSFER_ACCOUNTS || apiConfig['v1'].GET_TRANSFER_ACCOUNTS
  return ajax.get(url, data, config)
}

/**
 * 发起转账
 * @param {Object} data get请求参数 {很多参数}
 * @param {string} [data.status] 转账状态 ：send => 发起转账，re_send => 重新转账
 * @param {string} [data.id] 转账记录ID
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getSingleSend = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_SINGLE_SEND || apiConfig['v1'].GET_SINGLE_SEND
  return ajax.get(url, data, config)
}

export {
  getRefundOrder,
  postrefund,
  getPublics,
  getHotels,
  getBankCheckAccount,
  postCheckAccount,
  getCapitalOverview,
  getCapitalList,
  getTransferAccounts,
  getSingleSend
}
