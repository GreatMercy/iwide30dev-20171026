<template>
  <div class="jfk-pages jfk-pages__gift-detail jfk-ta-c" :class="theme">

    <div class="gift-container">

      <giftBg :wish="info.wish"></giftBg>

      <div class="gift-goods-img jfk-ta-c jfk-pl-30 jfk-pr-30">
        <div v-if="info.face_img" :style="'background-image:url('+ info.face_img + ')'" class="gift-goods-img__content"></div>
      </div>

      <p class="gift-goods-name jfk-ta-c font-size--30 jfk-pl-30 jfk-pr-30" v-html="info.name"></p>
      <p class="gift-goods-number jfk-ta-c font-size--24 jfk-pl-30 jfk-pr-30"
         v-html="'已使用'+ info.used +'/' + info.qty_origin + '份'"></p>

      <p class="gift-goods-btn">
        <button class="jfk-button jfk-button--primary  jfk-button--free" @click="link(info.goods_link)">
          <span class="font-size--34">
            立即查看
          </span>
        </button>
      </p>

      <div class="gift-detail-bottom">
        <div class="gift-detail-line"></div>
        <a class="jfk-ta-c gift-detail-put-order"
           :href="info.link || 'javascript:void(0)'">
          <i class="font-size--28">暂不使用，放至订单中心</i>
          <span class="jfk-d-ib jfk-font icon-user_icon_jump_normal"></span>
        </a>
      </div>

    </div>

  </div>
</template>
<script>
  import giftBg from '@/components/gift/gift_background'
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
    methods: {
      link (href) {
        if (href) {
          window.location.href = href
        }
      }
    },
    components: {
      giftBg
    }
  }
</script>
