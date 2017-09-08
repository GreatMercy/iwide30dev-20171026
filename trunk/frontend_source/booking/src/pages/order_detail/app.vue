<template>
  <div class="jfk-pages jfk-pages__orderDetail">
    <div class="jfk-pages__theme"></div>

    <div class="order_status">
      <orderTime :states="states"/>
      <!--订单状态-->
      <orderStatus :orderItem="order"/>
      <p class="desc font-size--24 grayColor80">
        {{states.status_tips}}
      </p>
      <p class="order_btn">
        <span v-if="states.re_pay === 1" @click="toLocationHref(states.repay_url)" class="order-btn-item nowPay">
          <!--立即支付-->
          <i class="booking_icon_font font-size--30 icon-font_zh_li_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_ji_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_zhi_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_fu_2_qkbys"></i>
        </span>
        <span @click="toLocationHref(links.INDEX)"
              class="order-btn-item">
          <!--再次预定-->
          <i class="booking_icon_font font-size--30 icon-font_zh_zai__qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_ci_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_yv_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_ding_qkbys"></i>
        </span>
        <span v-if="states.can_cancel === 1" @click="cancelOrder(order.orderid)" class="order-text-item">
          <!--取消订单-->
          <i class="booking_icon_font font-size--30 icon-font_zh_qv_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_xiao_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_ding_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_dan_qkbys"></i>
        </span>
        <span v-else-if="states.can_comment === 1" @click="toLocationHref(links.TO_COMMENT)">
          <!-- 评论 -->
          <i class="booking_icon_font font-size--30 icon-font_zh_ping_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_lun_qkbys"></i>
        </span>
        <span v-if="states.self_checkout === 1" @click="toLocationHref(links.CHECK_OUT)"
              class="order-text-item">
          <!--退房-->
          <i class="booking_icon_font font-size--30 icon-font_zh_tui_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_fang_qkbys"></i>
        </span>
      </p>
    </div>
    <!-- 酒店详情 -->
    <div class="ht_del">
      <div class="ht_del_info" @click="getLocationData()">
        <p class="info_title font-size--34">{{hotel.name}}</p>
        <p class="info_place font-size--24">
          <i class="booking_icon_font icon-booking_icon_businessdistrict_norma font-size--30"></i>
          {{hotel.address}}
        </p>
        <span class="icon_dh font-size--24">
          <i class="booking_icon_font icon-booking_icon_navigation_normal  font-size--34"></i><br/>
          导 航
        </span>
      </div>
      <div class="bottom_container">
        <div class="hotel_room_info">
          <span class="font-size--28">{{roomname }}  - {{price_code_name}}</span>
          <span class="font-size--24">{{order.roomnums}}间</span>
        </div>
        <div class="live_time">
          <span class="left font-size--24">
            <span class="grayColorbf">入住</span>
            <span class="font-size--32 darkColor333">{{startdate}}</span>
            <span class="grayColor80">{{startDateWeekday}}</span>
          </span>
          <span class="right font-size--24">
            <span class="grayColorbf">离店</span>
            <span class="font-size--32 darkColor333">{{enddate}}</span>
            <span class="grayColor80">{{endDateWeekday}}</span>
          </span>
        </div>
        <p class="name font-size--28">
          {{order.name}} {{order.tel}}
        </p>
      </div>
    </div>
    <!-- 订单信息 -->
    <div class="order_info font-size--28">
      <p class="order_info_title font-size--24 grayColor80">订单信息</p>
      <p class="order_info_item grayColor80"><span>订单编号</span> <span
        class="font-size--30 darkColor333">{{order.show_orderid}}</span></p>
      <p class="order_info_item grayColor80"><span>支付类型</span> <span
        class="font-size--30 darkColor333">{{order.paytype_des}}</span>
      </p>
      <p class="order_info_item grayColor80"><span>下单时间</span> <span
        class="font-size--30 darkColor333">{{parseTime(order.order_time)}}</span>
      </p>
      <p class="order_info_item grayColor80"><span>优&nbsp惠&nbsp券</span> <span
        class="font-size--30 darkColor333">{{order.coupon_favour}}</span></p>
      <p class="order_info_item grayColor80"><span>积&nbsp&nbsp&nbsp&nbsp&nbsp分</span> <span
        class="font-size--30 darkColor333">{{order.point_favour}}</span></p>
    </div>
    <!-- 预定说明 -->
    <div class="booking_desc font-size--24">
      <p class="grayColor80 title"><i
        class="booking_icon_font font-size--28 icon-msg_icon_prompt_default grayColorbf"></i>&nbsp&nbsp预定说明</p>
      <p class="desc grayColorbf">
        {{hotel.book_policy}}
      </p>
    </div>
  </div>
