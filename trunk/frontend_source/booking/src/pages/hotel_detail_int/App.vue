<template>
  <div class="jfk-pages jfk-pages__hotelDetailint">
    <div class="jfk-pages__theme"></div>
    <div class="ht_del_top">
      <div class="ht_del_top_info" @click="getLocationData()">
        <p class="info_title font-size--34">{{hotel.name}}</p>
        <p class="info_place font-size--24">
          <i class="booking_icon_font icon-booking_icon_businessdistrict_norma font-size--30"></i>
          {{hotel.address}}
        </p>
        <span class="icon_dh font-size--24">
          <i class="booking_icon_font icon-booking_icon_navigation_normal  font-size--34"></i>
          <span>导 航</span>
        </span>
      </div>
      <div class="ht_tel font-size--28">
        <span>酒店电话： {{hotel.tel}}</span>
        <i class="booking_icon_font icon-mall_icon_reservation_contact font-size--28 icon_tel"
           @click="phoneCall(hotel.tel)"></i>
      </div>
    </div>
    <!--酒店设施 组件-->
    <hotelServiceIcon :hotel_service="hotelService"/>
    <div class="ht_int font-size--28">
      <p class="ht_int_title">酒店介绍</p>
      <p class="ht_int_del">
        {{hotel.intro}}
      </p>
    </div>
  </div>
</template>
<script>
  import {getHotelIntDetail} from '@/service/http'
  import hotelServiceIcon from '../../components/common/hotel_service_icon.vue'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'

  export default {
    components: {
      hotelServiceIcon
    },
    created () {
      this.hotel_id = formatUrlParams(location.href).h || ''
      this.getHotelData()
    },
    data () {
      return {
        hotel_id: 0,
        hotel: {},
        hotelService: ''
      }
    },
    methods: {
      // 获取酒店数据
      getHotelData () {
        getHotelIntDetail({h: this.hotel_id}).then((res) => {
          this.hotel = res.web_data.hotel
          this.hotelService = this.hotel.imgs.hotel_service
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
      },
      // 拨打酒店电话
      phoneCall (tel) {
        window.location.href = 'tel://' + tel
      }
    }
  }
</script>
