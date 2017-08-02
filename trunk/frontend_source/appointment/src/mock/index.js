import Mock from 'mockjs'
import goodsList from './goodsList.mock'
import api from '@js/api'

function getMockUrl ($url) {
  let reg = new RegExp($url, 'g')
  return reg
}

Mock.mock(getMockUrl(api.GET_TICKET_GOODS_LIST), goodsList)

