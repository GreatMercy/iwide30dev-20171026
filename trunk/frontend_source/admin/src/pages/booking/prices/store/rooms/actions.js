import {
  INIT_HOTEL_ROOMS,
  INIT_HOTEL_ROOMS_ACTION,
  UPDATE_HOTEL_ROOMS,
  UPDATE_HOTEL_ROOMS_ACTION,
  UPDATE_LOADING
} from '@/service/booking/types'
import { getHotelRooms } from '@/service/booking/http'

export default {
  [INIT_HOTEL_ROOMS_ACTION] ({
    commit,
    state
  }, params) {
    commit(UPDATE_LOADING, { loading: true })
    getHotelRooms(params).then(function (res) {
      /* eslint-disable camelcase */
      const { items = {}, page_resource = { count: 0 } } = res.web_data
      commit(INIT_HOTEL_ROOMS, { items, count: page_resource.count })
      commit(UPDATE_LOADING, { loading: false })
    }).catch(function (err) {
      console.log(err)
      commit(UPDATE_LOADING, { loading: false })
    })
  },
  [UPDATE_HOTEL_ROOMS_ACTION] ({
    commit,
    state
  }, params) {
    commit(UPDATE_LOADING, { loading: true })
    const { page = 1, keyword, size = 10 } = params
    getHotelRooms(params).then(function (res) {
      const { items = {}, page_resource = { count: 0 } } = res.web_data
      commit(UPDATE_HOTEL_ROOMS, { page, items, keyword, count: page_resource.count, size })
      commit(UPDATE_LOADING, { loading: false })
    }).catch(function (err) {
      console.log(err)
      commit(UPDATE_LOADING, { loading: false })
    })
  }
}
