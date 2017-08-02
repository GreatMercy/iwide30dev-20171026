import axios from 'axios'
import { LOGIN_URL, INTER_ID, OPEN_ID } from '../config/env'
import { JfkToast, JfkMessageBox } from 'jfk-ui'
import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'

// 开发环境跨域请求带cookie
if (process.env.NODE_ENV === 'development') {
  axios.defaults.withCredentials = true
}
// 默认一分钟超时
axios.defaults.timeout = 60000
axios.interceptors.request.use(function (config) {
  console.log(config)
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
const checkStatus = function (response) {
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
}
const checkCode = function (res) {
  // 错误处理
  if (res.code === -404) {
    return handleErrorStatus(res)
  } else {
    return res
  }
}
const handleErrorStatus = function (res) {
  const {httpError, serveError, duration} = res.REJECTERRORCONFIG
  const {status, msg, url} = res
  if (!httpError || !serveError) {
    let message
    if (!httpError && status < 1000 && status > 399) {
      message = msg
      if (res.status === 401) {
        let curURL = encodeURIComponent(location.href)
        // TODO 401不跳转登录
        location.replace(`${LOGIN_URL}${curURL}`)
        return
      }
      switch (status) {
        case 403:
          message = process.env.NODE_ENV === 'development' ? `当前用户无权限请求接口${url}` : '无权限进行相关操作，请反馈给网站提供者'
          break
        case 404:
          message = process.env.NODE_ENV === 'development' ? `接口${url}未找到` : '请确认链接是否正确'
          break
        case 500:
        case 504:
          message = process.env.NODE_ENV === 'development' ? `服务器发生内部错误` : '请刷新页面后重试'
          break
      }
    }
    if (!serveError && status > 1000) {
      message = msg
    }
    if (message) {
      if (status === 1001) {
        JfkToast({
          iconType: 'error',
          title: '',
          message: message,
          duration: duration
        })
      } else {
        res.$msgbox = JfkMessageBox.alert(message, '', {
          iconType: 'error'
        })
      }
    }
  }
  return Promise.reject(res)
}
const formatUrl = function (url, data, contentType) {
  if (contentType === 'application/x-www-form-urlencoded') {
    data = formatUrlParams('?' + data)
  } else if (!data) {
    data = {}
  }
  let urlParams = formatUrlParams(url)
  urlParams.id = data.id || urlParams.id || INTER_ID
  urlParams.openid = data.openid || urlParams.openid || OPEN_ID
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
export default {
  post (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers['Content-Type'])
      url = d.url
      data = d.data
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'post'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  get (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers['Content-Type'])
      url = d.url
      data = d.data
    }
    let _config = Object.assign({}, {params: data, method: 'get', url: url}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  put (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers['Content-Type'])
      url = d.url
      data = d.data
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'put'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  delete (url, data, config) {
    if (process.env.NODE_ENV === 'development') {
      let d = formatUrl(url, data, config && config.headers['Content-Type'])
      url = d.url
      data = d.data
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'post'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  }
}