</template>
<script>
  import {getOrderDetail, getCancelOrder} from '@/service/http'
  import orderStatus from './module/order_status.vue'
  import orderTime from './module/order_time.vue'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'

  export default {
    name: 'app',
    components: {
      orderStatus,
      orderTime
    },
    created () {
      // 获取订单id
      this.oid = formatUrlParams(location.href).oid || ''
      this.getDetailData()
    },
    data () {
      return {
        order: {},
        oid: 0,
        states: {},
        links: {},
        hotel: {},
        startDateWeekday: '',
        endDateWeekday: '',
        roomname: '',
        price_code_name: '',
        startdate: '',
        enddate: '',
        pay_ways: ''
      }
    },
    methods: {
      toLocationHref (href) {
        window.location.href = href
      },
      getDetailData () {
        getOrderDetail({oid: this.oid}).then((res) => {
          this.order = res.web_data.order
          this.states = res.web_data.states
          this.links = res.web_data.page_resource.links
          this.hotel = res.web_data.hotel
          this.startDateWeekday = res.web_data.startdate_weekday
          this.endDateWeekday = res.web_data.enddate_weekday
          this.roomname = this.order.first_detail.roomname
          this.price_code_name = this.order.first_detail.price_code_name
          this.startdate = this.setMyDate(this.order.startdate)
          this.enddate = this.setMyDate(this.order.enddate)
          let payType = this.order.paytype
          this.pay_ways = res.web_data.pay_ways[payType].pay_name
        })
      },
      // 将时间戳改为日期
      parseTime (time) {
        let oDate = new Date(time * 1000)
        let year = oDate.getFullYear()
        let month = oDate.getMonth() + 1
        let day = oDate.getDate()
        if (year >= 0 && year <= 9) {
          year = '0' + year
        }
        if (month >= 0 && month <= 9) {
          month = '0' + month
        }
        if (day >= 0 && day <= 9) {
          day = '0' + day
        }
        return year + '.' + month + '.' + day
      },
      // 设置年月日期的格式
      setMyDate (strDate) {
        return strDate.substring(0, 4) + '/' + strDate.substring(4, 6) + '/' + strDate.substring(6, 8)
      },
      // 取消订单
      cancelOrder (oid) {
        // 确认
        this.$jfkConfirm('是否确定删除?').then(action => {
          if (action === 'confirm') {
            this.toast = this.$jfkToast({
              duration: -1,
              iconClass: 'jfk-loading__snake',
              isLoading: true
            })
            getCancelOrder({oid: oid}).then((res) => {
              this.toast.close()
              window.location.reload()
            }).catch(() => {
              this.toast.close()
            })
          }
        }).catch(() => {
        })
      },
      // 获取位置
      getLocationData () {
        window.wx.openLocation({
          latitude: parseFloat(this.hotel.latitude), // 纬度，浮点数，范围为90 ~ -90
          longitude: parseFloat(this.hotel.longitude), // 经度，浮点数，范围为180 ~ -180。
          name: this.hotel.name, // 位置名
          address: this.hotel.address, // 地址详情说明
          scale: 1, // 地图缩放级别,整形值,范围从1~28。默认为最大
          infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
        })
      }
    }
  }
</script>
