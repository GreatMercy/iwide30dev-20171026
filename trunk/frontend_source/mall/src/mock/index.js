import Mock, { Random } from 'mockjs'
import moment from 'moment'
import advLists from './advs.mock'
import getProductBaseFn from './products.baseFn'
import products from './products.mock'
import productDetail from './product_detail.mock'
import url from 'url'
import { v1 } from '@/service/api'

const strToReg = function (str) {
  return new RegExp(str.replace(/\//g, '\\/').replace(/\./g, '\\.'))
}
v1.GET_MALL_ADVS && Mock.mock(strToReg(v1.GET_MALL_ADVS), function (options) {
  return advLists
})
Mock.mock(strToReg(v1.GET_GOODS_LIST), function (options) {
  const urlObj = url.parse(options.url, true)
  const { type } = urlObj.query
  let killsec
  let groupon
  let ordinary
  if (!type || type === 1) {
    // 添加热卖
    ordinary = {
      items: products.ordinary
    }
  }
  if (!type || type === 2) {
    // 添加秒杀
    let momentFormatTpl = 'YYYY-MM-DD HH:mm:ss'
    let now = moment()
    let killsecTime = now.clone().add(Random.integer(0, 20), Random.pick(['h', 's', 'm']))
    killsec = {
      items: products.killsec,
      start_time: now.clone().subtract(1, Random.pick(['h', 'd', 'y'])).format(momentFormatTpl),
      end_time: killsecTime.add(Random.integer(1, 3), 'h').format(momentFormatTpl)
    }
  }
  if (!type || type === 3) {
    let discount = Random[Math.random() > 0.5 ? 'float' : 'integer'](10, 99, 0, 2)
    let price = Math.ceil(discount * 6)
    groupon = {
      items: products.groupon,
      discount: discount,
      price: price
    }
  }
  switch (type) {
    case 1:
      return ordinary
    case 2:
      return killsec
    case 3:
      return groupon
    default:
      return {
        killsec,
        ordinary,
        groupon
      }
  }
})
Mock.mock(strToReg(v1.GET_GOOD_DATA), function (options) {
  const urlObj = url.parse(options.url, true)
  let { type, calendar } = urlObj.query
  if (!type) {
    type = Random.integer(1, 3)
  }
  if (type === 1 && calendar === undefined) {
    calendar = Random.boolean()
  }
  return productDetail(type, calendar)
})
Mock.mock(strToReg(v1.GET_GOOD_RECOMMENDATION), function (options) {
  return {
    products: new Array(Random.integer(3, 8)).fill(0).map(() => {
      return getProductBaseFn()
    })
  }
})
