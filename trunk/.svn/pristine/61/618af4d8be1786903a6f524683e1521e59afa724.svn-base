import { getPresentsPackage } from '@/service/http'
const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
let params = formatUrlParams.default(location.href)

export default {
  getGiftInfo ({commit}) {
    let requestParams = {
      'aiid': params['aiid'] || '',
      'bsn': params['bsn'] || '',
      'send_from': params['send_from'] || '',
      'send_order_id': params['send_order_id'] || ''
    }
    if (process.env.NODE_ENV === 'development') {
      requestParams['openid'] = params['openid'] || 'o9Vbtw1W0ke-eb0g6kE4SD1eh6qU'
    }
    return getPresentsPackage(requestParams).then((res) => {
      commit('updateGiftInfo', res['web_data'])
    })
  }
}
