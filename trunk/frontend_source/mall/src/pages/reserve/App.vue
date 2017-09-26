<template>
  <div class="jfk-pages jfk-pages__reserve">
    <div class="jfk-pages__theme"></div>
    <div class="reserve-box" v-if="productInfo.product_id">
      <reverse-killsec-time @killsec-finish="handleKillsecFinish" :countdown="countdown" v-if="productInfo.tag === 2 && tokenId"></reverse-killsec-time>
      <div class="mail-only jfk-pt-30 jfk-pl-30 jfk-pr-30" v-if="addressPosition === 1" @click="handleChangeAddress">
        <div class="address card">
          <div class="add jfk-flex is-align-middle is-justify-center font-size--28 font-color-extra-light-gray" v-if="addressId === '-1'">
            <div class="cont">
              <i class="icon color-golden jfk-font icon-mall_icon_address_add"></i>新增收货地址
            </div>
          </div>
          <div class="list jfk-flex is-align-middle" v-else>
            <div class="cont">
              <div class="list-item">
                <span class="label font-color-extra-light-gray font-size--24 label--word-3">收件人</span>
                <div class="item-cont font-size--28 font-color-white">
                  <span class="contact">{{addressPicked.contact}}</span>
                  <span class="phone">{{addressPicked.phone}}</span>
                </div>
              </div>
              <div class="list-item">
                <span class="label font-color-extra-light-gray font-size--24">收件地址</span>
                <div class="item-cont font-color-white font-size--28">{{addressPickedDetail}}</div>
              </div>
              <i class="jfk-font icon-user_icon_jump_normal font-color-extra-light-gray font-size--24 list-icon"></i>
            </div>
            <div class="lace"></div>
          </div>
        </div>
      </div>
      <div class="product-info jfk-ml-30 jfk-mr-30">
        <i class="color-golden gap-line"></i>
        <div class="name font-color-white font-size--38">{{productInfo.name}}</div>
        <div class="product-other font-size--24" v-once v-html="packageInfoHtml"></div>
        <div class="price">
          <span class="jfk-price product-price-package color-golden-price font-size--54">
            <i class="jfk-font-number jfk-price__currency" v-if="!isIntegral">￥</i>
            <i class="jfk-font-number jfk-price__number">{{productInfo.price_package}}</i>
          </span>
        </div>
      </div>
      <div class="mail-gift jfk-ml-30 jfk-mr-30 font-size--28" v-if="addressPosition === 3">
        <p class="use-type-tip font-size--24 font-color-light-gray-common">使用方式</p>
        <div class="item item-address card jfk-mb-30" :class="{'is-checked': useType === '1', 'font-color-light-gray-common no-checked': useType === '2'}">
          <div :class="{'font-color-white': useType === '1'}" class="title jfk-flex is-align-middle" @click="handleChangeUseType('1')">
            <div class="jfk-flex cont is-justify-space-between">
              <span>
                <i class="jfk-font icon-mall_icon_orderDetail_post icon" :class="{'color-golden': useType === '1'}"></i>直接邮寄</span>
              <span class="jfk-radio jfk-radio--shape-circle color-golden">
                <label class="jfk-radio__label">
                  <input type="radio" name="type" :checked="useType === '1'" value="1" v-model="useType" />
                  <span class="jfk-radio__icon">
                    <i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i>
                  </span>
                </label>
              </span>
            </div>
          </div>
          <transition name="fade">
            <div v-show="useType === '1'" class="address body tip" @click="handleChangeAddress">
              <div class="add-box" v-if="addressId === '-1'">
                <div class="add font-color-extra-light-gray font-size--28 jfk-flex is-align-middle is-justify-center">
                  <div class="cont">
                    <i class="icon color-golden jfk-font icon-mall_icon_address_add"></i>新增收货地址
                  </div>
                </div>
              </div>
              <div class="list jfk-flex is-align-middle" v-else>
                <div class="cont">
                  <div class="list-item">
                    <span class="label font-size--24 font-color-extra-light-gray label--word-3">收件人</span>
                    <div class="item-cont font-size--28 font-color-white">
                      <span class="contact">{{addressPicked.contact}}</span>
                      <span class="phone">{{addressPicked.phone}}</span>
                    </div>
                  </div>
                  <div class="list-item">
                    <span class="label font-size--24 font-color-extra-light-gray">收件地址</span>
                    <div class="item-cont font-size--28 font-color-white">{{addressPickedDetail}}</div>
                  </div>
                  <i class="jfk-font icon-user_icon_jump_normal font-color-extra-light-gray font-size--24 list-icon"></i>
                </div>
              </div>
            </div>
          </transition>
        </div>
        <div class="item item-gift card" :class="{'is-checked': useType === '2', 'font-color-light-gray-common  no-checked': useType === '1'}">
          <div :class="{'font-color-white': useType === '2'}" class="title jfk-flex is-align-middle" @click="handleChangeUseType('2')">
            <div class="jfk-flex cont is-justify-space-between">
              <span>
                <i class="jfk-font icon-mall_icon_orderDetai_gift icon" :class="{'color-golden': useType === '2'}"></i>赠送他人</span>
              <span class="jfk-radio jfk-radio--shape-circle color-golden">
                <label class="jfk-radio__label">
                  <input type="radio" name="type" value="2" :checked="useType === '2'" v-model="useType" />
                  <span class="jfk-radio__icon">
                    <i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i>
                  </span>
                </label>
              </span>
            </div>
          </div>
          <transition name="fade">
            <div class="tip jfk-flex is-align-middle jfk-pr-30 font-color-light-gray-common body font-size--24" v-show="useType === '2'">
              <div class="box jfk-pos-r">
                <i class="jfk-font font-size--28 tip-icon icon-msg_icon_prompt_1_default"></i>下单后，购买成功，将礼物打包赠转发给好友，好友点击即可成功领取
              </div>
            </div>
          </transition>
        </div>
      </div>
      <div class="order-info jfk-pl-30 jfk-pr-30">
        <form class="jfk-form font-size--28">
          <!-- 只赠送他人不显示 <div class="form-item gift-only" v-if="addressPosition === 2">
            <span class="form-item__label font-color-extra-light-gray">使用方式</span>
            <div class="form-item__body">
              <span @click="handleShowGiftTip">
                <i class="jfk-d-ib font-color-white">赠送他人</i>
                <i class="jfk-font font-size--28 font-color-light-gray gift-icon icon-booking_icon_question_normal"></i>
              </span>
            </div>
          </div> -->
          <div class="form-item">
            <span class="form-item__label font-color-extra-light-gray">购买数量</span>
            <div class="form-item__body jfk-ta-r">
              <div class="count jfk-d-ib font-size--32">
                <jfk-input-number v-model="count" :min="min" :max="max"></jfk-input-number>
              </div>
            </div>
          </div>
          <div class="form-item">
            <label>
              <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">购买人</span>
              <div class="form-item__body">
                <input type="text" class="font-color-white" v-model="customerInfo.name" placeholder="请输入购买人" />
                <div class="form-item__status is-error" v-show="validResult.name.show" @click="handleHiddenError('name')">
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
            <span class="form-item__label  font-color-extra-light-gray">联系方式</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" v-model="customerInfo.phone" placeholder="请输入购买人手机" />
              <div class="form-item__status is-error" v-show="validResult.phone.show" @click="handleHiddenError('phone')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                    <i class="form-item__status-cont">{{validResult.phone.message}}</i>
                    <i class="form-item__status-trigger">重新输入</i>
                  </span>
              </div>
            </div>
          </div>
          <div class="form-item form-item__select" v-if="!couponDisabled">
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">优惠券</span>
            <div @click="handleShowCoupons">
              <div class="form-item__body">
                <p class="tip" :class="couponsClass">{{couponsText}}</p>
              </div>
              <span class="form-item__foot" v-show="coupons.length && !(this.orderRulePicked && this.orderRule.rule_type)">
                <i class="jfk-font icon-user_icon_jump_normal font-color-extra-light-gray"></i>
              </span>
            </div>
          </div>
          <div class="form-item" v-if="!orderRuleDisabled" :class="{'form-item__switch': packageActivityShowSwitch}">
            <span class="form-item__label  font-color-extra-light-gray">优惠活动</span>
            <div class="form-item__body">
              <p class="tip" :class="activityClass">{{activityText}}</p>
            </div>
            <div class="form-item__foot" v-show="packageActivityShowSwitch">
              <label class="jfk-switch color-golden font-size--30">
                <input type="checkbox" v-model="packageActivityChecked" class="jfk-switch__input" />
                <span class="jfk-switch__core"></span>
              </label>
            </div>
          </div>
          <div class="form-item">
            <span class="form-item__label  font-color-extra-light-gray">支付方式</span>
            <div class="form-item__body">
              <p class="tip font-color-white">{{payTypeText}}</p>
            </div>
          </div>
        </form>
      </div>
      <div class="reserve-tip font-size--24 jfk-pl-30 jfk-pr-30">
        <div class="tip-title font-color-extra-light-gray-common"><i class="jfk-font icon-msg_icon_prompt_default font-size--28"></i>说明</div>
        <div class="tip-cont font-color-light-gray-common">商品超过有效期不能使用也不能退款</div>
      </div>
      <footer class="footer jfk-footer jfk-clearfix" :style="{'z-index': footZIndex}">
        <div class="order-detail jfk-fl-l" :class="{'is-open': priceOrderVisible}" @click="handleShowOrderDetail">
          <span class="price color-golden-price">
            <i class="price__currency font-size--24" v-if="!isIntegral">¥</i>
            <i class="price__number font-size--48">{{priceWithDiscount}}</i>
          </span>
          <span class="detail font-size--24 font-color-extra-light-gray" v-show="priceDiscountItem.name">
            明细
          </span>
        </div>
        <div class="control jfk-fl-l">
          <button href="javascript:;" @click="handleSubmitOrder" class="jfk-button font-size--34 jfk-button--higher jfk-button--suspension jfk-button--free">
            <span class="jfk-button__text">
              <i class="jfk-font jfk-button__text-item icon-font_zh_li_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_ji_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_zhi_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_fu_qkbys"></i>
            </span>
          </button>
        </div>
      </footer>
    </div>
    <jfk-support></jfk-support>
    <template v-if="addressPosition === 1 || addressPosition === 3">
      <div class="page-address" v-show="addressLayerVisible">
        <div class="jfk-pages__theme"></div>
        <jfk-address :address.sync="address" :show-address-list="showAddressList" :addressId="addressId" @pick-address="handlePickedAddress"></jfk-address>
      </div>
    </template>
    <template>
      <div class="page-coupons"  v-show="couponLayerVisible">
        <div class="jfk-pages__theme"></div>
        <jfk-coupons :items="coupons" :couponId="couponId" @coupon-picked="handlePickedCoupon"></jfk-coupons>
      </div>
    </template>
    <jfk-popup
      class="jfk-popup__price-detail"
      position="bottom"
      modal-class="jfk-modal__price-detail"
      do-after-close="doAfterClose"
      v-model="priceOrderVisible">
      <div class="price-detail-box">
        <div class="price-detail-item item-price jfk-flex is-justify-space-between">
          <span class="font-size--28 font-color-extra-light-gray price-detail-label">微信价</span>
          <span class="font-size--30 color-golden-price"><i v-if="!isIntegral">¥</i>{{pricePackage}}</span>
        </div>
        <div class="price-detail-item item-discount jfk-flex is-justify-space-between">
          <span class="font-size--28 font-color-extra-light-gray price-detail-label">{{priceDiscountItem.name}}</span>
          <span class="font-size--30 color-golden-price">- <i v-if="!isIntegral">¥</i>{{priceDiscountItem.price}}</span>
        </div>
      </div>
    </jfk-popup>
  </div>
