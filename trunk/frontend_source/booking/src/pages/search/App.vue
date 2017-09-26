<template>
  <div class="jfk-pages jfk-pages__search">
    <div class="jfk-pages__theme"></div>
    <div class="search_container" v-show="!showCityChoose">
      <div class="pageContainer" v-show="true">
        <jfk-banner :items="advs"
                    v-if="advs.length">
        </jfk-banner>
        <div class="search_place_container">
          <div class="search_place">
            <p class="search_title font-size--30" @click="goCityChoose(1)">
              <i class="booking_icon_font icon_search icon-icon_search font-size--24"></i>
              <span v-if="areaWord !== '搜索城市'">{{areaWord}} ({{clickCityWord}})</span>
              <span v-if="areaWord === '搜索城市'">{{clickCityWord}}</span>
            </p>
            <i class="booking_icon_font icon_place font-size--46 icon-booking_icon_nearby_normal"
               @click="HrefToNearby()"></i>
          </div>
          <div class="search_place search_place2">
            <p class="search_title font-size--30 searchCity noLine" @click="goCityChoose(0)">
              <i class="booking_icon_font icon_search icon-user_icon_myaddress_normal font-size--24"></i>
              {{searchVal}}
            </p>
          </div>
        </div>
        <div class="date_container">
          <div class="left_date" @click="goCalendar()">
            <span class="left_date_style">入住</span>
            <span class="live_date jfk-font-number jfk-price__number"><i
              class="booking_icon_font icon_arrow icon-booking_icon_dropdown_normal"></i>{{startDate}}</span>
            <span class="live_year font-size--24">{{startMonth}}</span>
          </div>
          <span class="center_line"></span>
          <div class="right_date" @click="goCalendar()">
            <span class="left_date_style">离店</span>
            <span class="live_date jfk-font-number jfk-price__number"><i
              class="booking_icon_font icon_arrow icon-booking_icon_dropdown_normal"></i>
            {{endDate}}</span>
            <span class="live_year font-size--24">{{endMonth}}</span>
          </div>
        </div>
        <div class="checkBtn">
          <a :href="toLinks.SRESULT + '&startdate=' + handleStartDate + '&enddate=' + handleEndDate + '&area=' + this.areaWord + '&city=' + clickCityWord">查询酒店</a>
        </div>
        <div class="search_info" v-if="searchCacheData.length !== 0">
          <p class="search_info_title">最近搜索</p>
          <p class="search_info_item item_first"
             v-for="item in searchCacheData">
            <a :href="item.link">
              <span>{{item.city}}&nbsp&nbsp&nbsp</span>
              <span>{{item.startdate}}</span>
              <span>{{item.enddate}}</span>
              <span>{{item.title}}</span>
            </a>
          </p>
        </div>
        <div class="webkitbox others center boxflex pad_lr30 box_container">
          <template v-for="item in homepage_set_menu">
            <a class="layer_bg color2 j_whole_show always" v-if="item.code === 'always'"
               @click="showBottomTip(0)">
              <div class="img">
                <i class="jfk-font icon_arrow icon-blankpage_icon_nohotel_bg font-size--42"></i>
              </div>
              <div class="txtclip font-size--28 mar_b">{{item.menu_name}}</div>
              <div class="txtclip font-size--24 gray_color">{{item.desc}}</div>
            </a>
            <a class="layer_bg color2 j_whole_show always" v-if="item.code === 'collect'"
               @click="showBottomTip(1)">
              <div class="img">
                <i class="booking_icon_font icon_arrow icon-icon_recommend font-size--42"></i>
              </div>
              <div class="txtclip font-size--28 mar_b">{{item.menu_name}}</div>
              <div class="txtclip font-size--24 gray_color">{{item.desc}}</div>
            </a>
            <a class="layer_bg color2 j_whole_show always lastAlways" v-if="item.code === 'order'"
               :href="item.link">
              <div class="img">
                <i class="jfk-font icon-blankpage_icon_noorder_bg font-size--42"></i>
              </div>
              <div class="txtclip font-size--28 mar_b">{{item.menu_name}}</div>
              <div class="txtclip font-size--24 gray_color">{{item.desc}}</div>
            </a>
          </template>
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
                        :range="true"
                        :value="[new Date(handleStartDate), new Date(handleEndDate)]">
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
            <ul v-show="showTipData !== null">
              <li v-for="(item, index) in showTipData">
                <a :href="item.link" class="font-size--32" v-if="item.mark_title">{{item.mark_title}}</a>
                <a :href="item.link" class="font-size--32" v-else>{{item.hname}}</a>
              </li>
            </ul>
            <a class="font-size--24" v-show="!showTipData">无</a>
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
                 :handleEndDate="handleEndDate"
                 :allCitys="allCitys"
                 :hotCitys="hotCitys"
                 :toLocationHref="toLocationHref"
                 :getChooseCityVal="getChooseCityVal"
                 :HrefToNearby="HrefToNearby"
                 :toLinks="toLinks"
                 :firstCity="firstCity"
                 :clicktype="cityChooseType"
                 :currentCity="clickCityWord">
    </city-choose>
  </div>
