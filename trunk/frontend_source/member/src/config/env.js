let BASE_PATH = ''
let LOGIN_URL = ''
let ID = 'a484619482'
let OPENID = 'oX3WojklzII6FwXZkN2ob0MpBzHo'

if (process.env.NODE_ENV !== 'development') {
  BASE_PATH = '/index.php'
  LOGIN_URL = '/index.php/privilege/auth/login?redirect='
}
console.log(BASE_PATH, LOGIN_URL)

export {
  BASE_PATH,
  LOGIN_URL,
  ID,
  OPENID
}
