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
/**
 * 获取皮肤信息
 * @param {Object} data 请求参数
 * @param {string} data.id inter_id
 * @param {object} config axios配置
 * @param {string} version api版本
 */
const getSkinIndex = (data, config, version = '') => {
  let url = apiConfig[version] && apiConfig[version].GET_SKIN_INDEX || apiConfig['v1'].GET_SKIN_INDEX
  return ajax.get(url, data, config)
}

/**
 * 选择皮肤
 * @param {Object} data 请求参数
 * @param {string} data.skin_name 皮肤名
 * @param {object} config axios配置
 * @param {string} version api版本
 */
const postSaveSkin = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_SAVE_SKIN || apiConfig['v1'].POST_SAVE_SKIN
  return ajax.post(url, data, config)
}

/**
 * 获取皮肤设置
 * @param {Object} data 请求参数
 * @param {string} data.skin_name 皮肤名
 * @param {string} data.id 公众号
 * @param {object} config axios配置
 * @param {string} version api版本
 */
const getSkinSetting = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_SKIN_SETTING || apiConfig['v1'].GET_SKIN_SETTING
  return ajax.get(url, data, config)
}

/**
 * 删除轮播图
 * @param {Object} data 请求参数
 * @param {string} data.id 轮播图id
 * @param {object} config axios配置
 * @param {string} version api版本
 */
const postSkinDelFocus = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_SKIN_DEL_FOCUS || apiConfig['v1'].POST_SKIN_DEL_FOCUS
  return ajax.post(url, data, config)
}

/**
 * 保存皮肤详情配置
 * @param {Object} data 请求参数
 * @param {string} data.share_setting 分享设置
 * @param {string} data.roasting_setting 轮播图设置
 * @param {string} data.font_setting 字体设置
 * @param {string} data.home_setting 首页设置
 * @param {object} config axios配置
 * @param {string} version api版本
 */
const postSkinSaveSetting = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_SKIN_SAVE_SETTING || apiConfig['v1'].POST_SKIN_SAVE_SETTING
  return ajax.post(url, data, config)
}
export {
  getHotelPriceCode,
  getHotelRooms,
  getHotelGoodsList,
  postHotelGoodsInfo,
  getHotelRoomsByCode,
  postHotelPricesCode,
  getSkinIndex,
  postSaveSkin,
  getSkinSetting,
  postSkinDelFocus,
  postSkinSaveSetting
}
