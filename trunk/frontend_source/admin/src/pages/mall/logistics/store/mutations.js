import {
  UPDATE_EXPRESS_LIST,
  UPDATE_EXPRESS_PAGE_NUMBER,
  UPDATE_EXPRESS_TIME_RANGE,
  UPDATE_EXPRESS_KEYWORD,
  UPDATE_TABLE_LOADING,
  UPDATE_EXPRESS_STATUS
} from '@/service/mall/types'
export default {
  [UPDATE_EXPRESS_LIST] (state, data) {
    state['express_logistics_list']['list'] = data['list']
    state['express_logistics_list']['total'] = parseInt(data['page_resource']['count'])
    state['express_logistics_list']['page_num'] = parseInt(data['page_resource']['page'])
    let total = 0
    for (let i = 0; i < data['list'].length; i++) {
      if (data['list'][i]['status'] === '1' || data['list'][i]['status'] === '4' || data['list'][i]['status'] === '7') {
        total++
      }
    }
    state['current_order_total'] = total
    state['express_logistics_list']['csrf'] = data['csrf']
  },
  [UPDATE_EXPRESS_PAGE_NUMBER] (state, data) {
    state['express_logistics_list']['page_num'] = parseInt(data)
  },
  [UPDATE_EXPRESS_TIME_RANGE] (state, data) {
    state['express_logistics_list']['begin_time'] = data['begin_time']
    state['express_logistics_list']['end_time'] = data['end_time']
  },
  [UPDATE_EXPRESS_KEYWORD] (state, data) {
    state['express_logistics_list']['keyword'] = data
  },
  [UPDATE_TABLE_LOADING] (state, data) {
    state['table_loading'] = data
  },
  [UPDATE_EXPRESS_STATUS] (state, data) {
    state['express_logistics_list']['status'] = data
  }
}
