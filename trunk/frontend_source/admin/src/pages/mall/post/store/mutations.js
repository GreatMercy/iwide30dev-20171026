import {
  UPDATE_EXPRESS_LIST,
  UPDATE_EXPRESS_PAGE_NUMBER,
  UPDATE_EXPRESS_TIME_RANGE,
  UPDATE_EXPRESS_KEYWORD,
  UPDATE_EXPRESS_TABS,
  UPDATE_EXPRESS_DIALOG,
  UPDATE_EXPRESS_PROVIDERS,
  UPDATE_EXPRESS_SHIPPING_ID,
  UPDATE_TABLE_LOADING
} from '@/service/mall/types'
export default {
  // 更新邮政列表
  [UPDATE_EXPRESS_LIST] (state, data) {
    state['express_tabs'][state['express_current_tabs']]['list'] = data['list']
    state['express_tabs'][state['express_current_tabs']]['page_num'] = parseInt(data['page_resource']['page'])
    state['express_tabs'][state['express_current_tabs']]['total'] = parseInt(data['page_resource']['count'])
    state['express_tabs'][state['express_current_tabs']]['csrf'] = data['csrf']
  },
  // 更新当前页码
  [UPDATE_EXPRESS_PAGE_NUMBER] (state, data) {
    state['express_tabs'][state['express_current_tabs']]['page_num'] = parseInt(data)
  },
  // 更新时间范围
  [UPDATE_EXPRESS_TIME_RANGE] (state, data) {
    state['express_tabs'][state['express_current_tabs']]['begin_time'] = data['begin_time']
    state['express_tabs'][state['express_current_tabs']]['end_time'] = data['end_time']
  },
  // 更新搜索的关键字
  [UPDATE_EXPRESS_KEYWORD] (state, data) {
    state['express_tabs'][state['express_current_tabs']]['keyword'] = data
  },
  // 更新当前选中的tabs
  [UPDATE_EXPRESS_TABS] (state, data) {
    state['express_current_tabs'] = data
  },
  // 更新dialog的显示
  [UPDATE_EXPRESS_DIALOG] (state, data) {
    state['express_dialog_visible'] = data
  },
  // 更新邮寄下来列表
  [UPDATE_EXPRESS_PROVIDERS] (state, data) {
    state['express_providers'] = data
  },
  // 更新邮寄选中的id
  [UPDATE_EXPRESS_SHIPPING_ID] (state, data) {
    state['express_shipping_id'] = data
  },
  // 更新loading
  [UPDATE_TABLE_LOADING] (state, data) {
    state['table_loading'] = data
  }
}
