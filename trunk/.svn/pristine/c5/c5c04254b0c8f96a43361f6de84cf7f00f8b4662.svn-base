import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import getters from './getters'
import mutations from './mutations'
import actions from './actions'
import index from '@/pages/index/store/index' // 首页
import detail from '@/pages/detail/store/index' // 详情
import order from '@/pages/order/store/index' // 提交订单
import orderList from '@/pages/orderList/store/index' // 订单列表
import orderDetail from '@/pages/orderDetail/store/index' // 订单详情
import cart from '@/pages/cart/store/index' // 购物车
Vue.use(Vuex)
/* eslint-disable no-new */
export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions,
  modules: {
    index,
    detail,
    order,
    orderList,
    orderDetail,
    cart
  }
})
