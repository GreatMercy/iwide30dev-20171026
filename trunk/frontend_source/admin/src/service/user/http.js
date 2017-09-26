import { user } from './api'
import ajax from '@/utils/http'

/**
 * 发送任务配置
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getCouponCode = (data, config) => {
  let url = user.GET_COUPON_CODE_INFO
  return ajax.get(url, data)
}
/**
 * 发送任务列表
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getCouponList = (data, config) => {
  let url = user.GET_COUPON_LIST
  return ajax.get(url, data)
}
/**
 * 发送任务详情
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getCouponDetail = (data, config) => {
  let url = user.GET_COUPON_CONTENT_DETAIL
  return ajax.get(url, data)
}
/**
 * 新建任务配置
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getRequestInfo = (data, config) => {
  let url = user.GET_REQUEST_CONTENT_INFO
  return ajax.post(url, data, config)
}
/**
 * 请求任务列表
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getRequestContent = (data, config) => {
  let url = user.GET_REQUEST_CONTENT_LIST
  return ajax.get(url, data)
}
/**
 * 请求任务详情
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getRequestDetail = (data, config) => {
  let url = user.GET_REQUEST_CONTENT_DETAIL
  return ajax.get(url, data)
}
/**
 * 删除任务
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getRequestDetele = (data, config) => {
  let url = user.GET_REQUEST_CONTENT_DELETE
  return ajax.post(url, data)
}
/**
 * 注册分销
 */
const getRegStatements = (data, config) => {
  let url = user.GET_REG_STATEMENTS
  return ajax.get(url, data)
}
/**
 * 充值与购卡接口地址
 */
const getDepostStatements = (data, config) => {
  let url = user.GET_DEPOST_STATEMENTS
  return ajax.get(url, data)
}
/**
 * 酒店列表
 */
const getHotelList = (data, config) => {
  let url = user.GET_HOTEL_LIST
  return ajax.get(url, data)
}
/**
 * 粉丝分析
 */
const getFansReport = (data, config) => {
  let url = user.GET_FANS_REPORT
  return ajax.get(url, data)
}
/**
 * 群发图文统计
 */
const getArticleTotal = (data, config) => {
  let url = user.GET_ARTICLE_TOTAL
  return ajax.get(url, data)
}
/**
 * 储值数据分析
 */
const getBalanceAnalysis = (data, config) => {
  let url = user.GET_BALANCE_ANALYSIS
  return ajax.get(url, data)
}
/**
 * 指定日期下的储值数据分析
 */
const getBalanceAnalysisBydate = (data, config) => {
  let url = user.GET_BALANCE_ANALYSIS_BYDATE
  return ajax.get(url, data)
}
/**
 * 积分数据分析
 */
const getCreditAnalysis = (data, config) => {
  let url = user.GET_CREDIT_ANALYSIS
  return ajax.get(url, data)
}
/**
 * 指定日期下的积分数据分析
 */
const getCreditAnalysisBydate = (data, config) => {
  let url = user.GET_CREDIT_ANALYSIS_BYDATE
  return ajax.get(url, data)
}
export {
  getCouponCode,
  getCouponList,
  getCouponDetail,
  getRequestInfo,
  getRequestContent,
  getRequestDetail,
  getRequestDetele,
  getRegStatements,
  getDepostStatements,
  getHotelList,
  getFansReport,
  getArticleTotal,
  getBalanceAnalysis,
  getBalanceAnalysisBydate,
  getCreditAnalysis,
  getCreditAnalysisBydate
}
