<template>
  <div v-if="orderItem.status_des === '待确认'" class="status goldColor">
    <span>待确认.</span>
    <i class="booking_icon_font font-size--24 icon-font_zh_dai_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_que_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_ren_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '已确认'" class="status goldColor">
    <span>已确认.</span>
    <i class="booking_icon_font font-size--24 icon-font_zh_yi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_que_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_ren_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '下单失败'" class="status goldColor">
    <span>下单失败</span>
    <!--下暂时缺少-->
    <i class="booking_icon_font font-size--24 icon-font_zh_yi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_dan_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_shi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_bai_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '系统取消'" class="status goldColor">
    <span>系统取消</span>
    <!--系统取 3个字暂无-->
    <i class="booking_icon_font font-size--24 icon-font_zh_yi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_dan_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_shi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_xiao_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '已入住'" class="status goldColor">
    <span>已入住</span>
    <i class="booking_icon_font font-size--24 icon-font_zh_yi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_ru_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_zhu_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '已离店'" class="status goldColor">
    <span>已离店</span>
    <i class="booking_icon_font font-size--24 icon-font_zh_yi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_li__qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_dian_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '用户取消'" class="status goldColor">
    <!--用户取消-->
    <i class="booking_icon_font font-size--24 icon-font_zh_yong_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_hu_qkbys"></i>
    <!--取暂时无-->
    <i class="booking_icon_font font-size--24 icon-font_zh_dian_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_xiao_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '酒店取消'" class="status goldColor">
    <!--酒店取消-->
    <i class="booking_icon_font font-size--24 icon-font_zh_jiu_fzdbs"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_dian_qkbys"></i>
    <!--取暂时无-->
    <i class="booking_icon_font font-size--24 icon-font_zh_dian_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_xiao_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '酒店删除'" class="status goldColor">
    <!--酒店删除-->
    <i class="booking_icon_font font-size--24 icon-font_zh_jiu_fzdbs"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_dian_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_shan_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_chu_2_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '异常'" class="status goldColor">
    <!--异常-->
    <i class="booking_icon_font font-size--24 icon-font_zh_jiu_fzdbs"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_dian_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '未到'" class="status goldColor">
    <!--未到-->
    <i class="booking_icon_font font-size--24 icon-font_zh_wei_qkbys"></i>
    <!--到字暂无-->
    <i class="booking_icon_font font-size--24 icon-font_zh_dian_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '待支付'" class="status goldColor">
    <!--待支付-->
    <i class="booking_icon_font font-size--24 icon-font_zh_dai_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_zhi_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_fu_2_qkbys"></i>
  </div>
  <div v-else-if="orderItem.status_des === '多订单'" class="status goldColor">
    <!--多订单-->
    <i class="booking_icon_font font-size--24 icon-font_zh_dai_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_ding_qkbys"></i>
    <i class="booking_icon_font font-size--24 icon-font_zh_dan_qkbys"></i>
  </div>
</template>
<script>
  export default {
    name: 'orderStatus',
    props: ['orderItem']
  }
</script>
