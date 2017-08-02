import { INIT_HOTEL_ROOMS, UPDATE_HOTEL_ROOMS, CACHE_HOTEL_ROOMS, UPDATE_LOADING } from '@/service/booking/types'
import { arrayFillWithArray } from '@/utils/utils'
/*
  "items": {
    "1": {
      "hotel_id": "1",
      "name": "金房卡大酒店金房卡大酒店",
      "room_ids": {
        "1": {
          "name": "高级双床房",
          "room_id": "1",
          "hotel_id": "1",
          "room_img": "http:\/\/gardeninns.iwide.cn\/media\/a426755343\/attachment\/2015032410593585.jpg"
        },
        "2": {
          "name": "高级大床房",
          "room_id": "2",
          "hotel_id": "1",
          "room_img": "http:\/\/file.iwide.cn\/public\/uploads\/201512\/yibohotel_110-3.jpg"
        }
      }
    }
  }
  转换成符合el-tree的格式
  items: {
   "1": {
      "hotel_id": "1",
      "name": "金房卡大酒店金房卡大酒店",
      "nid": 'hotel_1',
      room_ids: [
        {
          "name": "高级双床房",
          "room_id": "1",
          "hotel_id": "1",
          "room_img": "http:\/\/gardeninns.iwide.cn\/media\/a426755343\/attachment\/2015032410593585.jpg"
          "nid": 1
        },
        {
          "name": "高级大床房",
          "room_id": "2",
          "hotel_id": "1",
          "room_img": "http:\/\/file.iwide.cn\/public\/uploads\/201512\/yibohotel_110-3.jpg"
          "nid": 2
        }
      ]
    }
  }
 */
const changeRoomsFormat = function (roomInfo = {}) {
  let roomIds = Object.keys(roomInfo)
  let rooms = []
  if (roomIds.length) {
    roomIds.forEach(function (id) {
      let room = roomInfo[id]
      rooms.push({
        ...room,
        nid: room.room_id
      })
    })
  }
  return rooms
}
export default {
  // 初始化酒店信息
  [INIT_HOTEL_ROOMS] (state, { count, items }) {
    let hotelIds = Object.keys(items)
    hotelIds.forEach(function (hotelId) {
      let hotel = items[hotelId]
      // 将room_ids由对象改为数组,将赋于全局惟一的key
      hotel.rooms = changeRoomsFormat(hotel.room_ids)
      hotel.nid = 'hotel_' + hotelId
    })
    // 缓存数据
    state.hotelRoomItems = items
    state.hotelRoomIds.__default__.count = count
    // 建立page与hotel对应的关系
    state.hotelRoomIds.__default__.hotelIds = hotelIds
  },
  [UPDATE_HOTEL_ROOMS] (state, { count, items, keyword, page, size }) {
    // 缓存搜索条件中page与hotel对应的关系
    let hotelIds = Object.keys(items)
    hotelIds.forEach(function (hotelId) {
      // 检测是否已经存在hotelRooms中
      let hotel = state.hotelRoomItems[hotelId]
      if (!hotel) {
        hotel = items[hotelId]
        // 将room_ids由对象改为数组,将赋于全局惟一的key
        hotel.rooms = changeRoomsFormat(hotel.room_ids)
        hotel.nid = 'hotel_' + hotelId
      } else {
        delete items[hotelId]
      }
    })
    // 缓存数据
    state.hotelRoomItems = Object.assign(state.hotelRoomItems, items)
    if (keyword && !state.hotelRoomIds.keyword) {
      state.hotelRoomIds = Object.assign({}, state.hotelRoomIds, {
        [keyword]: {
          hotelIds,
          count
        }
      })
    } else {
      if (hotelIds.length) {
        let startIndex = (page - 1) * size
        state.hotelRoomIds[keyword || '__default__'].hotelIds = arrayFillWithArray(startIndex, size, state.hotelRoomIds[keyword || '__default__'].hotelIds, hotelIds)
      }
    }
  },
  // 只缓存酒店数据，不缓存page 及page与hotelid之间的关系，是由编辑价格代码时通过接口请求选中的酒店的数据
  [CACHE_HOTEL_ROOMS] (state, items) {
    // 缓存搜索条件中page与hotel对应的关系
    let hotelIds = Object.keys(items)
    hotelIds.forEach(function (hotelId) {
      // 检测是否已经存在hotelRooms中
      let hotel = state.hotelRoomItems[hotelId]
      if (!hotel) {
        hotel = items[hotelId]
        // 将room_ids由对象改为数组,将赋于全局惟一的key
        hotel.rooms = changeRoomsFormat(hotel.room_ids)
        hotel.nid = 'hotel_' + hotelId
      } else {
        delete items[hotelId]
      }
    })
    state.hotelRoomItems = Object.assign(state.hotelRoomItems, items)
  },
  [UPDATE_LOADING] (state, { loading }) {
    state.loading = loading
  }
}
