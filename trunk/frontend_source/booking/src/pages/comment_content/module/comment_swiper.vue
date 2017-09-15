<template>
  <swiper :options="recommendationSwiperOptions" class="jfk-swiper jfk-swiper__recommendation" v-if="items.length > 1">
    <swiper-slide v-for="(item, index) in items" :key="index" class="jfk-swiper__item">
      <a href="javascipt:;">
        <div class="jfk-swiper__item-box">
          <div class="jfk-swiper__item-bg swiper-lazy" :data-background="item">
            <div
              class="jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image">
            </div>
            <div class="jfk-swiper__item-mask"></div>
          </div>
        </div>
      </a>
    </swiper-slide>
  </swiper>
  <swiper v-else class="jfk-swiper jfk-swiper__recommendation single-pic">
    <swiper-slide class="jfk-swiper__item">
      <a href="javascipt:;">
        <div class="jfk-swiper__item-box">
          <div class="jfk-swiper__item-bg swiper-lazy" :data-background="items[0]">
            <div
              class="jfk-image__lazy--3-3">
            </div>
            <div class="jfk-swiper__item-mask"></div>
          </div>
        </div>
      </a>
    </swiper-slide>
  </swiper>
</template>
<script>
  export default {
    name: 'commentSwiper',
    data () {
      return {
        recommendationSwiperOptions: {
          autoplay: 0,
          lazyLoading: true,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          spaceBetween: 10,
          slidesPerView: 'auto'
        }
      }
    },
    props: {
      items: {
        type: Array,
        required: true
      }
    },
    method: {
      seeBigPic (curImg) {
        window.wx.previewImage({
          current: curImg, // 当前显示图片的http链接
          urls: this.items // 需要预览的图片http链接列表
        })
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .jfk-swiper {
    overflow: hidden;
    position: relative;
    z-index: 1;
    padding-left: px2rem(30);
    &__wrapper {
      display: flex;
      width: 100%;
      height: 100%;
      position: relative;
      z-index: 1;
    }

    &__slide {
      flex-shrink: 0;
      width: 100%;
      padding-bottom: 50%;
      position: relative;
      margin-right: px2rem(24);
      a {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }
      &-content, a {
        width: 100%;
        height: 100%;
      }
      &-content {
        position: relative;
      }
      &-mask {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: -1;
        display: none;
      }
      &-content[lazy="loaded"] &-mask {
        display: block;
      }
    }
    &__pagination {
      position: absolute;
      bottom: 0;
      z-index: 2;
      &-current {
        font-size: px2rem(32);
      }
      &-separator, &-total {
        font-size: px2rem(24)
      }
    }
    &--single {
      padding-left: 0;
      .jfk-swiper__slide {
        padding-bottom: calc(318 / 750 * 100%);
      }
    }
  }
</style>
