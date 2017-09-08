<template>
  <div class="jfk-pages jfk-pages__productChoose">
    <div v-show="!showSubmitOrder">
      <div class="jfk-pages__theme"></div>
      <!--  <good-list class="jfk-tab__body-item" :products="products" :detailUrlPrefix="detailUrlPrefix" :layout="layout" v-infinite-scroll="loadMore" infinite-scroll-disabled="disableLoadProduct" infinite-scroll-distance="60"></good-list> -->
      <div class="choose_prt_top">
        <p class="choose_prt_top_item1 font-size--32">
          请勾选你需要的商品
        </p>
        <p class="choose_prt_top_item2 font-size--24">
          组合已选房型 <span class="other_room">{{item.room_info.name}}</span> 购买更优惠
        </p>
      </div>
      <div class="products-layout jfk-tab__body-item products-layout--card" infinite-scroll-disabled="disableLoadProduct"
           infinite-scroll-distance="60">
        <div class="products-layout__body">
          <ul class="jfk-pl-30 jfk-pr-30">
            <li class="mt30" v-for="(value, key) in item.package_info.items" :key="key">
              <div class="products-list__item">
                <div class="product-box">
                  <div class="product-image">
                    <div class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image"
                         lazy="loaded"
                         :style="{'background-image' : 'url('+ value.intro_img + ')'}">
                    </div>
                  </div>
                  <div class="product-info">
                    <label class="check main_color1">
                      <input type="checkbox"
                             check="false"
                             class="room_check"
                             @click="addRoom($event, value, key)">
                      <em></em>
                    </label>
                    <div class="product-info-cont">
                      <h3 class="product-title font-size--32 font-color-dark-white">{{value.goods_name}}</h3>
                      <div class="product-price">
                      <span class="jfk-price product-price-package color-golden font-size--54">
                      <i class="jfk-font-number jfk-price__currency">￥</i>
                      <i class="jfk-font-number jfk-price__number">{{value.price}}</i>
                      </span>
                        <span
                          class="jfk-price__original product-price-market font-size--24 font-color-light-gray is-integral">¥{{value.oprice}}</span>
                      </div>
                      <div class="show_detail_btn font-size--24">
                      <span @click="setDetailStatus(key)">
                        详情
                        <span class="icon_show">
                          <i class="booking_icon_font icon-booking_icon_right_normal font-size--24">
                          </i>
                        </span>
                      </span>
                      </div>
                      <div class="count jfk-d-ib font-size--32 set_num">
                        <jfk-input-number v-model="value.countNum"
                                          :min="minNum"
                                          :max="value.nums"
                                          @click.native.prevent="handleRoom(item, key)">
                        </jfk-input-number>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--v-if="item.product_show_status"-->
              <div class="bottom_info_del font-size--24">
                <p class="title font-size--28">
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
        <span class="click_pay" @click="goSubmitOrder()">
        <i class="booking_icon_font icon-booking_icon_rightarrow_normal"></i>
      </span>
      </footer>
      <JfkSupport v-once></JfkSupport>
    </div>
    <!--提交订单-->
    <submit-order v-if="showSubmitOrder" :sendData="sendData"></submit-order>
  </div>
