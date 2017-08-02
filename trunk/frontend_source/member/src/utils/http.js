import axios from 'axios'
import { LOGIN_URL, ID, OPENID } from '@/config/env'
// 开发环境跨域请求带cookie
if (process.env.NODE_ENV === 'development') {
  axios.defaults.withCredentials = true
}
// 默认一分钟超时
axios.defaults.timeout = 60000
// resolve error
axios.interceptors.response.use(function (response) {
  return response
}, function (error) {
  return Promise.resolve(error.response)
})
const checkStatus = function (response) {
  return response.data
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
  const {httpError, serveError, duration = 3000} = res.REJECTERRORCONFIG
  const {status, msg, url} = res
  if (!httpError || !serveError) {
    let message
    if (!httpError && status < 1000 && status > 399) {
      message = msg
      if (res.status === 401) {
        let curURL = encodeURIComponent(location.href)
        location.replace(`${LOGIN_URL}${curURL}`)
        return
      }
      switch (status) {
        case 403:
          message = process.env.NODE_ENV === 'development' ? `当前用户无权限请求接口${url}` : '请联系管理员开通相关权限'
          break
        case 404:
          message = process.env.NODE_ENV === 'development' ? `接口${url}未找到` : '请联系管理员确认是否存在相关页面'
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
        console.log(duration)
      } else {
        console.log(duration)
      }
    }
  }
  return Promise.reject(res)
}

const INTERIDREG = /(|&|\?)id=([^&]+)?/
const OENIDREG = /(|&|\?)open_id=([^&]+)?/

export default {
  post (url, data, config) {
    let _config = Object.assign({}, {data: data, url: url, method: 'post'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  get (url, data, config) {
    let _config = Object.assign({}, {params: data, method: 'get', url: url}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  put (url, data, config) {
    if (process.env.NODE_ENV === 'development' && !data.id) {
      if (config && config.headers && config.headers['Content-Type'] === 'application/x-www-form-urlencoded') {
        if (!INTERIDREG.test(data)) {
          data += '&id=' + ID
        }
        if (!OENIDREG.test(data)) {
          data += '&openid=' + OPENID
        }
      } else if (data.id === undefined || data.openid === undefined) {
        data.id = ID
        data.openid = OPENID
      }
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'put'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  },
  delete (url, data, config) {
    if (process.env.NODE_ENV === 'development' && data.ID === undefined && data.OPENID === undefined) {
      data.id = ID
      data.openid = OPENID
    }
    let _config = Object.assign({}, {data: data, url: url, method: 'delete'}, config)
    return axios(_config).then(checkStatus).then(checkCode)
  }
}
