<template>
  <div class="btn_container font-size--28">
    <template v-if="item.re_pay === '1'">
      <!--立即支付-->
      <span class="order_btn" @click="toLocationHref(item.orderstate.repay_url)">
            <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_li_qkbys"></i>-->
            <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_ji_qkbys"></i>-->
            <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_zhi_qkbys"></i>-->
            <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_fu_2_qkbys"></i>-->
            立即支付
      </span>
    </template>
    <template v-else>
      <span v-if="item.status === '3' && item.can_comment === '1' " class="comment"
            @click="toLocationHref(item.TO_COMMENT)">
      <!-- 评论 -->
      <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_ping_qkbys"></i>-->
      <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_lun_qkbys"></i>-->
        评论
      </span>
      <!--退房-->
      <template v-if="item.orderstate.self_checkout !== 0">
        <span v-if="item.orderstate.self_checkout === 1" class="return"
              @click="toLocationHref(item.CHECK_OUT)">
          <!--退房-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_tui_qkbys"></i>-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_fang_qkbys"></i>-->
          退房
        </span>
        <span v-else class="return" @click="toLocationHref('javascript:void(0)')">
          <!--已预约退房-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_yi_qkbys"></i>-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_yv_qkbys"></i>-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_yue_qkbys"></i>-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_tui_qkbys"></i>-->
          <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_fang_qkbys"></i>-->
          已预约退房
        </span>
      </template>
      <!--再次预定-->
      <span class="order_btn whiteColor" @click="toLocationHref(item.INDEX)">
        <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_zai__qkbys"></i>-->
        <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_ci_qkbys"></i>-->
        <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_yv_qkbys"></i>-->
        <!--<i class="booking_icon_font font-size&#45;&#45;30 icon-font_zh_ding_qkbys"></i>-->
        再次预定
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
