// api v1版本
let API_URL_SUFFIX = '/index.php/iapi'
let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}/v1`

// V1版本
// HOTEL相关部分
let API_HOTEL_V1 = `${API_URL_SUFFIX_V1}/hotel`
// express(快递)相关部分
let API_EXPRESS_V1 = `${API_URL_SUFFIX_V1}/some/express`
// http://dev.iwide30.admin.com/index.php/iapi/v1/soma/express/createShippingOrder
const v1 = {
  // 价格码
  GET_HOTEL_PRICES_CODE_INFO: `${API_HOTEL_V1}/prices/code_edit`,
  // 房型
  GET_HOTEL_ROOMS_LIST: `${API_HOTEL_V1}/rooms/get_rooms`,
  // 获取商品
  GET_HOTEL_GOODS_LIST: `${API_HOTEL_V1}/goods/get_list`,
  // 修改商品订房价格 单位
  POST_HOTEL_GOODS_INFO: `${API_HOTEL_V1}/goods/edit_post`,
  // 通过pcode获取价格代码已经设置的酒店和房型
  GET_HOTEL_ROOM_BY_CODE: `${API_HOTEL_V1}/rooms/get_rooms_by_code`,
  // 提交价格代码配置
  POST_HOTEL_PRICES_CODE_INFO: `${API_HOTEL_V1}/prices/edit_code_post`,
  // 邮寄发货
  POST_EXPRESS_DELIVERY: `${API_EXPRESS_V1}/create_shipping_order`,
  // 皮肤管理首页
  GET_SKIN_INDEX: `${API_HOTEL_V1}/skin/index`,
  // 选择皮肤
  POST_SAVE_SKIN: `${API_HOTEL_V1}/skin/save_skin`,
  // 获取皮肤详情
  GET_SKIN_SETTING: `${API_HOTEL_V1}/skin/get_setting`,
  // 删除轮播图
  POST_SKIN_DEL_FOCUS: `${API_HOTEL_V1}/skin/del_focus`,
  // 保存皮肤详情配置
  POST_SKIN_SAVE_SETTING: `${API_HOTEL_V1}/skin/save_setting`
}

export {
  v1
}
