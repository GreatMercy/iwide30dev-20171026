<template>
  <swiper :options="recommendationSwiperOptions"  class="jfk-swiper jfk-swiper__recommendation">
    <swiper-slide v-for="(item, index) in lists" :key="index" :class="{'jfk-swiper__item': true, 'jfk-swiper__item--empty': item._isEmpty}">
      <a :href="item._link" v-if="item._isEmpty">
        <div class="jfk-swiper__item-box"></div>
        <div class="jfk-swiper__item-info"></div>
        <div class="empty-tip" v-html="item._html || defaultEmptyHtml"></div>
      </a>
      <a :href="item._link" v-else>
        <div  class="jfk-swiper__item-box">
          <div class="jfk-swiper__item-bg swiper-lazy" :data-background="item._img">
            <div class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image">
            </div>
            <div class="jfk-swiper__item-mask"></div>
          </div>
        </div>
        <div class="jfk-swiper__item-info">
          <div class="info-box">
          <h5 class="title font-size--28 font-color-silver" v-html="item._name"></h5>
          <p class="price">
            <span class="jfk-price color-golden font-size--38">
              <i class="jfk-font-number jfk-price__currency">￥</i>
              <i class="jfk-font-number jfk-price__number">{{item._pricePackage}}</i>
            </span>
            <span class="jfk-price__original font-size--24 font-color-extra-light-gray">￥{{item._priceMarket}}</span>
          </p>
          </div>
        </div>
      </a>
    </swiper-slide>
  </swiper>
</template>
<script>
  export default {
    name: 'jfk-recommendation',
    data () {
      return  {
        defaultEmptyHtml: '<div class="jfk-flex is-justify-center is-align-middle"><div class="box"><p class="font-size--28 font-color-extra-light-gray zh">查看更多</p><p class="en font-size--24 font-color-light-gray">VIEW&nbsp;&nbsp;&nbsp;MORE</p></div></div>',
        lists: [],
        recommendationSwiperOptions: {
          autoplay: 0,
          lazyLoading: true,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          spaceBetween: 15,
          slidesPerView: 2.3571
        }
      }
    },
    created () {
      let _lists = []
      let that = this
      let num = 3 - that.items.length
      if (num > 0) {
        let i = 0
        while (i < num) {
          that.items.push({
            _isEmpty: true
          })
          i++
        }
      }
      _lists = that.items.map(function (item, index) {
        if (that.formatProductInfo) {
          return that.formatProductInfo(item, index)
        }
        return that.formatProductInfoInner(item, index)
      })
      that.lists = _lists
    },
    methods: {
      formatProductInfoInner (item) {
        if (item._isEmpty) {
          return {
            _link: item._link || this.emptyLink,
            _html: this.defaultEmptyHtml,
            _isEmpty: true
          }
        }
        return {
          _link: this.linkPrefix + item.product_id,
          _img: item.face_img,
          _name: item.name,
          _pricePackage: item.killsec ? item.killsec.killsec_price : item.price_package,
          _priceMarket: item.price_market
        }
      }
    },
    props: {
      formatProductInfo: {
        type: Function
      },
      items: {
        type: Array,
        required: true
      },
      linkPrefix: {
        type: String
      },
      emptyLink: {
        type: String
      }
    }
  }
</script>
