let API_URL_SUFFIX = '/shortterm'
let API_URL_SUFFIX_V1 = `${API_URL_SUFFIX}`
// 博饼相关API
let API_PANCAKE_V1 = `${API_URL_SUFFIX_V1}/pancake-sett`

const v1 = {
  GET_PANCAKE_LIST: `${API_PANCAKE_V1}/index`,
  POST_PANCAKE_ADD: `${API_PANCAKE_V1}/add`,
  GET_PANCAKE_INFO: `${API_PANCAKE_V1}/edit`,
  POST_PANCAKE_INFO: `${API_PANCAKE_V1}/edit`,
  POST_PANCAKE_UPLOAD: `${API_PANCAKE_V1}/upload`,
  DELETE_PANCAKE_INFO: `${API_PANCAKE_V1}/delete`
}

export {
  v1
}
