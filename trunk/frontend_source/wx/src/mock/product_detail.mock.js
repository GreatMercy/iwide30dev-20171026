import { Random } from 'mockjs'
import getProductBaseTpl from './products.baseFn'
import imgLists from './img_list'

export default function productDetail (type, calendar) {
  let data = getProductBaseTpl(type, true, false)
  let images = new Array(Random.integer(1, 10)).fill(0).map(() => imgLists[Random.integer(0, 9)])
  let desc = Random.cparagraph()
  let notice = Random.cparagraph()
  Object.assign(data, { images, desc, notice })
  return data
}
