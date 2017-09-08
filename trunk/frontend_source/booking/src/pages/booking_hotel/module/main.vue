<template>
  <div class="jfk-pages jfk-pages__bookingHotel">
    <div v-show="!showSubmitOrder">
    <div class="jfk-pages__theme"></div>
      <!--顶层banner-->
    <div class="detail-top" v-if="advs" :class="{'is-default': productGalleryIsDefault}">
      <div class="banners">
        <swiper :options="bannerSwiperOptions" class="jfk-swiper">
          <swiper-slide v-for="(item, index) in advs" :key="index" class="jfk-swiper__item" :class="{'swiper-no-swiping': advs.length === 1}">
            <div class="banners__item-box jfk-swiper__item-box">
              <div :data-background="item.image_url"
                   class="banners__item jfk-swiper__item-bg swiper-lazy"
                   v-if="item.image_url">
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
        <a :href="page_resource.HOTEL_COMMENT">
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
        </a>
        <span class="center_line"></span>
        <span class="live_date" @click="showCalenDar()">
          <span class="live">入住</span>{{startDate}}<br/><span class="live">离店</span>{{endDate}}
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
          <div class="room_pic" @click="showHotelDesc(item.room_info.room_id)">
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
                    <span class="pay_btn hasline"
                          v-if="value.condition.pre_pay === 1"
                          @click="collectItem(item,1)">
                      <span class="topWord">
                        <i class="booking_icon_font icon-font_zh_yv_qkbys ft-18"></i>
                        <i class="booking_icon_font icon-font_zh_ding__qkbys ft-18"></i>
                      </span>
                      <span class="needpaybefore ft-18">
                        需预付
                      </span>
                     </span>
                    <span class="pay_btn" @click="collectItem(item,1)" v-else>
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
               @click="showPackageDesc(item, item.room_info.room_id)">
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
              <span class="chooseBtn"
                    v-if="item.package_info.sale_way === 1"
                    @click="collectItem(item, 2)">
                <i class="booking_icon_font icon-font_zh_yv_qkbys ft-18"></i><i class="booking_icon_font icon-font_zh_ding__qkbys ft-18"></i>
              </span>
               <span class="chooseBtn"
                     v-else
                     @click="goProductChoose(item)">
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
          <!--酒店设施 组件-->
          <hotelServiceIcon :hotel_service="hotelService"/>
        </div>
        <div class="room_detail">
          <p>建筑面积：{{roomDescData.area}}m²</p>
          <p v-html="roomDescData.book_policy" v-if="allData !== ''"></p>
        </div>
      </div>
    </div>
    <!--畅享套餐详情-->
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
            <!--酒店设施 组件-->
            <hotelServiceIcon :hotel_service="hotelService"/>
          </div>
          <div class="package_detail" v-if="packageDescData !== '' && isRoomStatus">
            <p>建筑面积：{{packageDescData.area}}m²</p>
            <p v-if="allData !== ''">{{packageDescData.book_policy}}</p>
          </div>
          <div class="packageDescDetail font-size--28"
               v-show="!isRoomStatus"
               v-for="(value, key) in packageDescDetail.items">
            <p>订购须知</p>
            <p>{{packageDescDetail.sale_notice}}</p>
            <p>套餐明细</p>
            <p>{{value.goods_name}}</p>
            <div class="del" v-html="value.details"></div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</template>
