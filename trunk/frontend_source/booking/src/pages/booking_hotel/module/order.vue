<template>
  <div class="jfk-pages jfk-pages__submitOrder" v-if="hotel.hotel_id">
    <div class="jfk-pages__theme"></div>
    <div class="submit_order_top">
      <div class="submit_order_top_title" v-show="false">
          <span class="word font-size--28">登陆后享受 <span class="font-size--36">更低优惠</span></span>
          <span class="if goldColor">
            <i class="booking_icon_font font-size--34 icon-font_zh_li_qkbys"></i><i class="booking_icon_font font-size--34 icon-font_zh_ji_qkbys"></i><i class="booking_icon_font font-size--34 icon-font_zh_deng_qkbys"></i><i class="booking_icon_font font-size--34 icon-font_zh_lu_qkbys"></i><i class="booking_icon_font font-size--28 icon-booking_icon_right_normal"></i>
          </span>
      </div>
      <p class="hotel_name font-size--38" v-html="hotel.name"></p>
      <p class="stay_time grayColor80 font-size--24">
        <span class="in">入住 <span class="date" v-html="startdate"></span></span>
        <span class="left">离店 <span class="date" v-html="enddate"></span></span>
        <span class="time">共{{days}}晚</span>
      </p>
      <div>
        <span v-for="(value,key) in roomList" class="room_del font-size--24">{{value.name}} - {{firstState.price_name}}</span>
        <span class="font-size--24"><i>{{count}}</i>间</span>
      </div>
      <div v-for="(value,key) in packages">
        <span class="room_del font-size--24">{{value.goods_name}}</span>
        <span class="font-size--24">{{value.nums}}{{value.unit}}</span>
      </div>
    </div>
    <!-- 房间数等 -->
     <div class="order-info jfk-pl-30 jfk-pr-30">
      <form class="jfk-form font-size--28">
        <div class="form-item">
          <span class="form-item__label font-color-extra-light-gray form-item__label--word-3">房间数</span>
          <div class="form-item__body jfk-ta-r">
            <div class="count jfk-d-ib font-size--32">
              <jfk-input-number v-model="count" :max="maxRoomNums" @click.native.prevent="handleRoom"></jfk-input-number>
            </div>
            <span class="font-color-extra-light-gray">间</span>
          </div>
        </div>
        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">入住人</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" v-model="customerInfo.name" placeholder="请输入入住人姓名" />
              <div class="form-item__status is-error" v-show="validResult.name.passed" @click="handleHiddenError('name')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{validResult.name.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
            </div>
          </label>
        </div>
        <div class="form-item">
          <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">手机号</span>
          <div class="form-item__body">
            <input type="text" maxlength="11" class="font-color-white" v-model="customerInfo.tel" placeholder="请输入入住人手机" />
              <div class="form-item__status is-error" v-show="validResult.tel.passed" @click="handleHiddenError('tel')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{validResult.tel.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
          </div>
        </div>
         <!-- 优惠券 -->
      <div class="pay_for">
        <div class="pay_for_item font-size--24" @click="handleShow">
          <span class="counp goldColor font-size--34">
          优惠券
          <i class="booking_icon_font font-size--24 icon-booking_icon_dropdown_normal"></i>
          </span>
          <br>
          <span class="counpon">
            {{couponText}}
          </span>
        </div>
        <div class="pay_for_item font-size--24">
          <div>
            <span class="counp goldColor font-size--34">{{submitResdata.web_data.point_name}}抵用</span>
            <br>
            <div>
              <span class="counpon">
                可用{{exchangeMaxPoint}}{{pointName}}
                <br>
                抵用¥{{pointBonus}}
              </span>
              <span @click="handleBouns" class="on_checked" :class="{'off_checked': !bonusCheck}"></span>
            </div>

          </div>
        </div>
      </div>
      <div class="form-item">
        <span class="form-item__label  font-color-extra-light-gray">备&nbsp;&nbsp;&nbsp;&nbsp;注</span>
        <div class="form-item__body">
          <input type="text" class="font-color-white"  maxlength="100" v-model="customerInfo.customRemark" placeholder="无" />
        </div>
      </div>
      </form>
    </div>
    <!-- 支付方式 -->
    <div class="pay_type">
      <p class="font-size--24">支付方式</p>
      <div class="pay_type_item" v-for="(value, key) in payWays" :key="key" :class="{'acitve' : key === 0 }">
        <input v-if="value.disable" type="radio" v-model="payType" @click="handleOrder(value.pay_type, value.fvour, value.cosume_code_need)" name="pay"  :value="value.pay_type">
        <input v-else type="radio" v-model="payType" @click="handleOrder(value.pay_type, value.favour, value.cosume_code_need)" name="pay" :value="value.pay_type">
        <p class="font-size--28">
          <i class="booking_icon_font font-size--40 icon-laqiala" v-if="value.pay_type === 'lakala' || value.pay_type === 'lakala_y'"></i>
          <i class="booking_icon_font font-size--40 icon-yinlianzhifu" v-else-if="value.pay_type === 'unionpay'"></i>
          <i class="booking_icon_font font-size--40 icon-jifenzhifu" v-else-if="value.pay_type === 'point'"></i>
          <i class="booking_icon_font font-size--40 icon-user_icon_pay_n" v-else-if="value.pay_type === 'balance'"></i>
          <i class="booking_icon_font font-size--40 icon-user_icon_wxpay_n-" v-else></i><br>
          {{value.pay_name}}
          <span class="font-size--24">{{value.des}}</span>
        </p>
        
      </div>
    </div>
    <!-- 支付密码 -->
    <div class="order-info jfk-pl-30 jfk-pr-30 passwordContainer" v-show="showPayPassWord">
      <form class="jfk-form font-size--28">
        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">支付密码</span>
            <div class="form-item__body">
              <input type="password" class="font-color-white" v-model="payPassWord" placeholder="请输入支付密码" />
              <div class="form-item__status is-error" v-show="false" @click="handleHiddenError('name')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                  <i class="form-item__status-cont">{{validResult.name.message}}</i>
                  <i class="form-item__status-trigger">重新输入</i>
                </span>
              </div>
            </div>
          </label>
        </div>
      </form>
    </div>
    <div class="booking_desc font-size--24 jfk-pl-30 jfk-pr-30">
      <p class="title">
        <i class="booking_icon_font font-size--30 icon-msg_icon_prompt_default"></i>
        预定说明
      </p>
      <p class="desc" v-html="hotel.book_policy">
      </p>
    </div>
    <!-- 底部栏 -->
    <footer class="footer jfk-clearfix">
      <div class="order-detail jfk-fl-l">
          <span class="price color-golden">
            <i class="price__currency font-size--24"><span class="money_icon">¥</span></i>
            <i class="price__number font-size--48">{{totalPrice}}</i>
          </span>
          <span @click="detailed = detailed ? false : true" class="detail font-size--24 font-color-extra-light-gray showDetailIcon">
            明细
          </span>
        </div>
        <div class="control jfk-fl-l">
          <button href="javascript:;" class="jfk-button font-size--34 jfk-button--higher jfk-button--free jfk-button--primary" @click="handleSumbit">
            <span class="jfk-button__text">
              <i class="booking_icon_font jfk-button__text-item icon-font_zh_ti_qkbys"></i>
              <i class="booking_icon_font jfk-button__text-item icon-font_zh_jiao_qkbys"></i>
              <i class="booking_icon_font jfk-button__text-item icon-font_zh_ding_qkbys"></i>
              <i class="booking_icon_font jfk-button__text-item icon-font_zh_dan_qkbys"></i>
            </span>
          </button>
        </div>
    </footer>
    <!-- 遮罩层 -->
    <div class="order_detail" v-show="detailed">
      <div class="order_detail_content">
        <div class="room_cost jfk-pl-30 jfk-pr-30 font-size--26 grayColor80">
          <p class="title font-size--28 font-color-dark-white">
            <span class="left">房费</span>
            <!--<span class="right goldColor font-size&#45;&#45;30"><span class="money_icon">¥</span>{{totalPrice}}</span>-->
            <!--xm-->
            <span class="right goldColor font-size--30"><span class="money_icon">¥</span>{{realPrice}}</span>
          </p>
          <p class="room_cost_item" v-for="(value,key) in tmpPrice">
            <span class="left">{{value.date}}（{{count}}间）</span>
            <span class="right">{{value.price}}</span>
          </p>
        </div>
        <div class="room_cost jfk-pl-30 jfk-pr-30 font-size--26 grayColor80">
          <p class="title font-size--28 font-color-dark-white">
            <span class="left">其他</span>
            <span class="right goldColor font-size--30"><span class="money_icon">¥</span>{{packagesPrice}}</span>
          </p>
          <p class="room_cost_item" v-for="(value,key) in packages">
            <span class="left">{{value.goods_name}}x{{value.nums}}</span>
            <span class="right">¥{{value.price * value.nums}}</span>
          </p>
        </div>
        <div class="use_coupon font-size--28 jfk-pl-30 jfk-pr-30">
          <p class="use_coupon_item">
            <span class="left">使用积分</span>
            <span class="right goldColor font-size--30">{{toalBonus}}积分</span>
          </p>
          <p class="use_coupon_item">
            <span class="left">支付优惠</span>
            <span class="right goldColor font-size--30">-<span class="money_icon">¥</span>{{payFavour}}</span>
          </p>
          <p class="use_coupon_item">
            <span class="left">优惠券</span>
            <span class="right goldColor font-size--30">-<span class="money_icon">¥</span>{{couponAmount}}</span>
          </p>
        </div>
      </div>
    </div>
    <!-- 使用优惠券 -->
    <div class="choose_coupon font-size--28" v-show="couponShow">
      <div class="choose_coupon_top jfk-pl-30 jfk-pr-30">
        <p class="title font-size--24 grayColor80">温馨提示</p>
        <div v-if="couponTips === ''">
          <p class="choose_coupon_item">
          1、每个间夜仅可使用1张优惠劵
          </p>
          <p class="choose_coupon_item">
          2、优惠劵不找零，不兑换，使用后不可取消，请谨慎使用
          </p>
        </div>
        <div v-else v-html="couponTips"></div>
        <!-- <span class="click_open font-size--24 goldColor">
          展开全文
        <span> -->
            <!-- <i class="booking_icon_font font-size--24 icon-booking_icon_right_normal"></i> -->
          </span>
        </span>
      </div>
      <!--
        <div class="coupon_num font-size--28 grayColor80 jfk-pl-30 jfk-pr-30">
          <span class="font-size--40 goldColor">1</span>
          <span class="sliver">/</span> 14可用
        </div>
       -->
      <div class="coupon_list jfk-pl-30 jfk-pr-30">
        <div class="coupon_list_item" v-for="(value,key) in couponCards" @click="handleChoose(key)" >
          <div class="price">
            <span class="jfk-price product-price-package color-golden" v-if = "value.coupon_type === 'discount'">
              <i class="jfk-font-number icon_num jfk-price__number">{{value.newReduce_cost * 10}}</i>
              <i class="jfk-font icon-font_zh_zhe_qkbys"></i>

            </span>
            <span class="jfk-price product-price-package color-golden" v-else>
              <i class="jfk-font-number jfk-price__currency font-size--28 icon_money">￥</i>
              <i class="jfk-font-number icon_num jfk-price__number">{{value.reduce_cost}}</i>
            </span>
          </div>
          <div class="coupon_desc">
            <p class="name font-size--32">{{value.title}}</p>
            <p class="desc font-size--24 grayColorbf">指定门店专用</p>
            <p class="date font-size--24 grayColor80">有效期至{{value.date_info_end_timestamp}}</p>
            <input type="checkbox" name="coupon" disabled v-if="value.check" checked="true" class="right_status">
            <input type="checkbox" name="coupon" disabled v-else class="right_status">
            <!-- <span class="right_status font-size--24 grayColorbf">不可用</span> -->
          </div>
        </div>
      </div>
      <div class="btn_submit font-size--32" @click="handleCoupon">
        确   认
      </div>
    </div>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
