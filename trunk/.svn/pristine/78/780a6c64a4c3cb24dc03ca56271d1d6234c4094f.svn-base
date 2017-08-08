<template>
  <div class="jfk-pages jfk-pages__reserve">
    <div class="jfk-pages__theme"></div>
    <div class="reserve-box" v-if="productInfo.product_id">
      <reverse-killsec-time :end="countdown" v-if="productInfo.tag === 2 && tokenId"></reverse-killsec-time>
      <div class="mail-only jfk-pt-30 jfk-pl-30 jfk-pr-30" v-if="addressPosition === 1">
        <div class="address card">
          <div class="add jfk-flex is-align-middle is-justify-center font-size--28 font-color-extra-light-gray" v-if="addressId === '-1'">
            <span class="cont">
              <i class="icon color-golden">+</i>新增收货地址
            </span>
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
        <div class="name font-color-white font-size--38">{{productInfo.name}}</div>
        <div class="product-other font-size--24" v-once v-html="productOtherHtml"></div>
        <div class="price">
          <span class="jfk-price product-price-package color-golden font-size--54">
            <i class="jfk-font-number jfk-price__currency" v-if="productInfo.tag !== 7">￥</i>
            <i class="jfk-font-number jfk-price__number">{{productInfo.price_package}}</i>
          </span>
        </div>
      </div>
      <div class="mail-gift jfk-ml-30 jfk-mr-30 font-size--28" v-if="addressPosition === 3">
        <p class="use-type-tip font-size--24 font-color-light-gray">使用方式</p>
        <div class="item item-address card jfk-mb-30" :class="{'is-checked': useType === '1', 'font-color-light-gray': useType === '2'}">
          <div :class="{'font-color-white': useType === '1'}" class="title jfk-flex is-align-middle" @click="handleChangeUseType('1')">
            <div class="jfk-flex cont is-justify-space-between">
            <span><i class="jfk-font icon-mall_icon_orderDetail_post icon" :class="{'color-golden': useType === '1'}"></i>直接邮寄</span>
            <span class="jfk-radio jfk-radio--shape-circle color-golden">
              <label class="jfk-radio__label">
                <input type="radio" name="type" :checked="useType === '1'" value="1" v-model="useType"/>
                <span class="jfk-radio__icon"><i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i></span>
              </label>
            </span>
            </div>
          </div>
          <transition name="fade">
          <div v-show="useType === '1'" class="address body tip" @click="handleChangeAddress">
            <div class="add font-color-extra-light-gray font-size--28 jfk-flex is-align-middle is-justify-center" v-if="addressId === '-1'">
              <span class="cont">
                <i class="icon color-golden">+</i>新增收货地址
              </span>
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
        <div class="item item-gift card" :class="{'is-checked': useType === '2', 'font-color-light-gray': useType === '1'}">
          <div :class="{'font-color-white': useType === '2'}" class="title jfk-flex is-align-middle" @click="handleChangeUseType('2')">
            <div class="jfk-flex cont is-justify-space-between">
              <span><i class="jfk-font icon-user_icon_Polite_nor icon" :class="{'color-golden': useType === '2'}"></i>赠送他人</span>
              <span class="jfk-radio jfk-radio--shape-circle color-golden">
                <label class="jfk-radio__label">
                  <input type="radio" name="type" value="2" :checked="useType === '2'" v-model="useType"/>
                  <span class="jfk-radio__icon"><i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i></span>
                </label>
              </span>
            </div>
          </div>
          <transition name="fade">
          <div class="tip jfk-flex is-align-middle jfk-pr-30 font-color-light-gray body font-size--24" v-show="useType === '2'">
            <div class="box jfk-pos-r">
            <i class="tip-icon font-size--22">?</i>下单后，购买成功，将礼物打包赠转发给好友，好友点击即可成功领取
            </div>
          </div>
          </transition>
        </div>
      </div>
      <div class="order-info jfk-pl-30 jfk-pr-30">
        <form class="jfk-form font-size--28">
          <div class="form-item gift-only" v-if="addressPosition === 2">
            <span class="form-item__label font-color-extra-light-gray">使用方式</span>
            <div class="form-item__body">
              <span @click="handleShowGiftOnly">
              <i class="jfk-d-ib font-color-white">赠送他人</i><i class="gift-icon font-size--22 font-color-extra-light-gray jfk-d-ib">?</i>
              </span>
            </div>
          </div>
          <div class="form-item">
            <span class="form-item__label font-color-extra-light-gray">购买数量</span>
            <div class="form-item__body jfk-ta-r">
              <div class="count jfk-d-ib font-size--32">
                <jfk-input-number v-model="count.default" :min="count.min" :max="count.limit"></jfk-input-number>
              </div>
            </div>
          </div>
          <div class="form-item">
            <label>
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">购买人</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" v-model="formItems.name.valule" placeholder="请输入购买人"/>
            </div>
            <div class="form-item__validator">
              <p class="form-item__validator-tip font-color-light-gray">姓名为空，请输入真实姓名</p>
            </div>
            </label>
          </div>
          <div class="form-item">
            <span class="form-item__label  font-color-extra-light-gray">联系方式</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" v-model="formItems.phone.value" placeholder="请输入购买人手机"/>
            </div>
          </div>
          <div class="form-item form-item__select">
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">优惠券</span>
            <div class="form-item__body">
              <p class="tip">请选择优惠券</p>
            </div>
            <span class="form-item__foot"><i class="jfk-font icon-user_icon_jump_normal"></i></span>
          </div>
          <div class="form-item form-item__switch">
            <span class="form-item__label  font-color-extra-light-gray">优惠活动</span>
            <div class="form-item__body"></div>
            <div class="form-item__foot">
              <label class="jfk-switch color-golden font-size--30">
                <input type="checkbox" class="jfk-switch__input"/>
                <span class="jfk-switch__core"></span>
              </label>
            </div>
          </div>
          <div class="form-item">
            <span class="form-item__label  font-color-extra-light-gray">支付方式</span>
            <div class="form-item__body"></div>
          </div>
        </form>
      </div>
      <footer class="footer jfk-clearfix">
        <div class="order-detail jfk-fl-l">
          <span class="price color-golden">
            <i class="price__currency font-size--24">¥</i>
            <i class="price__number font-size--48">{{pricePackage}}</i>
          </span>
          <span class="detail font-size--24 font-color-extra-light-gray">
            明细
          </span>
        </div>
        <div class="control jfk-fl-l">
          <button href="javascript:;" class="jfk-button font-size--34 jfk-button--higher jfk-button--free jfk-button--primary" v-html="buttonText"></button>
        </div>
      </footer>
    </div>
    <template v-if="addressPosition === 1 || addressPosition === 3">
    <div class="page-address" v-show="addressLayerVisible">
      <div class="jfk-pages__theme"></div>
      <jfk-address :address.sync="address" :show-address-list="showAddressList" :addressId="addressId" @pick-address="handlePickAddress"></jfk-address>
    </div>
    </template>
  </div>