<script>
  import { getBookroomDetail, getHotelIndex, getHotelDetail } from '@/service/http'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import hotelServiceIcon from '../../../components/common/hotel_service_icon.vue'
  let params = formatUrlParams(location.search)
  export default {
    components: {
      hotelServiceIcon
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
        productGalleryIndex: 1,
        // 无gallery图片，添加默认图片
        productGalleryIsDefault: true,
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
          'RETURN_ROOM_DETAIL': ''
        },
        startString: '',
        endString: '',
        sendData: {},
        showProductChoose: false,
        couponProductItem: null,
        // 显示提交订单
        showSubmitOrder: false,
        // 用于发送数据
        xprice_code: {},
        datas: {},
        price_type: {},
        package_info: '',
        hotelService: '',
        packageDescDetail: {}
      }
    },
    methods: {
      // 获取数据
      getHotelIndex () {
        let _this = this
        let loading
        // 对 url 上的参数的预处理
        if (params.start && params.end) {
          _this.startString = params.start
          _this.endString = params.end
        } else if (params.startdate && params.enddate) {
          _this.startString = params.startdate
          _this.endString = params.enddate
        } else {
          let year = new Date().getFullYear()
          let month = new Date().getMonth() + 1
          month = (month < 10 ? '0' + month : month)
          let today = new Date().getDate()
          today < 10 ? today = '0' + today : today
          _this.startString = year + '/' + month + '/' + today
          _this.endString = _this.getDayAdd(_this.startString)
        }
        loading = _this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          h: params.h,
          start: _this.startString || '',
          end: _this.endString || '',
          id: params.id || '',
          openid: params.openid || ''
        }
        getHotelIndex(args).then(function (res) {
          _this.allData = res.web_data
          _this.packagesInfo = res.web_data.packages
          _this.rooms = res.web_data.rooms
          _this.page_resource = res.web_data.page_resource.links
          _this.advs = res.web_data.hotel.imgs.hotel_lightbox
          if (loading) {
            loading.close()
          }
          for (let key in _this.rooms) {
            _this.rooms[key] = Object.assign({}, _this.rooms[key], {showWord: '收起'})
            _this.rooms[key] = Object.assign({}, _this.rooms[key], {showStatus: true})
          }
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      // 预订酒店 收起 与更多的状态控制
      showroom (index) {
        if (!this.rooms[index].showStatus) {
          this.rooms[index] = Object.assign({}, this.rooms[index], {showWord: '收起'})
          this.rooms[index] = Object.assign({}, this.rooms[index], {showStatus: true})
          this.$set(this.rooms[index], 'showWord', '收起')
          this.$set(this.rooms[index], 'showStatus', true)
        } else {
          this.rooms[index] = Object.assign({}, this.rooms[index], {showWord: '更多'})
          this.rooms[index] = Object.assign({}, this.rooms[index], {showStatus: false})
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
        this.startDate = this.changeMonth(this.startString)
        this.endDate = this.changeMonth(this.endString)
      },
      handleDateClick (result) {
        let _self = this
        _self.startDate = _self.changeMonth(result[0])
        _self.endDate = _self.changeMonth(result[1])
        _self.startString = result[0]
        _self.endString = result[1]
        console.log('====================', _self.startDate)
        console.log('====================', _self.endDate)
        setTimeout(function () {
          _self.showCalendar = false
          _self.getHotelIndex()
        }, 500)
      },
      // show room desc 显示房间预订弹窗
      showHotelDesc (roomId) {
        this.roomDescStatus = true
        let _self = this
        let loading
        loading = _self.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          id: params.id,
          openid: params.openid,
          h: params.h,
          r: roomId
        }
        getHotelDetail(args).then(function (res) {
          _self.roomDescData = res.web_data
          _self.hotelService = res.web_data.imgs.hotel_room_service
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
      // showPackageDesc 显示畅享套餐弹窗
      showPackageDesc (item, roomId) {
        this.packageDescDetail = item.package_info
        this.packageDescStatus = true
        let _self = this
        let loading
        loading = _self.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          id: params.id,
          openid: params.openid,
          h: params.h,
          r: roomId
        }
        getHotelDetail(args).then(function (res) {
          _self.packageDescData = res.web_data
          _self.hotelService = res.web_data.imgs.hotel_room_service
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
      // showRoomStatus 畅享套餐弹窗 房型详情与套餐详情的tab点击事件
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
      // 显示日历
      showCalenDar () {
        let _self = this
        let today = new Date()
        _self.min = today
        _self.max = _self.setDateMonth()
        this.showCalendar = true
      },
      // 设置日期+3
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
      // 预订酒店 && 畅享套餐 tab 点击
      changeTabEvt (val) {
        if (val) {
          this.changeTab = true
        } else {
          this.changeTab = false
        }
      },
      // 显示选择商品页面
      goProductChoose (item) {
        item.startDate = this.startString
        item.endDate = this.endString
        this.$store.commit('updateproductListData', item)
        this.$store.commit('updatebookingAllData', this.allData)
        this.$router.push('/choose')
      },
      // 预定按钮点击
      collectItem (item, type) {
        console.log(item, 'item====')
        this.packages = this.allData.packages
        this.sendData.hotel_id = params.h
        this.sendData.room_id = item.room_info.room_id
        this.sendData.startdate = this.startString
        this.sendData.enddate = this.endString
        this.sendData.price_codes = {}
        if (type === 1) {
          for (let key in item.state_info) {
            this.sendData.price_codes = item.state_info[key].price_code
            this.sendData.price_type = item.state_info[key].price_type
          }
        } else {
          this.sendData.price_codes = item.state_info.price_code
          this.sendData.price_type = item.state_info.price_type
        }
        this.$store.commit('updateSubmitOrderConfig', this.sendData)
//        protrol_code (协议代码)
        this.beforePage()
      },
      // 去往提交订单前的日期预处理
      beforePage () {
        let loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        // 数据处理
        if (this.sendData.room_id) {
          this.xprice_code = {}
          this.xprice_code[this.sendData.room_id] = this.sendData.price_codes
          this.datas = {}
          this.datas[this.sendData.room_id] = 1
          this.price_type[this.sendData.price_type] = 1
        }
        let goodsItems = ''
        if (this.sendData.select_package) {
          for (let i = 0; i < this.sendData.select_package.length; i++) {
            const content = this.sendData.select_package[i]
            let goodId = content.goods_id.toString()
            let nums = content.countNum
            let obj = `"${goodId}":{"gid":"${goodId}","nums":"${nums}"`
            goodsItems += obj
          }
        }
        this.package_info = `{${goodsItems}}`
        let setData = {
          id: params.id || '',
          openid: params.openid || '',
          startdate: this.sendData.startdate || '',
          enddate: this.sendData.enddate || '',
          price_codes: JSON.stringify(this.xprice_code) || '',
          hotel_id: this.sendData.hotel_id || '',
          datas: JSON.stringify(this.datas) || '',
          protrol_code: '',
          price_type: JSON.stringify(this.price_type) || '',
          select_package: this.sendData.select_package || [],
          package_info: this.package_info || []
        }
        getBookroomDetail(setData).then((res) => {
          if (loading) {
            loading.close()
          }
          this.$store.commit('updateSubmitResdata', res)
          this.$router.push('/order')
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      // 时间戳转换成八位日期
      getDayAdd (d) {
        d = new Date(d)
        d = +d + 1000 * 60 * 60 * 24 + 86400
        d = new Date(d)
        let month = d.getMonth() + 1
        let tommorrow = d.getDate()
        if (tommorrow < 10) tommorrow = '0' + tommorrow
        month = (month < 10 ? '0' + month : month)
        return d.getFullYear() + '/' + month + '/' + tommorrow
      }
    }
  }
</script>
