import * as apiConfig from './api'
import ajax from '@/utils/http'

/**
 * 获取绑定的公众号信息
 * @param  {String} token    请求参数
 */
const getAccountData = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BIND_PUBLIC || apiConfig.v1.GET_BIND_PUBLIC
  return ajax.get(url, data, config)
}
/**
 * 绑定微信
 * @param  {String} token    请求参数
 */
const putBindWx = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_BIND_WX || apiConfig.v1.GET_BIND_WX
  return ajax.put(url, data, config)
}
/**
 * 二维码登录
 * @param  {String} token    请求参数
 * @param  {String} admin_id    请求参数
 */
const postQrLogin = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_QR_LOGIN || apiConfig.v1.POST_QR_LOGIN
  return ajax.post(url, data, config)
}
export {
  getAccountData,
  putBindWx,
  postQrLogin
}
