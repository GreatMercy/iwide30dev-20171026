<template>
  <div id="detail-banner">

    <div v-if="goodsDetail.banner_length === 1" class="swiper">
      <a href="javascript:void(0)" class="pr img-wrap">
        <img :src="goodsDetail.goods_img[0]" alt="" class="pa">
      </a>
    </div>

    <swiper :options="swiperOption" v-if="goodsDetail.banner_length > 1">
      <swiper-slide v-for="(item, index) in goodsDetail.goods_img" :key="index">
        <a href="javascript:void(0)" class="pr img-wrap">
          <img :src="item" alt="" class="pa">
        </a>
      </swiper-slide>
    </swiper>

    <div class="swiper-pagination pa" slot="pagination" v-if="goodsDetail.banner_length > 1"></div>
    <div class="bg pa"></div>
    <div class="info pa">
      <p class="name f36" v-html="goodsDetail.goods_name"></p>
      <p class="desc tofle f24" v-html="goodsDetail.goods_alias"></p>
    </div>
  </div>

</template>

<script>
  import swiper from '@components/swiper/swiper.vue'
  import swiperSlide from '@components/swiper/slide'

  export default {
    data () {
      return {
        swiperOption: {
          loop: true,
          autoplay: false,
          autoplayDisableOnInteraction: false,
          pagination: '.swiper-pagination',
          paginationType: 'fraction'
        }
      }
    },
    computed: {
      goodsDetail () {
        return this.$store.getters.goodsDetail
      }
    },
    components: {
      swiper,
      swiperSlide
    }
  }
</script>

<style lang="scss">
  @import '../../../common/scss/include';

  #detail-banner {
    overflow: hidden;

    .img-wrap {
      display: block;
      min-height: px2rem(778);
      width: 100%;
      background: url(../img/default.png) center px2rem(210) no-repeat;
      background-size: px2rem(256) px2rem(266);
      img {
        min-height: px2rem(778);
        width: 100%;
        left: 50%;
        transform: translate(-50%, 0);
        top: 0;
      }
    }
    position: relative;
    .swiper-wrapper {
      text-align: center;
    }

    .swiper-container {
      z-index: 0;
    }

    .swiper-pagination {
      left: - 4%;
      bottom: 21%;
      color: $white;
      z-index: 10;
      text-align: right;
      .swiper-pagination-current {
        font-size: px2rem(38);
        @media screen and (min-width: 414px) {
          font-size: px2rem(38);
        }
      }
    }

    .bg {
      width: 100%;
      height: px2rem(409);
      left: 0;
      bottom: -1px;
      background: url(../img/bg.png) center bottom no-repeat;
      background-size: 100% 100%;
      z-index: 1;
    }

    .info {
      width: 100%;
      height: px2rem(140);
      color: $white;
      bottom: 0;
      z-index: 9999;
      p {
        padding: 0 px2rem(120) 0 9%;
      }

      .name {
        margin-top: px2rem(-18);
        line-height: 1.3;
        @include ellipsis(2)
      }

      .desc {
        width: px2rem(460);
        margin-top: px2rem(26);
        line-height: 1.2;
        color: $gray;
      }

    }

  }

</style>
