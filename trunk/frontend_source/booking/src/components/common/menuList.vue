<template>
  <div class="jfk-menuList">
      <div class="menu-inn jfk-flex">
          <div class="item"><a href=""><i class="jfk-font icon-user_icon_Checkin_normal"></i><p class="font-size--24">预约</p></a></div>
          <div class="item"><a href=""><i class="jfk-font icon-mall_icon_orderDetail_verify"></i><p class="font-size--24">验券</p></a></div>
          <div class="item"><a href=""><i class="jfk-font icon-mall_icon_orderDetail_post"></i><p class="font-size--24">邮寄</p></a></div>
          <div class="item"><a href=""><i class="jfk-font icon-user_icon_Reservatio"></i><p class="font-size--24">订房</p></a></div>
          <div class="item"><a href=""><i class="jfk-font icon-user_icon_Polite_nor"></i><p class="font-size--24">转赠</p></a></div>

      </div>
  </div>
</template>
<script>
export default{
  name: 'menulist',
  props: ['menu']
}
</script>
