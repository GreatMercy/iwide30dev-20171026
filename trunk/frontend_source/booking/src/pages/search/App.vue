<template>
  <div class="jfk-pages jfk-pages__search">
    <div class="search_container" v-show="!showCityChoose">
    <div class="pageContainer" v-show="true">
      <div class="jfk-pages__theme"></div>
    <jfk-banner :items="advs" v-if="advs.length" :swiperOptions="swiperOptions"></jfk-banner>
    <div class="search_place_container" @click="goCityChoose()">
      <div class="search_place">
          <p class="search_title font-size--28">
            <i class="booking_icon_font icon_search icon-icon_search"></i>
            {{searchVal}}
          </p>
          <i class="booking_icon_font icon_place icon-booking_icon_nearby_normal"></i>
      </div>
    </div>
    <div class="date_container">
      <div class="left_date" @click="goCalendar()">
        <span class="left_date_style">入 住</span>
        <span class="live_date jfk-font-number jfk-price__number"><i class="booking_icon_font icon_arrow icon-booking_icon_dropdown_normal"></i>{{startDate}}</span>
        <span class="live_year">{{startMonth}}</span>
      </div>
      <span class="center_line"></span>
      <div class="right_date" @click="goCalendar()">
        <span class="left_date_style">离 开</span>
        <span class="live_date jfk-font-number jfk-price__number"><i class="booking_icon_font icon_arrow icon-booking_icon_dropdown_normal"></i>
        {{endDate}}</span>
        <span class="live_year">{{endMonth}}</span>
      </div>
    </div>
    <div class="checkBtn">
      <a :href="page_resource.SRESULT + '&startDate=' + handleStartDate + '&endDate=' + handleEndDate">查 询 酒 店</a>
    </div>
    <!-- <p class="color-golden" v-show="isLoadProduct">loading</p> -->
    <div class="search_info"
         v-show="allData.web_data.last_orders"
         v-if="allData != ''">
      <p class="search_info_title">最近搜索</p>
      <p class="search_info_item item_first"
         v-for="(item, index) in allData.web_data.last_orders">
        {{item.hcity}}  {{item.hname}}</p>
    </div>
    <div class="webkitbox others center boxflex pad_lr30 box_container">
      <a class="layer_bg color2 j_whole_show always" @click="showBottomTip(0)">
          <div class="img">
            <i class="booking_icon_font icon_arrow icon-booking_icon_timerent_normal font-size--40"></i>
          </div>
          <div class="txtclip font-size--28 mar_b">常住酒店</div>
          <div class="txtclip font-size--24 gray_color">8：00-18：00</div>
      </a>
      <a class="layer_bg color2 j_whole_show kill_sec" @click="showBottomTip(1)">
        <div class="img">
          <i class="booking_icon_font icon_arrow icon-booking_icon_timelimitspike_normal font-size--40"></i>
        </div>
        <div class="txtclip font-size--28 mar_b">我的收藏</div>
        <div class="txtclip font-size--24 gray_color">一元拼手气</div>
      </a>
      <a class="layer_bg color2 order">
        <div class="img">
          <i class="booking_icon_font icon_arrow icon-booking_icon_earlytoearly_normal font-size--40"></i>
        </div>
        <div class="txtclip font-size--28 mar_b">我的订单</div>
        <div class="txtclip font-size--24 gray_color">提前预定享8折</div>
      </a>
    </div>
    </div>
    <JfkSupport v-once></JfkSupport>
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
       <!-- :minDate="min" :maxDate="max" :defaultValue="defaultValue" :dateCellRender="dateCellRender" :disabledDate="disabledDate" @date-click="handleDateClick"  -->
    </div>
    <!-- 我的收藏 && 常住酒店模块 -->
    <div class="my_collection" v-show="showCollection">
      <div class="jfk-pl-30 jfk-pr-30">
        <div class="collection_mask">
          <span class="closeBtn" @click="showCollection = false">
            <i class="jfk-font font-size--24 icon-icon_close"></i>
          </span>
          <p class="title font-size--32">{{bottomTitle}}</p>
          <ul v-show="showTipData.length != 0">
            <li v-for="(item, index) in showTipData">
              <a :href="item.link" class="font-size--32" v-if="item.mark_title">{{item.mark_title}}</a>
              <a :href="item.link" class="font-size--32" v-else>{{item.hname}}</a>
            </li>
          </ul>
          <a class="font-size--24" v-show="showTipData.length == 0">无</a>
          <span class="sure font-size--24" @click="showCollection = false">
            <i class="booking_icon_font font-size--32 icon-font_zh_que_qkbys"></i>
            <i class="booking_icon_font font-size--32 icon-font_zh_ding__qkbys"></i>
          </span>
        </div>
      </div>
    </div>
    </div>
  <city-choose v-show="showCityChoose"
               :handleStartDate="handleStartDate"
               :handleEndDate="handleEndDate">
  </city-choose>
  </div>
  </div>
