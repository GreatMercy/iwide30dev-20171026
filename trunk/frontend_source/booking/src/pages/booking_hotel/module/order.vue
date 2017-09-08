<template>
  <div class="jfk-pages jfk-pages__submitOrder" v-if="hotel.hotel_id">
    <div class="jfk-pages__theme"></div>
    <div class="submit_order_top">
      <div class="submit_order_top_title" style="display:none;">
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
        <span class="font-size--24"><i>1</i>间</span>
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
            <span class="counp goldColor font-size--34">积分抵用</span>
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
      <div class="pay_type_item" v-for="(value,key) in payWays" :class="{'acitve' : key === 0 }">

        <input v-if="value.disable" type="radio" v-model="payType" @click="handleOrder(value.pay_type)" name="pay"  :value="value.pay_type">
        <input v-else type="radio" v-model="payType" @click="handleOrder(value.pay_type)" name="pay" :value="value.pay_type">

        <p class="font-size--28">
          <i class="booking_icon_font font-size--40 icon-user_icon_wxpay_n-"></i><br>
          {{value.pay_name}}
        </p>
      </div>
    </div>
    <div class="booking_desc font-size--24 jfk-pl-30 jfk-pr-30">
      <p class="title">
        <i class="booking_icon_font font-size--30 icon-msg_icon_prompt_default"></i>
        预定说明
      </p>
      <p class="desc">
        {{hotel.book_policy}}
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
            <span class="right goldColor font-size--30"><span class="money_icon">¥</span>{{totalPrice}}</span>
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
            <span class="jfk-price product-price-package color-golden">
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
  import { formatDate } from '@/utils/utils'
  export default {
    watch: {
      submitOrderConfig (val) {
        // this.sendData = Object.assign({}, this.sendData, val)
        // this.sendData = val
        // this.submitOrderConfig()
      }
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
    created () {
      this.beforePage()
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
        sendData: {}
      }
    },
    methods: {
      beforePage () {
        this.sendData = this.submitOrderConfig
        this.datas = {}
        this.xprice_code = {}
        this.datas[this.sendData.room_id] = 1
        this.xprice_code[this.sendData.room_id] = this.sendData.price_codes
        this.price_type[this.sendData.price_type] = 1
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
          this.customerInfo.name = resData.last_order.name
          this.customerInfo.tel = resData.last_order.tel
          this.exchangeMaxPoint = resData.exchange_max_point
          this.pointName = resData.point_name
          this.pointConsumRate = resData.point_consum_rate ? 0 : resData.point_consum_rate
          this.pointBonus = Number(this.exchangeMaxPoint) * Number(this.pointConsumRate)
          this.payWays = resData.pay_ways
          this.totalPrice = resData.total_price
          this.unitPrice = resData.total_price
          this.allPrice = resData.first_state.allprice.split(',')
          this.packages = resData.packages
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
      getCoupon () {
        let loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        // 获取优惠券需要数据
        let couponData = {
          // url id
          id: this.getUrlParams('id'),
          openid: this.getUrlParams('openid'),
          datas: JSON.stringify(this.datas) || {},
          start: this.sendData.startdate || '',
          end: this.sendData.enddate || '',
          h: this.sendData.hotel_id || '',
          total: this.sendData.allPrice || '',
          price_code: JSON.stringify(this.xprice_code) || {},
          // ================
          paytype: this.payType,
          pay_favour: this.sendData.pay_favour || ''
        }
        getBookroomCoupon(couponData).then((res) => {
          if (loading) {
            loading.close()
            loading = true
          }
          // 优惠券数据
          const coupon = res.web_data
          if (coupon.cards !== '') {
            let bool = false

            if (!coupon.vid || coupon.vid === 0) {
              bool = true
            }
            if (bool) {
              this.maxRoomNightUse = coupon.count.max_room_night_use
              this.maxOrderUse = coupon.count.max_order_use
            } else {
              this.maxCouponUse = coupon.count.num
              if (coupon.count.effects && coupon.count.effects.paytype_counts) {
                this.paytypeCounts = coupon.count.effects.paytype_counts
              }
            }
            if (coupon.selected) {
              this.couponAmount = 0
              this.coupons = {}
              for (let item in coupon.selected) {
                this.coupons[[coupon.selected[item].code]] = coupon.selected[item].reduce_cost
              }
            }
            for (let index in coupon.cards) {
              if (this.coupons[[coupon.cards[index].code]]) {
                this.couponAmount += this.couponAmount + parseFloat(coupon.cards[index].reduce_cost)
                if (coupon.cards[index].hotel_use_num_type === 'room_nights' && bool) {
                  this.maxRoomNightUse--
                } else if (coupon.cards[index].hotel_use_num_type === 'order' && bool) {
                  this.maxOrderUse--
                } else if (!bool) {
                  this.maxCouponUse--
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
            this.couponCards = coupon.cards
            this.totalFavour = this.couponAmount + this.payFavour
            if (this.couponAmount > 0) {
              this.couponText = '已选￥' + this.couponAmount.toFixed(2)
            } else {
              this.couponText = '选择优惠券'
            }
            this.totalPrice = (parseFloat((this.realPrice - this.totalFavour).toFixed(2)) + parseFloat(this.packagesPrice)).toFixed(2)
            this.getBonusSet()
          }
        }).catch(function (e) {
          if (loading) {
            loading.close()
          }
          console.log(e)
        })
      },
      getBonusSet () {
        if (this.noPartBonus === 0) {
          // 获取积分所需数据
          let bonusData = {
            // url id
            id: this.getUrlParams('id'),
            openid: this.getUrlParams('openid'),
            datas: JSON.stringify(this.datas) || {},
            start: this.sendData.startdate || '',
            end: this.sendData.enddate || '',
            h: this.sendData.hotel_id || '',
            total_price: this.sendData.allPrice || '',
            price_code: JSON.stringify(this.xprice_code) || {},
            // ================
            paytype: this.payType,
            point_name: '积分'
          }
          let loading = this.$jfkToast({
            iconClass: 'jfk-loading__snake ',
            duration: -1,
            isLoading: true
          })
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
          this.getBonusSet()
        } else {
          this.couponText = '选择优惠券'
        }
        this.couponShow = false
      },
      handleChoose (key) {
        const thatCoupon = this.couponCards[key]
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
      getPointpaySet () {
        let loading = this.$jfkToast({
          iconClass: 'jfk-loading__snake ',
          duration: -1,
          isLoading: true
        })
        // 判断能否使用积分支付
        if (this.hasPointPay === 1) {
          let getPoint = {
            // url id
            id: this.getUrlParams('id'),
            openid: this.getUrlParams('openid'),
            datas: JSON.stringify(this.datas) || {},
            start: this.sendData.startdate || '',
            end: this.sendData.enddate || '',
            h: this.sendData.hotel_id || '',
            total_price: this.sendData.allPrice || '',
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
        this.pointFavour = 0
        if (this.paytype === 'weixin') {
          this.totalFavour = this.payFavour
        } else {
          this.totalFavour = 0
        }
        let tmpval = this.count
        this.realPrice = this.unitPrice * tmpval
        this.totalPrice = (parseFloat((this.unitPrice * tmpval).toFixed(2)) + parseFloat(this.packagesPrice)).toFixed(2)
        let roomnos = {}
        roomnos[[this.rid]] = tmpval
        this.getBonusSet()
        this.getPointpaySet()
        this.getCoupon()
      },
      handleShow () {
        if (this.couponDis) {
          this.couponShow = true
        }
      },
      handleOrder (type) {
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
        if (saveBol) {
          let saveData = {
            // url id
            id: this.getUrlParams('id'),
            openid: this.getUrlParams('openid'),
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
            consume_code: '',
            intime: '',
            invoice: '',
            package_info: this.package_info
          }
          this.prevend = 1
          let loading = this.$jfkToast({
            iconClass: 'jfk-loading__snake ',
            duration: -1,
            isLoading: true
          })
          postSaveOrder(saveData).then((res) => {
            if (loading) {
              loading.close()
              loading = true
            }
            if (res.status === 1000) {
              window.location.href = res.web_data.link
            }
          }).catch(function (e) {
            if (loading) {
              loading.close()
            }
            console.log(e)
          })
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
