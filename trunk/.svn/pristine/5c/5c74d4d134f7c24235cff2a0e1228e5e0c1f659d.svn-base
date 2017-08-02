import {
  GET_EXPRESS_ORDER_LIST,
  UPDATE_EXPRESS_LIST,
  GET_EXPRESS_PROVIDERS,
  UPDATE_EXPRESS_PROVIDERS,
  UPDATE_TABLE_LOADING
} from '@/service/mall/types'
import { getExpressOrderList, getExpressList } from '@/service/mall/http'
export default {
  [GET_EXPRESS_ORDER_LIST] ({commit, state}, bol) {
    const tabsId = state['express_current_tabs']
    const reload = () => {
      const content = state['express_tabs'][tabsId]
      return getExpressOrderList({
        like: content['keyword'],
        status: content['status'],
        begin_time: content['begin_time'],
        end_time: content['end_time'],
        page_num: content['page_num'],
        page_size: content['page_size'],
        type: 1
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
    // false 表示tabs切换
    // true 表示分页和搜索
    if (bol === false) {
      // 判断当前的tab 是否存在旧的数据
      let tabsContent = state['express_tabs'][tabsId]
      if (tabsContent['list'].length === 0) {
        reload()
      } else {
        commit(UPDATE_EXPRESS_LIST, {
          list: state['express_tabs'][tabsId]['list'],
          page_resource: {
            page: state['express_tabs'][tabsId]['page_num'],
            count: state['express_tabs'][tabsId]['total'],
            csrf: state['express_tabs'][tabsId]['csrf']
          }
        })
        commit(UPDATE_TABLE_LOADING, false)
      }
    } else {
      reload()
    }
  },
  [GET_EXPRESS_PROVIDERS] ({commit, state}) {
    return getExpressList().then((res) => {
      if (res.status === 1000) {
        commit(UPDATE_EXPRESS_PROVIDERS, res['web_data']['data'])
      }
    })
  }
}

