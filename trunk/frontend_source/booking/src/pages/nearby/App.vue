<template>
  <div class="jfk-pages jfk-pages__nearby">
    <div class="jfk-pages__theme"></div>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <div class="search_bar font-size--30 grayColor80" v-show="showList">
      <span class="search_bar_item" @click="changeTab($event,'price')">
        <span class="type">价格</span>
        <i class="booking_icon_font font-size--24 icon-booking_icon_reverseorder_normal" v-show="priceDown"></i>
        <i class="booking_icon_font font-size--24 icon-booking_icon_positiveorder_normal" v-show="priceUp"></i>
      </span>
      <span class="search_bar_item" @click="changeTab($event,'comment_score')">
        <span class="type">评价</span>
      </span>
      <span class="search_bar_item" @click="changeTab($event,'distance')">
        <span class="type">距离</span>
      </span>
      <span class="search_bar_item" @click="showSearchEvt()">
        <span class="type">筛选</span>
        <i class="booking_icon_font icon-booking_icon_dropdown_normal arrow_icon"></i>
      </span>
      <span class="search_bar_item dateContainer font-size--28" @click="showCalenDar()">
        <span class="type3">
          <span class="grayColorbf">入住</span> {{startDate}}<br><span class="grayColorbf">离店</span> {{endDate}}
        </span>
        <i class="booking_icon_font icon-booking_icon_dropdown_normal arrow_icon"></i>
      </span>
    </div>
    <div class="img_container" v-show="showList">
      <div class="img_container_item" v-for="(item, index) in listData" @click="toLocationHref(item.link)">
        <a :href="item.link + '&startdate=' + startString + '&enddate=' + endString + '&'">
          <img :src="item.intro_img" alt="" class="one_img">
        </a>
        <!-- 特惠 -->
        <!-- <span class="cheap font-size--28">
          <i class="booking_icon_font font-size--24 icon-font_zh_hui_fzdbs"></i>
           <i class="booking_icon_font font-size--24 icon-font_zh_hui_fzdbs"></i>
        </span> -->
        <p class="hotel_name font-size--30">
          <span class="score font-size--24">{{item.comment_data.comment_score}}</span>
          {{item.name}}
        </p>
        <p class="address font-size--24 grayColor80">
          <span class="distance" v-if="item.distance">距您{{item.distance}}公里</span>
          {{item.address}}
        </p>
        <span class="jfk-price product-price-package font-size--24" v-if="item.lowest && item.lowest >= 0">
          <i class="jfk-font-number jfk-price__currency font-size--30">￥</i>
          <i class="jfk-font-number jfk-price__number font-size--54">{{item.lowest}}</i>
          起
        </span>
        <span class="jfk-price product-price-package font-size--24" v-else-if="item.lowest && item.lowest < 0">
          满房
        </span>
        <span class="jfk-price product-price-package font-size--24" v-else="!item.lowest">
          暂无价格
        </span>
      </div>
    </div>
    <!--日历-->
    <div class="choose_date_calendar" v-show="showCalendar">
      <div class="jfk-pl-30 jfk-pr-30">
        <jfk-calendar ref="jfkCalendar" class="font-size--28" format="yyyy/MM/dd" @date-pick="handleDateClick"
                      :minDate="min" :maxDate="max" :range="true">
        </jfk-calendar>
      </div>
    </div>
    <div class="nosearch_container" v-show="!showList">
      <div class="search_city font-size--38 jfk-pl-30 jfk-pr-30">
        <form @submit.prevent="searchHotelAction()">
          <input type="text" class="font-size--38" placeholder="城市/关键字/位置" v-model="searchInputVal" id="searchVal"
                 autocomplete="off">
        </form>
        <i class="jfk-font jfk-button__text-item icon-icon_close icon-icon_delete" v-show="showDeleteIcon"
           @click="clearInput"></i>
      </div>
      <!-- 无搜索结果 -->
      <div v-show="hasNoResult">
        <div class="no_search">
          <div class="no_seach_result font-size--24 grayColor">
            <i class="booking_icon_font icon-icon_search font-size--52 icon_noresult_search"></i><br/>
            没有搜索到相关结果~ <br/>
            换个条件试试
          </div>
        </div>
      </div>
    </div>
    <!--异步搜索的列表-->
    <div class="search_city_list jfk-pl-30 jfk-pr-30" v-show="searchResult">
      <div class="search_city_list_item" v-for="(item, index) in asycSearchData" :key="index">
        <p>
          <i class="booking_icon_font font-size--24 icon-booking_icon_businessdistrict_norma grayColor"></i>
          <span class="goldColor">{{item.name}}</span>
        </p>
      </div>
    </div>
    <!-- 百度搜索的列表 -->
    <div class="search_city_list jfk-pl-30 jfk-pr-30" v-show="searchResult">
      <div class="baidu-search">搜索到以下地标</div>
      <div class="search_city_list_item" v-for="(item, index) in baiduApiData" :key="index">
        <p>
          <i class="booking_icon_font font-size--24 icon-booking_icon_businessdistrict_norma grayColor"></i>
          <span class="goldColor">{{item.title}}</span>
        </p>
      </div>
    </div>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import {getAjaxHotelList, getBaiduSearchPlaceList} from '@/service/http'
  import {showFullLayer} from '@/utils/utils'

  export default {
    name: 'useCoupon',
    components: {},
    beforeCreate () {
    },
    created () {
      // 加载swiper
      this.loadPackages()
      // 获取日期
      this.getDate()
    },
    data () {
      return {
        // 模拟id，后期由后台加上
        id: '',
        openid: '',
        // 所有数据
        allData: null,
        // 列表数据
        listData: null,
        // swiper
        isLoadProduct: false,
        // 价格排序往上
        priceUp: false,
        // 价格排序往下
        priceDown: false,
        // 筛选的type
        filterType: 'distance',
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
        startString: this.getUrlParams('startdate'),
        endString: this.getUrlParams('enddate'),
        page_resource: '',
        // 显示列表
        showList: true,
        showDeleteIcon: false,
        searchStatus: false,
        searchResult: false,
        // 无结果
        hasNoResult: false,
        searchInputVal: '',
        // 百度地图搜索data
        baiduApiData: [],
        asycSearchData: [],
        firstCity: '全部',
        defaultCity: '北京',
        searchedCity: '',
        localSearchData: ''
      }
    },
    methods: {
      getDate () {
//        let month = this.getUrlParams('startdate').substr(5, 2)
        this.startMonth = this.getUrlParams('startdate').substr(5, 2)
        this.endMonth = this.getUrlParams('enddate').substr(5, 2)
        this.startDate = this.startMonth + '/' + this.getUrlParams('startdate').substr(8, 2)
        this.endDate = this.endMonth + '/' + this.getUrlParams('enddate').substr(8, 2)
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
          openid: that.getUrlParams('openid'),
          // 纬度
          lat: window.localStorage.getItem('latitude') || 23.117,
          // 经度
          lnt: window.localStorage.getItem('longitude') || 113.275,
          // 开始日期
          start: that.startString,
          // 结束日期
          end: that.endString,
          // 城市
          city: that.getUrlParams('city') || '广州',
          // 县
          area: '',
          // 关键字
          keyword: '',
          // 开始位置
          off: 0,
          // 排序类型
          sort_type: this.filterType,
          // 每次返回数量
          num: 20,
          // 根据百度地标搜索，根据标签搜索
          ec: '',
          // 类型
          type: '',
          // 专题活动id
          tc_id: ''
        }
        getAjaxHotelList(args).then(function (res) {
          if (loading) {
            loading.close()
          }
          that.allData = res
          that.listData = res.web_data.result
          that.page_resource = res.web_data.index_url
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      // 异步查询酒店列表
      searchHotelAction () {
        let postData = {
          start: this.startDate,
          end: this.endDate,
          keyword: this.searchInputVal
        }
        getAjaxHotelList(postData).then((res) => {
          this.asycSearchData = res.web_data.result
          this.checkSearchNull()
        }).catch((e) => {
          this.asycSearchData.length = 0
        })
        if (this.searchInputVal) {
          this.showDeleteIcon = true
        } else {
          this.showDeleteIcon = false
        }
        this.baiduCheck()
      },
      toBaiduSearch (lat, lng, title) {
        // JSON.parse 将json字符串转为JSON对象
        let saveData = {
          city: this.firstCity,
          startdate: this.handleStartDate,
          enddate: this.handleEndDate,
          link: this.toLinks.SRESULT,
          lat: lat,
          lng: lng,
          title: title
        }
        if (window.localStorage.searchcache) {
          this.localSearchData = JSON.parse(window.localStorage.searchcache)
        }
        if (this.localSearchData.length >= 2) {
          this.localSearchData.splice(0, 1)
        }
        this.localSearchData.push(saveData)
        window.localStorage['searchcache'] = JSON.stringify(this.localSearchData)
        window.location.href = this.toLinks.SRESULT + '&lat=' + lat + '&lng=' + lng + '&title' + title
      },
      checkSearchNull () {
        if (this.baiduApiData.length === 0 && this.asycSearchData.length === 0) {
          this.searchResult = false
          this.hasNoResult = true
        } else {
          this.searchResult = true
          this.hasNoResult = false
        }
      },
      // 百度查询
      baiduCheck () {
        // 使用百度地图进行模糊查询
        const BMap = window.BMap
        let myGeo = new BMap.Geocoder()
        // 如果不传首选城市(值为全部) 则默认为北京
        this.searchedCity = this.firstCity === '全部' ? this.defaultCity : this.firstCity
        let keyword = this.searchInputVal
        myGeo.getPoint(this.searchedCity, (point) => {
          //  获取指定城市的经纬度
          if (point) {
            let local = new BMap.LocalSearch(point, {
              onSearchComplete: (results) => {
                this.baiduApiData = results.vr
                this.checkSearchNull()
              }
            })
            // 查询完成 => onSearchComplete
            local.search(keyword, {forceLocal: true})
          } else {
            this.baiduApiData.length = 0
          }
        }, this.searchedCity)
      },
      changeTab ($event, tabType) {
        let searchbaritem = document.querySelectorAll('.search_bar .search_bar_item')
        this.removeClass(searchbaritem, 'active')
        if (!this.hasClass($event.currentTarget, 'active')) $event.currentTarget.className += ' active'
        let _this = this
        if (tabType === 'price') {
          if (!_this.priceUp && !_this.priceDown) {
            _this.priceUp = true
            tabType = 'price_up'
          } else if (!_this.priceUp) {
            _this.priceUp = true
            _this.priceDown = false
            tabType = 'price_up'
          } else {
            _this.priceDown = true
            _this.priceUp = false
            tabType = 'price_down'
          }
        } else {
          _this.priceDown = false
          _this.priceUp = false
        }
        _this.filterType = tabType
        _this.loadPackages()
      },
      handleDateClick (result) {
        let _self = this
        _self.startDate = _self.changeMonth(result[0])
        _self.endDate = _self.changeMonth(result[1])
        _self.startString = result[0]
        _self.endString = result[1]
        _self.startMonth = _self.changeMonth(result[0])
        _self.endMonth = _self.changeMonth(result[1])
        setTimeout(function () {
          _self.showCalendar = false
          _self.loadPackages()
        }, 500)
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
      showSearchEvt () {
        let _this = this
        _this.showList = false
        const cb = () => {
          _this.showList = true
        }
        showFullLayer(null, '搜索', location.href, cb)
      },
      toLocationHref (href) {
        window.location.href = href + '&startdate=' + this.startString + '&enddate=' + this.endString + '&'
      },
      // input离焦事件
      searchPlace () {
        let _this = this
        _this.showDeleteIcon = false
//      console.log(_self.searchInputVal)
        let args = {
          q: _this.searchInputVal,
          region: '北京',
          output: 'json',
          ak: 'ggmZIrqw5hOjnXwT7ypK0aIoZXrn4yfS'
        }
        getBaiduSearchPlaceList(args).then(function (res) {
          console.log(res)
        }).catch(function (e) {
          console.log(e)
        })
      },
      // 输入事件
      inputSearch () {
        if (this.searchInputVal) {
          this.showDeleteIcon = true
          if (this.baiduApiData.results.length !== 0) {
            this.searchResult = false
            this.hasNoResult = true
          } else {
            this.searchResult = true
            this.hasNoResult = false
          }
        } else {
          this.showDeleteIcon = false
        }
      },
      clearInput () {
        this.searchInputVal = ''
        this.hasNoResult = false
      },
      hasClass (obj, cls) {
        return obj.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'))
      },
      removeClass (obj, cls) {
        for (var i = 0; i < obj.length; i++) {
          if (this.hasClass(obj[i], cls)) {
            var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)')
            obj[i].className = obj[i].className.replace(reg, '')
          }
        }
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
      }
    }
  }
</script>
