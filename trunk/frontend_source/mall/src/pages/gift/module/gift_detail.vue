<template>
  <div class="jfk-pages jfk-pages__gift-detail jfk-ta-c" :class="theme">
    <giftBg :wish="info.wish"></giftBg>
    <p class="gift-goods-img jfk-ta-c jfk-pl-30 jfk-pr-30">
      <img :src="info.face_img">
    </p>
    <p class="gift-goods-name jfk-ta-c font-size--30 jfk-pl-30 jfk-pr-30" v-html="info.name"></p>
    <p class="gift-goods-number jfk-ta-c font-size--24 jfk-pl-30 jfk-pr-30"
       v-html="'已使用'+ info.used +'/' + info.qty_origin + '份'"></p>
    <p class="gift-goods-btn">
      <button class="jfk-button jfk-button--primary  jfk-button--free">
      <span class="jfk-button__text font-size--34">
        <i class="jfk-font jfk-button__text-item icon-font_zh_li_qkbys"></i>
        <i class="jfk-font jfk-button__text-item icon-font_zh_ji_qkbys"></i>
        <i class="jfk-font jfk-button__text-item icon-font_zh_cha_qkbys"></i>
        <i class="jfk-font jfk-button__text-item icon-font_zh_kan_qkbys"></i>
      </span>
      </button>
    </p>

    <div class="gift-detail-bottom">
      <div class="gift-detail-line"></div>
      <a class="font-size--28 jfk-ta-c gift-detail-put-order" :href="info.link || 'javascript:void(0)'">暂不使用，放至订单中心</a>
    </div>
  </div>
</template>
<script>
  import giftBg from '@/components/gift_themes/gift_background'
  export default {
    name: 'giftDetail',
    props: {
      theme: {
        type: String,
        default: ''
      },
      info: {
        type: Object
      }
    },
    components: {
      giftBg
    },
    watch: {
      info (val) {
        console.log(val)
      }
    }
  }
</script>