</template>
<script>
  /* eslint-disable camelcase */
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { accSub, accMul, accDiv } from 'jfk-ui/lib/arithmetic.js'
  import validator from 'jfk-ui/lib/validator.js'
  import { showFullLayer, findIndex } from '@/utils/utils'
  import handleErrorStatus from '@/utils/handleErrorStatus'
  import axios from 'axios'
  import { getOrderPay, getPackageCoupons, getPackageRule, postOrderCreate } from '@/service/http'
  import JfkCoupons from './module/coupon.vue'
  /* eslint-disable no-new */
  const formatOrderRule = function (data) {
    const { activity = {}, asset = {} } = data
    if (activity.auto_rule.rule_type) {
      return activity.auto_rule
    } else if (asset.cal_rule.rule_type) {
      return asset.cal_rule
    }
    return null
  }
  const CancelToken = axios.CancelToken
  let cancel
  export default {
    name: 'reverse',
    components: {
      'reverse-killsec-time': () => import('./module/killsec'),
      'jfk-address': () => import('../../components/address/main'),
      JfkCoupons
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      this.common = params.common || ''
      this.tokenId = params.token || ''
      this.productId = params.pid
      this.settingId = params.psp_id || ''
      this.act_id = params.act_id || ''
      this.inid = params.inid || ''
      this.grid = params.grid || ''
      this.gridType = params.grid_type || ''
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      this.$pageNamespace(params)
    },
    created () {
      let vm = this
      // 获取订单信息
      getOrderPay({
        pid: this.productId,
        btype: this.orderParams.business,
        psp_id: this.settingId,
        token: this.tokenId,
        common: this.common
      }).then(function (res) {
        vm.toast.close()
        const { count, psp_setting, product, countdown, address, public_info, customer_info = {}, create_order_params = {}, point, balance } = res.web_data
        vm.count = count.default
        vm.max = count.limit
        vm.pspSetting = psp_setting
        vm.point = point
        vm.balance = Object.assign({}, vm.balance, balance)
        // 倒计时5分钟
        vm.countdown = countdown * 1000
        vm.orderParams = Object.assign({}, vm.orderParams, create_order_params)
        if (address.length) {
          vm.address = address
          vm.addressId = address[0].address_id
        }
        vm.productInfo = Object.assign({}, vm.productInfo, product)
        vm.publicInfo = Object.assign({}, vm.publicInfo, public_info)
        vm.customerInfo = Object.assign({}, vm.customerInfo, {
          name: customer_info.name || '',
          phone: customer_info.mobile || ''
        })
      })
    },
    data: function () {
      const areaValidatorRequired = () => {
        if (this.addressPosition === 1 || (this.addressPosition === 3 && this.useType === '1')) {
          return this.addressId !== '-1'
        }
        return true
      }
      const areaValidator = () => {
        if (this.addressPosition === 1 || (this.addressPosition === 3 && this.useType === '1')) {
          let d = this.addressPicked
          return d.province && d.city && d.address && d.contact && d.phone && d.address
        }
        return true
      }
      const qtyValidator = () => {
        return this.count >= this.min && this.count <= this.max
      }
      return {
        isIntegral: false,
        // 使用方式 1 邮寄  2 赠送
        useType: '1',
        // 商品信息
        productInfo: {},
        // 公众号信息
        publicInfo: {},
        // 用户信息
        customerInfo: {
          name: '',
          phone: ''
        },
        // 多规格
        pspSetting: [],
        // 地址相关
        address: [],
        addressId: '-1',
        addressPosition: 0,
        showAddressList: 0,
        addressLayerVisible: false,
        // 订单数量相关
        min: 1,
        max: 200,
        count: 0,
        // 倒计时
        countdown: 0,
        // 倒计时是否已完成
        killsecFinished: false,
        // 可用积分
        point: 0,
        // 储值信息
        balance: {},
        // 优惠券相关
        coupons: [],
        couponId: '-1',
        couponDisabled: false,
        couponLayerVisible: false,
        // 优惠活动相关
        orderRule: {},
        orderRulePicked: false,
        orderRuleDisabled: false,
        // 最后一次获取优惠的时间戳
        lastGetDiscountTimestamp: Date.now(),
        // 储值抵扣 积分抵扣是否开启
        packageActivityChecked: true,
        // 价格详情
        priceOrderVisible: false,
        // 下单时一些参数
        orderParams: {},
        // 表单规则
        rules: {
          qty: [{
            required: true, type: 'number', message: '请选择购买数量'
          }, {
            type: 'number', validator: qtyValidator, message: '购买数量有误'
          }],
          name: [{
            required: true, message: '购买人为空'
          }, {
            max: 10, length: true, message: '购买人必须在10个字符内'
          }],
          phone: [{
            required: true, message: '联系方式为空'
          }, {
            type: 'phone', message: '手机号码错误'
          }],
          area: [{
            validator: areaValidatorRequired, message: '收件地址为空'
          }, {
            validator: areaValidator, message: '收件地址信息错误'
          }]
        },
        validResult: {
          name: {
            passed: false,
            message: ''
          },
          phone: {
            passed: false,
            message: ''
          },
          area: {
            passed: false,
            message: ''
          }
        },
        footZIndex: 1000
      }
    },
    computed: {
      // 支付方式文案
      payTypeText () {
        let tag = this.productInfo.tag
        if (tag === 7) {
          return '积分支付'
        } else if (tag === 6) {
          return '储值支付'
        }
        return '微信支付'
      },
      // 已选择地址
      addressPicked () {
        const { address, addressId } = this
        let idx = findIndex(address, function (o) {
          return o.address_id === addressId
        })
        return address[idx] || {}
      },
      // 已选择详情
      addressPickedDetail () {
        const { provice_name = '', city_name = '', region_name = '', address = '' } = this.addressPicked
        return provice_name + city_name + region_name + address
      },
      // 商品信息片段
      packageInfoHtml () {
        let limit = ''
        let result = ''
        // 如果是默认200，则不显示
        if (this.max !== 200) {
          limit = '<span class="jfk-d-ib color-golden limit-tag font-size--22"><i>限购' + this.max + '份</i></span>'
        }
        if (this.publicInfo.name) {
          result = '<div class="provide' + (limit && ' limit' || '') + '"><span class="jfk-d-ib font-color-light-gray-common">' + this.publicInfo.name + '提供</span>' + (limit || '') + '</div>'
        }
        if (this.pspSetting.length) {
          result += '<div class="spec' + (!result && limit && ' limit' || '') + '"><span class="font-color-light-gray-common jfk-d-ib">' + this.pspSetting[0].spec_name.join('<i class="line">|</i>') + '</span>' + (!result && limit || '') + '</div>'
        }
        if (!result && limit) {
          result += '<div class="limit">' + limit + '</div>'
        }
        return result
      },
      // 优惠券类名
      couponsClass () {
        return {
          'font-color-light-gray': this.couponId === '-1',
          'font-color-white': this.couponId !== '-1'
        }
      },
      // 优惠券文案
      couponsText () {
        if (this.couponDisabled) {
          return '暂无可用优惠券'
        } else if (this.orderRulePicked && this.orderRule.rule_type) {
          return '不与优惠活动同享'
        } else if (this.coupons.length) {
          if (this.couponId !== '-1') {
            return this.couponPicked.title
          } else if (this.coupons[0].usable) {
            return '请选择优惠券'
          }
          return '暂无可用优惠券'
        } else {
          return '暂无可用优惠券'
        }
      },
      // 选中的优惠券
      couponPicked () {
        const { couponId, coupons } = this
        if (couponId !== '-1') {
          let index = findIndex(coupons, function (o) {
            return o.member_card_id === couponId
          })
          return coupons[index] || {}
        }
        return {}
      },
      // 优惠活动类名
      activityClass () {
        return {
          'font-color-light-gray': !this.orderRulePicked,
          'font-color-white': this.orderRulePicked
        }
      },
      // 优惠活动文案
      activityText () {
        let r = this.orderRule
        if (r.rule_type) {
          if (this.orderRulePicked) {
            return r.name
          }
          return '请选择优惠活动'
        } else {
          return '暂无优惠活动'
        }
      },
      // 储值抵扣与积分抵扣能否关闭
      packageActivityShowSwitch () {
        const ruleType = this.orderRule.rule_type
        if (ruleType === '30' || ruleType === '40') {
          return true
        }
        return false
      },
      // 原价
      pricePackage () {
        return accMul(this.productInfo.price_package, this.count)
      },
      // 优惠后的价格
      priceWithDiscount () {
        let price = accSub(this.pricePackage, this.priceDiscountItem.price)
        return price < 0 ? (this.priceDiscountItem.canZero ? 0 : 0.01) : price
      },
      // 优惠的情况
      priceDiscountItem () {
        let price = 0
        let name = ''
        let canZero = true
        let o = this.orderRule
        let c = this.couponPicked
        if (o.rule_type && this.packageActivityChecked) {
          price = o.reduce_cost
          name = o.name
        } else if (c.member_card_id) {
          // 抵扣券
          if (c.card_type === '1') {
            price = c.reduce_cost
          } else if (c.card_type === '2') {
            // 折扣券
            price = Number(accMul(accMul(this.productInfo.price_package, this.count), accDiv(10 - c.discount, 10)).toFixed(2))
            canZero = false
          } else if (c.card_type === '3') {
            // 兑换券，只能兑换一个商品
            price = this.productInfo.price_package
          }
          name = c.title
        }
        console.log(price)
        return {
          name,
          price,
          canZero
        }
      }
    },
    methods: {
      // 恢复底部层级
      doAfterClose () {
        this.footZIndex = 1000
      },
      // 切换使用方式
      handleChangeUseType (val) {
        this.useType = val
      },
      handleKillsecFinish () {
        this.killsecFinished = true
      },
      // 切换地址
      handleChangeAddress () {
        this.addressLayerVisible = true
        // 强制渲染地址列表列表
        this.showAddressList = Date.now()
        const cb = () => {
          this.addressLayerVisible = false
        }
        showFullLayer(null, '立即购买', location.href, cb)
      },
      handlePickedAddress (aid) {
        this.addressId = aid
        history.back(-1)
      },
      // 弹框显示赠送说明
      handleShowGiftTip () {
        this.$jfkAlert('下单后，购买成功，将礼物打包赠转发给好友，好友点击即可成功领取')
      },
      // 显示优惠券弹层
      handleShowCoupons () {
        if (this.couponDisabled) {
          return
        }
        // 如果有优惠活动存在，优惠券不可选
        if (!this.orderRule.rule_type && this.coupons.length) {
          this.couponLayerVisible = true
          const cb = () => {
            this.couponLayerVisible = false
          }
          showFullLayer(null, '立即购买', location.href, cb)
        }
      },
      // 选择完成优惠券
      handlePickedCoupon (val) {
        this.couponId = val
        if (val !== '-1') {
          history.back(-1)
        }
      },
      // 显示价格明细
      handleShowOrderDetail () {
        if (this.priceDiscountItem.name) {
          if (!this.priceOrderVisible) {
            this.footZIndex = 99999
          }
          this.priceOrderVisible = !this.priceOrderVisible
        }
      },
      // 获取优惠券
      getCoupons () {
        let vm = this
        vm.coupons = []
        vm.couponId = '-1'
        getPackageCoupons({
          pid: this.productId,
          qty: this.count,
          card_type: -1
        }, {
          cancelToken: new CancelToken(function executor (c) {
            cancel = c
          })
        }).then(function (res) {
          vm.lastGetDiscountTimestamp = Date.now()
          vm.coupons = res.web_data || []
        }).catch(function () {
          vm.lastGetDiscountTimestamp = Date.now()
          vm.coupons = []
        })
      },
      // 获取优惠活动
      getActivities () {
        let vm = this
        // 请求前先置空数据
        vm.$set(vm, 'orderRule', {})
        vm.orderRulePicked = false
        getPackageRule({
          pid: this.productId,
          qty: this.count,
          stl: this.orderParams.settlement,
          psp_sid: this.settingId
        }, {
          cancelToken: new CancelToken(function executor (c) {
            cancel = c
          })
        }).then(function (res) {
          vm.lastGetDiscountTimestamp = Date.now()
          let rule = formatOrderRule(res.web_data)
          if (rule) {
            vm.orderRule = Object.assign({}, vm.orderRule, rule)
          } else {
            vm.$set(vm, 'orderRule', {})
          }
        }).catch(function () {
          vm.lastGetDiscountTimestamp = Date.now()
          vm.$set(vm, 'orderRule', {})
        })
      },
      // 同时获取优惠活动及优惠券
      getPackageDiscount () {
        let vm = this
        let cc = new CancelToken(function executor (c) {
          cancel = c
        })
        vm.coupons = []
        vm.$set(vm, 'orderRule', {})
        vm.orderRulePicked = false
        vm.couponId = '-1'
        axios.all([
          getPackageCoupons({
            pid: this.productId,
            qty: this.count,
            card_type: -1
          }, {
            cancelToken: cc
          }),
          getPackageRule({
            pid: this.productId,
            qty: this.count,
            stl: 'default',
            psp_sid: this.settingId
          }, {
            cancelToken: cc
          })
        ]).then(axios.spread(function (coupons, rule) {
          vm.lastGetDiscountTimestamp = Date.now()
          if (coupons.status === 1000) {
            vm.coupons = coupons.web_data
          } else {
            vm.coupons = []
          }
          if (rule.status === 1000) {
            let _rule = formatOrderRule(rule.web_data)
            if (_rule) {
              vm.orderRule = Object.assign({}, vm.orderRule, _rule)
              return
            }
          }
          vm.$set(vm, 'orderRule', {})
        })).catch(function (err) {
          vm.lastGetDiscountTimestamp = Date.now()
          vm.coupons = []
          vm.$set(vm, 'orderRule', {})
          return handleErrorStatus(err)
        })
      },
      getFormItemVal (key) {
        switch (key) {
          case 'qty':
            return this.count
          case 'name':
            return this.customerInfo.name
          case 'phone':
            return this.customerInfo.phone
          case 'area':
            return this.addressId
          default:
            return ''
        }
      },
      getOrderParams () {
        let pid = this.productInfo.product_id
        let params = {
          product_id: pid,
          qty: this.count,
          act_id: this.act_id,
          inid: this.inid,
          token: this.tokenId,
          grid: this.grid,
          type: this.gridType,
          password: '',
          bpay_passwd: '',
          address_id: '',
          u_type: '-1',
          scope_product_link_id: '',
          quote: '',
          quote_type: '',
          mcid: this.couponId === '-1' ? '' : this.couponId,
          psp_setting: this.settingId
        }
        if (this.useType === '1' && this.addressId !== '-1') {
          params.address_id = this.addressId
        }
        if (this.packageActivityShowSwitch && this.packageActivityChecked) {
          params.quote = this.orderRule.quote
          params.quote_type = this.orderRule.rule_type
        }
        return Object.assign({}, this.orderParams, params, this.customerInfo)
      },
      checkForm () {
        let passed = true
        let rules = this.rules
        let vm = this
        for (let i in rules) {
          let r = validator(vm.getFormItemVal(i), rules[i])
          vm.validResult = Object.assign({}, vm.validResult, {
            [i]: {
              ...r,
              show: !r.passed
            }
          })
          if (!r.passed) {
            passed = false
            // 不监测validResult的变化
            if (i === 'area') {
              vm.$jfkAlert('邮寄地址错误', '', {
                iconType: 'error'
              })
            }
          }
        }
        return passed
      },
      handleHiddenError (type) {
        this.validResult = Object.assign({}, this.validResult, {
          [type]: {
            show: false
          }
        })
      },
      // 提交订单
      handleSubmitOrder () {
        if (this.priceOrderVisible) {
          this.priceOrderVisible = false
          this.footZIndex = 1000
        }
        if (this.killsecFinished) {
          this.$jfkAlert('已超过支付时间，请重新购买', '', {
            iconType: 'error'
          })
          return
        }
        if (this.productInfo.tag === 6 && this.priceWithDiscount > Number(this.balance.money)) {
          this.$jfkAlert('储值不足', '', {
            iconType: 'error'
          })
          return
        } else if (this.productInfo.tag === 7 && this.priceWithDiscount > Number(this.point)) {
          this.$jfkAlert('积分不足', '', {
            iconType: 'error'
          })
          return
        }

        let passed = this.checkForm()
        if (passed) {
          let submitToast = this.$jfkToast({
            isLoading: true,
            iconClass: 'jfk-loading__snake',
            duration: -1
          })
          let params = this.getOrderParams()
          postOrderCreate(params).then(function (res) {
            submitToast.close()
            if (process.env.NODE_ENV === 'development') {
              return alert('下单成功')
            }
            let payLink = res.web_data.page_resource.link.wx_pay
            location.href = payLink
          }).catch(function () {
            submitToast.close()
          })
        }
      }
    },
    watch: {
      productInfo (val) {
        const { tag, can_gift, can_mail } = val
        // 专属 秒杀 积分 不使用优惠券，不参加优惠活动 储值不参加优惠活动，能使用优惠券
        if (tag === 1 || tag === 2 || tag === 7) {
          this.orderRuleDisabled = true
          this.couponDisabled = true
        }
        if (tag === 6) {
          this.orderRuleDisabled = true
        }
        if (tag === 7) {
          this.isIntegral = true
        }
        // 1邮寄 2 赠送 3 邮寄赠送
        let pos = 0
        if (can_mail === '1') {
          pos = 1
        }
        if (can_gift === '1') {
          pos += 2
        }
        if (pos === 1) {
          this.useType = '1'
        } else if (pos === 2) {
          this.useType = '2'
        }
        this.addressPosition = pos
      },
      count (val) {
        if (val) {
          const { orderRuleDisabled, couponDisabled } = this
          if (cancel) {
            cancel()
          }
          if (orderRuleDisabled && couponDisabled) {
            return
          } else if (couponDisabled) {
            this.getActivities()
          } else if (orderRuleDisabled) {
            this.getCoupons()
          } else {
            this.getPackageDiscount()
          }
        }
      },
      lastGetDiscountTimestamp (val) {
        if (this.orderRule.rule_type) {
          this.orderRulePicked = true
          this.couponId = '-1'
        } else if (this.coupons.length) {
          let firstCoupon = this.coupons[0]
          if (firstCoupon.usable) {
            this.couponId = firstCoupon.member_card_id
          }
          this.orderRulePicked = false
        } else {
          this.couponId = '-1'
          this.orderRulePicked = false
        }
      }
    }
  }
</script>
