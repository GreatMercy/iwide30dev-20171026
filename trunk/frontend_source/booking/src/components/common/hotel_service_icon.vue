<template>
  <div class="ht_del_ul_container">
    <p class="ht_sth font-size--24">酒店设施</p>
    <ul class="ht_del_ul font-size--28">
      <template v-for="(item,index) in hotel_service">
        <li v-if="item.info === '浴缸'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_Bathcro"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '温泉'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_Hotspr"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '管家'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_houseke"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '游泳池'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_swimmin"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '餐厅'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_restaur"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '因特网接口'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_interfa"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '叫醒'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_iTowak"></i>{{item.info}}
        </li>
        <!--室外暂无-->
        <!--<li v-else-if="item.info === '室外'">-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 "></i>{{item.info}}-->
        <!--</li>-->
        <li v-else-if="item.info === '停车'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_parking"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === 'Wifi'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_wifi_no"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '寄存'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_registe"></i>{{item.info}}
        </li>
        <!--餐厅与上面雷同-->
        <!--<li v-else-if="item.info === '餐厅'">-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-booking_icon_chineserestaurant_normal"></i>{{item.info}}-->
        <!--</li>-->
        <li v-else-if="item.info === '热水'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_hotwat"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '24小时热水'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_h_nor"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '会议室'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_meetingroom_normal"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '接机'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_bus_normal"></i>{{item.info}}
        </li>
        <li v-else-if="item.info === '洗衣'" :key="index">
          <i class="booking_icon_font font-size--30 icon-booking_icon_laundryservice_normal"></i>{{item.info}}
        </li>
      </template>
    </ul>
  </div>
</template>
<script>
  export default {
    name: 'hotelServiceIcon',
    props: ['hotel_service']
  }
</script>
