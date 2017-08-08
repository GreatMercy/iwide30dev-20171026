import fontMap from './fontMap'
export default {
  functional: true,
  render (h, context) {
    let priceN = Number(context.props.price)
    let price = String(priceN)
    let priceArr = price.split('.')
    if (priceArr.length === 2 && priceArr[1].length > 2) {
      price = Number(priceN).toFixed(2)
    }
    let len = price.length
    let i = 0
    let prices = []
    while (i < len) {
      let symbol = price[i]
      let c = 'jfk-font '
      if (symbol !== '.') {
        c += 'jfk-price__number icon-font_number_' + fontMap[symbol] + '_ht'
      } else {
        c += 'jfk-price__digital icon-user_icon_digital_p'
      }
      i++
      prices.push(<i class={c}></i>)
    }
    if (prices.length) {
      let c = 'jfk-price__currency jfk-font ' + context.props.currencyIcon
      prices.unshift(<i class={c}></i>)
    }
    let c = 'jfk-price ' + context.data.staticClass
    return (
      <span class={c} {...context.attrs}>
        {prices}
      </span>
    )
  },
  props: {
    'currency-icon': {
      type: String,
      default: 'icon-price_icon_symbol_nor'
    },
    'price': {
      type: [Number, String],
      default: 0,
      required: true
    }
  }
}
