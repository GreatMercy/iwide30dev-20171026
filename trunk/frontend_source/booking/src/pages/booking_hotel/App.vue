<template>
  <div class="jfk-pages jfk-pages__bookingHotel">
    <!--<div class="jfk-pages__theme"></div> -->
    <div class="detail-top">
      <div class="banners">
        <swiper :options="bannerSwiperOptions" class="jfk-swiper">
          <swiper-slide v-for="(item, index) in advs" :key="item.adv_id" class="jfk-swiper__item"
                        :class="{'swiper-no-swiping': advs.length === 1}">
            <div class="banners__item-box jfk-swiper__item-box">
              <div :data-background="item.logo" class="banners__item jfk-swiper__item-bg swiper-lazy">
                <div
                  class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
              </div>
            </div>
          </swiper-slide>
          <div class="swiper-pagination font-size--24" slot="pagination"></div>
        </swiper>
      </div>
    </div>
    <div class="title_info_container">
      <div class="title_info">
        <p class="title_info_ht_name font-size--38">金房卡酒店石牌桥店金房卡房</p>
        <p class="title_info_ht_place font-``size--24">金房卡酒店石牌桥店金房卡房</p>
        <p class="btn_group">
          <span class="btn_span">商务精选</span>
          <span class="btn_span">预约发票</span>
          <span class="btn_span">618大促</span>
        </p>
      </div>
    </div>
    <div class="score_info_container">
      <div class="score_info">
        <span class="score_info_score">
          <span class="font">49.99</span>分
        </span>
        <span class="star_info">
          <span class="star_info_5">
            <i class="booking_icon_font icon-booking_icon_star_normal i0"></i>
            <i class="booking_icon_font icon-booking_icon_star_normal i1"></i>
            <i class="booking_icon_font icon-booking_icon_star_normal i2"></i>
            <i class="booking_icon_font icon-booking_icon_star_normal i3"></i>
            <i class="booking_icon_font icon-booking_icon_star_normal i4"></i>
          </span>
          <span class="comments">
            50条评论<i class="booking_icon_font icon-booking_icon_right_normal"></i>
          </span>
        </span>
        <span class="center_line"></span>
        <span class="live_date">
          <span class="live">入住</span>03/14<br/><span class="live">离开</span>03/14
          <i class="booking_icon_font icon_arrow icon-booking_icon_dropdown_normal"></i>
        </span>
      </div>
    </div>

    <div class="hotel_info">
      <div class="hotel_info_title">
        <span class="hotel_info_title_item active item1">
          <span>预定酒店</span>
        </span>
        <span class="hotel_info_title_item item2"><span>畅游套餐</span></span>
        <span class="hotel_info_title_item font-size--24 item3">商务入口
        <i class="booking_icon_font icon-booking_icon_right_normal font-size--24"></i></span>
      </div>
      <div class="hotel_info_room">
        <div class="room_pic">
          <img src="http://30.iwide.cn:821/public/media/a450089706/adv/logo/20160613171158.jpg" alt="" class="src">
          <div class="room_pic_info">
            <span class="room_type font-size--30">
              经济大床房
              <span class="room_icon">
                <i class="booking_icon_font icon-booking_icon_dropdown_normal"></i>
              </span>
            </span>
            <ul class="room_type_ul">
              <li>34m</li>
              <li>34m</li>
              <li>34m</li>
            </ul>
          </div>
        </div>
        <div class="hotel_info_room_price">
          <span class="price">
            <span class="font-size--42 sFont">¥8899</span> 门市价
          </span>
          <span class="shBtn">
            <span class="ishide"><i class="booking_icon_font icon-booking_icon_up_normal font-size--24"></i></span>收起
          </span>
        </div>
        <div class="room_price_ul_container">
          <span class="price_icon">
            <i class="booking_icon_font icon-booking_icon_dropdown_normal"></i>
          </span>
          <ul class="room_price_ul">
            <li>
              <span class="price_type font-size--30">
                金卡专线价金卡专线价金<i class="booking_icon_font icon-booking_icon_question_normal font-size--24"></i><br/>
                <span class="belong blueColor">
                  社群客专属
                </span>
              </span>
              <span class="food font-size--24">
                双早
              </span>
              <span class="price_num font-size--32">
                800积分
              </span>
              <span class="pay_btn">
                <i class="booking_icon_font icon-font_zh_wei_qkbys font-size--24"></i><i
                class="booking_icon_font icon-font_zh_yong_qkbys font-size--24"></i>
              </span>
            </li>
            <li>
              <span class="price_type font-size--30">
                金卡专线价金卡专线价金<i class="booking_icon_font icon-booking_icon_question_normal font-size--24"></i><br/>
                <span class="belong blueColor">
                  社群客专属
                </span>
              </span>
              <span class="food font-size--24">
                双早
              </span>
              <span class="price_num font-size--32">
                800积分
              </span>
              <span class="pay_btn">
                预定
              </span>
            </li>
            <li>
              <span class="price_type font-size--30">
                金卡专线价<i class="booking_icon_font icon-booking_icon_question_normal font-size--24"></i><br/>
                <span class="belong blueColor">
                  社群客专属
                </span>
              </span>
              <span class="food font-size--24">
                双早
              </span>
              <span class="price_num font-size--32">
                800积分
              </span>
              <span class="pay_btn">
                预定
              </span>
            </li>
            <li>
              <span class="price_type font-size--30">
                金卡专线<i class="booking_icon_font icon-booking_icon_question_normal font-size--24"></i><br/>
                <span class="belong blueColor">
                  社群客专属
                </span>
              </span>
              <span class="food font-size--24">
                双早
              </span>
              <span class="price_num font-size--32">
                800积分
              </span>
              <span class="pay_btn">
                预定
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="ht_int">
      <p class="title font-size--32">
        酒店政策
      </p>
      <p class="ht_int_item">ninisdfsfafafasfasfasfasflafalsf</p>
      <p class="ht_int_item">ninisdfsfafafasfasfasfasflafalsf</p>
      <p class="ht_int_item">ninisdfsfafafasfasfasfasflafalsf</p>
      <p class="ht_int_item">ninisdfsfafafasfasfasfasflafalsf</p>
    </div>


    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <!--<JfkSupport v-once></JfkSupport>-->

    <jfk-rater v-model="value" :disabled="false" :value="value"></jfk-rater>

  </div>
</template>
<script>
  import { getPackageLists } from '@/service/http'
  // import rater from '../../../../common/components/src/packages/jfk-rater/src/main'
  export default {
    watch: {},
    components: {
      // rater
    },
    beforeCreate () {
    },
    created () {
//    加载swiper
      this.loadPackages()
    },
    data () {
      return {
        value: 2.2,
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
