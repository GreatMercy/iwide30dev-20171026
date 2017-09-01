/**
* 品质保证
* 随时退款
* 邮寄到家 can_mail
* 赠送好友 can_gift
* 到店自提 can_pickup
* 开具发票 can_invoice
* 七天退款
*/
export default {
  can_refund_3: {
    label: '随时退款',
    desc: '该商品支持有效期内随时退款',
    icon: 'icon-mall_icon_orderDetail_refund',
    key: 'can_refund_3'
  },
  can_mail: {
    label: '邮寄到家',
    desc: '该商品可邮寄到家，足不出户便收到货品',
    icon: 'icon-mall_icon_orderDetail_post',
    key: 'can_mail'
  },
  can_gift: {
    label: '赠送好友',
    desc: '该商品随时可以通过微信转赠给您的好友',
    icon: 'icon-mall_icon_orderDetai_gift',
    key: 'can_gift'
  },
  can_pickup: {
    label: '到店自提',
    desc: '该商品支持您到店领取',
    icon: 'icon-mall_icon_support_deliver',
    key: 'can_pickup'
  },
  can_invoice: {
    label: '开具发票',
    desc: '该商品支持开具发票',
    icon: 'icon-mall_icon_support_invoice',
    key: 'can_invoice'
  },
  can_refund: {
    label: '七天退款',
    desc: '该商品支持七天内退款，超过规定时间不可退，请您合理安排使用时间',
    icon: 'icon-mall_icon_orderDetail_refund',
    key: 'can_refund'
  }
}
