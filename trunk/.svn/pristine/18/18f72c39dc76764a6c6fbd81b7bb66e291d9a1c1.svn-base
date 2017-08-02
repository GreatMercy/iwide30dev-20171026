import { GET_HOTEL_GOODS, CLEAN_HOTEL_GOODS, UPDATE_LOADING } from '@/service/booking/types'
import { arrayFillWithArray } from '@/utils/utils'
export default {
  [GET_HOTEL_GOODS] (state, { count, items, page, size, links }) {
    state.links = links
    if (count) {
      state.count = count
      let goodIds = Object.keys(items)
      if (goodIds.length) {
        let startIndex = (page - 1) * size
        state.goodIds = arrayFillWithArray(startIndex, size, state.goodIds, goodIds)
      }
      Object.assign(state.goodItems, items)
    }
  },
  [CLEAN_HOTEL_GOODS] (state) {
    state.count = 0
    state.goodIds = []
    state.goodItems = {}
  },
  [UPDATE_LOADING] (state, { loading }) {
    state.loading = loading
  }
}
