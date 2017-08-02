import {
  GET_HOTEL_ROOM_BY_CODE_ACTION,
  GET_HOTEL_ROOM_BY_CODE,
  CACHE_HOTEL_ROOMS
} from '@/service/booking/types'

import { getHotelRoomsByCode } from '@/service/booking/http'

export default {
  [GET_HOTEL_ROOM_BY_CODE_ACTION] ({
    commit,
    state
  }, params) {
    getHotelRoomsByCode(params).then(function (res) {
      const { items } = res.web_data
      if (items) {
        const checkHotels = {}
        for (let hotel in items) {
          let roomIds = Object.keys(items[hotel].room_ids)
          let _roomIds = {}
          roomIds.forEach(function (room) {
            _roomIds[room] = hotel
          })
          checkHotels[hotel] = {
            hotelId: hotel,
            rooms: _roomIds
          }
        }
        commit(GET_HOTEL_ROOM_BY_CODE, checkHotels)
        commit('rooms/' + CACHE_HOTEL_ROOMS, items, {root: true})
      }
    })
  }
}
