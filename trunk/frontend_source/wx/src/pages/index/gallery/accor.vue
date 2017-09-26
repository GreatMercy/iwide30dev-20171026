<template>
  <div class="accor-header jfk-pl-30 jfk-pr-30" :class="{'is-show': brandname}" v-show="brandname">
    <div class="accor-header__cont font-size--24">
      <a class="link" href="http://pro.zzbzxl.com/html/creative/hotelwx/accor/index.html#/">
        <i class="jfk-font icon-icon_jump_normal"></i>
        <span class="back">
          <i class="logo"></i>
          <i class="text">返回</i>
        </span>
      </a>
      <div class="info" :class="{'has-hotel': hotel}">
        <div class="logo">
          <span class="logo-img"></span>
        </div>
        <div class="line">
        <div class="slash">
          <i></i>
          <i></i>
          <i></i>
        </div>
        </div>
        <div class="hotel">{{hotel}}</div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'accor-header',
    props: {
      hotel: String,
      brandname: String
    }
  }
</script>
