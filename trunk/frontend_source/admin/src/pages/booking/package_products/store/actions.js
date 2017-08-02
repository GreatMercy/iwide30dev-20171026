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
    commit(UPDATE_LOADING, { loading: true })
    getHotelGoodsList(params).then(function (res) {
      /* eslint-disable camelcase */
      // items为null
      let { items, page_resource, csrf_token, csrf_value } = res.web_data
      if (!items) {
        items = {}
      }
      commit(GET_HOTEL_GOODS, { page, items, size, count: page_resource.count || 0, links: page_resource.links || {}, csrf_token, csrf_value })
      commit(UPDATE_LOADING, { loading: false })
    }).catch(function (err) {
      console.log(err)
      commit(UPDATE_LOADING, { loading: false })
    })
  }
}
