<template>
  <div class="jfk-pages jfk-pages__myorder">
    <div class="jfk-pages__theme"></div>
    <div class="order_list">
      <div v-for="(item,index) in orderList" :key="index"
           class="order_list_item">
        <!--前端路由-->
        <!--<div @click="toLocationHref('/order_detail?oid='+parseInt(item.id))">-->
        <!--线上环境-->
        <div @click="toLocationHref(item.ORDERDETAIL)">
          <orderStatus v-bind:orderItem="item"/>
          <template v-if="item.status === '9' || item.status === '0' || item.status === '1' || item.status_des === '待入住' ||
          item.status ==='2'">
            <div class="title font-size--38 active">
              {{item.hname}}
            </div>
            <div class="room_detail font-size--24 grayColorbf">
              <p class="item">
                {{item.first_detail.roomname}} - {{item.first_detail.price_code_name}} {{item.roomnums}}间 </p>
              <p class="item">
                入住 <span class="active">{{setDate(item.startdate)}}</span>
                离店 <span class="active">{{setDate(item.enddate)}}</span>
                {{accountNight(item.startdate, item.enddate)}}晚
              </p>
            </div>
            <div class="price goldColor">
              <i class="jfk-font-number jfk-price__currency">￥</i>
              <i class="jfk-font-number jfk-price__number font-size--38">{{item.price}}</i>
            </div>
          </template>
          <template v-else>
            <div class="title font-size--38 unactive">{{item.hname}}</div>
            <div class="room_detail font-size--24 grayColorbf">
              <p class="item">
                {{item.first_detail.roomname}} - {{item.first_detail.price_code_name}} {{item.roomnums}}间 </p>
              <p class="item">
                入住 <span class="unactive">{{setDate(item.startdate)}}</span>
                离店 <span class="unactive">{{setDate(item.enddate)}}</span>
                {{accountNight(item.startdate, item.enddate)}}晚
              </p>
            </div>
            <div class="price grayColor">
              <i class="jfk-font-number jfk-price__currency">￥</i>
              <i class="jfk-font-number jfk-price__number font-size--38">{{item.price}}</i>
            </div>
          </template>
          <orderTime v-bind:item="item"/>
        </div>
        <orderControl v-bind:item="item"/>
      </div>
    </div>
  </div>
</template>
<script>
  import {getOrderData} from '@/service/http'
  import orderStatus from './module/order_status.vue'
  import orderControl from './module/order_control.vue'
  import orderTime from './module/order_time.vue'

  export default {
    components: {
      orderStatus,
      orderControl,
      orderTime
    },
    beforeCreate () {
    },
    created () {
      this.getOrderList()
    },
    data () {
      return {
        orderList: [],
        outingTime: ''
      }
    },
    methods: {
      getOrderList () {
        let loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake',
          duration: -1,
          isLoading: true
        })
        getOrderData({id: this.id, openid: this.openid}).then((res) => {
          loading.close()
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
