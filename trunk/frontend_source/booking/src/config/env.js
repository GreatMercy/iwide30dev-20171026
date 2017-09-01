let BASE_PATH = ''
let LOGIN_URL = ''
let HOTEL_PRICE_BASE_PATH = ''
let HOTEL_PRICE_EDIT_PATH = ''
let HOTEL_PRICE_PATH = ''
let HOTEL_PRICE_EDIT_URL = ''
let INTER_ID = 'a429262687'
let OPEN_ID = 'oX3WojhfNUD4JzmlwTzuKba1MywY'

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
  INTER_ID,
  OPEN_ID
}
