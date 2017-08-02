/**
 * @author huanghaojun
 * @email  yellowhaojun@gmail.com
 */
import axios from 'axios'
import qs from 'qs'
import { getQueryString } from './browser'
import { closeAll, errorMessage, loading } from '@js/popup'
let debug = false
if (process.env.NODE_ENV === 'development') {
  debug = true
}

/**
 * ajax 请求的状态值
 */
let requestState = {
  pending: false, // true 表示发起了请求，false表示结束了一次请求
  csrfName: null, // csrf_token 的key名称
  csrfValue: null // csrf_token 的value
}

axios.defaults.timeout = 10000
/**
 * axios 拦截器
 * */
axios.interceptors.request.use(function (config) {
  loading()
  requestState.pending = true
  return config
}, function (error) {
  requestState.pending = false
  return Promise.reject(error)
})

/**
 * 处理debug请求的参数配置
 * @param {object} data 请求的参数
 * @param {string} type 请求方式 （get||post）
 */
const checkRequestUrl = (data, type) => {
  let id = getQueryString('id') || ''
  let openid = 'ohQSEuLLpZmokFIt9_Vf2wOH9LvY'
  if (debug) {
    switch (type) {
      case 'get':
        data = `${data}?id=${id}&openid=${openid}`
        break
      case 'post':
        data = `${data}?id=${id}&openid=${openid}`
        break
      case 'put':
        data = `${data}?id=${id}&openid=${openid}`
        break
      case 'delete':
        data = `${data}?id=${id}&openid=${openid}`
        break
    }
  }
  return data
}

/**
 * 处理通用的请求状态值为200时的code
 * @param {number} status 服务器端返回的code
 * @param {function} success 成功的方法
 * @param {function} error 错误的方法
 * @param {boolean} successModel 成功的关闭模式
 */
const ajaxCheckStatus = (res, success, error, successModel) => {
  if (res.data.status === 200) {
    if (!!successModel === false) {
      closeAll()
    }
    success(res.data.data)
    requestState.pending = false
  } else if (res.data.status > 300 && res.data.status < 400) {
    errorMessage('登录已过期，请重新刷新页面！', null, true)
  } else {
    if (typeof error === 'function') {
      error(res.data)
    } else {
      errorMessage('请求超时，请稍后重试！', null, true)
    }
  }
  if (res.status === 200) {
    return res.data
  } else {
    return false
  }
}

/**
 * 处理error
 * */
let checkError = (err) => {
  if (debug) {
    errorMessage(err, null, true)
  } else {
    if (err.response) {
      if (err.response.status > 300 && err.response.status < 400) {
        errorMessage('登录已过期，请重新刷新页面！', null, true)
      } else if (err.response.status >= 400 && err.response.status <= 500) {
        errorMessage('请检查请求的页面是否正确！', null, true)
      } else if (err.response.status >= 500) {
        errorMessage('服务器异常，请稍后重试！', null, true)
      }
    } else {
      errorMessage('请求超时，请稍后重试！', null, true)
    }
  }
}

/**
 * 处理请求的参数（所有接口统一传送 id、openid、hotel_id）
 * @param {object} data 参数
 * */
let checkParams = (data) => {
  data['id'] = getQueryString('id') || ''
  data['shop_id'] = getQueryString('shop_id') || ''
  data['hotel_id'] = getQueryString('hotel_id') || ''
  if (requestState.csrfName && requestState.csrfValue) {
    data[requestState.csrfName] = requestState.csrfValue
  }
  return data
}

/**
 * 请求的方法
 * @param {string} url 请求的链接
 * @param {object} data 请求的参数
 * @param {function} success 返回200时执行的方法
 * @param {function} error 返回非200时执行的方法
 * @param {string} id 公众号id （默认所有请求都带）
 * @param {string} shop_id 商店的id 默认所有请求都带）
 * */

/**
 * get 请求
 */
let ajaxGet = (url, data, success, error) => {
  const requestUrl = checkRequestUrl(url, 'get')
  return axios.get(requestUrl, {params: checkParams(data)}).then(function (res) {
    if (res.data.status === 200) {
      requestState.csrfName = res.data.data['csrf_token']
      requestState.csrfValue = res.data.data['csrf_value']
    }
    return ajaxCheckStatus(res, success, error, true)
  }).catch(err => {
    checkError(err)
  })
}

/**
 * post 请求
 * */
let ajaxPost = (url, data, success, error) => {
  const requestUrl = checkRequestUrl(url, 'post')
  return axios.post(requestUrl, qs.stringify(checkParams(data)), {
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  }).then(function (res) {
    return ajaxCheckStatus(res, success, error)
  }).catch(err => {
    checkError(err)
  })
}

/**
 * put 请求
 * */
let ajaxPut = (url, data, success, error) => {
  const requestUrl = checkRequestUrl(url, 'put')
  return axios.put(requestUrl, checkParams(data), {}).then(function (res) {
    return ajaxCheckStatus(res, success, error)
  }).catch(err => {
    checkError(err)
  })
}

/**
 * delete 请求
 * */
let ajaxDelete = (url, data, success, error) => {
  const requestUrl = checkRequestUrl(url, 'delete')
  return axios({
    method: 'delete',
    url: requestUrl,
    data: checkParams(data)
  }).then((res) => {
    return ajaxCheckStatus(res, success, error)
  }).catch(err => {
    checkError(err)
  })
}

export { ajaxGet, requestState, ajaxPost, ajaxCheckStatus, ajaxPut, ajaxDelete }

