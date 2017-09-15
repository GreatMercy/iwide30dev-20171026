import axios from 'axios'
import {INTER_ID, OPEN_ID} from '../config/env'
import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
import handleErrorStatus from '@/utils/handleErrorStatus'

// 开发环境跨域请求带cookie
if (process.env.NODE_ENV === 'development') {
  axios.defaults.withCredentials = true
}
// 默认一分钟超时
axios.defaults.timeout = 60000
axios.interceptors.request.use(function (config) {
  // 生产环境默认增加token
  if (process.env.NODE_ENV === 'production') {
    if (config.method === 'post' || config.method === 'put') {
      addCSRFTOKEN(config.data)
    }
  }
  return config
}, function (err) {
  return Promise.reject(err)
})
// resolve error
axios.interceptors.response.use(function (response) {
  return response
}, function (error) {
  return Promise.resolve(error.response)
})
const addCSRFTOKEN = function (data) {
  const token = window.jfkConfig.token
  const {name, value} = token
  if (data[name] === undefined) {
    data[name] = value
  }
}
const checkStatus = function (response) {
  if (response) {
    const {REJECTERRORCONFIG = {}} = response.config
    if (response.status === 200 || response.status === 304) {
      if (response.data.status === 1000) {
        return response.data
      } else {
        return {
          code: -404,
          url: response.config.url,
          REJECTERRORCONFIG,
          ...response.data
        }
      }
    }
    return {
      code: -404,
      status: response.status,
      msg: response.statusText,
      url: response.config.url,
      REJECTERRORCONFIG
    }
  } else {
    return {
      code: -404
    }
  }
}
const checkCode = function (res) {
  // 错误处理
  if (res.code === -404) {
    return handleErrorStatus(res)
  } else {
    return res
  }
}
const formatUrl = function (url, data, contentType) {
  if (contentType === 'application/x-www-form-urlencoded') {
    data = formatUrlParams('?' + data)
  } else if (!data) {
    data = {}
  }
  let urlParams = formatUrlParams(url)
  let urlOpenid = formatUrlParams(window.location.href).openid
  urlParams.id = data.id || urlParams.id || INTER_ID
  urlParams.openid = data.openid || urlParams.openid || urlOpenid || OPEN_ID
  delete data.id
  delete data.openid
  let newUrl = url.split('?')[0]
  let urlParamArr = []
  for (let key in urlParams) {
    urlParamArr.push(key + '=' + encodeURIComponent(urlParams[key]))
  }
  if (urlParamArr.length) {
    newUrl += '?' + urlParamArr.join('&')
  }
  if (contentType === 'application/x-www-form-urlencoded') {
    let dataArr = []
    for (let key in data) {
      dataArr.push(key + '=' + encodeURIComponent(data[key]))
    }
    data = dataArr.join('&')
  }
  return {
    url: newUrl,
    data: data
  }
}
const dealSalerParam = function (url, data, config) {
  let d = formatUrl(url, data, config && config.headers && config.headers['Content-Type'])
  // 序列化d.url
  let hostUrl = d.url.split('?')[0]
  let urlObj = formatUrlParams(d.url)
  let urlParamArr = []
  // 分销的参数
  const salerParam = window.url_param
  if (salerParam.indexOf('id=') >= 0 && d.url.indexOf('id=') >= 0) {
    delete urlObj.id
  }
  if (salerParam.indexOf('openid=') >= 0 && d.url.indexOf('openid=') >= 0) {
    delete urlObj.openid
  }
  for (let key in urlObj) {
    urlParamArr.push(key + '=' + encodeURIComponent(urlObj[key]))
  }
  if (urlParamArr.length !== 0) {
    hostUrl = hostUrl + '?' + urlParamArr.join('&')
    hostUrl = hostUrl + '&' + salerParam
  } else {
    hostUrl = hostUrl + '?' + salerParam
  }
  return {
    url: hostUrl,
    data: d.data
  }
}
export default {
  post (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers && config.headers['Content-Type'])
      url = d.url
      data = d.data
    } else if (window.url_param) {
      dealSalerParam(url, data, config)
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'post'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  get (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers && config.headers['Content-Type'])
      url = d.url
      data = d.data
    } else if (window.url_param) {
      let oreturn = dealSalerParam(url, data, config)
      url = oreturn.url
      data = oreturn.data
    }
    let _config = Object.assign({}, {params: data, method: 'get', url: url}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  put (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers && config.headers['Content-Type'])
      url = d.url
      data = d.data
    } else if (window.url_param) {
      dealSalerParam(url, data, config)
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'put'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  delete (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers['Content-Type'])
      url = d.url
      data = d.data
    } else if (window.url_param) {
      dealSalerParam(url, data, config)
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'delete'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  }
}
