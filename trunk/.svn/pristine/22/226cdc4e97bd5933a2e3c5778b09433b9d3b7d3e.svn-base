import {
  GET_HOTEL_GOODS_ACTION,
  GET_HOTEL_GOODS,
  UPDATE_LOADING
} from '@/service/booking/types'
import { getHotelGoodsList } from '@/service/booking/http'

export default {
  [GET_HOTEL_GOODS_ACTION] ({
    commit,
    state
  }, params = {}) {
    const { page = 1, size = 20 } = params
    commit(UPDATE_LOADING, {loading: true})
    getHotelGoodsList(params).then(function (res) {
      /* eslint-disable camelcase */
      const { items = {}, page_resource = { count: 0, links: {} } } = res.web_data
      commit(UPDATE_LOADING, {loading: false})
      commit(GET_HOTEL_GOODS, { page, items, size, count: page_resource.count, links: page_resource.links })
    }).catch(function (err) {
      console.log(err)
      commit(UPDATE_LOADING, {loading: false})
    })
  }
}
