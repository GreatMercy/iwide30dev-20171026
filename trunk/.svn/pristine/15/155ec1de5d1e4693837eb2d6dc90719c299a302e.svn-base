<template>
  <div>
    <bc />
    <headTitle :headTitleMsg="headTitleMsg" />
    <orderStatus :orderStatus="orderStatusMsg"/>
    <orderProfile :orderProfileObject="orderProfileObject" />
    <orderCoupon :orderCouponObject="orderCouponObject"/>
    <orderInfo @TSshow="TSshow = true" :orderInfoObject="orderInfoObject" />
    <orderBtns />
    <transactionSnapshot v-if="TSshow" @TSclose="TSshow = false" transition="fade"/>
  </div>
</template>
<script>
  import bc from '../../components/common/background_color'
  import headTitle from '../../components/common/headTitle'
  import orderStatus from '../../components/orderDetail/orderStatus.vue'
  import orderProfile from '../../components/orderDetail/orderProfile.vue'
  import orderInfo from '../../components/orderDetail/orderInfo.vue'
  import orderBtns from '../../components/orderDetail/orderBtns.vue'
  import orderCoupon from '../../components/orderDetail/orderCoupon.vue'
  import transactionSnapshot from '../../components/orderDetail/transactionSnapshot.vue'

  export default {
    name: 'orderDetail',
    components: {
      bc,
      headTitle,
      orderStatus,
      orderProfile,
      orderInfo,
      orderBtns,
      orderCoupon,
      transactionSnapshot
    },
    data () {
      return {
        TSshow: false,
        headTitleMsg: '该商品由柚子酒店提供',
        orderStatusMsg: '购买成功.',
        orderProfileObject: {
          goodsName: '金房卡酒店月饼月饼圈圈',
          validPeriod: '有效期 2017／10／30',
          goodsPrice: '987'
        },
        orderInfoObject: {
          orderNumber: '1208328478',
          offerTime: '2017/05/01',
          orderPrice: '987'
        },
        orderCouponObject: [
          {
            status: 'normal',
            coupons: '321321312'
          },
          {
            status: 'normal',
            coupons: '321321312'
          },
          {
            status: 'used',
            coupons: '321321312'
          },
          {
            status: 'send',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          },
          {
            status: 'gift',
            coupons: '321321312'
          }
        ]
      }
    }
  }
</script>
<style>
</style>
