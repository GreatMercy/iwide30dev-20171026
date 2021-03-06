import { GET_HOTEL_GOODS, UPDATE_LOADING } from '@/service/booking/types'
import { UPDATE_CSRF_ITEMS } from '@/service/common/types'
import { arrayFillWithArray } from '@/utils/utils'
let timeReg = /\s?\d{2}:\d{2}:\d{2}/
/* eslint-disable camelcase */
export default {
  [GET_HOTEL_GOODS] (state, { count, items, page, size, links, statusDes, csrf_token, csrf_value }) {
    state.count = count
    state.links = links
    if (csrf_token) {
      state.csrf_token = csrf_token
    }
    if (csrf_value) {
      state.csrf_value = csrf_value
    }
    let goodIds = Object.keys(items) || ['']
    if (goodIds.length) {
      let startIndex = (page - 1) * size
      state.goodIds = arrayFillWithArray(startIndex, size, state.goodIds, goodIds)
    }
    for (let item in items) {
      if (items[item].un_validity_date) {
        items[item].unvalid_date = items[item].un_validity_date.replace(timeReg, '')
      }
      if (items[item].validity_date) {
        items[item].valid_date = items[item].validity_date.replace(timeReg, '')
      }
    }
    state.goodItems = Object.assign({}, state.goodItems, items)
  },
  [UPDATE_LOADING] (state, { loading }) {
    state.loading = loading
  },
  [UPDATE_CSRF_ITEMS] (state, { csrf_token, csrf_value }) {
    state.csrf_token = csrf_token
    state.csrf_value = csrf_value
  }
}
