import * as apiConfig from './api'
import ajax from '@/utils/http'

/**
 * 获取价格码
 * @param {Object} data get请求参数
 * @param {number} [data.pcode] 请求的code
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getHotelPriceCode = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_PRICES_CODE_INFO || apiConfig['v1'].GET_HOTEL_PRICES_CODE_INFO
  console.log(url)
  return ajax.get(url, data, config)
}
/**
 `* 获取酒店门店及房型
 * @param {Object} data 请求参数
 * @param {string} data.page=1 分页
 * @param {number} data.size=10 每页数据条数
 * @param {string} data.keyword='' 搜索关键字
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 */
const getHotelRooms = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_ROOMS_LIST || apiConfig['v1'].GET_HOTEL_ROOMS_LIST
  return ajax.get(url, data, config)
}

/**
 `* 获取酒店门店及房型
 * @param {Object} data 请求参数
 * @param {string} data.pcode 价格代码
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 */
const getHotelRoomsByCode = (data = {}, config, version = 'v1') => {
  if (!data.pcode) {
    return Promise.reject({
      message: '请提供pcode参数',
      status: 404
    })
  }
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_ROOM_BY_CODE || apiConfig['v1'].GET_HOTEL_ROOM_BY_CODE
  return ajax.get(url, data, config)
}
/**
 * 获取酒店商品列表
 * @param {Object} data 请求参数
 * @param {string} data.page=1 分页
 * @param {number} data.size=20 每页数据条数
 * @param {string} [data.status] 商品状态 无值代表上架商品，all表示全部商品
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 */
const getHotelGoodsList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_HOTEL_GOODS_LIST || apiConfig['v1'].GET_HOTEL_GOODS_LIST
  return ajax.get(url, data, config)
}
/**
 * 修改酒店中商品信息
 * @param {Object} data 请求参数
 * @param {string} data.csrf_token csrf_token值, 这个key及value都是由服务器返回
 * @param {number} data.gid 商品编号
 * @param {number} data.hotel_price 商品价格
 * @param {number} data.gs_unit 商品份数
 * @param {object} config axios配置
 * @param {string} version api版本
 */
const postHotelGoodsInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_HOTEL_GOODS_INFO || apiConfig['v1'].POST_HOTEL_GOODS_INFO
  return ajax.post(url, data, config)
}
/**
 * 修改酒店中商品信息
 * @param {Object} data 请求参数
 * @param {string} data.csrf_token csrf_token值, 这个key及value都是由服务器返回
 * @param {number} data.gid 商品编号
 * @param {number} data.hotel_price 商品价格
 * @param {number} data.gs_unit 商品份数
 * @param {object} config axios配置
 * @param {string} version api版本
 */
const postHotelPricesCode = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_HOTEL_PRICES_CODE_INFO || apiConfig['v1'].POST_HOTEL_PRICES_CODE_INFO
  return ajax.post(url, data, config)
}
export {
  getHotelPriceCode,
  getHotelRooms,
  getHotelGoodsList,
  postHotelGoodsInfo,
  getHotelRoomsByCode,
  postHotelPricesCode
}
