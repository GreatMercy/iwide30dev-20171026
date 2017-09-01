<template>
  <div class="jfk-pages jfk-pages__cityChoose">
    <!-- <div class="jfk-pages__theme"></div> -->
      <p class="float_word font-size--22">
        <span v-for="(item, index) in citys" :key="index">
          {{index}} <br/>
        </span>
      </p>
      <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
      <!--<JfkSupport v-once></JfkSupport>-->
      <div class="search_city font-size--38 jfk-pl-30 jfk-pr-30">
        <input type="text" placeholder="搜索城市/关键字/位置" class="font-size--38" :blur="searchPlace" v-model="searchInputVal" :input="inputSearch" id="searchVal">
        <i class="booking_icon_font font-size--24 icon-icon_search"></i>
        <i class="jfk-font jfk-button__text-item icon-icon_close icon-icon_delete" v-show="showDeleteIcon" @click="clearInput"></i>
      </div>
      <!-- 热门搜索 -->
      <div class="search_city font-size--32 jfk-pl-30 jfk-pr-30" v-show="showHotSearch" @click='hrefTosresult()'>
        <span class="no_far">
          <i class="booking_icon_font font-size--34 icon-booking_icon_businessdistrict_norma"></i>附近</span>
        <span class="font-size--24 color">
          &nbsp;&nbsp;&nbsp;附近有什么，去看看
        </span>
      </div>
      <!-- 历史搜索 -->
      <div class="history_search font-size--30 jfk-pl-30 jfk-pr-30">
        <p class="history_search_title font-size--24 grayColor">
          历史搜索
        </p>
        <span v-for="(item, index) in lastorderData">{{item.hname}}</span>
      </div>
      <!-- 热门搜索 -->
      <div class="history_search font-size--30 jfk-pl-30 jfk-pr-30">
        <p class="history_search_title font-size--24 grayColor">
          热门搜索
        </p>
        <span v-for="(item, index) in hotCityData">{{item}}</span>
      </div>
      <!-- 可滑动的热门搜索 暂时屏蔽 -->
<!--       <div class="hot_search jfk-pl-30 jfk-pr-30" v-show="showHotSearch">
        <p class="hot_search_title font-size--24 grayColor">热门搜索</p>
        <div class="recommendations-list">
          <city-swiper :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></city-swiper>
        </div>
      </div> -->
      <div class="all_city font-size--28 jfk-pl-30 jfk-pr-30" v-show="showHotSearch">
        <div class="all_city_item" v-for="(item, index) in citys" :key="index">
          <p class="all_city_item_word">{{index}}</p>
          <ul v-for="(item, index) in citys[index]">
            <li>{{item.city}}</li>
          </ul>
        </div>
      </div>
      <!-- 搜索的城市list -->
      <div class="search_city_list jfk-pl-30 jfk-pr-30" v-show="true">
        <div class="search_city_list_item">
          <p>
            <i class="booking_icon_font font-size--24 icon-booking_icon_businessdistrict_norma grayColor"></i>
            七天<span class="goldColor">广州火车店</span>
          </p>
        </div>
      </div>
      <!-- 无搜索结果 -->
      <div class="nosearch_container" v-show="false">
        <div class="no_search">
          <div class="no_seach_result font-size--24 grayColor">
            <i class="booking_icon_font icon-icon_search font-size--52 icon_noresult_search"></i><br />
            没有搜索到相关结果~ <br />
            换个条件试试
          </div>
        </div>
        <div class="for_you jfk-pl-30 jfk-pr-30">
          <p class="for_you_title font-size--24">
            为您推荐
          </p>
          <div class="for_you_list_item font-size--32">
          <p>
            <i class="booking_icon_font icon-booking_icon_hotel_normal grayColor"></i>
            七天<span class="goldColor">广州火车店</span>
          </p>
          <p>
            <i class="booking_icon_font icon-booking_icon_hotel_normal grayColor"></i>
            七天<span class="goldColor">广州火车店</span>
          </p>
          <p>
            <i class="booking_icon_font icon-booking_icon_hotel_normal grayColor"></i>
            七天<span class="goldColor">广州火车店</span>
          </p>
        </div>
        </div>
    </div>
    </div>
