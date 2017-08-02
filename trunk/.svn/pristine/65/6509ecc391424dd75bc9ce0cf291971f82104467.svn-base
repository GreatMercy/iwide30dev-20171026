<template>
  <div class="order-detail">
    <count-down :remainingTime="remainingTime" v-if="remainingTime"></count-down>
    <jperation-title :title="shop.shop_name" :class="{'remaining': remainingTime}"></jperation-title>
    <order-detail :status="status" :list="goods" :total="total" :title="title"></order-detail>
    <user-info ref="userInfo" :userInfo="info" :disabled="true"></user-info>
    <tip :content="'订单订单支付成功后，不支持退换以及变更消费时间'"></tip>
    <restaurant-info></restaurant-info>
    <order-info></order-info>
    <watermark></watermark>
    <order-footer></order-footer>
  </div>
</template>

<script>
  import countDown from './modules/countDown'  // 倒计时
  import title from '@components/title/index'  // 标题
  import orderDetail from '@components/orderDetail/index'  // 订单详情
  import userInfo from '@components/userInfo' // 订单预约信息
  import tip from '@components/tip/index' // 订单温馨提示
  import restaurantInfo from './modules/restaurantInfo' // 餐厅信息
  import orderInfo from './modules/orderInfo' // 订单信息
  import orderFooter from './modules/footer' // 底部
  import { closeAll } from '@js/popup'
  import axios from 'axios'
  import { wxApiCall } from '@js/wx'
  import watermark from '@components/watermark/index'

  export default {
    data () {
      return {
        title: '需付'
      }
    },
    watch: {
      info (val) {
        if (val) {
          // 1-待消费，2-已消费，3-已取消, 4-未支付
          if (val['order_btn'] === 1) {
            this.title = '已付'
          } else if (val['order_btn'] === 2) {
            this.title = '已付'
          } else if (val['order_btn'] === 3) {
            this.title = '需付'
          } else if (val['order_btn'] === 4) {
            this.title = '需付'
          }
        }
      }
    },
    computed: {
      status () {
        return this.$store.getters.status
      },
      goods () {
        return this.$store.getters.orderDetail['goods'] || []
      },
      total () {
        return this.$store.getters.orderDetail['order'] || {'discount_fee': '', 'total_fee': ''}
      },
      shop () {
        return this.$store.getters.orderDetail['shop'] || {}
      },
      info () {
        return this.$store.getters.orderDetail['order'] || {}
      },
      remainingTime () {
        let store = this.$store.getters.orderDetail.order
        let time = ''
        if (store) {
          time = store['out_time']
        }
        return time
      }
    },
    components: {
      jperationTitle: title,
      orderDetail,
      userInfo,
      countDown,
      tip,
      restaurantInfo,
      orderInfo,
      orderFooter,
      watermark
    },
    created () {
      axios.all([this.$store.dispatch('getOrderDetail', {}), this.$store.dispatch('getWxConfig')]).then((res) => {
        if (res) {
          wxApiCall(res[1]['data']['wx_config'], 'hideMenu', {
            'imgUrl': res[0]['data']['shop']['share_img'],
            'link': window.location.href,
            'title': res[0]['data']['shop']['share_title'],
            'desc': res[0]['data']['shop']['share_spec']
          })
          closeAll()
        }
      })
    }
  }
</script>

<style lang="scss" scoped>
  @import '../../common/scss/include';

  .order-detail {
    .jperation-title {
      margin: px2rem(48) auto px2rem(62);
    }
    .remaining {
      margin-top: px2rem(66 + 48);
    }

    .watermark {
      margin-top: px2rem(146);
      margin-bottom: px(100 + 58);
    }
  }

</style>
