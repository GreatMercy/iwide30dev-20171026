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
      <span class="search_bar_item" @click="changeTab($event,'star')">
        <span class="type">评价</span>
      </span>  
      <span class="search_bar_item" @click="changeTab($event,'distance')">
        <span class="type">距离</span>
      </span>
      <span class="search_bar_item">
        <span class="type">筛选</span>
        <i class="booking_icon_font icon-booking_icon_dropdown_normal arrow_icon"></i>
      </span>
      <span class="search_bar_item dateContainer font-size--28">
        <span class="type3">
          <span class="grayColorbf">入住</span> 03/14<br><span class="grayColorbf">离店</span> 03/15
        </span>
        <i class="booking_icon_font icon-booking_icon_dropdown_normal arrow_icon"></i>
      </span>
    </div>
    <div class="img_container">
      <div class="img_container_item" v-for="(item, index) in listData">
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
  </div>
</template>
<script>
import { getAjaxHotelList } from '@/service/http'
// import { wxApiCall } from '@/utils/wx'
export default {
  name: 'useCoupon',
  components: {
  },
  beforeCreate () {
  },
  created () {
//    加载swiper
    this.loadPackages()
    // this.getlat()
  },
  data () {
    return {
      // 模拟id，后期由后台加上
      id: 'a429262687',
      openid: 'oX3WojhfNUD4JzmlwTzuKba1MywY',
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
      filterType: 'distance'
    }
  },
  methods: {
    loadPackages (resetProducts) {
      let that = this
      let args = {
        id: that.id,
        openid: that.openid,
        // 纬度
        lat: 23.117,
        // 经度
        lnt: 113.275,
        // 开始日期
        start: '',
        // 结束日期
        end: '',
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
      if (that.fcid > 0) {
        args.fcid = that.fcid
      }
      that.isLoadProduct = true
      getAjaxHotelList(args).then(function (res) {
        console.log(res)
        that.allData = res
        that.listData = res.web_data.result
      }).catch(function (e) {
        that.isLoadProduct = false
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
    }
    // getlat () {
      // wxApiCall()
    // }
  }
}
</script>
