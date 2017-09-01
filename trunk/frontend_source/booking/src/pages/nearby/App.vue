<template>
  <div class="jfk-pages jfk-pages__nearby">
    <div class="jfk-pages__theme"></div>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <div class="search_bar font-size--30 grayColor80">
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
      <span class="search_bar_item">
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
    <div class="img_container">
      <div class="img_container_item" v-for="(item, index) in listData" @click="goBookingHotel()">
        <img :src="item.intro_img" alt="" class="one_img">
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
    </div>
  </div>
</template>
<script>
import {getAjaxHotelList} from '@/service/http'
export default {
  name: 'useCoupon',
  components: {
  },
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
      allData: [],
      // 列表数据
      listData: [],
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
      startString: this.getUrlParams('startDate'),
      endString: this.getUrlParams('endDate'),
      page_resource: ''
    }
  },
  methods: {
    getDate () {
      let month = this.getUrlParams('startDate').substr(5, 2)
      this.startMonth = this.getUrlParams('startDate').substr(5, 2)
      this.endMonth = this.getUrlParams('endDate').substr(5, 2)
      this.startDate = this.startMonth + '/' + this.getUrlParams('startDate').substr(8, 2)
      this.endDate = this.endMonth + '/' + this.getUrlParams('endDate').substr(8, 2)
      console.log(month)
    },
    loadPackages (resetProducts) {
      let that = this
      let loading
      loading = this.$jfkToast({
        iconClass: 'jfk-loading__snake ',
        duration: -1,
        isLoading: true
      })
      let args = {
        id: that.getUrlParams('id'),
        openid: that.getUrlParams('openid'),
        // 纬度
        lat: 23.117,
        // 经度
        lnt: 113.275,
        // 开始日期
        start: that.startString,
        // 结束日期
        end: that.endString,
        // 城市
        city: '广州',
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
        console.log(res)
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
    changeTab ($event, tabType) {
      let searchbaritem = document.querySelectorAll('.search_bar .search_bar_item')
      this.removeClass(searchbaritem, 'active')
      if (!this.hasClass($event.currentTarget, 'active')) $event.currentTarget.className += ' active'
      let _self = this
      if (tabType === 'price') {
        if (!_self.priceUp && !_self.priceDown) {
          _self.priceUp = true
          tabType = 'price_up'
        } else if (!_self.priceUp) {
          _self.priceUp = true
          _self.priceDown = false
          tabType = 'price_up'
        } else {
          _self.priceDown = true
          _self.priceUp = false
          tabType = 'price_down'
        }
      } else {
        _self.priceDown = false
        _self.priceUp = false
      }
      _self.filterType = tabType
      _self.loadPackages()
    },
    handleDateClick (result) {
      let _self = this
      console.log(result)
      _self.startDate = _self.changeMonth(result[0])
      _self.endDate = _self.changeMonth(result[1])
      _self.startString = result[0]
      _self.endString = result[1]
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
    goBookingHotel () {
      if (process.env.NODE_ENV === 'development') {
        window.location.href = this.page_resource + '&theme=1&startDate=' + this.startString + '/' + '&endDate=' + this.endString
      } else {
        window.location.href = 'http://ihotels.iwide.cn/index.php/hotel/hotel/search??theme=1&id=a429262687&startDate=2017/09/31&endDate=2017/09/32'
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