</template>
<script>
import { getBannerList, getBaiduSearchPlaceList } from '@/service/http'
// import citySwiper from './module/cityswiper/src/main.vue'
export default {
  name: 'cityChoose',
  components: {
    // citySwiper
  },
  beforeCreate () {
  },
  created () {
    this.loadPackages()
  },
  data () {
    return {
      // 模拟id，后期由后台加上
      id: '',
      openid: '',
      // 显示热门搜索
      showHotSearch: true,
      // 历史搜索
      lastorderData: [],
      // 所有数据
      allData: [],
      // 历史搜索
      hotCityData: [],
      // 所有城市
      citys: [],
      // input 删除按钮
      showDeleteIcon: false,
      searchInputVal: '',
      page_resource: {
        'SRESULT': 'nearby?theme=1&id=a429262687'
      }
    }
  },
  methods: {
    loadPackages () {
      let that = this
      let loading
      loading = this.$jfkToast({
        iconClass: 'jfk-loading__snake ',
        duration: -1,
        isLoading: true
      })
      let args = {
        id: that.getUrlParams('id'),
        openid: that.getUrlParams('openid')
      }
      that.isLoadProduct = true
      getBannerList(args).then(function (res) {
        if (loading) {
          loading.close()
        }
        that.allData = res
        that.hotCityData = res.web_data.hot_city
        that.lastorderData = res.web_data.last_orders
        that.citys = res.web_data.citys
        if (process.env.NODE_ENV !== 'development') {
          that.page_resource = res.web_data.page_resource.links
        }
        that.logJSON(res)
        console.log(res.web_data.citys)
      }).catch(function (e) {
        if (loading) {
          loading.close()
        }
        console.log(e)
      })
    },
    // 跳转到附近酒店
    hrefTosresult () {
      window.location.href = this.page_resource.SRESULT + '&startDate=' + this.handleStartDate + '&endDate=' + this.handleEndDate
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
    },
    // input输入事件
    searchPlace () {
      let _self = this
      _self.showDeleteIcon = false
      console.log(_self.searchInputVal)
      let args = {
        q: _self.searchInputVal,
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
    inputSearch () {
      var _self = this
      if (_self.searchInputVal) {
        _self.showDeleteIcon = true
      } else {
        _self.showDeleteIcon = false
      }
    },
    clearInput () {
      var _self = this
      _self.searchInputVal = ''
    },
    sthnerveruse () {
        // detailUrl: '',
        // indexUrl: '',
        // recommendations: [],
        // let that = this
        // 推荐商品无分页，page_size设置大一些，一页全部请求完毕
        // getPackageRecommendation({
        //   page: 1,
        //   page_size: 100
        // }).then(function (res) {
        //   const { products, page_resource } = res.web_data
        //   that.recommendations = products
        //   let { detail, home } = page_resource.link
        //   if (process.env.NODE_ENV === 'development') {
        //     detail = '/detail?pid='
        //     home = '/'
        //   }
        //   that.detailUrl = detail
        //   that.indexUrl = home
        // }) // let that = this
       // 推荐商品无分页，page_size设置大一些，一页全部请求完毕
        // getPackageRecommendation({
        //   page: 1,
        //   page_size: 100
        // }).then(function (res) {
        //   const { products, page_resource } = res.web_data
        //   that.recommendations = products
        //   let { detail, home } = page_resource.link
        //   if (process.env.NODE_ENV === 'development') {
        //     detail = '/detail?pid='
        //     home = '/'
        //   }
        //   that.detailUrl = detail
        //   that.indexUrl = home
        // })
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
  },
  props: {
    handleStartDate: String,
    handleEndDate: String
  }
}
</script>
