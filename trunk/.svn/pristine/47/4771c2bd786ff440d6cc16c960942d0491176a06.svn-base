import api from '@js/api'
import { ajaxGet, ajaxDelete, ajaxPut } from '@js/ajax'
import { getQueryString } from '@js/browser'

const state = {
  cartList: [],
  cartShopName: '',
  cartTotal: '0.00',
  cartIdList: ''
}

const getters = {
  cartList: state => state.cartList,
  cartShopName: state => state.cartShopName,
  cartTotal: state => state.cartTotal,
  cartIdList: state => state.cartIdList
}

const actions = {
  /**
   * 获取购物车列表
   * */
  getCartList ({commit}, {id = getQueryString('id'), shopId = getQueryString('shop_id')}) {
    return ajaxGet(api.GET_TICKET_CART_LIST, {'id': id, 'shop_id': shopId}, (res) => {
      commit('updateCartList', res)
      commit('getCartIdList')
    })
  },
  /**
   * 删除购物车列表
   **/
  delCart ({commit}, {id = getQueryString('id'), shopId = getQueryString('shop_id'), cartId, ind}) {
    return ajaxDelete(api.DELETE_TICKET_DEL_CART, {
      'cart_id': cartId,
      'shop_id': shopId,
      'id': id
    }, (res) => {
      commit('deleteCart', {ind, res})
    })
  },
  /**
   * 选择购物车列表
   * */
  selectCart ({commit}, {ind, selected, cartId, id = getQueryString('id'), shopId = getQueryString('shop_id')}) {
    let isSelected = ''
    if (selected === '1' || selected === 1) {
      isSelected = '2'
    } else {
      isSelected = '1'
    }
    ajaxPut(api.PUT_TICKET_TAG_SELECTED, {
      'cart_id': cartId, 'shop_id': shopId, 'id': id, 'is_selected': isSelected
    }, (res) => {
      commit('selectCart', {'ind': ind, 'res': res, 'selected': isSelected})
      commit('getCartIdList')
    })
  },
  /**
   * 编辑购物车
   * */
  editCart ({commit}, {id = getQueryString('id'), shopId = getQueryString('shop_id'), ind, goodsNum, cartId}) {
    ajaxPut(api.PUT_TICKET_UPDATE_CART, {
      'id': id,
      'shop_id': shopId,
      'goods_num': goodsNum,
      'cart_id': cartId
    }, (res) => {
      commit('editCart', {
        'ind': ind,
        'num': goodsNum,
        'res': res
      })
      commit('getCartIdList')
    })
  }
}

const mutations = {
  /**
   * 更新圆角
   * */
  updateBorderRadius (state, data) {
    state.borderRadius = data
  },
  /**
   * 编辑购物车
   * */
  editCart (state, data) {
    state.cartList[parseInt(data.ind)].goods_num = data.num
    state.cartTotal = data['res']['money']
    state.cartList[data.ind].selected = '1'
  },
  /**
   * 更新购物车列表
   * */
  updateCartList (state, data) {
    for (let i = 0; i < data['goods'].length; i++) {
      let current = data['goods'][i]
      if (i === 0) {
        current.open = true
      } else {
        current.open = false
      }
      if (parseInt(current.status) === 1) { // 正常
        current.gray = false
      } else if (parseInt(current.status) === 2) { // 已过期
        current.gray = true
      } else if (parseInt(current.status) === 3) { // 库存不足
        current.gray = false
      } else if (parseInt(current.status) === 4) { // 已下架
        current.gray = true
      } else {
        current.gray = true
      }
    }
    state.cartList = data['goods']
    state.cartShopName = data['shop']['shop_name']
    state.cartTotal = data['total']['money']
  },
  /**
   * 处理点击展开商品详情
   */
  openMoreInfo (state, id) {
    for (let i = 0; i < state.cartList.length; i++) {
      if (state.cartList[i]['cart_id'] === id) {
        state.cartList[i]['open'] = !state.cartList[i]['open']
      }
    }
  },
  /**
   * 获取购物车选中的列表
   */
  getCartIdList (state) {
    let idList = []
    for (let i = 0; i < state.cartList.length; i++) {
      if (parseInt(state.cartList[i].selected) === 1) {
        idList.push(state.cartList[i]['cart_id'])
      }
    }
    state.cartIdList = idList.join(',') || ''
  },
  /**
   * 删除购物车
   * @param {string} data.cartId  需要删除的cart_id
   * */
  deleteCart (state, data) {
    state.cartTotal = data['res']['money']
    state.cartList.splice(data.ind, 1)
  },
  /**
   * 修改选中状态
   * */
  selectCart (state, data) {
    state.cartList[data.ind].selected = data.selected
    state.cartTotal = data['res']['money']
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
