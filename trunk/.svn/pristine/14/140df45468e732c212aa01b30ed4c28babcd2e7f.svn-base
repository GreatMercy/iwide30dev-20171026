import api from '@/common/js/api'
import { ajaxGet, ajaxPost } from '@/common/js/ajax'
import { getQueryString } from '@/common/js/browser'

const state = {
  calendarShow: false, // 是否显示日历
  goodsDetail: [], // 商品的信息
  hotelDetail: {}, // 酒店的信息
  spec: [], // 规格的列表
  currentSpec: '', // 当前选中的规格
  calendarDate: {}, // 日历的信息
  specPrice: '0.00', // 当前选中的规格的价格
  original: '0.00', // 原价
  specName: '', // 当前选中的规格的名称
  buyType: 1, // 购买方式(1-加入购物车, 2-立即购买)
  date: {} // 日期数据
}

const getters = {
  date: state => state.date, // 日期的数据
  original: state => state.original, // 原价
  calendarShow: state => state.calendarShow, // 是否显示日历
  goodsDetail: state => state.goodsDetail, // 商品的信息
  hotelDetail: state => state.hotelDetail, // 酒店的信息
  spec: state => state.spec, // 规格的列表
  calendarDate: state => state.calendarDate, // 日历的信息
  specPrice: state => state.specPrice, // 选中的规格的价格
  currentSpec: state => state.currentSpec, // 当前的规格
  buyType: state => state.buyType // 购买方式(1-加入购物车, 2-立即购买)
}

const actions = {
  /**
   * 获取商品详情
   * @param {string} goodsId 商品的id
   * */
  getGoodsDetail ({commit}, {goodsId = getQueryString('goods_id')}) {
    return ajaxGet(api.GET_TICKET_GOODS_DETAIL, {
      'goods_id': goodsId
    }, (res) => {
      commit('updateGoodsDetail', res)
      commit('updateCartNumber', res.cart)
    })
  },
  addCart ({commit, state}, data) {
    data['shop_id'] = getQueryString('shop_id') || ''
    data['id'] = getQueryString('id') || ''
    data['goods_id'] = getQueryString('goods_id') || ''
    data['buy_type'] = state.buyType || 1
    data['spu_id'] = state.currentSpec || ''
    data['spu_name'] = state.specName || ''
    data['goods_price'] = state.specPrice || ''
    return ajaxPost(api.POST_TICKET_ADD_CART, data, (res) => {
      commit('updateCartNumber', res.count.num)
    })
  }
}

const mutations = {
  /**
   * 更新信息详情
   */
  updateGoodsDetail (state, res) {
    state.goodsDetail = res.goods || {}
    if (res.goods) {
      state.goodsDetail['banner_length'] = res.goods.goods_img.length || 0
    }
    state.date = res.date || {}
    state.spec = res.spu || []
    state.hotelDetail = res.hotel
    state.calendarDate = res.date || {}
  },
  /**
   * 更新日历的显示
   */
  updateCalendarShow (state, bol) {
    state.calendarShow = bol
  },
  /**
   * 更新购买的方式
   * */
  updateBuyType (state, data) {
    state.buyType = data
  },
  /**
   * 修改选中的规格
   * @param {string} specId 规格的id
   * */
  selectSpec (state, specId) {
    for (let i = 0; i < state.spec.length; i++) {
      state.spec[i]['selected'] = 0
      if (state.spec[i]['spu_id'] === specId) {
        state.spec[i]['selected'] = 1
      }
    }
  },
  /**
   * 根据选中规格 获取规格的价格
   * */
  getSpecPrice (state) {
    for (let i = 0; i < state.spec.length; i++) {
      if (state.spec[i]['selected'] === 1) {
        state.specPrice = state.spec[i].price
        state.original = state.spec[i]['prime_price']
        state.currentSpec = state.spec[i].spu_id
        state.specName = state.spec[i].spu_name
      }
    }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
