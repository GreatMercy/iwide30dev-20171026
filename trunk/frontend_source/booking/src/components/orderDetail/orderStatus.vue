<template>
    <div class="orderDetail__state jfk-pl-30 jfk-pr-30 ">
      <div class="orderDetail__state__main">
        <img src="../../assets/image/goldlight.png" class="goldlight">
        <div class="orderDetail__state__type color-golden">
          <i class="jfk-font icon-font_zh_yi_qkbys"></i>
          <i class="jfk-font icon-font_zh_zhi_qkbys"></i>
          <i class="jfk-font icon-font_zh_fu_qkbys"></i>.</div>
        <div class="orderDetail__state__tip font-size--24 " v-if="showtip">期待你的使用~</div>
      </div>
    </div>
</template>
<script>
export default{
  name: 'orderStatus',
  props: ['showtip']
}
</script>

