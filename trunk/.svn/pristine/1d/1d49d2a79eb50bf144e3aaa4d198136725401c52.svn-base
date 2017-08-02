import {
  UPDATE_PRICE_STEP,
  UPDATE_LOADING
} from '@/service/booking/types'
/* eslint-disable camelcase */
export default {
  [UPDATE_PRICE_STEP] (state, { increment }) {
    if (increment) {
      state.increment = state.increment > 0 ? ++state.increment : 1
    } else {
      state.increment = state.increment < 0 ? --state.increment : -1
    }
  },
  [UPDATE_LOADING] (state, { loading }) {
    state.loading = loading
  }
}