</template>
<script>
  import {getBannerList} from '@/service/http'
  import cityChoose from './module/city_choose/App.vue'
  import {showFullLayer} from '@/utils/utils'
  export default {
    name: 'index',
    components: {
      cityChoose
    },
    created () {
      // 计算日期
      this.getDate()
      // 加载swiper
      this.loadPackages()
      // 使用日历
      this.setCalendar()
      // 设置缓存
      if (this.searchCacheData.length !== 0) {
        this.searchCacheData = JSON.parse(window.localStorage['searchcache'])
      }
    },
    data () {
      return {
        // 所有数据
        allData: null,
        // 模拟id，后期由后台加上
        id: '',
        openid: '',
        advs: [],
        // 我的收藏
        hotelCollectionData: null,
        // 常住酒店
        lastOrderData: null,
        // 提示的data
        showTipData: null,
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
        searchVal: '关键字 / 位置',
        showCityChoose: false,
        // 显示热搜
        showHotSearch: false,
        // 日历最小日期
        min: null,
        // 日历最大日期
        max: null,
        page_resource: {
          'SRESULT': ''
        },
        toLinks: {},
        handleStartDate: '',
        handleEndDate: '',
        homepage_set_menu: [],
        allCitys: {},
        hotCitys: [],
        // 设置首选城市
        firstCity: '',
        searchCacheData: [],
        startString: '',
        endString: '',
        // 用来判断是选择城市还是搜索 0 1 因为使用watch 要给0 ，1 以外的数字
        cityChooseType: 3,
        // 入住城市
        clickCityWord: '搜索城市',
        areaWord: '搜索城市'
      }
    },
    methods: {
      // 页面跳转
      toLocationHref (href) {
        window.location.href = href
      },
      // nearby = 1 查看附近
      HrefToNearby () {
        let href = this.toLinks.NEARBY + '&startdate=' + this.handleStartDate + '&area=' + this.areaWord + '&enddate=' + this.handleEndDate + '&city=' + this.clickCityWord
        window.location.href = href
      },
      getChooseCityVal (area, city) {
        this.clickCityWord = city
        if (area !== 0) {
          this.areaWord = area
        } else {
          // 设置 城市 过去 nearby 会被忽略
          this.areaWord = '搜索城市'
        }
        this.showCityChoose = false
      },
      getDate () {
        // 获取现在的时间
        let year = new Date().getFullYear()
        let month = new Date().getMonth() + 1
        month = (month < 10 ? '0' + month : month)
        let today = new Date().getDate()
        this.startMonth = year + '/' + month
        this.endMonth = year + '/' + month
        this.startDate = today
        this.endDate = today + 1
        if (this.startDate < 10) {
          this.startDate = '0' + this.startDate
        }
        this.handleStartDate = year + '/' + month + '/' + this.startDate
        this.handleEndDate = this.getDayAdd(this.handleStartDate)
        this.startDate = this.handleStartDate.substring(8, 10)
        this.endDate = this.handleEndDate.substring(8, 10)
      },
      loadPackages () {
        let that = this
        let loading = null
        loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        let args = {
          id: that.getUrlParams('id'),
          openid: that.getUrlParams('openid')
        }
        // 获取基础信息
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
          that.toLinks = res.web_data.page_resource.links
          that.allCitys = res.web_data.citys
          that.hotCitys = res.web_data.hot_city
          that.firstCity = res.web_data.first_city
//          that.setJumpUrls()
          let menu = res.web_data.homepage_set.menu
          for (let attr in menu) {
            that.homepage_set_menu.push(menu[attr])
          }
          if (process.env.NODE_ENV !== 'development') {
            that.page_resource = res.web_data.page_resource.links
          }
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
        })
      },
      // 去往选择城市组件
      goCityChoose (type) {
        let _this = this
        _this.showCityChoose = true
        // 用来判断是选择城市还是搜索
        _this.cityChooseType = type
        const cb = () => {
          _this.showCityChoose = false
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
        // 调用日期插件
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
//        _self.setJumpUrls()
        // 关闭日历
        setTimeout(function () {
          _self.showCalendar = false
        }, 500)
      },
      // 设置跳转添加(加参)
      setJumpUrls () {
        // 查询酒店路径
//        let url1 = this.toLinks.SRESULT
//        let url2 = this.toLinks.NEARBY
//        this.toLinks.SRESULT = url1 + '&startdate=' + this.handleStartDate + '&enddate=' + this.handleEndDate + '&city=' + this.clickCityWord
//        this.toLinks.NEARBY = url2 + '&startdate=' + this.handleStartDate + '&enddate=' + this.handleEndDate + '&city=' + this.clickCityWord
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
        // 设置最晚的时间
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
