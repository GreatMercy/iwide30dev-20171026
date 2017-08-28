<template>
  <div class="btn_container pay_now">
            <span class="comment" v-show="false">
              <i class="booking_icon_font font-size--24 icon-font_zh_yv_qkbys"></i><i
              class="booking_icon_font font-size--24 icon-font_zh_yv_qkbys"></i>
            </span>
    <span class="return" v-show="false">
              <i class="booking_icon_font font-size--24 icon-font_zh_yv_qkbys"></i>
              <i class="booking_icon_font font-size--24 icon-font_zh_yv_qkbys"></i>
            </span>
    <span class="order_btn whiteColor">
              <i class="booking_icon_font font-size--24 icon-font_zh_yv_qkbys"></i><i
      class="booking_icon_font font-size--24 icon-font_zh_yv_qkbys"></i><i
      class="booking_icon_font font-size--24 icon-font_zh_yv_qkbys"></i>
            </span>
  </div>

</template>
<script>
  export default {
    name: 'orderControl',
    props: ['orderControl']
  }
</script>
