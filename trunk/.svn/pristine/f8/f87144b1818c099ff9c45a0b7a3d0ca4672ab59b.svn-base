import { getPresentsPackage } from '@/service/http'
const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
let params = formatUrlParams.default(location.href)

export default {
  getGiftInfo ({commit}) {
    let requestParams = {
      'aiid': params['aiid'] || 6184,
      'bsn': params['bsn'] || 'package',
      'send_from': params['send_from'] || 1,
      'send_order_id': params['send_order_id'] || '1000011817',
      'openid': 'o9Vbtw1W0ke-eb0g6kE4SD1eh6qU'
    }
    getPresentsPackage(requestParams).then((res) => {
      commit('updateGiftInfo', res['web_data'])
    })
  }
}

