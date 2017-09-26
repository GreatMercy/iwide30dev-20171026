// 数据分析接口

// api v1版本
let API_URL_SUFFIX = '/index.php/iapi'
let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}/v1`

// V1版本
// HOTEL相关部分
let API_HOTEL_V1 = `${API_URL_SUFFIX_V1}/hotel`

const v1 = {
  GET_HOTELS_LIST: `${API_HOTEL_V1}/hotel/get_hotels`
}

export {
  v1
}
