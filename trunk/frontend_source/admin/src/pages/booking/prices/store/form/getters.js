export default {
  limitWeeksHasAllChecked (state) {
    return state.limitWeeks.length === 7
  },
  limitRoomCheckedCount (state) {
    return Object.keys(state.limitRoomChecked).length
  },
  goodInfoItemsNumber (state) {
    if (state.goodInfoItems.items) {
      return Object.keys(state.goodInfoItems.items).length
    }
    return 0
  },
  hasWxPayInPayways (state) {
    return state.payWays.indexOf('weixin') > -1
  }
}
