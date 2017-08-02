import api from '@js/api'
import { ajaxGet, requestState } from '@js/ajax'
import { getQueryString } from '@js/browser'
import { closeAll } from '@js/popup'

const state = {
  goodsList: [], // 商品列表
  page: {}, // 页码信息
  shop: {}, // 商店信息
  goodsListOffset: 1, // 当前的页码
  goodsLoading: false // 是否加载
}

const getters = {
  goodsList: state => state.goodsList,
  shop: state => state.shop,
  goodsLoading: state => state.goodsLoading,
  goodsListOffset: state => state.goodsListOffset
}

/**
 *获取商品列表
 * @param {number} 当前页码（默认为1）
 * @param {number} data.limit 显示数量/页（默认为10）
 * */
const actions = {
  getGoodsList (context, data) {
    const total = context.state.page.page_total
    let offset = context.state.goodsListOffset || 1
    let limit = data.limit || 10
    let hotelId = getQueryString('hotel_id')
    if (typeof total !== 'undefined' && offset > total) {
      return false
    }
    if (requestState.pending === true) {
      context.commit('updateGoodsLoading', true)
      return false
    }
    return ajaxGet(api.GET_TICKET_GOODS_LIST, {
      'offset': offset,
      'hotel_id': hotelId,
      'limit': limit
    }, (res) => {
      if (offset !== 1) {
        closeAll()
      }
      context.commit('updateGoods', res)
      context.commit('updateGoodsListOffset', res)
      context.commit('updateGoodsLoading', false)
      context.commit('updateCartNumber', res.cart)
    })
  }
}

const mutations = {
  updateGoods (state, res) {
    res.goods.forEach((item) => { // 设置商品
      state.goodsList.push(item)
    })
    state.shop = res.shop // 设置商店信息
    state.page = res.page // 设置页码信息
  },
  updateGoodsLoading (state, bol) {
    state.goodsLoading = bol
  },
  updateGoodsListOffset (state) {
    state.goodsListOffset++
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
