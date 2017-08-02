import api from '@js/api'
import { ajaxGet } from '@js/ajax'

const actions = {
  /**
   * 获取微信配置
   * */
  getWxConfig ({commit}) {
    let url = window.location.href
    if (url.indexOf('#/') > -1) {
      url = url.substr(0, url.indexOf('#/'))
    }
    return ajaxGet(api.GET_TICKET_WX_CONFIG, {'url': url}, (res) => {
      commit('updateConfig', res)
    })
  }
}
export default actions
