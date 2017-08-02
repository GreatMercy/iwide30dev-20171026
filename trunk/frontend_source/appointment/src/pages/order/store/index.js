import api from '@/common/js/api'
import { ajaxPost, ajaxGet } from '@/common/js/ajax'
import { getQueryString } from '@/common/js/browser'
import { errorMessage, closeAll } from '@js/popup'
const state = {
  checkout: {} // 结算信息
}

const getters = {
  orderGoodsList: state => state.orderGoodsList,
  checkout: state => state.checkout // 结算信息
}

const actions = {
  /**
   * 提交订单信息
   * @param {string} shopId 商店的id
   * @param {string} id 公众号的id
   * @param {string} cartId 购物车的id
   * @param {string} username 联系人信息
   * @param {string} phone 手机号码
   * @param {string} verifyId 上一次的用户信息的id
   * @param {string} userNote 备注
   * */
  saveOrder (state, {
               cartId = getQueryString('cart_id'),
               username = '',
               phone = '',
               verifyId = '',
               userNote = ''
             }) {
    return ajaxPost(api.POST_TICKET_SAVE_ORDER, {
      'cart_id': cartId,
      'username': username,
      'phone': phone,
      'verify_id': verifyId,
      'user_note': userNote
    }, (res) => {
      location.href = res['pay_url']
    }, (res) => {
      errorMessage(res.msg)
    })
  },
  /**
   * 获取结算的信息
   * */
  getCheckout ({commit}, {cartId = getQueryString('cart_id')}) {
    return ajaxGet(api.GET_TICKET_CHECKOUT, {
      'cart_id': cartId
    }, (res) => {
      closeAll()
      commit('updateCheckout', res)
    }, (res) => {
      if (res.status === 410) {
        errorMessage(res.msg, function () {
          window.location.href = res.data.cart_url
        }, true)
      } else {
        errorMessage(res.msg, null, true)
      }
    })
  }
}

const mutations = {
  updateCheckout (state, data) {
    state.checkout = data
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
