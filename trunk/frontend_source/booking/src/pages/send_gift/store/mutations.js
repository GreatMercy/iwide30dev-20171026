export default {
  updateGiftInfo (state, data) {
    if (data['qty_origin'] && data['qty']) {
      data['send_out_number'] = parseInt(data['qty_origin']) - parseInt(data['qty'])
      // 剩余的总数量
      data['residue'] = parseInt(data['qty'])
    }
    state['giftInfo'] = data
  },
  updateGiftCurrentTheme (state, data) {
    state['giftCurrentTheme'].name = data['name']
    state['giftCurrentTheme'].id = data['id']
  }
}
