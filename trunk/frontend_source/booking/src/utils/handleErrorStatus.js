import { LOGIN_URL } from '../config/env'
import { JfkToast, JfkMessageBox } from 'jfk-ui'
export default function handleErrorStatus (res) {
  const {httpError, serveError, duration} = res.REJECTERRORCONFIG || {}
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
