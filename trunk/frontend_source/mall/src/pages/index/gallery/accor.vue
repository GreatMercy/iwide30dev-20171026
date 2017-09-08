<template>
  <div class="accor-header jfk-pl-30 jfk-pr-30" v-show="hotel">
    <div class="accor-header__cont font-size--24">
      <a class="link" href="http://pro.zzbzxl.com/html/creative/hotelwx/accor/index.html#/">
        <i class="jfk-font icon-icon_jump_normal"></i>
        <span class="back">
          <i class="logo"></i>
          <i class="text">返回</i>
        </span>
      </a>
      <div class="info">
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
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import data from '@/gallery/accor/data.js'
  export default {
    name: 'accor-header',
    beforeCreate () {
      let params = formatUrlParams(location.href)
      let info = data[params.tkid] || {}
      this.hotel = info.hotel
    }
  }
</script>
