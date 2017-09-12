<template>
  <div class="jfk-pages jfk-pages__cityChoose">
    <!-- <div class="jfk-pages__theme"></div> -->
    <p class="float_word font-size--22" v-show="searchCityList">
        <span v-for="(item, index) in allCitys" :key="index">
          <a @click.stop.prevent="href(index)">{{index}}</a><br/>
        </span>
    </p>
    <!--<p class="color-golden" v-show="isLoadProduct">loading</p>-->
    <!--<JfkSupport v-once></JfkSupport>-->
    <div class="search_city font-size--38 jfk-pl-30 jfk-pr-30" v-show="showInput">
      <form @submit.prevent="searchHotelAction()">
        <!--v-on:input="searchHotelAction"-->
        <input type="text"
               placeholder="关键字 / 位置 / 名称"
               class="font-size--38"
               autocomplete="off"
               v-model="searchInputVal"
               id="searchVal">
        <i class="booking_icon_font font-size--24 icon-icon_search"></i>
      </form>
      <i class="jfk-font jfk-button__text-item icon-icon_close icon-icon_delete"
         v-show="showDeleteIcon"
         @click="clearInput">
      </i>
    </div>
    <!-- 附近搜索 -->
    <div class="search_city font-size--32 jfk-pl-30 jfk-pr-30" v-show="searchStatus"
         @click="HrefToNearby()">
        <span class="no_far">
          <i class="booking_icon_font font-size--34 icon-booking_icon_businessdistrict_norma"></i>附近</span>
        <span class="font-size--24 color">
          &nbsp;&nbsp;&nbsp;附近有什么，去看看
        </span>
    </div>
    <!-- 历史搜索 -->
    <!--<div class="history_search font-size&#45;&#45;30 jfk-pl-30 jfk-pr-30" v-show="searchStatus">-->
    <!--<p class="history_search_title font-size&#45;&#45;24 grayColor">-->
    <!--历史搜索-->
    <!--</p>-->
    <!--<span v-for="(item, index) in lastorderData"-->
    <!--:key="index">-->
    <!--<a :href="item.link">-->
    <!--{{item.hname}}-->
    <!--</a>-->
    <!--</span>-->
    <!--</div>-->
    <!-- 热门搜索结果 -->
    <div class="history_search font-size--30 jfk-pl-30 jfk-pr-30" v-show="searchCityList">
      <p class="history_search_title font-size--24 grayColor">
        热门搜索
      </p>
      <span class="hot_item" v-for="(item, index) in hotCitys" :key="index"
            @click="toLocationHref(toLinks.SRESULT+'&keyword='+item + '&startdate=' + handleStartDate + '&enddate=' + handleEndDate + '&city=' + item)">{{item}}</span>
    </div>
    <!--所有城市-->
    <div class="all_city font-size--28 jfk-pl-30 jfk-pr-30" v-show="searchCityList">
      <div class="all_city_item"
           v-for="(item,value) in allCitys">
        <p class="all_city_item_word" :id="value">{{value}}</p>
        <ul v-for="(item1, index1) in item"
            :key="index1">
          <li @click="getChooseCityVal(0, item1.city)" v-if="!item1.area">{{item1.city}}</li>
          <li @click="getChooseCityVal(item1.area, item1.city)" v-if="item1.area">{{item1.area}} ({{item1.city}})</li>
        </ul>
      </div>
    </div>
    <!-- 异步获取酒店列表 -->
    <div class="search_city_list jfk-pl-30 jfk-pr-30" v-show="searchResult">
      <div v-for="(item, index) in asycSearchData" :key="index" class="search_city_list_item">
        <p>
          <i class="booking_icon_font font-size--24 icon-booking_icon_businessdistrict_norma grayColor"></i>
          <span v-html="item.name.replace(searchInputVal, highLightKeyword)"></span>
        </p>
      </div>
    </div>
    <!-- 百度模糊搜索 -->
    <div class="search_city_list jfk-pl-30 jfk-pr-30" v-show="searchResult">
      <div class="baidu-search">搜索到以下地标</div>
      <div v-for="item in baiduApiData" class="search_city_list_item"
           @click="toBaiduSearch(item.point.lat,item.point.lng,item.title)">
        <p>
          <i class="booking_icon_font font-size--24 icon-booking_icon_businessdistrict_norma grayColor"></i>
          <span v-html="item.title.replace(searchInputVal, highLightKeyword)"></span>
        </p>
      </div>
    </div>
    <!-- 无搜索结果 -->
    <div class="nosearch_container" v-show="hasNoResult">
      <div class="no_search">
        <div class="no_seach_result font-size--24 grayColor">
          <i class="booking_icon_font icon-icon_search font-size--52 icon_noresult_search"></i><br/>
          没有搜索到相关结果~ <br/>
          换个条件试试
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import {getSearchHotelList} from '@/service/http'
  export default {
    name: 'cityChoose',
    created () {
    },
    data () {
      return {
        // 模拟id，后期由后台加上
        id: '',
        openid: '',
        // 总状态
        searchStatus: true,
        // 无结果
        hasNoResult: false,
        // 显示热门搜索
        showHotSearch: true,
        // 附近搜索
        showNearSearch: true,
        // 历史搜索
        lastorderData: null,
        hotSearch: true,
        searchResult: false,
        defaultCity: '北京',
        // 所有数据
        allData: null,
        asycSearchData: [],
        // input 删除按钮
        showDeleteIcon: false,
        searchInputVal: '',
        page_resource: {
          'SRESULT': 'nearby?theme=1&id=a429262687'
        },
        // 百度地图搜索data
        baiduApiData: {},
        localSearchData: [],
        // 最终在调用百度接口的城市
        searchedCity: '',
        // 城市列表显示状态
        searchCityList: false,
        showInput: false,
        keyword: '',
        highLightKeyword: ''
      }
    },
    watch: {
      clicktype () {
        if (this.clicktype === 0) {
          this.searchStatus = true
          this.searchCityList = false
          this.showInput = true
        } else {
          this.searchStatus = false
          this.showInput = false
          this.searchCityList = true
        }
      }
    },
    methods: {
      // 异步查询酒店列表
      searchHotelAction () {
        if (!this.searchInputVal) return
        this.currentCity === '全部' ? this.currentCity = '' : this.currentCity
        let postData = {
          keyword: this.searchInputVal,
          city: this.currentCity
        }
        getSearchHotelList(postData).then((res) => {
          this.asycSearchData = res.web_data.result
          this.highLightKeyword = '<span style="color:#b2945e">' + this.searchInputVal + '</span>'
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
        window.location.href = this.toLinks.SRESULT + '&lat=' + lat + '&lng=' + lng + '&title=' + title + '&city=' + this.currentCity + '&keyword=' + this.searchInputVal
      },
      clearInput () {
        this.searchInputVal = ''
        this.searchStatus = true
        this.searchResult = false
        this.hasNoResult = false
        this.showDeleteIcon = false
      },
      // 百度查询
      baiduCheck () {
        // 使用百度地图进行模糊查询
        const BMap = window.BMap
        let myGeo = new BMap.Geocoder()
        // 如果不传首选城市(值为全部) 则默认为北京
        // this.searchedCity = this.firstCity === '全部' ? this.defaultCity : this.firstCity
        this.searchedCity = this.currentCity === '' ? this.defaultCity : this.currentCity
        let keyword = this.searchInputVal
        this.highLightKeyword = '<span style="color:#b2945e">' + this.searchInputVal + '</span>'
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
      checkSearchNull () {
        if (this.baiduApiData.length === 0 && this.asycSearchData.length === 0) {
          this.searchStatus = false
          this.searchResult = false
          this.hasNoResult = true
        } else {
          this.searchStatus = false
          this.searchResult = true
          this.hasNoResult = false
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
      href (index) {
        let height = document.getElementById(index).offsetTop
        window.scrollTo(0, height)
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
    },
    mounted () {

    },
    props: {
      handleStartDate: String,
      handleEndDate: String,
      hotCitys: Array,
      allCitys: Object,
      getChooseCityVal: Function,
      toLocationHref: Function,
      HrefToNearby: Function,
      toLinks: Object,
      firstCity: String,
      // 用来判断是选择城市还是搜索
      clicktype: Number,
      // 当前选择的城市名
      currentCity: String
    }
  }
</script>

