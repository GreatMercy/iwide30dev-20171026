<template>
  <div class="gradient_bg padding_0_15">
  <section>
    <div class="iconfont center pad_t60">
      <img class="okpay_logo" src="../../assets/image/su_gou.png" alt="">
    </div>
    <p class="iconfont center color1 mar_t40 font_21">支付失败!</p>
  </section>
</div>
</template>
<script>
import { getBalancePay } from '@/service/http'
export default {
  data () {
    return {
      dataList: []
    }
  },
  created () {
    getBalancePay().then((res) => {
      this.dataList = res.web_data
    })
  },
  methods: {
    submit () {
    }
  }
}
</script>
