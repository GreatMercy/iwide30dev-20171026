<template>
  <div class="jfk-pages jfk-pages__coupon">
    <div class="jfk-pages__theme"></div>

    <jfk-notification :message="message" class="font-size--24"></jfk-notification>

    <div class="coupon-base-info jfk-pl-30 jfk-pr-30 is-align-middle">
      <div class="coupon-base-info__name font-size--38 is-align-middle jfk-flex">
        <div class="coupon-base-info__shadow color-golden"></div>
        <span v-text="product.name"></span>
      </div>
      <div class="coupon-base-info__hotel font-size--24" v-text="product.hotel_name"></div>

      <ul class="coupon-base-info__service font-size--24">
        <li v-for="(item, index) in product.compose"
            v-if="item.content && item.num && item.num !== '0' && item.num !== 0">
          <i v-text="item.content"></i><span v-text="item.num"></span>
        </li>
      </ul>
    </div>

    <div class="coupon-way jfk-pr-30 jfk-pl-30">
      <div class="coupon-way__title font-size--24">
        <i>使用方式</i>
        <!--<span>（请选择以下任意一种方式使用套票）</span>-->
      </div>

      <div class="coupon-way__qrcode">
        <p class="font-size--28 coupon-way__name">方式一：向商家出示券码／二维码</p>
        <p class="font-size--34 coupon-way__code jfk-ta-c">
          <jfk-text-split :text="code" :split="4"></jfk-text-split>
        </p>

        <div class="coupon-way__img jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"
             :style="size">
          <img :src="qrcode" v-if="qrcode">
        </div>
      </div>
    </div>
    <jfk-support v-once></jfk-support>
  </div>
</template>

<script>
  import { getOrderPackageUsage } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    components: {},
    computed: {
      size () {
        return {
          'width': (window.innerWidth * (382 / 750)) + 'px',
          'height': (window.innerWidth * (382 / 750)) + 'px'
        }
      }
    },
    created () {
      this.$pageNamespace(params)
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      getOrderPackageUsage({
        'aiid': params['aiid'] || '',
        'code_id': params['code_id'] || ''
      }).then((res) => {
        this.product = res['web_data']['product']
        this.code = res['web_data']['code']['code']
        this.qrcode = res['web_data']['code']['qrcode_url']
        this.toast.close()
      }).catch(() => {
        this.toast.close()
      })
    },
    data () {
      return {
        product: {},
        code: '',
        qrcode: false,
        message: '此张套票使用后，您的订单将不能退款'
      }
    }
  }
</script>
