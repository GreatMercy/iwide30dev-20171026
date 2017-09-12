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
      <span class="search_bar_item"
            @click="changeTab($event,'distance')" :class="filterType === 'distance' ? 'active' : ''">
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
          <span v-html="item.name.replace(keyword, highLightKeyword)"></span>
        </p>
        <p class="address font-size--24 grayColor80">
          <span class="distance" v-if="item.distance">
            距离
            <span v-html="allData.web_data.landmark.replace(searchInputVal, replaceWord)"></span>
            {{item.distance}}公里
          </span>
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
        <jfk-calendar ref="jfkCalendar"
                      class="font-size--28"
                      format="yyyy/MM/dd"
                      @date-pick="handleDateClick"
                      :minDate="min"
                      :maxDate="max"
                      :range="true"
                      :value="[new Date(startString), new Date(endString)]">
        </jfk-calendar>
      </div>
    </div>
    <div class="filter" v-show="filterContainerStatus">
      <div class="nosearch_container" v-show="!showList">
        <div class="search_city font-size--38 jfk-pl-30 jfk-pr-30">
          <form @submit.prevent="searchHotelAction()">
          <!--v-on:input="searchHotelAction"-->
          <input type="text"
                 class="font-size--38"
                 placeholder="城市/关键字/位置"
                 v-model="searchInputVal"
                 id="searchVal"
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
            <a :href="item.link" class="grayColor80">
              <i class="booking_icon_font font-size--24 icon-booking_icon_hotel_normal grayColor80"></i>
              <span v-html="item.name.replace(searchInputVal, replaceWord)"></span>
            </a>
          </p>
        </div>
      </div>
      <!-- 百度搜索的列表 -->
      <div class="search_city_list jfk-pl-30 jfk-pr-30" v-show="searchResult">
        <div class="baidu-search">搜索到以下地标</div>
        <div class="search_city_list_item"
             v-for="(item, index) in baiduApiData"
             :key="index"
             @click="checkBaiLai(item)">
          <p>
            <i class="booking_icon_font font-size--24 icon-booking_icon_hotel_normal grayColor80"></i>
            <span v-html="item.title.replace(searchInputVal, replaceWord)"></span>
          </p>
        </div>
      </div>
    </div>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import {getAjaxHotelList, getSearchHotelList} from '@/service/http'
  import {showFullLayer} from '@/utils/utils'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  let params = formatUrlParams(location.search)
  export default {
    name: 'useCoupon',
    components: {},
    beforeCreate () {
    },
    created () {
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
        filterType: '',
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
        startString: '',
        endString: '',
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
        localSearchData: '',
        replaceWord: '',
//        lat: window.localStorage.getItem('latitude') || 23.117,
//        lnt: window.localStorage.getItem('longitude') || 113.275
        lat: '',
        lnt: '',
        ec: {},
        keyword: '',
        highLightKeyword: '',
        city: '',
        area: '',
        tc_id: '',
        filterContainerStatus: false
      }
    },
    methods: {
      getDate () {
        // 对 url 上的日期参数的预处理
        let _this = this
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
        _this.startDate = _this.startString.substr(5, 10)
        _this.endDate = _this.endString.substr(5, 10)
        // 对不同页面过来的 url 参数进行预处理
        _this.dealWithUrlData()
      },
      dealWithUrlData () {
        if (params.nearby === '1') {
          if (window.wx) {
            window.wx.getLocation({
              type: 'wgs84',
              // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
              success: (res) => {
                // 纬度
                this.lat = res.latitude || ''
                // 经度
                this.lnt = res.longitude || ''
                this.filterType = 'distance'
              }
            })
          } else {
            // 纬度
            this.lat = ''
            // 经度
            this.lnt = ''
            this.filterType = ''
          }
        } else {
          this.lat = params.lat || ''
          this.lnt = params.lng || ''
        }
        // 百度搜索过来
        if (params.title) {
          this.ec['bdmap'] = this.lat + ',' + this.lnt + ',' + params.title
        }
        // 百度搜索关键词高亮
        if (params.keyword) {
          this.keyword = params.keyword
          this.highLightKeyword = '<span style="color:#b2945e">' + params.keyword + '</span>'
        }
        params.city === '全部' ? params.city = '' : params.city
        params.area === '全部' ? params.area = '' : params.area
        this.city = params.city
        this.area = params.area
        params.tc_id ? this.tc_id = params.tc_id : ''
        // 加载数据
        this.loadPackages()
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
          id: params.id,
          openid: params.openid,
          // 纬度
          lat: that.lat,
          // 经度
          lnt: that.lnt,
          // 开始日期
          start: that.startString,
          // 结束日期
          end: that.endString,
          // 城市
          city: that.city || '',
          // 县
          area: that.area || '',
          // 关键字
          keyword: that.keyword,
          // 开始位置
          off: 0,
          // 排序类型
          sort_type: that.filterType,
          // 每次返回数量
          num: 20,
          // 根据百度地标搜索，根据标签搜索
          ec: that.ec || {},
          // 类型
          type: '',
          // 专题活动id
          tc_id: that.tc_id || ''
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
          city: this.city,
          tc_id: this.tc_id,
          keyword: this.searchInputVal
        }
        getSearchHotelList(postData).then((res) => {
          this.asycSearchData = res.web_data.result
          this.replaceWord = '<span style="color: #b2945e">' + this.searchInputVal + '</span>'
          for (let i = 0; i < res.web_data.result.length; i++) {
            res.web_data.result[i].link = res.web_data.result[i].link + '&startdate=' + this.startString + '&enddate=' + this.endString + '&'
          }
          this.checkSearchNull()
        }).catch((e) => {
          this.asycSearchData.length = 0
        })
        if (this.searchInputVal) {
          this.showDeleteIcon = true
          this.baiduCheck()
        } else {
          this.showDeleteIcon = false
        }
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
      // input 是否为空
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
        let _this = this
        // 如果不传首选城市(值为全部) 则默认为北京
//        this.searchedCity = this.firstCity === '全部' ? this.defaultCity : this.firstCity
        _this.searchedCity = _this.city === '' ? _this.defaultCity : _this.city
        let keyword = this.searchInputVal
        myGeo.getPoint(_this.searchedCity, (point) => {
          console.log(point)
          //  获取指定城市的经纬度
          if (point) {
            let local = new BMap.LocalSearch(point, {
              onSearchComplete: (results) => {
                console.log(results)
                if (results.vr) {
                  _this.baiduApiData = results.vr
                }
                _this.checkSearchNull()
              }
            })
            // 查询完成 => onSearchComplete
            local.search(keyword, {forceLocal: true})
          } else {
            _this.baiduApiData = []
          }
        }, _this.searchedCity)
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
        const cb = () => {
          _self.showCalendar = false
        }
        // 调用日期插件
        showFullLayer(null, '选择日期', location.href, cb)
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
      showSearchEvt () {
        let _this = this
        _this.showList = false
        _this.filterContainerStatus = true
        const cb = () => {
          _this.showList = true
          _this.filterContainerStatus = false
        }
        showFullLayer(null, '搜索', location.href, cb)
      },
      toLocationHref (href) {
        window.location.href = href + '&startdate=' + this.startString + '&enddate=' + this.endString + '&'
      },
      clearInput () {
        this.searchInputVal = ''
        this.hasNoResult = false
        this.showDeleteIcon = false
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
      // 百度地图的搜索
      checkBaiLai (item) {
        console.log(item)
        this.lat = item.point.lat
        this.lnt = item.point.lng
        this.searchResult = false
        // 从百度地图api的地标搜索结果里进入，需将日期、所选城市(city)、城镇(area)、地标的经纬度、extra_condition(ec)传入，
        // ec参数为json，格式如{"bdmap":"39.90841,116.479538,飘HOME连锁酒店(国贸东店)"}，
        // 通过百度地标搜索时键名为bdmap，键值格式为“经度,纬度,地标名”，
        // 且在搜索结果中显示距离地标多少距离，返回结果里的酒店数据里有distance，即酒店与该地标距离，landmark，即该地标名称，输入的关键字需高亮
        // let href = this.allData.web_data.index_url + '&nearby=1&lat=' + item.point.lat + '&lng=' +item.point.lng + '&title=' + item.title + '&keyword=' +this.searchInputVal
        // window.location.href = href
        this.lat = item.point.lat
        this.lnt = item.point.lng
        this.ec['bdmap'] = this.lat + ',' + this.lnt + ',' + item.title
        this.keyword = this.searchInputVal
        // 高亮
        this.highLightKeyword = '<span style="color:#b2945e">' + this.keyword + '</span>'
        this.showList = true
        this.filterContainerStatus = false
        this.loadPackages()
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
      },
      // 获取url 参数+
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
