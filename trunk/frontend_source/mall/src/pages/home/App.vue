<template>
  <div class="jfk-pages jfk-pages__home">
    <div class="jfk-pages__theme"></div>
    <div v-if="advs.length">
      <div class="banners">
        <div v-if="advs.length === 1" v-once class="banner__item">
          <a :href="advs[0].link ? advs[0].link : 'javascript:;'" class="jfk-swiper__item-box">
            <div v-lazy:background-image="advs[0].logo" class="jfk-swiper__item-bg banners__item jfk-image__lazy jfk-image__lazy--3-3 jfk-swiper__slide-content jfk-image__lazy--background-image">
              <div class="banners__item-mask"></div>
            </div>
          </a>
        </div>
        <swiper class="jfk-pt-30 jfk-swiper" v-else :options="bannerSwiperOption">
          <swiper-slide class="jfk-swiper__item" v-for="(item, index) in advs" :key="index">
            <a :href="item.link ? item.link : 'javascript:;'" class="jfk-swiper__item-box">
              <div :data-background="item.logo" class="banners__item jfk-swiper__item-bg swiper-lazy">
                <div class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
                <div class="banners__item-mask"></div>
              </div>
            </a>
          </swiper-slide>
          <div class="swiper-pagination font-size--24" slot="pagination"></div>
        </swiper>
      </div>
    </div>
    <div class="jfk-tab">
      <div class="jfk-tab__head jfk-pl-30">
        <ul class="jfk-flex">
          <li
            v-for="(item, sort) in sorts"
            :key="sort"
            :class="{'jfk-tab__head-item': true, 'jfk-tab__head-item--selected': item.type === currentSort}"
          >
          <a href="javascript:;">{{item.name}}</a>
          </li>
        </ul>
      </div>
      <div class="jfk-tab__body">
        <good-list class="jfk-tab__body-item" :goods="goods" :layout="layout"></good-list>
      </div>
    </div>
    <JfkSupport v-once></JfkSupport>
    <!-- <tabbar class="font-size--24"></tabbar> -->
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getPackageLists } from '@/service/http'
  // import Tabbar from '@/components/common/tabbar'
  import GoodList from './module/good_list'
  let layouts = ['card', 'pic']
  export default {
    name: 'app',
    components: {
      // Tabbar,
      GoodList
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      let layout = 'card'
      if (params.layout !== undefined) {
        layout = layouts[params.layout] || layouts[0]
      }
      this.layout = layout
    },
    created () {
      let that = this
      getPackageLists().then(function (goods) {
        console.log(goods)
        that.goods = Object.assign({}, that.goods, goods)
      })
    },
    data () {
      return {
        src: 'https://www.baidu.com/img/bd_logo1.png',
        advs: [],
        goods: {},
        currentSort: 1,
        bannerSwiperOption: {
          autoplay: 0,
          lazyLoading: true,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          spaceBetween: 12,
          slidesPerView: 1.12,
          pagination: '.swiper-pagination',
          paginationType: 'fraction',
          loop: true
        },
        sorts: [{
          name: '全部商品',
          type: 1
        }, {
          name: '自助餐',
          type: 2
        }, {
          name: '西餐',
          type: 3
        }, {
          name: '中餐',
          type: 4
        }]
      }
    },
    watch: {
    }
  }
</script>

<style>
</style>
