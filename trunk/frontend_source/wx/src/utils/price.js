/**
 * 处理商品价格，将积分处理不带￥，并返回商城类型对应的价格
 * @param  {Object}  product   商品信息对象
 * @param  {Boolean} isMarket  是否为未优惠价
 * @param  {Boolean} hasFormat 是否为服务器处理好的价格，如果处理好，直接读price_market price_package
 * @return {String}            价格html片段
 */
export default function formatPrice (product, isMarket, hasFormat) {
  let price
  if (hasFormat) {
    price = product[isMarket ? 'price_market' : 'price_package']
  } else {
    switch (product.tag) {
      case 2:
        price = isMarket ? product.price_package : product.killsec.killsec_price
        break
      case 3:
        price = isMarket ? product.price_package : product.groupons.group_price
        break
      default:
        price = isMarket ? product.price_market : product.price_package
    }
  }
  let html
  if (isMarket) {
    html = (product.tag !== 7 ? '￥' : '') + price
  } else {
    html = (product.tag !== 7 ? '<i class="jfk-font-number jfk-price__currency">￥</i>' : '') + '<i class="jfk-font-number jfk-price__number">' + price + '</i>'
  }
  return {
    html,
    hasCurrency: product.tag !== 7,
    length: (price || '').length
  }
}
