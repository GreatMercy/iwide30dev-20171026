<template>
  <div class="jfk-pages jfk-pages__hotelDetailint">
    <div class="jfk-pages__theme"></div>
    <div class="ht_del_top">
      <div class="ht_del_top_info">
        <p class="info_title font-size--34">金房卡壬丰大厦222222222</p>
        <p class="info_place font-size--24">
          <i class="booking_icon_font icon-booking_icon_businessdistrict_norma font-size--30"></i>
          金房卡壬丰大厦222222
        </p>
        <span class="icon_dh font-size--24">
          <i class="booking_icon_font icon-booking_icon_navigation_normal  font-size--34"></i><br />
          导 航
        </span>
      </div>
      <div class="ht_tel">
        <span>酒店电话： 020-902323232</span>
        <i class="booking_icon_font icon-booking_icon_collect1 icon_tel font-size--28"></i>
      </div>
    </div>
    <div class="ht_service font-size--24">
      <p class="title">酒店服务</p>
      <div class="ht_service_style">
        <span class="ht_service_style_btn">免押金</span>
        <p class="ht_service_style_item">哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈</p>
      </div>
      <div class="ht_service_style">
        <span class="ht_service_style_btn">免押金</span>
        <p class="ht_service_style_item">哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈</p>
      </div>
      <div class="ht_service_style">
        <span class="ht_service_style_btn">免押金</span>
        <p class="ht_service_style_item">哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈</p>
      </div>
    </div>
    <div class="ht_del_ul_container">
      <p class="ht_sth">酒店设施</p>
      <ul class="ht_del_ul">
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
        <li><i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--30"></i>免费WiFi</li>
      </ul>
    </div>
    <div class="ht_int font-size--28">
      <p class="ht_int_title">酒店介绍</p>
      <p class="ht_int_del">
        酒店介绍酒店介绍酒店介绍酒店介绍酒店介绍酒店介绍酒店介绍酒店介绍酒店介绍酒店介绍
      </p>
    </div>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <!--<JfkSupport v-once></JfkSupport>-->
  </div>
</template>
<script>
import { getPackageLists } from '@/service/http'
export default {
  name: 'app',
  components: {
  },
  beforeCreate () {
  },
  created () {
//    加载swiper
    this.loadPackages()
  },
  data () {
    return {
      advs: [
        {
          'adv_id': '20',
          'cat_id': '',
          'hotel_id': '180',
          'inter_id': 'a450089706',
          'link': 'http://',
          'logo': 'http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171158.jpg',
          'name': '五一出游，应该去的地方',
          'name_en': '',
          'product_id': '0',
          'sort': '3',
          'status': '1',
          'type': '1'
        }
      ],
      isLoadProduct: false,
      categories: [],
      tabbarItems: [],
      page: 1,
      fcid: '-1',
      showAdsCat: 1,
      curCategoryIndex: 0,
      pageSize: 20,
      bannerSwiperOptions: {
        autoplay: 3000,
        lazyLoading: false,
        lazyLoadingInPrevNext: true,
        lazyPreloaderClass: 'jfk-image__lazy--preload',
        pagination: '.swiper-pagination',
        paginationType: 'fraction'
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
        const { advs } = res.web_data
        /* eslint camelcase: 0 */
        if (that.showAdsCat === 1) {
          that.showAdsCat = 2
          that.advs = advs
        }
      }).catch(function (e) {
        that.isLoadProduct = false
        console.log(e)
      })
    }
  }
}
</script>
