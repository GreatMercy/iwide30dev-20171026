let BASE_PATH = ''
let LOGIN_URL = ''
let HOTEL_PRICE_BASE_PATH = ''
let HOTEL_PRICE_EDIT_PATH = ''
let HOTEL_PRICE_PATH = ''
let HOTEL_PRICE_EDIT_URL = ''
// let INTER_ID = 'a421641095'
let INTER_ID = 'a450089706'
// 订房后台新版皮肤公众号
// let INTER_ID = 'a426755343'

if (process.env.NODE_ENV !== 'development') {
  BASE_PATH = '/index.php'
  LOGIN_URL = '/index.php/privilege/auth/login?redirect='
  HOTEL_PRICE_BASE_PATH = 'hotel/prices'
  HOTEL_PRICE_EDIT_PATH = 'code_edit'
  HOTEL_PRICE_PATH = `${BASE_PATH}/${HOTEL_PRICE_BASE_PATH}`
  HOTEL_PRICE_EDIT_URL = `${HOTEL_PRICE_PATH}/${HOTEL_PRICE_EDIT_PATH}`
}
console.log(BASE_PATH, LOGIN_URL, HOTEL_PRICE_EDIT_URL)

export {
  BASE_PATH,
  LOGIN_URL,
  HOTEL_PRICE_EDIT_URL,
  INTER_ID
}
