<template>
  <div class="jfk-pages jfk-pages__bookingHotel">
    <div class="jfk-pages__theme"></div>
    <div class="detail-top">
      <div class="banners">
        <swiper :options="bannerSwiperOptions" class="jfk-swiper">
          <swiper-slide v-for="(item, index) in advs" :key="item.id" class="jfk-swiper__item" :class="{'swiper-no-swiping': advs.length === 1}">
            <div class="banners__item-box jfk-swiper__item-box">
              <div :data-background="item.image_url" class="banners__item jfk-swiper__item-bg swiper-lazy">
                <div
                  class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
              </div>
            </div>
          </swiper-slide>
          <div class="swiper-pagination font-size--24" slot="pagination"></div>
        </swiper>
      </div>
    </div>
    <!--商务精选等 后期再显示-->
    <!--<div class="title_info_container" v-if="false">-->
      <!--<div class="title_info">-->
        <!--<p class="title_info_ht_name font-size&#45;&#45;38">{{allData.hotel.name}}</p>-->
        <!--<p class="title_info_ht_place font-size&#45;&#45;24">{{allData.hotel.address}}</p>-->
        <!--<p class="btn_group">-->
          <!--<span class="btn_span">商务精选</span>-->
          <!--<span class="btn_span">预约发票</span>-->
          <!--<span class="btn_span">618大促</span>-->
        <!--</p>-->
      <!--</div>-->
    <!--</div>-->
    <div class="score_info_container">
      <!--分数信息及日历-->
      <div class="score_info">
        <span class="score_info_score" v-if="allData != ''">
          <span class="font">{{allData.t_t.comment_score}}</span>分
        </span>
        <span class="star_info">
          <span class="star_info_5">
          <jfk-rater
            :disabled="true"
            :value="allData.t_t.comment_score"
            :fontSize="16"
            v-if="allData != ''">

          </jfk-rater>
          </span>
          <span class="comments" v-if="allData != ''">
            {{allData.t_t.comment_count}}条评论<i class="booking_icon_font icon-booking_icon_right_normal"></i>
          </span>
        </span>
        <span class="center_line"></span>
        <span class="live_date" @click="showCalenDar()">
          <span class="live">入住</span>{{startDate}}<br/><span class="live">离开</span>{{endDate}}
          <i class="booking_icon_font icon_arrow icon-booking_icon_dropdown_normal"></i>
        </span>
      </div>
    </div>
    <div class="hotel_info">
      <!--可切换的头部-->
      <div class="hotel_info_title">
        <span class="hotel_info_title_item item1"
              @click="changeTabEvt(true)"
              :class="[changeTab ? activeClass : '']">
          <span>预定酒店</span>
        </span>
        <span class="hotel_info_title_item item2"
              @click="changeTabEvt(false)"
              :class="[!changeTab ? activeClass : '']">
          <span>畅享套餐</span>
        </span>
        <span class="hotel_info_title_item font-size--24 item3">商务入口
        <i class="booking_icon_font icon-booking_icon_right_normal font-size--24"></i>
        </span>
      </div>
      <!--预定酒店-->
      <div class="hotel_info_room" v-show="changeTab">
        <div class="hotel_info_room_item" v-for="(item, index) in rooms" :key="index">
          <div class="room_pic" @click="showHotelDesc(item.room_info.hotel_id,item.room_info.room_id)">
            <img
              :src="item.room_info.room_img ? item.room_info.room_img : defaultImg" alt="" class="src">
            <div class="room_pic_info">
            <span class="room_type font-size--30">
             {{item.room_info.name}}
              <span class="room_icon">
                <i class="booking_icon_font icon-booking_icon_dropdown_normal"></i>
              </span>
            </span>
              <ul class="room_type_ul">
                <li v-if="item.room_info.area">{{item.room_info.area}}m²</li>
                <li v-if="item.room_info.sub_des">{{item.room_info.sub_des}}</li>
              </ul>
            </div>
          </div>
          <div class="hotel_info_room_price">
          <span class="price" v-if="item.showStatus">
            <span class="font-size--42 sFont">¥{{item.room_info.oprice}}</span> 门市价
          </span>
          <span class="price" v-if="!item.showStatus">
            <span class="jfk-price product-price-package color-golden font-size--54">
              <i class="jfk-font-number jfk-price__currency">￥</i>
              <i class="jfk-font-number jfk-price__number">{{item.lowest}}</i></span> 起
          </span>

            <span class="shBtn" @click="showroom(index)">
            <span :class="item.showStatus ? '' : showIcon">
              <i class="booking_icon_font icon-booking_icon_up_normal font-size--24" ></i>
            </span><span class="font-size--24">{{item.showWord}}</span>
            </span>
          </div>
          <div class="room_price_ul_container">
          <span class="price_icon">
            <i class="booking_icon_font icon-booking_icon_dropdown_normal"></i>
          </span>
            <ul class="room_price_ul" v-show="item.showStatus">
              <li v-for="(value, object) in item.state_info" :key="object">
                <span class="price_type font-size--30">
                {{value.price_name}}<i class="booking_icon_font icon-booking_icon_question_normal font-size--24"></i><br/>
                <span class="belong blueColor" v-if="value.useable_coupon_favour">
                  券可减{{value.useable_coupon_favour}}元
                  <br>
                </span>
                <span class="belong blueColor" v-if="value.wxpay_favour_sign === 1">
                  微信支付减{{value.bookpolicy_condition.wxpay_favour}}元
                </span>
              </span>
                <span class="food font-size--24">
                  {{value.bookpolicy_condition.breakfast_nums}}
                  </span>
                <span class="price_num font-size--32">
                ¥{{value.avg_price}}
                </span>
                <span v-if="value.book_status === 'available'">
                    <span class="pay_btn hasline" v-if="value.condition.pre_pay === 1">
                      <span class="topWord">
                        <i class="booking_icon_font icon-font_zh_yv_qkbys ft-18"></i>
                        <i class="booking_icon_font icon-font_zh_ding__qkbys ft-18"></i>
                      </span>
                      <span class="needpaybefore ft-18">
                        需预付
                      </span>
                     </span>
                    <span class="pay_btn" v-else>
                      <i class="booking_icon_font icon-font_zh_yv_qkbys font-size--24"></i>
                      <i class="booking_icon_font icon-font_zh_ding__qkbys font-size--24"></i>
                    </span>
                </span>
                <span v-if="value.book_status === 'disabled'">
                  <span class="pay_btn">
                    <i class="booking_icon_font icon-font_zh_man_qkbys font-size--24"></i><i class="booking_icon_font icon-font_zh_fang_qkbys font-size--24"></i>
                  </span>
                </span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--畅享套餐-->
      <div class="hotel_info_room" v-show="!changeTab">
        <div class="hotel_info_room_item" v-for="(item, index) in packagesInfo" :key="index">
          <div class="room_pic"
               :class="[item.package_info.sale_way != 1 ? chooseClass : '']"
               @click="showPackageDesc(item.room_info.hotel_id, item.room_info.room_id)">
            <img :src="item.room_info.room_img" alt="" class="src">
            <div class="room_pic_info">
            <span class="room_type font-size--30">
             {{item.show_price_name}}
              <span class="room_icon">
                <i class="booking_icon_font icon-booking_icon_dropdown_normal"></i>
              </span>
            </span>
              <ul class="room_type_ul">
                <li v-if="item.room_info.area">{{item.room_info.area}}m²</li>
                <li v-if="item.room_info.sub_des">{{item.room_info.sub_des}}</li>
              </ul>
            </div>
          </div>
          <div class="hotel_info_room_price">
          <span class="price">
            <span class="font-size--42 goldColor">
              <i class="jfk-font-number jfk-price__currency">￥</i>
              <i class="jfk-font-number jfk-price__number">{{item.package_info.total_show_price}}</i>
            </span>
            <span v-if="item.book_status === 'available'">
              <span class="chooseBtn" v-if="item.package_info.sale_way === 1">
                <i class="booking_icon_font icon-font_zh_yv_qkbys ft-18"></i><i class="booking_icon_font icon-font_zh_ding__qkbys ft-18"></i>
              </span>
               <span class="chooseBtn" v-else @click="goProductChoose()">
                <i class="booking_icon_font icon-font_zh_xuan__qkbys ft-18"></i><i class="booking_icon_font icon-font_zh_ze_qkbys ft-18"></i>
              </span>
            </span>
            <span v-else="item.book_status === 'disabled'">
              <span>售罄</span>
            </span>
          </span>
          </div>
        </div>
      </div>
    </div>
    <!--酒店政策-->
    <div class="ht_int">
      <p class="title font-size--32">酒店政策</p>
      <p class="ht_int_item" v-show="allData.hotel.book_policy" v-html="allData.hotel.book_policy" v-if="allData != ''"></p>
      <p class="ht_int_item" v-else>无</p>
    </div>
    <!--选择日历-->
    <div class="choose_date_calendar" v-show="showCalendar">
      <div class="jfk-pl-30 jfk-pr-30">
        <jfk-calendar ref="jfkCalendar"
                      class="font-size--28"
                      format="yyyy/MM/dd"
                      @date-pick="handleDateClick"
                      :minDate="min"
                      :maxDate="max"
                      :range="true">
        </jfk-calendar>
      </div>
    </div>
    <!--酒店预订的详情-->
    <div class="room_desc" v-if="roomDescStatus">
      <div class="room_mask">
        <div class="banner_img">
          <img :src="roomDescData.room_img ? roomDescData.room_img : defaultImg" alt="">
          <i class="jfk-font icon-icon_close icon_close font-size--28" @click="roomDescStatus = false"></i>
        </div>
        <div class="room_desc_ul_container">
          <ul class="room_desc_ul">
            <li v-for="(item, index) in roomDescData.imgs.hotel_room_service">
              免费WiFi
            </li>
          </ul>
        </div>
        <div class="room_detail">
          <p>建筑面积：{{roomDescData.area}}m²</p>
          <p v-html="roomDescData.book_policy" v-if="allData !== ''"></p>
        </div>
      </div>
    </div>
    <!--畅游套餐详情-->
    <div class="package_desc" v-if="packageDescStatus">
      <div class="package_mask">
        <div class="package_mask2">
          <div class="swich_bar font-size--32 grayColor80">
            <span class="room"
                  @click="showRoomStatus(0)"
                  :class="isRoomStatus ? 'active' : ''">房型详情</span>
            <span class="room"
                  @click="showRoomStatus(1)"
                  :class="isRoomStatus ? '' : 'active'">套餐详情</span>
            <i class="jfk-font icon-icon_close icon_close font-size--28" @click="packageDescStatus = false"></i>
          </div>
          <div class="banner_img" v-show="isRoomStatus">
            <img :src="packageDescData.room_img" alt="">
          </div>
          <div class="package_desc_ul_container" v-show="isRoomStatus">
            <ul class="package_desc_ul">
              <li v-for="(item, index) in packageDescData.imgs.hotel_room_service" v-show="item.info">
                {{item.info}}
              </li>
            </ul>
          </div>
          <div class="package_detail" v-if="packageDescData !== '' && isRoomStatus">
            <p>建筑面积：{{packageDescData.area}}m²</p>
            <p v-if="allData !== ''">{{packageDescData.book_policy}}</p>
          </div>
        </div>
      </div>
    </div>
    <!--选择优惠券-->
    <product-Choose v-if="showProductChoose" :alldata.async="allData"></product-Choose>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import { getHotelIndex, getHotelDetail } from '@/service/http'
  import productChoose from '../product_choose/App.vue'
  import { showFullLayer } from '@/utils/utils'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  export default {
    watch: {},
    computed: {
    },
    components: {
      productChoose
    },
    beforeCreate () {
      let params = formatUrlParams(location.search)
      console.log(params)
    },
    created () {
//    加载swiper
      this.getHotelIndex()
      // 获取日期
      this.getDate()
    },
    data () {
      return {
        value: 2.2,
        advs: [],
        allData: [],
        categories: [],
        curCategoryIndex: 0,
        bannerSwiperOptions: {
          autoplay: 3000,
          lazyLoading: true,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          pagination: '.swiper-pagination',
          paginationType: 'fraction',
          onSlideChangeEnd: function (swiper) {
            this.productGalleryIndex = swiper.activeIndex + 1
          }
        },
        packagesInfo: [],
        rooms: [],
        // 显示预定选择
        showRoomInfo: true,
        showWord: '收起',
        listIndex: '',
        show: false,
        // 日历显示
        showCalendar: false,
        startDate: '',
        endDate: '',
        startMonth: '',
        endMonth: '',
        // 日历最小日期
        min: null,
        // 日历最大日期
        max: null,
        changeTab: true,
        showCy: false,
        showHotel: true,
        activeClass: 'active',
        chooseClass: 'chooseIce',
        roomDescStatus: false,
        roomDescData: [],
        showIcon: 'ishide',
        packageDescStatus: false,
        packageDescData: [],
        isRoomStatus: true,
        defaultImg: 'http://file.iwide.cn/public/uploads/201512/yibohotel_39-2.jpg',
        page_resource: {
          'ADD_HOTEL_COLLECTION': '',
          'BOOKROOM': 'submit_order?theme=1',
          'CANCEL_ONE_MARK': '',
          'HOTEL_COMMENT': 'comment?theme=1',
          'HOTEL_DETAIL': 'hotel_detail_int?theme=1',
          'HOTEL_PHOTO': '',
          'RETURN_MORE_ROOM': '',
          'RETURN_ROOM_DETAIL': '',
          startString: this.getUrlParams('startDate'),
          endString: this.getUrlParams('endDate')
        },
        sendData: [],
        showProductChoose: false
      }
    },
    methods: {
      getHotelIndex (resetProducts) {
        let _self = this
        let loading
        loading = _self.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          h: _self.getUrlParams('h'),
          start: _self.startString,
          end: _self.endString,
          id: _self.getUrlParams('id'),
          openid: _self.getUrlParams('openid')
        }
        getHotelIndex(args).then(function (res) {
          _self.logJSON(res)
          _self.allData = res.web_data
          _self.advs = res.web_data.hotel.imgs.hotel_lightbox
          _self.packagesInfo = res.web_data.packages
          _self.rooms = res.web_data.rooms
          _self.page_resource = res.web_data.page_resource
          for (var key in _self.rooms) {
            _self.rooms[key].showWord = '收起'
            _self.rooms[key].showStatus = true
          }
          _self.logJSON(_self.rooms)
          if (loading) {
            loading.close()
          }
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      showroom (index) {
        console.log(index)
        if (!this.rooms[index].showStatus) {
//          this.rooms[index] = Object.assign({}, this.rooms[index], {showWord: '收起'})
//          this.rooms[index] = Object.assign({}, this.rooms[index], {showStatus: true})
          this.$set(this.rooms[index], 'showWord', '收起')
          this.$set(this.rooms[index], 'showStatus', true)
        } else {
//          this.rooms[index] = Object.assign({}, this.rooms[index], {showWord: '更多'})
//          this.rooms[index] = Object.assign({}, this.rooms[index], {showStatus: false})
          this.$set(this.rooms[index], 'showWord', '更多')
          this.$set(this.rooms[index], 'showStatus', false)
        }
        console.log(this.rooms[index])
      },
      reverLiveDate (val) {
        let str = val.substring(val.length - 4)
        let str1 = str.substring(str.length - 2)
        let str2 = str.substring(2, 0)
        return str2 + '/' + str1
      },
      getDate () {
        let year = new Date().getFullYear()
        let month = new Date().getMonth() + 1
        month = (month < 10 ? '0' + month : month)
        let today = new Date().getDate()
        this.startMonth = year + '/' + month
        this.endMonth = year + '/' + month
        this.startDate = month + '/' + today
        this.endDate = month + '/' + (today + 1)
      },
      handleDateClick (result) {
        let _self = this
        _self.startDate = _self.changeMonth(result[0])
        _self.endDate = _self.changeMonth(result[1])
        _self.startString = result[0]
        _self.endString = result[1]
//      _self.startMonth = _self.changeMonth(result[0])
//      _self.endMonth = _self.changeMonth(result[1])
        setTimeout(function () {
          _self.showCalendar = false
          _self.getHotelIndex()
        }, 500)
      },
      // show room desc
      showHotelDesc (htId, roomId) {
        this.roomDescStatus = true
        let _self = this
        let loading
        loading = _self.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          id: _self.getUrlParams('id'),
          openid: _self.getUrlParams('openid'),
          h: htId,
          r: roomId
        }
        getHotelDetail(args).then(function (res) {
          _self.logJSON(res)
          if (res.status === 1000) {
            _self.roomDescData = res.web_data
          } else {
            _self.roomDescData = []
          }
          if (loading) {
            loading.close()
          }
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      // showPackageDesc
      showPackageDesc (htId, roomId) {
        this.packageDescStatus = true
        let _self = this
        let loading
        loading = _self.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          id: _self.getUrlParams('id'),
          openid: _self.getUrlParams('openid'),
          h: htId,
          r: roomId
        }
        getHotelDetail(args).then(function (res) {
          _self.logJSON(res)
          if (res.status === 1000) {
            _self.packageDescData = res.web_data
          } else {
            _self.packageDescData = []
          }
          if (loading) {
            loading.close()
          }
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      // showRoomStatus
      showRoomStatus (type) {
        type === 0 ? this.isRoomStatus = true : this.isRoomStatus = false
      },
      // change day
      changeDay (result) {
        let day = result.lastIndexOf('/')
        day = result.substring(day + 1, result.length)
        return day
      },
      // change month
      changeMonth (result) {
        result = result.substring(5)
        return result
      },
      showCalenDar () {
        let _self = this
        let today = new Date()
        _self.min = today
        _self.max = _self.setDateMonth()
        this.showCalendar = true
      },
      //  设置日期+3
      setDateMonth () {
        var d = new Date()
        var month = d.getMonth()
        if (month === 11) {
          var year = d.getFullYear()
          d.setMonth(0)
          d.setFullYear(year + 1)
        } else {
          d.setMonth(month + 3)
        }
        return d
      },
      changeTabEvt (val) {
        if (val) {
          this.changeTab = true
        } else {
          this.changeTab = false
        }
      },
      // 显示选择商品页面
      goProductChoose () {
        let _self = this
        _self.showProductChoose = true
        const cb = () => {
          _self.showProductChoose = false
        }
        showFullLayer(null, '选择优惠券', location.href, cb)
      },
      // 获取url 参数
      getUrlParams (urlName) {
        let url = location.href
        let paraString = url.substring(url.indexOf('?') + 1, url.length).split('&')
        let returnValue
        for (let i = 0; i < paraString.length; i++) {
          let tempParas = paraString[i].split('=')[0]
          let parasValue = paraString[i].split('=')[1]
          if (tempParas === urlName) returnValue = parasValue
        }
        if (typeof (returnValue) === 'undefined') {
          return ''
        } else {
          return returnValue
        }
      },
      // 输出专用
      logJSON (data) {
        function innerLog (data) {
          const temp = {}
          for (let p in data) {
            if (typeof data[p] === 'object') temp[p] = innerLog(data[p])
            else temp[p] = data[p]
          }
          return temp
        }
        console.log(innerLog(data))
      }
    }
  }
</script>
