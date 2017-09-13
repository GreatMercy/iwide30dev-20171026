<template>
  <!--这里只有已确认是金色的，待确认和待支付时黑色的，其他的各种取消和入住状态的都是灰色,前面的分隔符只有各种取消和入住状态是灰色-->
  <div v-if="orderItem.status_des === '待确认'" class="status darkBlack1a">
    <!--<span>待确认.</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_dai_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_que_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_ren_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '已确认'" class="status goldColor">
    <!--<span>已确认.</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_yi_a_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_que_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_ren_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '下单失败'" class="status grayColorbf">
    <!--<span>下单失败</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_xia_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_dan_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_shi_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_bai_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '系统取消'" class="status grayColorbf">
    <!--<span>系统取消</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_xi_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_tong_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_qv_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_xiao_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '已入住'" class="status grayColorbf">
    <!--<span>已入住</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_yi_a_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_ru_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_zhu_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '已离店'" class="status grayColorbf">
    <!--<span>已离店</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_yi_a_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_li__qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_dian_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '用户取消'" class="status grayColorbf">
    <!--用户取消-->
    <!--<span>用户取消</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_yong_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_hu_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_qv_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_xiao_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '酒店取消'" class="status grayColorbf">
    <!--酒店取消-->
    <!--<span>酒店取消</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_jiu_a_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_dian_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_qv_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_xiao_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '酒店删除'" class="status grayColorbf">
    <!--酒店删除-->
    <!--<span>酒店删除</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_jiu_a_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_dian_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_shan_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_chu_2_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '异常'" class="status grayColorbf">
    <!--异常-->
    <!--<span>异常</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_yi_1_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_chang_1_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '未到'" class="status grayColorbf">
    <!--未到-->
    <!--<span>未到</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_wei_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_dao_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '待支付'" class="status darkBlack1a">
    <!--待支付-->
    <!--<span>待支付</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_dai_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_zhi_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_fu_2_qkbys"></i>.
  </div>
  <div v-else-if="orderItem.status_des === '多订单'" class="status grayColorbf">
    <!--多订单-->
    <!--<span>多订单</span>-->
    <i class="booking_icon_font font-size--60 icon-font_zh_duo_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_ding_qkbys"></i>
    <i class="booking_icon_font font-size--60 icon-font_zh_dan_qkbys"></i>.
  </div>
</template>
<script>
  export default {
    name: 'orderStatus',
    props: ['orderItem']
  }
</script>

