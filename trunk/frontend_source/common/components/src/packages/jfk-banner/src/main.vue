<template>
  <div class="jfk-banner" :class="{'is-full': type === 'full', 'not-full': type !== 'full'}">
    <div v-if="items.length === 1" v-once class="jfk-banner__item is-one-item">
      <a :href="hrefMethod(items[0])" class="jfk-swiper__item-box">
        <div v-lazy:background-image="imgUrlMethod(items[0])" class="jfk-swiper__item-bg jfk-banner__item-content jfk-image__lazy jfk-image__lazy--4-2 jfk-swiper__slide-content jfk-image__lazy-background-image">
          <div class="jfk-banner__item-mask"></div>
        </div>
      </a>
    </div>
    <swiper v-else class="jfk-swiper" :class="swiperBoxClass" :options="bannerSwiperOptions">
      <swiper-slide class="jfk-swiper__item" v-for="(item, index) in items" :key="index">
        <a :href="hrefMethod(item)" class="jfk-swiper__item-box">
          <div :data-background="imgUrlMethod(item)" class="jfk-banner__item-content jfk-swiper__item-bg swiper-lazy">
            <div class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--4-2 jfk-image__lazy--background-image"></div>
            <div class="jfk-banner__item-mask"></div>
          </div>
        </a>
      </swiper-slide>
      <div class="swiper-pagination font-size--24" slot="pagination"></div>
    </swiper>
  </div>
</template>
<script>
  const errorLinkReg = /^http:\/\/\s*$/
  const defaultSwiperOptions = {
    autoplay: 3000,
    lazyLoading: true,
    lazyLoadingInPrevNext: true,
    lazyPreloaderClass: 'jfk-image__lazy--preload',
    slidesPerView: 1,
    pagination: '.swiper-pagination',
    paginationType: 'fraction'
  }
  export default {
    name: 'JfkBanner',
    data () {
      let bannerSwiperOptions = Object.assign({}, defaultSwiperOptions, this.swiperOptions, this.type !== 'full' ? {
        spaceBetween: 12,
        slidesPerView: 1.12
      } : {
        loop: true,
        autoplayDisableOnInteraction: false
      })
      return {
        bannerSwiperOptions
      }
    },
    methods: {
      hrefMethod (obj) {
        if (this.linkMethod) {
          return this.linkMethod(obj)
        }
        if (this.linkKey) {
          let link = obj[this.linkKey] || 'javascript:;'
          if (errorLinkReg.test(link)) {
            return 'javascript:;'
          }
          return link
        }
        return 'javascript:;'
      },
      imgUrlMethod (obj) {
        return obj[this.imgUrlKey]
      }
    },
    computed: {
      swiperBoxClass () {
        let _c = this.swiperClass || ''
        if (this.type !== 'full') {
          return _c + ' jfk-pt-30 jfk-ml-30'
        }
        return _c
      }
    },
    props: {
      items: {
        type: Array,
        required: true
      },
      type: {
        type: String,
        default: 'full'
      },
      linkMethod: {
        type: Function
      },
      linkKey: {
        type: String,
        default: 'link'
      },
      imgUrlKey: {
        type: String,
        default: 'logo'
      },
      swiperClass: {
        type: String,
        default: ''
      },
      swiperOptions: {
        type: Object
      }
    }
  }
</script>