<template>
  <div class="jfk-pages jfk-pages__index">
    <div class="jfk-pages__theme"></div>
    <div class="page__header">
    <accor-header v-if="isAccor" :brandname="brandname" :hotel="hotel"></accor-header>
    <jfk-banner :items="advs" v-if="advs.length"></jfk-banner>
    </div>
    <div class="categories jfk-pl-30">
      <swiper class="jfk-swiper" :options="tabSwiperOptions">
        <swiper-slide v-for="(category, index) in categories" :key="category.cat_id" :data-cid="category.cat_id"
                      class="category__item"
                      :class="{'is-selected color-golden': index === curCategoryIndex, 'font-color-extra-light-gray': index !== curCategoryIndex}">
          <span class="category__label font-size--32">{{category.cat_name}}</span>
        </swiper-slide>
      </swiper>
    </div>
    <good-list class="jfk-tab__body-item" :show-empty-tip="!showFullLoading" :products="products"
               :detailUrlPrefix="detailUrlPrefix" :layout="layout" v-infinite-scroll="loadMore"
               infinite-scroll-disabled="disableLoadProduct" infinite-scroll-distance="60"></good-list>
    <p class="products-list__loading" v-show="!showFullLoading && isLoadProduct">
      <span class="jfk-loading__triple-bounce color-golden font-size--24">
        <i class="jfk-loading__triple-bounce-item"></i>
        <i class="jfk-loading__triple-bounce-item"></i>
        <i class="jfk-loading__triple-bounce-item"></i>
      </span>
    </p>
    <jfk-support v-once></jfk-support>
    <tabbar class="font-size--24" :tabbarItems="tabbarItems"></tabbar>
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { findIndex } from '@/utils/utils'
  import { getPackageLists, getPackageAccorInfo } from '@/service/http'
  import Tabbar from '@/components/common/tabbar'
  import GoodList from './module/good_list'
  let layouts = ['card', 'pic']
  export default {
    name: 'app',
    components: {
      Tabbar,
      GoodList,
      'accor-header': () => import('./gallery/accor')
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      let layout = 'card'
      if (params.layout !== undefined) {
        layout = layouts[params.layout] || layouts[0]
      }
      this.$pageNamespace(params)
      this.fcid = params.fcid || '-1'
      this.layout = layout
      this.isAccor = process.env.INTER_ID === 'accor'
      this.tkid = params.tkid || ''
      this.brandname = params.brandname || ''
    },
    created () {
      // 请求雅高信息
      if (this.isAccor) {
        let vm = this
        getPackageAccorInfo({
          tkid: this.tkid
        }).then(function (res) {
          vm.hotel = res.web_data.hotel
          if (res.web_data.brandname) {
            if (!vm.brandname) {
              document.body.classList.add('is-' + res.web_data.brandname)
            } else if (vm.brandname !== res.web_data.brandname) {
              document.body.classList.remove('is-' + vm.brandname)
              document.body.classList.add('is-' + res.web_data.brandname)
            }
            vm.brandname = res.web_data.brandname
          }
        })
      }
    },
    data () {
      let that = this
      return {
        hotel: '',
        advs: [],
        products: [],
        disableLoadProduct: false,
        isLoadProduct: false,
        categories: [],
        tabbarItems: [],
        page: 1,
        detailUrlPrefix: 'javascript:;',
        showAdsCat: 1,
        pageSize: 20,
        showFullLoading: true,
        curCategoryIndex: 0,
        tabSwiperOptions: {
          autoplay: 0,
          slidesPerView: 'auto',
          slideToClickedSlide: true,
          notNextTick: true,
          onTap: function (swiper) {
            let idx = swiper.clickedIndex
            if (idx !== that.curCategoryIndex) {
              that.curCategoryIndex = idx
              try {
                let cid = swiper.clickedSlide.dataset.cid
                if (cid) {
                  that.fcid = cid
                  that.disableLoadProduct = true
                  that.page = 1
                  that.showFullLoading = true
                  that.loadPackages(true)
                }
              } catch (e) {
                console.log(e)
              }
            }
          }
        }
      }
    },
    watch: {
      categories (val) {
        let fcid = this.fcid
        let idx = findIndex(val, function (o) {
          return o.cat_id === fcid
        })
        if (idx === -1) {
          this.fcid = '-1'
          idx = 0
        }
        this.curCategoryIndex = idx
      }
    },
    methods: {
      loadPackages (resetProducts) {
        let that = this
        let loading
        let args = {
          page: that.page,
          show_ads_cat: that.showAdsCat,
          page_size: that.pageSize
        }
        if (that.fcid > 0) {
          args.fcid = that.fcid
        }
        if (this.showFullLoading) {
          loading = this.$jfkToast({
            iconClass: 'jfk-loading__snake',
            duration: -1,
            isLoading: true
          })
        }
        that.isLoadProduct = true
        getPackageLists(args).then(function (res) {
          that.showFullLoading = false
          if (loading) {
            loading.close()
          }
          that.isLoadProduct = false
          let {advs, categories, products, page_resource} = res.web_data
          /* eslint camelcase: 0 */
          let {page = 1, size = 20, count = 0, link = {}} = page_resource
          if (resetProducts) {
            that.products = products
          } else {
            that.products = that.products.concat(products)
          }
          if (that.showAdsCat === 1) {
            that.detailUrlPrefix = link.detail
            that.showAdsCat = 2
            that.advs = advs
            that.categories = [{cat_id: '-1', cat_name: '全部商品'}].concat(categories)
            if (process.env.NODE_ENV === 'development') {
              link.home = '/index'
              link.order = 'order_center'
            }
            that.tabbarItems = [{
              link: link.home,
              text: '首页',
              icon: 'icon-mall_icon_home'
            }, {
              link: link.order,
              text: '订单',
              icon: 'icon-user_icon_Onlineboo'
            }, {
              link: link.center,
              text: '我的',
              icon: 'icon-mall_icon_home_user'
            }]
          }
          that.disableLoadProduct = page * size >= count
          if (!that.disableLoadProduct) {
            that.page = +page + 1
          }
        }).catch(function (e) {
          that.isLoadProduct = false
          console.log(e)
        })
      },
      loadMore () {
        this.disableLoadProduct = true
        this.loadPackages()
      }
    }
  }
</script>
