<template>
  <div class="jfk-pages jfk-pages__productChoose">
    <div class="jfk-pages__theme"></div>
    <!--  <good-list class="jfk-tab__body-item" :products="products" :detailUrlPrefix="detailUrlPrefix" :layout="layout" v-infinite-scroll="loadMore" infinite-scroll-disabled="disableLoadProduct" infinite-scroll-distance="60"></good-list> -->
    <div class="choose_prt_top">
      <p class="choose_prt_top_item1 font-size--32">
        请勾选你需要的商品
      </p>
      <p class="choose_prt_top_item2 font-size--24">
        组合已选房型 <span class="other_room">高级大床房</span> 购买更优惠
      </p>
    </div>
    <div class="products-layout jfk-tab__body-item products-layout--card" infinite-scroll-disabled="disableLoadProduct"
         infinite-scroll-distance="60">
      <div class="products-layout__body">
        <ul class="jfk-pl-30 jfk-pr-30">
          <li class="mt30" v-for="(item, index) in packages" :key="index">
            <div class="products-list__item">
              <div class="product-box">
                <div class="product-image">
                  <div class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image"
                       lazy="loaded"
                       :style="{'background-image' : 'url('+ item.room_info.room_img + ')'}">
                  </div>
                </div>
                <div class="product-info">
                  <label class="check main_color1">
                    <input type="checkbox"
                           check="false"
                           class="room_check"
                           @click="addRoom($event, item.package_info.items, index)">
                    <em></em>
                  </label>
                  <div class="product-info-cont">
                    <h3 class="product-title font-size--32 font-color-dark-white">{{item.show_price_name}}</h3>
                    <div class="product-price">
                      <span class="jfk-price product-price-package color-golden font-size--54">
                      <i class="jfk-font-number jfk-price__currency">￥</i>
                      <i class="jfk-font-number jfk-price__number">{{item.room_info.oprice}}</i>
                      </span>
                      <span
                        class="jfk-price__original product-price-market font-size--24 font-color-light-gray is-integral">¥{{item.room_info.price}}</span>
                    </div>
                    <div class="show_detail_btn font-size--24">
                      <span @click="setDetailStatus(index)">
                        详情
                        <span class="icon_show">
                          <i class="booking_icon_font icon-booking_icon_right_normal font-size--24">
                          </i>
                        </span>
                      </span>
                    </div>
                    <div class="count jfk-d-ib font-size--32 set_num">
                      <jfk-input-number v-model="item.countNum" :min="minNum" :max="maxNum"></jfk-input-number>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="bottom_info_del font-size--24" v-if="item.product_show_status">
              <p class="title font-size--28" v-for="(value, key) in item.package_info.items" :key="index">
                {{value.short_intro}}</p>
              <!--<p class="del_item">迪士尼一日三餐晚餐迪士尼一 </p>-->
            </div>
          </li>
        </ul>
      </div>
    </div>
    <footer class="font-size--24">
      <span class="money">¥<span class="font-size--48">{{allPrice}}</span></span>
      选好了
      <span class="click_pay">
        <i class="booking_icon_font icon-booking_icon_rightarrow_normal"></i>
      </span>
    </footer>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import { getUrlParams, logJSON } from '@/utils/geturl'
  // const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  // let params = formatUrlParams.default(location.href)
  export default {
    name: 'productChoose',
    components: {},
    created () {
      // this.getData()
      // console.log(typeof this.alldata)
      if (this.alldata) {
        this.getData()
      }
    },
    beforeCreate () {
    },
    data () {
      return {
        minNum: 0,
        maxNum: 9,
//      countNum: 0,
        packages: [],
        allPrice: 0,
        sendData: []
//      product_show_status: false
      }
    },
    watch: {
      alldata (val) {
        // console.log(val)
      }
    },
    props: {
      alldata: {
        type: Object,
        default: function () {
          return {}
        }
      }
    },
    methods: {
      getData () {
        const content = this.alldata
        this.packages = content['packages']
        // console.log(111)
        for (let i = 0; i < this.alldata.packages.length; i++) {
          this.alldata.packages[i].product_show_status = false
          this.alldata.packages[i].countNum = 0
        }
//      nums datas protrol_code(商务协议码) more_room（接口RETURN_MORE_ROOM） package_info（是否是数组） select_package csrf_token
        this.packages = this.alldata.packages
        this.sendData.hotel_id = this.packages[0].room_info.hotel_id
        this.sendData.price_codes = this.packages[0].state_info.price_code
        this.sendData.price_type = this.packages[0].state_info.price_type
        this.sendData.startdate = getUrlParams('startDate')
        this.sendData.enddate = getUrlParams('endDate')
        this.sendData.select_package = []
//      不确定
        this.sendData.nums = this.packages[0].package_info.items[8]
        logJSON(this.sendData)
      },
      setDetailStatus (index) {
        console.log(index)
        // this.$set(this.packages[index], 'product_show_status', true)
        // console.log()
        this.packages[index]['product_show_status'] = !this.packages[index]['product_show_status']
        // console.log(this.packages)
//      this.packages[index] = Object.assign({}, this.packages[index], {product_show_status: true})
//      this.packages.$set(index, 'product_show_status', true)
      },
      addRoom ($event, item, index) {
        if ($event.currentTarget.checked) {
          for (let key in item) {
            console.log(item[key])
            item[key].indexVal = index
            this.sendData.select_package.push(item[key])
          }
        } else {
          for (let i = 0; i < this.sendData.select_package.length; i++) {
            if (index === this.sendData.select_package[i].indexVal) {
              this.sendData.select_package.splice(i, 1)
            }
          }
        }
        logJSON(this.sendData)
      }
    }
  }
</script>
