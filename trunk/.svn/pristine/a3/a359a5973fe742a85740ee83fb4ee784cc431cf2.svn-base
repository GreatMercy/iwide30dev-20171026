<template>
  <div class="jfk-pages jfk-pages__reserve">
    <div class="jfk-pages__theme"></div>
    <jfk-input-number class="number"></jfk-input-number>
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getOrderPay } from '@/service/http'
  export default {
    name: 'reverse',
    data: function () {
      return {}
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      this.tokenId = params.token
      this.productId = params.pid
      this.settingId = params.psp_id
      this.btype = params.btype || ''
    },
    created () {
      getOrderPay({
        pid: this.productId,
        btype: this.btype,
        psp_id: this.settingId,
        token: this.tokenId
      }).then(function (res) {
        console.log(res)
      })
    }
  }
</script>
<style>
  .number {
    padding: 50px;
  }
</style>
