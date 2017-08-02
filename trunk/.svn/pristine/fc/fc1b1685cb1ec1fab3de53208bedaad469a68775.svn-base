<template>
  <div id="submit">
    <jperation-title :title="shop.shop_name"></jperation-title>
    <order-detail :status="false" :list="goods" :total="total"></order-detail>
    <user-info ref="userInfo" :userInfo="info"></user-info>
    <tip :content="'订单订单支付成功后，不支持退换以及变更消费时间'"></tip>
    <watermark></watermark>
    <pay-footer :submitTitle="'提交订单'" @pay="submitOrder" :price="price"></pay-footer>
  </div>
</template>

<script>
  import title from '@components/title/index'  // 标题
  import orderDetail from '@components/orderDetail/index'  // 订单详情
  import userInfo from '@components/userInfo' // 订单预约信息
  import tip from '@components/tip/index' // 订单温馨提示
  import payFooter from '@components/payFooter' // 底部
  import watermark from '@components/watermark/index'
  import { errorMessage } from '@js/popup'
  import axios from 'axios'
  import { wxApiCall } from '@js/wx'
  export default {
    computed: {
      checkout () {
        return this.$store.getters.checkout
      },
      goods () {
        return this.$store.getters.checkout['goods'] || []
      },
      total () {
        return this.$store.getters.checkout['total'] || {'discount_fee': '', 'total_fee': ''}
      },
      price () {
        return this.total.total_fee
      },
      shop () {
        return this.$store.getters.checkout['shop'] || {}
      },
      info () {
        return this.$store.getters.checkout['user_info'] || {}
      }
    },
    methods: {
      submitOrder () {
        const result = this.$refs.userInfo.verification()
        if (result['status']) {
          this.$store.dispatch('saveOrder', result)
        } else {
          errorMessage(result['msg'])
        }
      }
    },
    data () {
      return {}
    },
    created () {
      axios.all([this.$store.dispatch('getCheckout', {}), this.$store.dispatch('getWxConfig')]).then((res) => {
        if (res) {
          wxApiCall(res[1]['data']['wx_config'], 'hideMenu')
        }
      })
    },
    components: {
      jperationTitle: title,
      orderDetail,
      userInfo,
      tip,
      payFooter,
      watermark
    }
  }
</script>

<style lang="scss" scoped>

  @import '../../common/scss/include';

  .jperation-title {
    margin: px2rem(48) auto px2rem(62);
  }

  .watermark {
    margin-top: px2rem(146);
    margin-bottom: px(100 + 58);
  }


</style>
