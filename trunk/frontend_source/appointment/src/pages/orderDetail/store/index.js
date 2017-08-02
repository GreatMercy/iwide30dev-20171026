import api from '@/common/js/api'
import { ajaxGet, ajaxPut } from '@/common/js/ajax'
import { getQueryString } from '@/common/js/browser'
import { successMessage } from '@js/popup'

const state = {
  orderDetail: {},
  status: true
}

const getters = {
  orderDetail: state => state.orderDetail,
  status: state => state.status
}

const actions = {
  /**
   * 获取订单详情
   * */
  getOrderDetail ({commit, state}, {orderId = getQueryString('order_id')}) {
    return ajaxGet(api.GET_TICKET_ORDER_DETAIL, {
      'order_id': orderId
    }, (res) => {
      commit('updateOrderDetail', res)
    })
  },
  /**
   * 取消订单
   * */
  cancelOrder ({commit}, {orderId = getQueryString('order_id')}) {
    ajaxPut(api.PUT_TICKET_CANCEL_ORDER, {
      'order_id': orderId
    }, () => {
      successMessage('取消订单成功', () => {
        window.location.reload()
      })
    })
  }
}

const mutations = {
  updateOrderDetail (state, data) {
    data.order['total_fee'] = data.order['pay_fee']
    if (data.order['order_btn'] === 4) {
      state.status = false
    }
    state.orderDetail = data
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
