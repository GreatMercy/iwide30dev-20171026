import * as apiConfig from './api'
import ajax from '@/utils/http'

const getPancakeList = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_LIST || apiConfig.v1.GET_PANCAKE_LIST
  return ajax.get(url, data, config)
}

const getPancakeInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].GET_PANCAKE_INFO || apiConfig.v1.GET_PANCAKE_INFO
  return ajax.get(url, data, config)
}

const postPancakeAdd = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_PANCAKE_ADD || apiConfig.v1.POST_PANCAKE_ADD
  return ajax.post(url, data, config)
}

const postPancakeInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_PANCAKE_INFO || apiConfig.v1.POST_PANCAKE_INFO
  return ajax.post(url, data, config)
}

const postPancakeUpload = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].POST_PANCAKE_UPLOAD || apiConfig.v1.POST_PANCAKE_UPLOAD
  return ajax.post(url, data, config)
}

const deletePancakeInfo = (data, config, version = 'v1') => {
  let url = apiConfig[version] && apiConfig[version].DELETE_PANCAKE_INFO || apiConfig.v1.DELETE_PANCAKE_INFO
  return ajax.delete(url, data, config)
}

export {
  getPancakeList,
  getPancakeInfo,
  postPancakeAdd,
  postPancakeInfo,
  postPancakeUpload,
  deletePancakeInfo
}
