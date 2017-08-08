<template>
  <div class="jfk-pages jfk-pages__coupon">
    <div class="jfk-pages__theme"></div>

    <jfk-notification :message="message" class="font-size--24"></jfk-notification>

    <div class="coupon-base-info jfk-pl-30 jfk-pr-30 is-align-middle">
      <div class="coupon-base-info__name font-size--38 is-align-middle jfk-flex">
        <div class="coupon-base-info__shadow"></div>
        <span v-text="product.name"></span>
      </div>
      <div class="coupon-base-info__hotel font-size--24" v-text="product.hotel_name"></div>

      <ul class="coupon-base-info__service font-size--24">
        <li v-for="(item, index) in product.compose">
          <i v-text="item.content"></i><span v-text="item.num"></span>
        </li>
      </ul>
    </div>

    <div class="coupon-way jfk-pr-30 jfk-pl-30">
      <div class="coupon-way__title font-size--24">
        <i>使用方式</i><span>（请选择以下任意一种方式使用套票）</span>
      </div>

      <div class="coupon-way__qrcode">
        <p class="font-size--28 coupon-way__name">方式一：向商家出示券码／二维码</p>
        <p class="font-size--34 coupon-way__code jfk-ta-c" v-text="code"></p>
        <div class="coupon-way__img jfk-ta-c">
          <div class="coupon-way__content jfk-d-ib">
            <qriously :value="code" :size="size"></qriously>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { getOrderPackageUsage } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    computed: {
      size () {
        return (window.innerWidth * (326 / 750))
      }
    },
    created () {
      getOrderPackageUsage({
        'aiid': params['aiid'] || ''
      }).then((res) => {
        this.product = res['web_data']['product']
        this.code = res['web_data']['code']['code']
      })
    },
    data () {
      return {
        product: {},
        code: '',
        message: '此张套票使用后，您的订单将不能退款'
      }
    }
  }
</script>
