<template>
  <div class="jfk-pages jfk-pages__useCoupon">
    <div class="jfk-pages__theme"></div>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <!--<JfkSupport v-once></JfkSupport>-->
    <div class="useCoupon_top font-size--38">
      <p class="useCoupon_title">迪士尼三日一晚门票</p>
      <p class="useCoupon_price">
        <span class="jfk-price product-price-package color-golden font-size--54"><i class="jfk-font-number jfk-price__currency">￥</i> <i class="jfk-font-number jfk-price__number">123</i></span>
        <span class="font-size--24">1份</span>
      </p>
    </div>
    <div class="qr_code">
      <p class="qr_code_title font-size--24">
        使用方式<span>（请选择以下任意一种方式使用套票）</span>
      </p>
      <div class="qr_code_type1">
        <p class="type1_del font-size--28">方式一：向商家出示二维码/券码</p>
        <img class="qr_img" src="http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171158.jpg" alt="">
        <p class="qr_num font-size--32">34567890</p>
      </div>
    </div>
    <div class="qr_code">
      <div class="qr_code_type2">
        <p class="type1_del font-size--28">方式二：商家输入核销码</p>
        <input type="text" class="input_num" placeholder="请商家输入核销码">
        <span class="submit_btn font-size--34">提  交</span>
      </div>
      
    </div>
  </div>
</template>
<script>
import { getPackageLists } from '@/service/http'
export default {
  name: 'useCoupon',
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
