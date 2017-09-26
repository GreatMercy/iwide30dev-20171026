import * as apiConfig from './api'
import ajax from '@/utils/http'

/**
 * 获取订房数据统计酒店
 * @param {Object} data 请求参数
 * @param {Object} [config] axios参数
 * @param {String} [version='v1'] api版本
 */
const getHotelsList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTELS_LIST || apiConfig['v1'].GET_HOTELS_LIST
  return ajax.get(url, data, config)
}

export {
  getHotelsList
}
