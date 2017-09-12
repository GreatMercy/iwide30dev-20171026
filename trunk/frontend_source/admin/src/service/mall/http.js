import * as apiConfig from './api'
import ajax from '@/utils/http'

/**
 * 获取套餐产品列表
 * @param {Object} data get请求参数
 * @param {number} [data.page] 请求的页码数
 * @param {number} [data.status] 商品的状态值 0: 所有商品 1:上架中商品 3: 已下架商品
 * @param {string} [data.word] 商品关键字
 * @param {number} [data.cat] 商品分类
 * @param {string} [data.sortid] ID排序 asc: 升序 desc: 降序
 * @param {string} [data.sortprice] 价格排序 asc: 升序 desc: 降序
 * @param {string} [data.sortstock] 库存排序 asc: 升序 desc: 降序
 * @param {string} [data.sortdate] 创建时间排序 asc: 升序 desc: 降序
 * @param {string} [data.sort] 优先级排序 asc: 升序 desc: 降序
 * @param {object} config axios配置
 * @param {string} [version=v1] api版本
 * @return {Promise} 返回一个promise
 */
const getPackageListDatas = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PACKAGE_LIST_DATAS || apiConfig['v1'].GET_PACKAGE_LIST_DATAS
  return ajax.get(url, data, config)
}

/**
 * 订单邮寄 发货
 * @param {string} data.shipping_id
 * @param {string} data.distributor 快递服务提供商
 * @param {string} data.tracking_no 快递单号
 */
const postExpressDelivery = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_EXPRESS_DELIVERY || apiConfig['v1'].POST_EXPRESS_DELIVERY
  return ajax.post(url, data, config)
}

/**
 * 邮寄订单列表
 * @param {string} data.like 条件
 * @param {number} data.status 1 未发货 2 发货 空值为全部
 * @param {string} data.begin_time 开始时间
 * @param {string} data.end_time 结束时间
 * @param {number} data.page_num 当前的页数
 * @param {number} data.page_size 一页多少条
 * @param {number} data.type 类型
 * */
const getExpressOrderList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_EXPRESS_ORDER_LIST || apiConfig['v1'].GET_EXPRESS_ORDER_LIST
  return ajax.get(url, data, config)
}

/**
 * 获取物流下拉列表
 * */
const getExpressList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_EXPRESS_LIST || apiConfig['v1'].GET_EXPRESS_LIST
  return ajax.get(url, data, config)
}

/**
 * 邮寄批量导入
 * */
const postExpressBatchPost = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_EXPRESS_BATCH_POST || apiConfig['v1'].POST_EXPRESS_BATCH_POST
  return ajax.post(url, data, config)
}

/**
 * 邮寄批量下单
 * @param {string} data.shipping_id
 */
const postExpressBatchCreateOrder = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_EXPRESS_BATCH_CREATE_ORDER || apiConfig['v1'].POST_EXPRESS_BATCH_CREATE_ORDER
  return ajax.post(url, data, config)
}
/**
 * 获取礼包列表
 * @param {Number} data.page 分页
 */
const getGiftPackagesList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_GIFT_DELIVERY_GIFT_LIST || apiConfig['v1'].GET_GIFT_DELIVERY_GIFT_LIST
  return ajax.get(url, data, config)
}
/**
 * 获取可以配送的商品列表
 * @param {String} data.name 搜索关键字
 */
const getGiftProductList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_GIFT_DELIVERY_PRODUCT_IST || apiConfig['v1'].GET_GIFT_DELIVERY_PRODUCT_IST
  return ajax.get(url, data, config)
}
/**
 * 选择商品添加礼包
 * @param {String} data.start_time 开始时间
 * @param {String} data.end_time 结束时间
 * @param {String} data.product_id 添加至礼包的商品id （单个或多个）
 */
const postGiftProduct = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_GIFT_DELIVERY_SELECT_GIFT || apiConfig['v1'].POST_GIFT_DELIVERY_SELECT_GIFT
  return ajax.post(url, data, config)
}
/**
 * 删除礼包
 * @param data.product_id 商品id
 */
const postDeleteGiftProduct = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].DELETE_GIFT_DELIVERY_GIFT || apiConfig['v1'].DELETE_GIFT_DELIVERY_GIFT
  return ajax.post(url, data, config)
}
export {
  getPackageListDatas,
  postExpressDelivery,
  getExpressOrderList,
  postExpressBatchPost,
  postExpressBatchCreateOrder,
  getExpressList,
  getGiftPackagesList,
  getGiftProductList,
  postGiftProduct,
  postDeleteGiftProduct
}
