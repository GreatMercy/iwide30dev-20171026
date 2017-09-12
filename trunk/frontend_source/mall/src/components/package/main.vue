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
            <p class="name font-size--32" v-text="info.name" v-if="info.name"></p>
            <p class="validity font-size--24" v-text="'有效期至' +info.time" v-if="info.time"></p>
            <p class="more" @click="changeStatus" v-if="info && info.products && info.products.length > 0">
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
        <li class="jfk-flex" v-if="info && info.products && info.products.length > 0"
            v-for="(item, index) in info.products" :key="index">
          <span class="jfk-ta-l font-size--28" v-text="item.name">自助餐</span>
          <span class="jfk-ta-r font-size--28" v-text="item.num"></span>
        </li>

      </ul>

    </div>
  </div>
</template>
<script>
  export default {
    props: {
      status: {
        type: Boolean,
        default: false
      },
      info: {
        type: Object,
        default: function () {
          return {}
        }
      }
    },
    methods: {
      changeStatus () {
        this.$emit('changeStatus')
      }
    }
  }
</script>
