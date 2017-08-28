let BASE_PATH = ''
let PANCAKE_BASE_PATH = ''
let PANCAKE_EDIT_PATH = ''
let PANCAKE_PATH = ''
let PANCAKE_EDIT_URL = ''
let DEBUG_KEY = '6458fb5d756affb8247150e71471e149'

if (process.env.NODE_ENV !== 'development') {
  BASE_PATH = '/index.php'
  PANCAKE_BASE_PATH = 'hotel/prices'
  PANCAKE_EDIT_PATH = 'code_edit'
  PANCAKE_PATH = `${BASE_PATH}/${PANCAKE_BASE_PATH}`
  PANCAKE_EDIT_URL = `${PANCAKE_PATH}/${PANCAKE_EDIT_PATH}`
}
console.log(BASE_PATH, PANCAKE_EDIT_URL)

export {
  BASE_PATH,
  PANCAKE_EDIT_URL,
  DEBUG_KEY
}