// getBookroomDetail
  import { getBookroomCoupon, getBookroomBonus, getPointpaySet, postSaveOrder } from '@/service/http'
  import { showFullLayer, formatDate } from '@/utils/utils'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  let params = formatUrlParams(location.search)
  export default {
    watch: {
    },
    computed: {
      submitOrderConfig () {
        console.log(this.$store.getters.submitOrderConfig)
        return this.$store.getters.submitOrderConfig || {}
      },
      submitResdata () {
        console.log(this.$store.getters.submitResdata, 'submitResdata===========')
        return this.$store.getters.submitResdata || {}
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        // 通过 `vm` 访问组件实例
        vm.beforePage()
      })
    },
    created () {
    },
    data () {
      return {
        couponShow: false,
        couponDis: true,
        couponTips: '',
        detailed: false,
        hotel: {},
        roomList: {},
        startdate: '',
        totalPrice: 0,
        enddate: '',
        days: '',
        count: 1,
        firstState: '',
        packages: {},
        exchangeMaxPoint: '',
        pointName: '',
        pointConsumRate: '',
        pointBonus: '',
        payWays: {},
        realPrice: 0,
        unitPrice: 0,
        allPrice: [],
        tmpPrice: {},
        packagesPrice: 0,
        maxRoomNightUse: 0,
        maxOrderUse: 0,
        maxCouponUse: 0,
        paytypeCounts: 0,
        couponAmount: 0,
        totalFavour: 0,
        payFavour: 0,
        noPartBonus: 0,
        pointFavour: 0,
        selectCoupons: {},
        partBonusSet: {},
        bonusCheck: false,
        pointMaxUse: 0,
        bonus: 0,
        paybonus: 0,
        toalBonus: 0,
        useFlag: '',
        rid: '',
        payType: '',
        hasPointPay: 0,
        maxRoomNums: 1,
        prevend: 0,
        totalBonusPrice: 0,
        totalPay: 0,
        totalCoupon: 0,
        priceType: '',
        member: {
          bonus: 0
        },
        // 用户信息
        customerInfo: {
          name: '',
          tel: '',
          customRemark: ''
        },
        couponText: '选择优惠券',
        couponCards: {},
        coupons: {
        },
        validResult: {
          name: {
            passed: false,
            message: ''
          },
          tel: {
            passed: false,
            message: ''
          }
        },
        // 用于发送数据
        xprice_code: {},
        datas: {},
        price_type: {},
        package_info: '',
        sendData: {},
        // 支付密码
        payPassWord: '',
        // 显示 / 隐藏 支付密码状态
        showPayPassWord: false
      }
    },
    methods: {
      beforePage () {
        window.scrollTo(0, 0)
        this.sendData = this.submitOrderConfig
        if (JSON.stringify(this.sendData) === '{}') {
          window.history.back()
          return
        }
        this.datas = {}
        this.xprice_code = {}
        this.datas[this.sendData.room_id] = 1
        this.xprice_code[this.sendData.room_id] = this.sendData.price_codes
        this.price_type[this.sendData.price_type] = 1
        // package_info 如果是选择商品页面跳转， 则会有this.sendData.select_package 商品
        if (this.sendData.select_package) {
          this.package_info = {}
          for (let i = 0; i < this.sendData.select_package.length; i++) {
            const content = this.sendData.select_package[i]
            let goodId = content.goods_id.toString()
            this.package_info[goodId] = {
              'gid': goodId,
              'nums': content.countNum
            }
          }
          this.package_info = JSON.stringify(this.package_info)
        } else {
          // 否则从主页面跳转 判断是否存在 package_info
          if (this.sendData.package_info) {
            this.package_info = JSON.stringify(this.sendData.package_info)
          }
        }
        const res = this.submitResdata
        if (res.web_data.page_resource.links.redirect) {
          window.location.href = res.web_data.page_resource.links.redirect
          return
        } else {
          // 初始数据处理
          const resData = res.web_data
          this.hotel = resData.hotel
          this.roomList = resData.room_list
          this.startdate = this.handleDate(resData.startdate)
          this.enddate = this.handleDate(resData.enddate)
          this.days = resData.days
          this.firstState = resData.first_state
          this.packages = resData.packages
          // 判断是否存在 lastorder 字段
          if (resData.last_order) {
            this.customerInfo.name = resData.last_order.name
            this.customerInfo.tel = resData.last_order.tel
          } else {
            this.customerInfo.name = ''
            this.customerInfo.tel = ''
          }
          this.exchangeMaxPoint = resData.exchange_max_point
          this.pointName = resData.point_name
          this.pointConsumRate = resData.point_consum_rate ? 0 : resData.point_consum_rate
          this.pointBonus = Number(this.exchangeMaxPoint) * Number(this.pointConsumRate)
          this.payWays = resData.pay_ways
          this.totalPrice = resData.total_price
          this.unitPrice = resData.total_price
          this.allPrice = resData.first_state.allprice.split(',')
          this.packages = resData.packages
          // 在 this.packages 中赋予一个额外的 nums 值 ，用来计算当 count_way 值为1的时候的商品数量
          for (let key in this.packages) {
            this.packages[key] = Object.assign({}, this.packages[key], {productNums: this.packages[key].nums})
          }
          this.packagesPrice = Number(resData.packages_price)
          this.couponAmount = resData.select_coupon_favour
          this.selectCoupons = resData.select_coupons
          this.totalFavour = resData.select_coupon_favour
          if (resData.first_pay_favour) {
            this.payFavour = resData.first_pay_favour
          }
          this.total_favour += Number(this.total_favour) * 1
          this.noPartBonus = resData.first_state.bonus_condition.no_part_bonus ? 0 : resData.first_state.bonus_condition.no_part_bonus
          this.realPrice = resData.total_price
          this.member.bonus = resData.member.bonus
          this.paybonus = resData.exchange_max_point
          this.rid = resData.first_room.room_info.room_id
          this.hasPointPay = resData.has_point_pay ? 1 : 0
          this.maxRoomNums = Number(resData.first_state.least_num)
          this.payType = resData.pay_ways[0].pay_type
          this.priceType = resData.price_type
          this.couponTips = resData.couponTips ? resData.couponTips : ''
          if (resData.point_consum_set) {
            this.partBonusSet = resData.point_consum_set
          }
          // 判断第一个支付的 cosume_code_need （1）是否需要支付密码 如果需要 显示支付密码框
          if (this.payWays[0].cosume_code_need === 1) {
            this.showPayPassWord = true
          }
          let dateTime = this.handleStrDate(resData.startdate)
          for (let i = 0; i < this.allPrice.length; i++) {
            this.tmpPrice[[i]] = {
              date: dateTime.getMonth() + 1 + '/' + dateTime.getDate(),
              price: this.allPrice[i]
            }
            dateTime = new Date((dateTime / 1000 + 86400) * 1000)
          }
        }
        this.getCoupon()
      },
      handleDate (val) {
        let dateStr = ''
        dateStr = val.substr(4, 2) + '/' + val.substr(6)
        return dateStr
      },
      handleStrDate (val) {
        let dateStr = ''
        dateStr = val.substr(0, 3) + '/' + val.substr(4, 2) + '/' + val.substr(6)
        let date = new Date(dateStr)
        return date
      },
      getCoupon (loadingType) {
        let loading = null
        if (!loadingType) {
          loading = this.$jfkToast({
            iconClass: 'jfk-loading__snake ',
            duration: -1,
            isLoading: true
          })
        }
        // 获取优惠券需要数据
        let couponData = {
          // url id
          id: params.id,
          openid: params.openid,
          datas: JSON.stringify(this.datas) || {},
          start: this.sendData.startdate || '',
          end: this.sendData.enddate || '',
          h: this.sendData.hotel_id || '',
          total: this.totalPrice || '',
          price_code: JSON.stringify(this.xprice_code) || {},
          // ================
          paytype: this.payType,
          pay_favour: this.payFavour || ''
        }
        getBookroomCoupon(couponData).then((res) => {
          if (loading) {
            loading.close()
            loading = true
          }
          let _this = this
          // 优惠券数据
          const coupon = res.web_data
          // xm 获取优惠券的数据预处理
          for (let key in coupon.cards) {
            // 如果是折扣券，获取真正的reduce_cost 总价 && 设置新字段用于显示在界面， 这样下面不用做太多更改
            if (coupon.cards[key].coupon_type === 'discount') {
              let addNum = coupon.cards[key].reduce_cost * this.realPrice
              coupon.cards[key] = Object.assign({}, coupon.cards[key], {newReduce_cost: coupon.cards[key].reduce_cost})
              coupon.cards[key] = Object.assign({}, coupon.cards[key], {reduce_cost: addNum})
            }
          }
          console.log(coupon.cards, '-----------')
          if (coupon.cards !== '') {
            let bool = false
            if (!coupon.vid || coupon.vid === 0) {
              bool = true
            }
            if (bool) {
              _this.maxRoomNightUse = coupon.count.max_room_night_use
              _this.maxOrderUse = coupon.count.max_order_use
            } else {
              _this.maxCouponUse = coupon.count.num
              if (coupon.count.effects && coupon.count.effects.paytype_counts) {
                _this.paytypeCounts = coupon.count.effects.paytype_counts
              }
            }
            if (coupon.selected) {
              _this.couponAmount = 0
              _this.coupons = {}
              for (let item in coupon.selected) {
                _this.coupons[[coupon.selected[item].code]] = coupon.selected[item].reduce_cost
              }
            }
            // xm
            for (let index in coupon.cards) {
              if (_this.coupons[[coupon.cards[index].code]]) {
                // _this.couponAmount += _this.couponAmount + parseFloat(coupon.cards[index].reduce_cost)
                _this.couponAmount += parseFloat(coupon.cards[index].reduce_cost)
                if (coupon.cards[index].hotel_use_num_type === 'room_nights' && bool) {
                  _this.maxRoomNightUse--
                } else if (coupon.cards[index].hotel_use_num_type === 'order' && bool) {
                  _this.maxOrderUse--
                } else if (!bool) {
                  _this.maxCouponUse--
                }
              }
              coupon.cards[index].date_info_end_timestamp = formatDate(coupon.cards[index].date_info_end_timestamp)
              if (!bool) {
                coupon.cards[index].max_use_num = ''
                coupon.cards[index].use_num_type = ''
              }
              if (this.coupons[[coupon.cards[index].code]]) {
                coupon.cards[index].check = true
              } else {
                coupon.cards[index].check = false
              }
              coupon.cards[index].bool = bool
            }
            _this.couponCards = coupon.cards
            _this.totalFavour = _this.couponAmount + _this.payFavour
            if (_this.couponAmount > 0) {
              _this.couponText = '已选￥' + _this.couponAmount.toFixed(2)
            } else {
              _this.couponText = '选择优惠券'
            }
            _this.totalPrice = (parseFloat((_this.realPrice - _this.totalFavour).toFixed(2)) + parseFloat(_this.packagesPrice)).toFixed(2)
            _this.getBonusSet()
          }
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      getBonusSet (loadingType) {
        let loading = null
        if (!loadingType) {
          loading = this.$jfkToast({
            iconClass: 'jfk-loading__snake ',
            duration: -1,
            isLoading: true
          })
        }
        if (this.noPartBonus === 0) {
          // 获取积分所需数据
          let bonusData = {
            // url id
            id: params.id,
            openid: params.openid,
            datas: JSON.stringify(this.datas) || {},
            start: this.sendData.startdate || '',
            end: this.sendData.enddate || '',
            h: this.sendData.hotel_id || '',
            total_price: this.totalPrice || '',
            price_code: JSON.stringify(this.xprice_code) || {},
            // ================
            paytype: this.payType,
            point_name: '积分'
          }
          getBookroomBonus(bonusData).then((res) => {
            if (loading) {
              loading.close()
              loading = true
            }
            let bonus = res.web_data
            this.totalFavour -= this.pointFavour
            this.pointFavour = 0
            this.totalPrice = parseFloat((Number(this.realPrice) - Number(this.totalFavour).toFixed(2)) + parseFloat(this.packagesPrice)).toFixed(2)
            if (bonus.s === 1 && bonus.consum_rate > 0) {
              if (this.partBonusSet !== bonus.part_set) {
                this.partBonusSet = bonus.part_set
                this.bonus_view = 1 // 新皮肤先写死
                if (this.bonus_view === 1) {
                  this.pointConsumRate = bonus.consum_rate
                  this.pointMaxUse = this.exchangeMaxPoint
                  if (this.partBonusSet['max_use']) {
                    if (Number(this.pointMaxUse) < Number(this.member.bonus)) {
                      this.pointMaxUse = this.partBonusSet['max_use']
                    }
                  } else {
                    this.pointMaxUse = this.member.bonus
                  }
                  if ((this.realPrice - 1 - this.totalFavour) < 0) {
                    this.pointMaxUse = 0
                  } else if ((this.realPrice - 1 - this.totalFavour) < this.pointMaxUse * bonus.consum_rate) {
                    let tempPointMax = Math.round((this.realPrice - 1 - this.totalFavour) / bonus.consum_rate)
                    if (tempPointMax * bonus.consum_rate < (this.realPrice - 1 - this.totalFavour)) {
                      this.pointMaxUse = Math.round((this.realPrice - 1 - this.totalFavour) / bonus.consum_rate)
                    } else {
                      this.pointMaxUse = Math.floor((this.realPrice - 1 - this.totalFavour) / bonus.consum_rate)
                    }
                  }
                  if (this.partBonusSet['use_rate']) {
                    if ((this.pointMaxUse % this.partBonusSet['use_rate']) !== 0) {
                      this.pointMaxUse = this.pointMaxUse - (this.pointMaxUse % this.partBonusSet['use_rate'])
                    }
                  }
                  let exMoney = this.pointMaxUse * bonus.consum_rate
                  this.paybonus = this.pointMaxUse
                  this.bonus = this.pointMaxUse
                  this.exchangeMaxPoint = this.pointMaxUse
                  this.pointBonus = exMoney.toFixed(2)
                  // if 积分抵扣可以使用 减去积分抵扣的价钱 xm
                  if (this.bonusCheck) {
                    this.totalPrice -= this.pointBonus
                  }
                  // xm 积分为0 按钮置灰
                  if (this.exchangeMaxPoint === 0) {
                    // 按钮置灰 xm
                    this.bonusCheck = false
                  }
                } else {
                  if (this.partBonusSet['max_use']) {
                    this.pointMaxUse = this.partBonusSet['max_use']
                    this.pointConsumRate = bonus.consum_rate
                  } else {
                    let mybonus = this.member.bonus ? 0 : this.member.bonus
                    this.pointMaxUse = mybonus
                    this.pointConsumRate = bonus.consum_rate
                  }
                }
              }
            } else {
              this.paybonus = 0
              this.bonus = 0
              this.exchangeMaxPoint = 0
              this.pointBonus = 0
              // 按钮置灰 xm
              this.bonusCheck = false
              console.log(this.totalPrice, '+++++')
            }
          }).catch(function (e) {
            if (loading) {
              loading.close()
            }
            console.log(e)
          })
        }
      },
      getJsonObjLength (obj) {
        let Length = 0
        for (let item in obj) {
          if (item) {
            Length++
          }
        }
        return Length
      },
      handleBouns () {
        if (this.paybonus > 0) {
          if (!this.bonusCheck) {
            this.bonus = this.paybonus
            this.toalBonus = this.bonus
          } else {
            this.bonus = ''
            this.toalBonus = 0
          }
          let tembonus = this.bonus ? Number(this.bonus) * 1 : 0
          if (this.bonusCheck) {
            this.bonusCheck = false
          } else {
            this.bonusCheck = true
          }
          this.totalFavour -= this.pointFavour
          this.pointFavour = Number(this.pointConsumRate) * Number(tembonus)
          this.totalFavour += this.pointFavour
          this.totalPrice = (parseFloat((this.realPrice - this.totalFavour).toFixed(2)) + parseFloat(this.packagesPrice
            )).toFixed(2)
        }
      },
      handleCoupon () {
        if (this.couponAmount > 0) {
          this.couponText = '已选￥' + this.couponAmount.toFixed(2)
        } else {
          this.couponText = '选择优惠券'
        }
        this.getBonusSet()
        this.couponShow = false
      },
      handleChoose (key) {
        const thatCoupon = this.couponCards[key]
        if (Number(this.couponCards[key].reduce_cost) >= Number(this.totalPrice)) {
          console.log(this.couponCards[key].check)
          if (this.couponCards[key].check === false) {
            this.$jfkToast({
              duration: 1000,
              iconType: 'error',
              message: '无法选择小于总金额的优惠券'
            })
            return
          }
        }
        if (this.couponCards[key].check) {
          this.couponCards[key].check = false
          if (this.coupons[[thatCoupon['code']]]) {
            delete (this.coupons[[thatCoupon['code']]])
            if (this.getJsonObjLength(this.coupons) === 0) {
              this.useFlag = ''
            }
            this.couponAmount -= Number(thatCoupon.reduce_cost) * 1
            this.totalFavour -= Number(thatCoupon.reduce_cost) * 1
            if (thatCoupon.use_num_type === 'room_nights' && thatCoupon.bool) {
              this.maxRoomNightUse++
            } else if (thatCoupon.use_num_type === 'order' && thatCoupon.bool) {
              this.maxOrderUse++
            } else if (!thatCoupon.bool) {
              this.maxCouponUse++
            }
          }
        } else {
          if (thatCoupon.bool) {
            if (!this.useFlag) {
              this.useFlag = thatCoupon.use_num_type
            }
            if (thatCoupon.use_num_type === 'room_nights') {
              if (this.maxRoomNightUse > 0) {
                this.maxRoomNightUse--
              } else {
                this.couponCards[key].check = false
                return false
              }
            } else if (thatCoupon.use_num_type === 'order') {
              if (this.maxOrderUse > 0) {
                this.maxOrderUse--
              } else {
                this.couponCards[key].check = false
                return false
              }
            }
          } else {
            if (this.maxCouponUse > 0) {
              this.maxCouponUse--
            } else {
              this.couponCards[key].check = false
              return false
            }
          }
          this.couponCards[key].check = true
          this.coupons[[thatCoupon['code']]] = thatCoupon.reduce_cost
          this.couponAmount += thatCoupon.reduce_cost * 1
          this.totalFavour += thatCoupon.reduce_cost * 1
        }
        this.couponCards = this.couponCards
        this.totalPrice = (parseFloat((this.realPrice - this.totalFavour).toFixed(2)) + parseFloat(this.packagesPrice)).toFixed(2)
      },
      getPointpaySet (loadingType) {
        let loading = null
        if (!loadingType) {
          loading = this.$jfkToast({
            iconClass: 'jfk-loading__snake ',
            duration: -1,
            isLoading: true
          })
        }
        // 判断能否使用积分支付
        if (this.hasPointPay === 1) {
          let getPoint = {
            // url id
            id: params.id,
            openid: params.openid,
            datas: JSON.stringify(this.datas) || {},
            start: this.sendData.startdate || '',
            end: this.sendData.enddate || '',
            h: this.sendData.hotel_id || '',
            total_price: this.totalPrice || '',
            price_code: JSON.stringify(this.xprice_code) || {},
            // ==========
            paytype: this.payType,
            point_name: '积分'
          }
          getPointpaySet(getPoint).then((res) => {
            if (loading) {
              loading.close()
              loading = true
            }
            if (res.web_data.can_exchange === 1) {
              for (let canExchange in this.payWays) {
                if (this.payWays[canExchange].pay_type === 'point') {
                  this.payWays[canExchange].disable = true
                }
              }
            } else {
              for (let noExchange in this.payWays) {
                if (this.payWays[noExchange].pay_type === 'point') {
                  this.payWays[noExchange].disable = false
                }
              }
            }
          }).catch(function (e) {
            if (loading) {
              loading.close()
            }
            console.log(e)
          })
        }
      },
      handleRoom () {
        if (this.count === this.maxRoomNums) return
        this.pointFavour = 0
        if (this.paytype === 'weixin') {
          this.totalFavour = this.payFavour
        } else {
          this.totalFavour = 0
        }
        let tmpval = this.count
        // xm
        this.datas[this.sendData.room_id] = this.count
        this.realPrice = this.unitPrice * tmpval
        this.totalPrice = (parseFloat((this.unitPrice * tmpval).toFixed(2)) + parseFloat(this.packagesPrice)).toFixed(2)
        let roomnos = {}
        roomnos[[this.rid]] = tmpval
        // 包价、按房晚赠送，一晚送1份；在提交订单页面，当增加房间数时，应该赠送的商品数量也相应增加
        for (let key in this.packages) {
          if (this.packages[key].count_way === 1) {
            let countNums = 0
            countNums = this.packages[key].productNums * this.count
            this.packages[key] = Object.assign({}, this.packages[key], {nums: countNums})
          }
        }
        let loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        this.getBonusSet(true)
        this.getPointpaySet(true)
        this.getCoupon(true)
        if (loading) {
          loading.close()
        }
      },
      handleShow () {
        if (this.couponDis) {
          this.couponShow = true
          const cb = () => {
            this.couponShow = false
          }
          showFullLayer(null, '选择优惠券', location.href, cb)
        }
      },
      handleOrder (type, favour, cosumeCodeNeed) {
        if (cosumeCodeNeed === 1) {
          this.showPayPassWord = true
        } else {
          this.showPayPassWord = false
        }
        if (type === 'bonus') {
          this.couponText = '不可用'
          this.couponDis = false
        } else {
          this.couponDis = true
          if (this.couponAmount > 0) {
            if (!this.paytypeCounts || this.paytypeCounts === 0) {
              this.couponText = '已选￥' + this.couponAmount.toFixed(2)
            } else if (this.paytypeCounts === 1) {
              this.couponText = '请重新选择优惠券'
            }
          } else {
            this.couponText = '选择优惠券'
          }
        }
        let temval = this.count
        this.realPrice = this.unitPrice * temval
        this.totalFavour -= this.couponAmount
        this.couponAmount = 0
        this.coupons = {}
        this.totalPrice = (parseFloat((this.realPrice - this.totalFavour).toFixed(2)) + parseFloat(this.packagesPrice)).toFixed(2)
        // xm
        this.payType = type
        this.payFavour = favour
        this.getBonusSet()
        this.getCoupon()
      },
      handleHiddenError (val) {
        this.validResult[[val]].passed = false
        this.validResult[[val]].message = ''
      },
      handleSumbit () {
        let saveBol = true
        let telReg = /^1\d{10}$/
        if (this.customerInfo.name === '') {
          this.validResult.name.passed = true
          this.validResult.name.message = '入住人不能为空'
          saveBol = false
        }
        if (this.customerInfo.tel === '') {
          this.validResult.tel.passed = true
          this.validResult.tel.message = '手机号不能为空'
          saveBol = false
        } else if (!telReg.test(this.customerInfo.tel)) {
          this.validResult.tel.passed = true
          this.validResult.tel.message = '请输入正确的手机号'
          saveBol = false
        }
        if (this.showPayPassWord && !this.payPassWord) {
          this.$jfkToast({
            duration: 1000,
            iconType: 'error',
            message: '请输入支付密码'
          })
          saveBol = false
          return
        }
        if (saveBol) {
          let loading = this.$jfkToast({
            iconClass: 'jfk-loading__snake ',
            duration: -1,
            isLoading: true
          })
          let saveData = {
            // url id
            id: params.id,
            openid: params.openid,
            name: this.customerInfo.name,
            tel: this.customerInfo.tel,
            custom_remark: this.customerInfo.customRemark,
            paytype: this.payType,
            datas: JSON.stringify(this.datas) || {},
            roomnos: '',
            coupons: JSON.stringify(this.coupons),
            add_services: '',
            startdate: this.sendData.startdate || '',
            enddate: this.sendData.enddate || '',
            hotel_id: this.sendData.hotel_id || '',
            price_codes: JSON.stringify(this.xprice_code) || {},
            price_type: JSON.stringify(this.price_type) || '',
            bonus: this.toalBonus,
            consume_code: this.payPassWord || '',
            intime: '',
            invoice: '',
            package_info: this.package_info
          }
          this.prevend = 1
          postSaveOrder(saveData).then((res) => {
            if (loading) {
              loading.close()
              loading = true
            }
            if (res.status === 1000) {
              window.location.href = res.web_data.link
            } else {
              this.$jfkToast({
                duration: 1000,
                iconType: 'error',
                message: res.msg
              })
            }
          }).catch(function (e) {
            if (loading) {
              loading.close()
            }
            console.log(e)
          })
        }
      }
    }
  }
</script>