</template>
<script>
  /* eslint-disable camelcase */
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getOrderPay } from '@/service/http'
  export default {
    name: 'reverse',
    components: {
      'reverse-killsec-time': () => import('./module/killsec'),
      'jfk-address': () => import('../../components/address/main')
    },
    data: function () {
      const qtyValidator = (val) => {
        return val > this.count.min && val < this.count.limit
      }
      const nameValidator = (val) => {
        return val && val.length < 10
      }
      const phoneValidator = (val) => {
        return val && /^1(\d){10}$/.test(val)
      }
      return {
        productInfo: {},
        count: {
          min: 1
        },
        start: Date.now(),
        pspSetting: [],
        publicInfo: {},
        address: {},
        addressId: '-1',
        addressLayerVisible: false,
        showAddressList: 0,
        countdown: 0,
        formItems: {
          qty: {
            value: 1,
            label: '数量',
            validator: qtyValidator
          },
          name: {
            value: '',
            label: '购买人',
            validator: nameValidator
          },
          phone: {
            value: '',
            label: '联系方式',
            validator: phoneValidator
          },
          coupon: {
            value: '',
            label: '优惠券',
            show: false
          },
          activity: {
            value: '',
            label: '优惠活动',
            show: false
          },
          payType: {
            value: '',
            label: '支付方式'
          }
        },
        // 使用方式 1 邮寄  2 赠送
        useType: '1'
      }
    },
    computed: {
      buttonText () {
        return '立即支付'
      },
      pricePackage () {
        return 0.01
      },
      // 地址显示位置 0 无邮寄无赠送 1 只邮寄  2 只赠送 3 能邮寄能赠送
      addressPosition () {
        const { can_mail, can_gift } = this.productInfo
        let pos = 0
        if (can_mail === '1') {
          pos = 1
        }
        if (can_gift === '1') {
          pos += 2
        }
        return pos
      },
      addressPicked () {
        const { address, addressId } = this
        let result = address.filter(function (d) {
          return d.address_id === addressId
        })
        return result[0]
      },
      addressPickedDetail () {
        const { provice_name = '', city_name = '', region_name = '', address = '' } = this.addressPicked
        return provice_name + city_name + region_name + address
      },
      productOtherHtml () {
        let limit = ''
        let result = ''
        // 如果是默认200，则不显示
        if (this.count.limit !== 200) {
          limit = '<span class="jfk-d-ib color-golden limit-tag font-size--22"><i>限购' + this.count.limit + '份</i></span>'
        }
        if (this.publicInfo.name) {
          result = '<div class="provide' + (limit && ' limit' || '') + '"><span class="jfk-d-ib font-color-light-gray">' + this.publicInfo.name + '提供</span>' + (limit || '') + '</div>'
        }
        if (this.pspSetting.length) {
          result += '<div class="spec' + (!result && limit && ' limit' || '') + '"><span class="font-color-light-gray jfk-d-ib">' + this.pspSetting[0].spec_name.join('<i class="line">|</i>') + '</span>' + (!result && limit || '') + '</div>'
        }
        if (!result && limit) {
          result += '<div class="limit">' + limit + '</div>'
        }
        return result
      }
    },
    methods: {
      handleChangeUseType (val) {
        this.useType = val
      },
      handlePickAddress (aid) {
        this.addressId = aid
        this.addressLayerVisible = false
      },
      handleShowGiftOnly () {
        this.$jfkAlert('下单后，购买成功，将礼物打包赠转发给好友，好友点击即可成功领取')
      },
      handleChangeAddress () {
        this.addressLayerVisible = true
        this.showAddressList = Date.now()
        let that = this
        window.history.pushState({t: Date.now()}, '立即购买', location.href)
        window.addEventListener('popstate', function () {
          setTimeout(function () {
            that.addressLayerVisible = false
          }, 100)
        })
      }
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      this.tokenId = params.token
      this.productId = params.pid
      this.settingId = params.psp_id
      this.btype = params.btype || ''
    },
    created () {
      let that = this
      getOrderPay({
        pid: this.productId,
        btype: this.btype,
        psp_id: this.settingId,
        token: this.tokenId
      }).then(function (res) {
        const { count, psp_setting, product, countdown, address, public_info } = res.web_data
        that.count = Object.assign({}, that.count, count)
        that.pspSetting = psp_setting
        that.countdown = countdown * 1000
        if (address.length) {
          that.address = address
          that.addressId = address[0].address_id
        }
        that.productInfo = Object.assign({}, that.productInfo, product)
        that.publicInfo = Object.assign({}, that.publicInfo, public_info)
      })
    }
  }
</script>
<style>
  .number {
    padding: 50px;
  }
</style>
