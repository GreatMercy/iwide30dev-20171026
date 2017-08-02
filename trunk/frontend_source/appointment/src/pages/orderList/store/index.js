import api from '@/common/js/api'
import { ajaxGet } from '@/common/js/ajax'
import { getQueryString } from '@/common/js/browser'
import { closeAll } from '@js/popup'

/**
 * 0：全部订单 1：待消费 2：已消费
 * */
const state = {
  0: {
    list: [],
    offset: 1,
    total: ''
  },
  1: {
    list: [],
    offset: 1,
    total: ''
  },
  2: {
    list: [],
    offset: 1,
    total: ''
  },
  currentOrderList: {},
  currentActiveId: ''
}

const getters = {
  currentOrderList: state => state.currentOrderList, // 当前显示的列表
  currentActiveId: state => state.currentActiveId // 当前活动的id
}

const actions = {
  getOrderList ({commit, state}, {shopId = getQueryString('shop_id'), id = getQueryString('id'), offset, limit = 10, type = state.currentActiveId, operation = 'tab'}) {
    offset = state[type].offset
    const total = state[type].total
    // 调用数据
    let callData = () => {
      if (total !== '' && total === 0) {
        commit('switchType', type)
        return false
      }
      if (total !== '' && offset > total) {
        return false
      }
      return ajaxGet(api.GET_TICKET_ORDER_LIST, {
        'shop_id': shopId,
        'id': id,
        'offset': offset,
        'limit': limit,
        'type': type
      }, (res) => {
        // 根据不同的type 设置不同的数组
        const dataType = parseInt(type)
        commit('updateOrderList', {
          'data': res,
          'type': dataType
        })
        closeAll()
        commit('updateCartNumber', res.cart)
      })
    }
    // 判断当前的操作为切换还是滚动
    if (operation === 'tab') {
      if (state[type].list.length === 0) {
        callData()
      } else {
        commit('switchType', type)
      }
    } else if (operation === 'scroll') {
      callData()
    }
  }
}

const mutations = {
  /**
   * 更新订单
   */
  updateOrderList (state, {data, type}) {
    data.list.forEach((item) => {
      state[type].list.push(item)
    })
    state[type].total = data.page.page_total
    state.currentOrderList = state[type]
    state[type].offset++
  },
  /**
   * 切换到当前的分类
   */
  switchType (state, type) {
    state.currentOrderList = state[type]
  },
  updateActiveId (state, data) {
    state.currentActiveId = data
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
