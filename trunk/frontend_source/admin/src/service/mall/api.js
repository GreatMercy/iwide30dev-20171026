// api v1版本
let API_URL_SUFFIX = '/index.php/iapi'
let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}/v1`

// V1版本
// HOTEL相关部分
let API_SOMA_V1 = `${API_URL_SUFFIX_V1}/soma`
// express(快递)相关部分
let API_EXPRESS_V1 = `${API_URL_SUFFIX_V1}/soma/express`
// gift_delivery(礼包派送)相关部分
let API_GIFT_DELIVERY = `${API_URL_SUFFIX_V1}/soma/gift_delivery`

const v1 = {
  // 获取商品套餐列表
  GET_PACKAGE_LIST_DATAS: `${API_SOMA_V1}/package/index`,
  // 邮寄发货
  POST_EXPRESS_DELIVERY: `${API_EXPRESS_V1}/create_other_shipping_order`,
  // 订单列表
  GET_EXPRESS_ORDER_LIST: `${API_EXPRESS_V1}/get_order_list`,
  // 物流列表
  GET_EXPRESS_LIST: `${API_EXPRESS_V1}/get_express_list`,
  // 导出订单列表
  GET_EXPRESS_EXPORT_ORDER_LIST: `${API_EXPRESS_V1}/export_order_list`,
  // 导入订单列表
  POST_EXPRESS_BATCH_POST: `${API_EXPRESS_V1}/batch_post`,
  // 上传csv
  POST_EXPRESS_UPLOAD: `${API_EXPRESS_V1}/do_upload`,
  // 批量下单至顺丰
  POST_EXPRESS_BATCH_CREATE_ORDER: `${API_EXPRESS_V1}/batch_create_order`,
  // 获取礼包列表
  GET_GIFT_DELIVERY_GIFT_LIST: `${API_GIFT_DELIVERY}/getGiftList`,
  // 获取可添加至礼包的商品列表
  GET_GIFT_DELIVERY_PRODUCT_IST: `${API_GIFT_DELIVERY}/getProductList`,
  // 选择商品
  POST_GIFT_DELIVERY_SELECT_GIFT: `${API_GIFT_DELIVERY}/selectAddGift`,
  // 删除商品
  DELETE_GIFT_DELIVERY_GIFT: `${API_GIFT_DELIVERY}/deleteProductGift`,
  // 礼物派送报表列表
  GET_GIFT_DELIVERY_GIFT_RECEIVE_LIST: `${API_GIFT_DELIVERY}/giftReceiveDetail`,
  // 导出礼包派送详情
  GET_GIFT_DELIVERY_EXPORT: `${API_GIFT_DELIVERY}/exportGiftExcel`
}

export {
  v1
}