</template>
<script>
//  import { getUrlParams, logJSON } from '@/utils/geturl'
  import { getBookroomDetail } from '@/service/http'
  // import submitOrder from '../booking_hotel/module/order.vue'
  // const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  // let params = formatUrlParams.default(location.href)
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  let params = formatUrlParams(location.search)
  export default {
    components: {
    },
    watch: {
    },
    computed: {
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        // 通过 `vm` 访问组件实例
        vm.getData()
      })
    },
    created () {
      this.getData()
    },
    data () {
      return {
        minNum: 1,
        maxNum: 9,
        packages: null,
        sendData: {
          hotel_id: '',
          price_codes: {},
          price_type: '',
          pay_favour: '',
          room_id: '',
          startdate: '',
          enddate: '',
          datas: {},
          select_package: {}
        },
        countNum: 1,
        allPrice: 0,
        showSubmitOrder: false,
        item: {},
        alldata: {},
        // 用于发送数据
        xprice_code: {},
        datas: {},
        price_type: {},
        package_info: ''
      }
    },
    methods: {
      getData () {
        this.item = this.$store.getters.productListData
        this.alldata = this.$store.getters.bookingAllData
        for (let key in this.item.package_info.items) {
          this.item.package_info.items[key].countNum = 1
        }
//      nums datas protrol_code(商务协议码) more_room（接口RETURN_MORE_ROOM） package_info（是否是数组） select_package csrf_token
        this.packages = this.alldata.packages
        this.sendData.hotel_id = this.alldata.hotel.hotel_id
        this.sendData.price_codes = this.item.state_info.price_code
        this.sendData.price_type = this.item.state_info.price_type
        this.sendData.pay_favour = this.item.state_info.bookpolicy_condition.wxpay_favour
        this.sendData.room_id = this.item.room_info.room_id
        this.sendData.startdate = this.item.startDate
        this.sendData.enddate = this.item.endDate
        this.datas = {}
        this.xprice_type = {}
        this.datas[this.sendData.room_id] = 1
        this.xprice_code[this.sendData.room_id] = this.sendData.price_code
        this.sendData.select_package = []
        // 设置按钮显示状态
        for (let key in this.item.package_info.items) {
//          this.item.package_info.items[key].product_show_status = true
          this.item.package_info.items[key] = Object.assign({}, this.item.package_info.items[key], {product_show_status: true})
        }
      },
      setDetailStatus (key) {
        console.log(this.packages.package_info.items, '==========')
        this.$set(this.packages[key], 'product_show_status', true)
        console.log(key)
        this.packages[key]['product_show_status'] = !this.packages[key]['product_show_status']
        console.log(this.packages)
        this.packages[key] = Object.assign({}, this.packages[key], {product_show_status: true})
        this.packages.$set(key, 'product_show_status', true)
      },
      addRoom ($event, item, key) {
        if ($event.currentTarget.checked) {
          item.indexVal = key
          this.sendData.select_package.push(item)
          for (let i = 0; i < this.sendData.select_package.length; i++) {
            if (key === this.sendData.select_package[i].indexVal) {
              this.sendData.select_package[i].isCheck = true
            }
          }
        } else {
          for (let i = 0; i < this.sendData.select_package.length; i++) {
            if (key === this.sendData.select_package[i].indexVal) {
              this.sendData.select_package.splice(i, 1)
            }
          }
        }
        let num = 0
        for (var keyIndex in this.sendData.select_package) {
          num += Number(this.sendData.select_package[keyIndex].price) * Number(this.sendData.select_package[keyIndex].countNum)
        }
        this.allPrice = num
        this.sendData.allPrice = this.allPrice
      },
      handleRoom (item, key) {
        let num = 0
        for (var keyIndex in this.sendData.select_package) {
          num += Number(this.sendData.select_package[keyIndex].price) * Number(this.sendData.select_package[keyIndex].countNum)
        }
        this.allPrice = num
        this.sendData.allPrice = this.allPrice
      },
      goSubmitOrder () {
        if (this.sendData.select_package.length === 0) {
          this.$jfkAlert('请选择商品')
          return
        }
        this.$store.commit('updateSubmitOrderConfig', this.sendData)
        this.beforePage()
      },
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
            let obj = `"${goodId}":{"gid":"${goodId}","nums":"${nums}"}`
            goodsItems += obj
          }
        }
        this.package_info = `{${goodsItems}}`
        let setData = {
          id: params.id || '',
          openid: params.openid || '',
          startdate: this.sendData.startdate || '',
          enddate: this.sendData.enddate || '',
          price_codes: JSON.stringify(this.xprice_code) || {},
          hotel_id: this.sendData.hotel_id || '',
          datas: JSON.stringify(this.datas) || {},
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
      }
    }
  }
</script>
