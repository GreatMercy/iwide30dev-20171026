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
        <div class="jfk-swiper__item-info" :class="'jfk-swiper__item-info--length-' + item._pricePackage.length">
          <div class="info-box">
          <h5 class="title font-color-silver-common font-size--28" v-html="item._name"></h5>
          <p class="price font-size--24" :title="item.type" :class="{'is-integral': item._integral}">
            <span class="jfk-price color-golden-price">
              <i class="jfk-font-number jfk-price__currency" v-if="!item._integral">￥</i>
              <i class="jfk-font-number jfk-price__number">{{item._pricePackage}}</i>
            </span>
            <span class="jfk-price__original font-color-extra-light-gray-common"><i v-if="!item._integral">￥</i>{{item._priceMarket}}</span>
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
        defaultEmptyHtml: '<div class="jfk-flex is-justify-center is-align-middle"><div class="box"><p class="font-size--28 font-color-extra-light-gray zh">查看更多</p><p class="en  font-color-light-gray-common font-size--24"><span><i>V</i><i>I</i><i>E</i><i>W</i></span><span><i>M</i><i>O</i><i>R</i><i>E</i></span></p></div></div>',
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
      let items = that.items.concat()
      if (num > 0) {
        items.push({
          _isEmpty: true
        })
        if (num === 2) {
          this.recommendationSwiperOptions = Object.assign({}, this.recommendationSwiperOptions, {
            slidesPerView: 2
          })
        }
      }
      _lists = items.map(function (item, index) {
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
          _priceMarket: item.price_market,
          _integral: item.type === '5'
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
