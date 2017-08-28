<template>
  <div class="jfk-pages jfk-pages__productChoose">
    <div class="jfk-pages__theme"></div>
   <!--  <good-list class="jfk-tab__body-item" :products="products" :detailUrlPrefix="detailUrlPrefix" :layout="layout" v-infinite-scroll="loadMore" infinite-scroll-disabled="disableLoadProduct" infinite-scroll-distance="60"></good-list> -->
    <div class="choose_prt_top">
      <p class="choose_prt_top_item1 font-size--32">
        请勾选你需要的商品
      </p>
      <p class="choose_prt_top_item2 font-size--24">
        组合已选房型 <span class="other_room">高级大床房</span> 购买更优惠
      </p>
    </div>
    <div class="products-layout jfk-tab__body-item products-layout--card" infinite-scroll-disabled="disableLoadProduct" infinite-scroll-distance="60">
      <div class="products-layout__body">
        <ul class="jfk-pl-30 jfk-pr-30">
          <li>
          <div class="products-list__item">
              <div class="product-box">
                <div class="product-image">
                  <div class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image" lazy="loaded" style="background-image: url(&quot;http://7n.cdn.iwide.cn/public/uploads/201702/qf171520035769.jpg&quot;);">
                  </div>
                </div> 
                <div class="product-info">
                  <label class="check main_color1"><input type="checkbox" checked="" class="room_check"><em></em></label>
                  <div class="product-info-cont">
                    <h3 class="product-title font-size--32 font-color-dark-white">迪士尼三日一晚门票</h3> 
                    <div class="product-price">
                      <span class="jfk-price product-price-package color-golden font-size--54">
                      <i class="jfk-font-number jfk-price__currency">￥</i>
                      <i class="jfk-font-number jfk-price__number">123</i>
                      </span> 
                    <span class="jfk-price__original product-price-market font-size--24 font-color-light-gray is-integral">¥1999</span>
                    </div> 
                    <div class="show_detail_btn font-size--24">
                      详情
                      <span class="icon_show">
                        <i class="booking_icon_font icon-booking_icon_right_normal font-size--24"></i>
                      </span>
                    </div>
                    <div class="set_num">
                      <span class="minus_num">-</span>
                      <span class="real_num">22</span>
                      <span class="add_num">+</span>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="bottom_info_del font-size--24">
              <p class="title font-size--28">迪士尼一日三餐晚餐</p>
              <p class="del_item">迪士尼一日三餐晚餐迪士尼一 </p>
              <p class="del_item">迪士尼一日三餐晚餐 </p>
          </div>
        </li>
        </ul>
      </div> 
    </div>
    <footer class="font-size--24">
      <span class="money">¥<span class="font-size--48">34567</span></span>
      选好了
      <span class="click_pay">
        <i class="booking_font_icon icon-booking_icon_rightarrow_normal"></i> 
      </span>
    </footer>
    <p class="color-golden" v-show="isLoadProduct">正在加载商品</p>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
import { getPackageLists } from '@/service/http'
import GoodList from './module/good_list'
let layouts = ['card', 'pic']
export default {
  name: 'app',
  components: {
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
  data () {
    let that = this
    return {
      advs: [],
      products: [],
      disableLoadProduct: false,
      isLoadProduct: false,
      categories: [],
      tabbarItems: [],
      page: 1,
      fcid: '-1',
      detailUrlPrefix: 'javascript:;',
      showAdsCat: 1,
      curCategoryIndex: 0,
      pageSize: 20,
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
                that.disableLoadProduct = false
                that.page = 1
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
  methods: {
    loadPackages (resetProducts) {
      let that = this
      let args = {
        page: that.page,
        show_ads_cat: that.showAdsCat,
        page_size: that.pageSize
      }
      if (that.fcid > 0) {
        args.fcid = that.fcid
      }
      that.isLoadProduct = true
      getPackageLists(args).then(function (res) {
        that.isLoadProduct = false
        const { advs, categories, products, page_resource } = res.web_data
        /* eslint camelcase: 0 */
        const { page = 1, size = 20, count = 0, link = {} } = page_resource
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
