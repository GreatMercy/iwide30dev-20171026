<template>
  <div class="gradient_bg padding_0_15">
  <section class="bg_show pad_b80">
    <div class="jfk-font center pad_t60">
      <img class="okpay_logo" src="../../assets/image/er_gou.png" alt="">
    </div>
    <p class="jfk-font center color1 mar_t40 font_21 txt_show5">支付失败!</p>
    <p class="font_13 color3 center margin_top_40 margin_bottom_70">很抱歉，您没有支付成功，请重新下单支付!</p>
    <a :href="dataList.page_resource.links.restarturl" class="block width_85 center btn_height auto jfk-font entry_btn reset" style="border-top:1px solid #b2945e">重新支付</a>
  </section>
  <JfkSupport v-once></JfkSupport>
</div>
</template>
<script>
import { getCardNopay, getBalanceNopay } from '@/service/http'
import { formatUrlParams } from '@/utils/utils'
export default {
  data () {
    return {
      dataList: []
    }
  },
  created () {
    const params = formatUrlParams(location.search)
    const setdata = {'orderId': params.orderId, 'orderNum': params.orderNum}
    if (params.payfor === 'card') {
      getCardNopay(setdata).then((res) => {
        this.dataList = res.web_data
      })
    } else {
      getBalanceNopay(setdata).then((res) => {
        this.dataList = res.web_data
        this.dataList.page_resource.links.restarturl = res.web_data.page_resource.links.pay
      })
    }
  },
  methods: {
    submit () {
    }
  }
}
</script>
