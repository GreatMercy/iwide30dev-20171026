import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import state from './state'
import mutations from './mutations'
import config from './config'
import form from './form'
import rooms from './rooms'
import goods from './goods'

Vue.use(Vuex)

export default new Vuex.Store({
  // strict: true,
  actions,
  state,
  mutations,
  modules: {
    config,
    form,
    rooms,
    goods
  }
})
