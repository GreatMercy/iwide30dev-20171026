export default {
  updateGiftInfo (state, data) {
    if (data && data['price_package']) {
      data['price_package'] = String(parseFloat(data['price_package']))
    }
    if (data && data['qty_origin'] && data['qty']) {
      data['send_out_number'] = parseInt(data['qty_origin']) - parseInt(data['qty'])
      // 剩余的总数量
      data['residue'] = parseInt(data['qty'])
    }
    state['giftInfo'] = data
    if (data['gift_theme'] && data['gift_theme'].length > 0) {
      state['giftCurrentTheme'].name = data['gift_theme'][0]['theme_name']
      state['giftCurrentTheme'].id = data['gift_theme'][0]['theme_id']
    }
  },
  updateGiftCurrentTheme (state, data) {
    state['giftCurrentTheme'].name = data['name']
    state['giftCurrentTheme'].id = data['id']
  }
}
