import Mock from 'mockjs'
let logos = ['http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171344.jpg', 'http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171158.jpg', 'http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171344.jpg']
let advsList = new Array(parseInt(Math.random() * 6) + 1)
  .fill(0)
  .map(() => ({
    'adv_id': Mock.mock('@id'),
    'inter_id': Mock.mock('@guid'),
    'hotel_id': Mock.mock('@id'),
    'name': Mock.mock('@ctitle(5,30)'),
    'name_en': Mock.mock('@title()'),
    'type|1-4': 1,
    'cat_id|1-4': 1,
    'product_id': Mock.mock('@id'),
    'logo': logos[parseInt(Math.random() * 3)],
    'link': '',
    'sort|1-5': 1,
    'status': Mock.mock('@integer(0,1)')
  }))

export default Mock.mock(advsList)
