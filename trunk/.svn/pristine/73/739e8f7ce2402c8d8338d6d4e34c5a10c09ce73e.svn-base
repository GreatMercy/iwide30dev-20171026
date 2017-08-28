<template>
  <div class="jfk-pages jfk-pages__commentContent">
    <div class="jfk-pages__theme"></div>
    <div class="comment_top jfk-pl-30 jfk-pr-30">
     <div class="container">
        <p class="score">
        <i class="jfk-font-number jfk-price__number font-size--80">4</i>
        <i class="jfk-font-number jfk-price__number font-size--70">.9</i>
        分
      </p>
      <jfk-rater :disabled="true" :value="4.8"></jfk-rater>
      <div class="pregress_list">
        <div class="pregress_item font-size--24">
          <span class="name">设施</span>
          <p class="pregress">
            <span class="bar" style="width: 80%"></span>
            <span class="score grayColor80">5.0</span>
          </p>
        </div>
        <div class="pregress_item font-size--24">
          <span class="name">卫生</span>
          <p class="pregress">
            <span class="bar" style="width: 40%"></span>
            <span class="score grayColor80">5.0</span>
          </p>
        </div>
        <div class="pregress_item font-size--24">
          <span class="name">服务</span>
          <p class="pregress">
            <span class="bar" style="width: 30%"></span>
            <span class="score grayColor80">5.0</span>
          </p>
        </div>
        <div class="pregress_item font-size--24">
          <span class="name">网络</span>
          <p class="pregress">
            <span class="bar" style="width: 30%"></span>
            <span class="score grayColor80">5.0</span>
          </p>
        </div>
      </div>
     </div>
    </div>
    <div class="talk jfk-pl-30 jfk-pr-30">
      <p class="title font-size--24 grayColor80">
        大家都在说
      </p>
      <ul>
        <li class="active">全部全部（403）</li>
        <li>全部（403）</li>
        <li class="bad">全部（403）</li>
      </ul>
    </div>
    <div class="content jfk-pl-30 jfk-pr-30">
      <div class="contitle_info">
        <img src="https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=a15086bc31adcbef01347900949449e0/aec379310a55b3199a363d0d43a98226cefc17fe.jpg" alt="" class="head_img">
        <span class="name font-size--28 grayColor80">懒茶</span>
        <span class="date font-size--24 grayColorbf">2018.09.09</span>
        <span class="score">
          <span class="left_num font-size--28">4.</span><span class="right_num font-size--24">9分</span>
        </span>
      </div>
      <p class="comment font-size--28 font-size--24">
        上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三上飞机啊十分三
      </p>
      <p class="show_all goldColor">展开全文</p>
      <div class="file">
        <img src="https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/w%3D268%3Bg%3D0/sign=a15086bc31adcbef01347900949449e0/aec379310a55b3199a363d0d43a98226cefc17fe.jpg" alt="" class="one_img" v-show="false">
        <div class="recommendations-list">
          <city-swiper :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></city-swiper>
        </div>
      </div>
      <p class="check_repeat font-size--28 grayColor80">
        收起酒店回复
          <i class="booking_icon_font font-size--24 icon-booking_icon_up_normal grayColorbf show_icon"></i>
      </p>
      <p class="repeat_content">
        <span class="hotel_name grayColor80">酒店回复：</span>
        你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷你大爷
      </p>
    </div>
    <button class="booking_now font-size--34">
      立 即 预 定
    </button>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import { getPackageLists, getPackageRecommendation } from '@/service/http'
  import citySwiper from './module/cityswiper/src/main.vue'
  export default {
    watch: {},
    components: {
      citySwiper
    },
    beforeCreate () {
    },
    created () {
//    加载swiper
      this.loadPackages()
      let that = this
     // 推荐商品无分页，page_size设置大一些，一页全部请求完毕
      getPackageRecommendation({
        page: 1,
        page_size: 100
      }).then(function (res) {
        const { products, page_resource } = res.web_data
        that.recommendations = products
        let { detail, home } = page_resource.link
        if (process.env.NODE_ENV === 'development') {
          detail = '/detail?pid='
          home = '/'
        }
        that.detailUrl = detail
        that.indexUrl = home
      })
    },
    data () {
      return {
        detailUrl: '',
        indexUrl: '',
        recommendations: [],
        showHotSearch: true,
        // 用户信息
        customerInfo: {
          name: '',
          phone: ''
        },
        validResult: {
          name: {
            passed: false,
            message: ''
          },
          phone: {
            passed: false,
            message: ''
          },
          area: {
            passed: false,
            message: ''
          }
        },
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
          const {advs} = res.web_data
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
