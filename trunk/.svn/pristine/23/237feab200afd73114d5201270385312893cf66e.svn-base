import { coupon } from './api'
import ajax from '@/utils/http'

/**
 * 发送任务配置
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @return {Promise} 返回一个promise
 */
const getCouponCode = (data, config) => {
  let url = coupon.GET_COUPON_CODE_INFO
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
  let url = coupon.GET_COUPON_LIST
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
  let url = coupon.GET_COUPON_CONTENT_DETAIL
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
  let url = coupon.GET_REQUEST_CONTENT_INFO
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
  let url = coupon.GET_REQUEST_CONTENT_LIST
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
  let url = coupon.GET_REQUEST_CONTENT_DETAIL
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
  let url = coupon.GET_REQUEST_CONTENT_DELETE
  return ajax.post(url, data)
}
export { getCouponCode, getCouponList, getCouponDetail, getRequestInfo, getRequestContent, getRequestDetail, getRequestDetele }
