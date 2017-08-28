<template>
  <div class="jfk-pages jfk-pages__myorder">
    <div class="jfk-pages__theme" style="left: 0;top: 0;"></div>
    <div class="order_list" :infinite-scroll-disabled="disableLoadList" :infinite-scroll-distance="0">
      <div v-for="(item,index) in orderList" @click="toLocationHref(item.ORDERDETAIL)" :key="index"
           class="order_list_item">
        <span>大声告诉我 {{index}}</span>
        <orderStatus v-bind:orderItem="item"/>
        <div class="title font-size--38">
          {{item.hname}}
        </div>
        <div class="room_detail font-size--24 grayColorbf">
          <p class="item">{{item.first_detail.roomname}} - {{item.first_detail.price_code_name}} {{item.roomnums}}间 </p>
          <p class="item">
            入住 <span>{{setDate(item.startdate)}}</span>
            离店 <span>{{setDate(item.enddate)}}</span>
            {{accountNight(item.startdate, item.enddate)}}晚
          </p>
        </div>
        <div class="price goldColor">
          <i class="jfk-font-number jfk-price__currency">￥</i>
          <i class="jfk-font-number jfk-price__number font-size--38">{{item.price}}</i>
        </div>

        <div v-if="item.status_des === '待支付'" class="count_down grayColorbf">
          支付倒计时 <span class="goldColor font-size--28">{{item.orderstate.last_repay_time}}</span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import {getOrderData} from '@/service/http'
  import orderStatus from './module/order_status.vue'
  // import rater from '../../../../common/components/src/packages/jfk-rater/src/main'
  export default {
    watch: {},
    components: {
      orderStatus
    },
    beforeCreate () {
    },
    created () {
      this.getOrderList()
    },
    data () {
      return {
        // 模拟id，后期由后台加上
        id: 'a429262687',
        openid: 'oX3WojhfNUD4JzmlwTzuKba1MywY',
        orderList: []
      }
    },
    methods: {
      getOrderList () {
        getOrderData({id: this.id, openid: this.openid}).then((res) => {
          this.orderList = res.web_data.orders
        })
      },
      toLocationHref (href) {
        window.location.href = href
      },
      // 设置年月日期的格式
      setDate (strDate) {
        return strDate.substring(4, 6) + '/' + strDate.substring(6, 8)
      },
      // 计算几晚
      accountNight (start, end) {
        return end.substring(6, 8) - start.substring(6, 8)
      }
    }
  }
</script>
