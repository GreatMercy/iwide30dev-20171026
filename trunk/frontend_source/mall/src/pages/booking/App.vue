<template>
  <div class="jfk-pages jfk-pages__booking">
    <div class="jfk-pages__theme"></div>

    <jfk-notification :message="message" class="font-size--24"></jfk-notification>

    <div class="booking-information jfk-pl-30 jfk-pr-30 is-align-middle">
      <div class="booking-information__name font-size--38 is-align-middle jfk-flex" v-if="product.name">
        <div class="booking-information__shadow"></div>
        <span v-text="product.name"></span>
      </div>
      <div class="booking-information__hotel font-size--24" v-text="product.hotel_name"></div>
      <div class="jfk-price font-size--54 booking-information__price" v-if="product.price_package">
        <i class="jfk-font-number jfk-price__currency">¥</i>
        <i class="jfk-font-number jfk-price__number" v-text="product.price_package"></i>
      </div>
    </div>

    <div class="booking-coupon jfk-pl-30 jfk-pr-30">

      <div class="booking-coupon-wrap">

        <div class="booking-coupon-list">
          <div class="booking-coupon-list__title font-size--28">请拨打预约电话进行预订客房</div>
          <div class="booking-coupon-list__content jfk-flex is-align-middle">
            <span class="font-size--28 booking-coupon-list__left">劵<i></i>码</span>
            <div class="font-size--32 booking-coupon-list__right">
              <jfk-text-split :text="code" :split="4"></jfk-text-split>
            </div>
          </div>
        </div>

        <div class="booking-coupon-phone jfk-flex is-align-middle" v-if="product.hotel_tel">
          <a :href="'tel:'+ product.hotel_tel" class="jfk-flex is-align-middle">
            <div class="booking-coupon-phone__number font-size--28" v-text="'预约电话：' + product.hotel_tel"></div>
            <div class="booking-coupon-phone__line"></div>
            <div class="booking-coupon-phone__icon jfk-font icon-mall_icon_reservation_contact"></div>
          </a>
        </div>
      </div>
    </div>

    <jfk-support v-once></jfk-support>
  </div>
</template>

<script>
  import { getOrderPackageBooking } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    created () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      getOrderPackageBooking({
        'aiid': params['aiid'] || '',
        'code_id': params['code_id'] || ''
      }).then((res) => {
        this.product = res['web_data']['product']
        this.code = res['web_data']['code']['code']
        this.toast.close()
      }).catch(() => {
        this.toast.close()
      })
    },
    data () {
      return {
        message: '客房预约，您的订单将不能退款',
        product: {},
        code: ''
      }
    },
    components: {}
  }
</script>
