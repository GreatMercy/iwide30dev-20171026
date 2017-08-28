<template>
  <div class="jfk-pages jfk-pages__roomDesc">
    <div class="jfk-pages__theme"></div>
    <div class="banner_img">
      <img src="http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171158.jpg" alt="">
      <i class="booking_icon_font icon-booking_icon_collect1 icon_close font-size--28"></i>
    </div>
  
    <div class="room_desc_ul_container">
      <ul class="room_desc_ul">
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

    <div class="room_detail">
      <p>建筑面积：20~30m²</p>
      <p>楼   层：20~30m²</p>
      <p>床   型：20~30m²</p>
      <p>该房型不可加床</p>
      <p>入住人数：最多2人</p>
      <p>可享受退房服务</p>
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
