// api v1版本
let API_URL_SUFFIX = '/index.php/iapi'
// let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}/v1`

let API_LOGIN = `${API_URL_SUFFIX}/authority/auth`
// let API_CODE_V1 = `${API_URL_SUFFIX_V1}/authorize/auth`

const v1 = {
  // 获取绑定的公众号列表
  GET_BIND_PUBLIC: (process.env.NODE_ENV === 'development') ? `${API_LOGIN}/getAccount?debug=1` : `${API_LOGIN}/getAccount`,
  // 绑定微信
  GET_BIND_WX: (process.env.NODE_ENV === 'development') ? `${API_LOGIN}/bindAccount?debug=1` : `${API_LOGIN}/bindAccount`,
  // 二维码确认登陆
  POST_QR_LOGIN: (process.env.NODE_ENV === 'development') ? `${API_LOGIN}/qrLogin?debug=1` : `${API_LOGIN}/qrLogin`
}

export {
  v1
}