</template>
<script>
import { getBannerList } from '@/service/http'
import cityChoose from '../city_choose/App.vue'
import { showFullLayer } from '@/utils/utils'
export default {
  name: 'index',
  components: {
    cityChoose
  },
  beforeCreate () {
  },
  created () {
    console.log(process.env.NODE_ENV)
//    计算日期
    this.getDate()
    // 加载swiper
    this.loadPackages()
//    使用日历
    this.setCalendar()
  },
  computed: {
  },
  data () {
    return {
      // 所有数据
      allData: [],
      // 模拟id，后期由后台加上
      id: '',
      openid: '',
      advs: [],
      // 我的收藏
      hotelCollectionData: [],
      // 常住酒店
      lastOrderData: [],
      // 提示的data
      showTipData: [],
      // 我的收藏显示状态
      showCollection: false,
      bottomTitle: '常住酒店',
      isLoadProduct: false,
      // banner 配置
      swiperOptions: {
        autoplay: 0,
        lazyLoading: true,
        lazyLoadingInPrevNext: true,
        lazyPreloaderClass: 'jfk-image__lazy--preload',
        spaceBetween: 12,
        slidesPerView: 1.12,
        pagination: '.swiper-pagination',
        paginationType: 'fraction'
      },
      // 日历显示
      showCalendar: false,
      startDate: '',
      endDate: '',
      startMonth: '',
      endMonth: '',
      // 搜索框显示的字
      searchVal: '搜索城市 / 关键字 / 位置',
      showCityChoose: false,
      // 显示热搜
      showHotSearch: false,
      // 日历最小日期
      min: null,
      // 日历最大日期
      max: null,
      page_resource: {
        'SRESULT': 'nearby?theme=1&id=a429262687'
      },
      handleStartDate: '',
      handleEndDate: ''
    }
  },
  methods: {
    getDate () {
      let year = new Date().getFullYear()
      let month = new Date().getMonth() + 1
      month = (month < 10 ? '0' + month : month)
      let today = new Date().getDate()
      this.startMonth = year + '/' + month
      this.endMonth = year + '/' + month
      this.startDate = today
      this.endDate = today + 1
      this.handleStartDate = year + '/' + month + '/' + today
      this.handleEndDate = year + '/' + month + '/' + this.endDate
    },
    loadPackages () {
      let that = this
      let loading
      loading = this.$jfkToast({
        iconClass: 'jfk-loading__snake ',
        duration: -1,
        isLoading: true
      })
      let args = {
        id: this.getUrlParams('id'),
        openid: this.getUrlParams('openid')
      }
      getBannerList(args).then(function (res) {
        if (loading) {
          loading.close()
        }
        that.allData = res
        for (let i = 0; i < res.web_data.pubimgs.length; i++) {
          res.web_data.pubimgs[i].logo = res.web_data.pubimgs[i].image_url
        }
        that.advs = res.web_data.pubimgs
        that.hotelCollectionData = res.web_data.hotel_collection
        that.lastOrderData = res.web_data.last_orders
        if (process.env.NODE_ENV !== 'development') {
          that.page_resource = res.web_data.page_resource.links
        }
        that.logJSON(res)
      }).catch(function (e) {
        if (loading) {
          loading.close()
        }
        console.log(e)
      })
    },
    // 去往选择城市组件
    goCityChoose () {
      let _self = this
      _self.showCityChoose = true
      const cb = () => {
        _self.showCityChoose = false
      }
      showFullLayer(null, '选择城市', location.href, cb)
    },
    // 去往选择日期组件
    goCalendar () {
      let _self = this
      _self.showCalendar = true
      const cb = () => {
        _self.showCalendar = false
      }
      showFullLayer(null, '选择日期', location.href, cb)
    },
    handleDateClick (result) {
      let _self = this
      _self.handleStartDate = result[0]
      _self.handleEndDate = result[1]
      _self.startDate = _self.changeDay(result[0])
      _self.endDate = _self.changeDay(result[1])
      _self.startMonth = _self.changeMonth(result[0])
      _self.endMonth = _self.changeMonth(result[1])
      setTimeout(function () {
        _self.showCalendar = false
      }, 500)
    },
    // change day
    changeDay (result) {
      let day = result.lastIndexOf('/')
      day = result.substring(day + 1, result.length)
      return day
    },
    // change day
    changeMonth (result) {
      result = result.substring(0, result.length - 3)
      return result
    },
    // 显示tip
    showBottomTip (type) {
      var _self = this
      type ? _self.bottomTitle = '我的收藏' : _self.bottomTitle = '常住酒店'
      type ? _self.showTipData = _self.hotelCollectionData : _self.showTipData = _self.lastOrderData
      _self.showCollection = true
    },
    setCalendar () {
      let _self = this
      let today = new Date()
      _self.min = today
      _self.max = _self.setDateMonth()
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
