<template>
  <div class="btn_container">
    <template v-if="item.re_pay === '1'">
      <!--立即支付-->
      <span class="order_btn" @click="toLocationHref(item.orderstate.repay_url)">
            <i class="booking_icon_font font-size--30 icon-font_zh_li_qkbys"></i>
            <i class="booking_icon_font font-size--30 icon-font_zh_ji_qkbys"></i>
            <i class="booking_icon_font font-size--30 icon-font_zh_zhi_qkbys"></i>
            <i class="booking_icon_font font-size--30 icon-font_zh_fu_2_qkbys"></i>
      </span>
    </template>
    <template v-else>
      <span v-if="item.status === '3' && item.can_comment === '1' " class="comment"
            @click="toLocationHref(item.TO_COMMENT+'?oid='+item.id)">
      <!-- 评论 -->
      <i class="booking_icon_font font-size--30 icon-font_zh_ping_qkbys"></i>
      <i class="booking_icon_font font-size--30 icon-font_zh_lun_qkbys"></i>
      </span>
      <!--退房-->
      <template v-if="item.orderstate.self_checkout !== 0">
        <span v-if="item.orderstate.self_checkout === 1" class="return"
              @click="toLocationHref(item.CHECK_OUT+'?oid='+item.id)">
          <!--退房-->
          <i class="booking_icon_font font-size--30 icon-font_zh_tui_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_fang_qkbys"></i>
        </span>
        <span v-else class="return" @click="toLocationHref('javascript:void(0)')">
          <!--已预约退房-->
          <i class="booking_icon_font font-size--30 icon-font_zh_yi_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_yv_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_yue_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_tui_qkbys"></i>
          <i class="booking_icon_font font-size--30 icon-font_zh_fang_qkbys"></i>
        </span>
      </template>
      <!--再次预定-->
      <span class="order_btn whiteColor" @click="toLocationHref(item.INDEX+'?h='+item.hotel_id)">
        <i class="booking_icon_font font-size--30 icon-font_zh_zai__qkbys"></i>
        <i class="booking_icon_font font-size--30 icon-font_zh_ci_qkbys"></i>
        <i class="booking_icon_font font-size--30 icon-font_zh_yv_qkbys"></i>
        <i class="booking_icon_font font-size--30 icon-font_zh_ding_qkbys"></i>
      </span>
    </template>
  </div>
</template>
<script>
  export default {
    name: 'orderControl',
    props: ['item'],
    methods: {
      toLocationHref (href) {
        window.location.href = href
      }
    }
  }
</script>
