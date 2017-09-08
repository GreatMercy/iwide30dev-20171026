<template>
  <div class="jfk-package-info jfk-pl-30 jfk-pr-30">
    <div class="jfk-package-info__content">

      <div class="jfk-package-info__base-info">

        <div class="jfk-package-info__base-info--left">
          <div class="jfk-package-info__base-info--title jfk-flex is-align-middle is-justify-center">
            <i class="jfk-font  icon-font_zh_li_1_qkbys"></i>
          </div>
        </div>

        <div class="jfk-package-info__base-info--right">
          <div class="jfk-package-info__base-info--content">
            <p class="name font-size--32">小狮子王A礼包</p>
            <p class="validity font-size--24">有效期至2017年8月29日</p>
            <p class="more" @click="changeStatus">
              <span class="font-size--24">详情</span>
              <span class="font-size--24 icon">
                   <i class="jfk-font icon-booking_icon_DN_norm" v-if="!status"></i>
                   <i class="jfk-font icon-booking_icon_up_normal" v-if="status"></i>
                </span>
            </p>
          </div>
        </div>
      </div>

      <ul class="jfk-package-info__more-info" v-if="status">
        <li class="jfk-flex">
          <span class="jfk-ta-l font-size--28">自助餐</span>
          <span class="jfk-ta-r font-size--28">1份</span>
        </li>

        <li class="jfk-flex">
          <span class="jfk-ta-l font-size--28">儿童乐园门票</span>
          <span class="jfk-ta-r font-size--28">1份</span>
        </li>
      </ul>

    </div>
  </div>
</template>
<script>
  export default {}
</script>
