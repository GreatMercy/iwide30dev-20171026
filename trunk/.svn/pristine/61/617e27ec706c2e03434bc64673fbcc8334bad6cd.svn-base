import {
  GET_EXPRESS_ORDER_LIST,
  UPDATE_EXPRESS_LIST,
  UPDATE_TABLE_LOADING
} from '@/service/mall/types'
import { getExpressOrderList } from '@/service/mall/http'
export default {
  [GET_EXPRESS_ORDER_LIST] ({commit, state}) {
    return getExpressOrderList({
      like: state['express_logistics_list']['keyword'],
      status: state['express_logistics_list']['status'],
      begin_time: state['express_logistics_list']['begin_time'],
      end_time: state['express_logistics_list']['end_time'],
      page_num: state['express_logistics_list']['page_num'],
      page_size: state['express_logistics_list']['page_size'],
      type: 2
    }).then((res) => {
      commit(UPDATE_EXPRESS_LIST, {
        list: res['web_data']['data'],
        page_resource: res['web_data']['page_resource'],
        csrf: res['web_data']['csrf']
      })
      commit(UPDATE_TABLE_LOADING, false)
    }).catch(() => {
      commit(UPDATE_TABLE_LOADING, false)
    })
  }
}

