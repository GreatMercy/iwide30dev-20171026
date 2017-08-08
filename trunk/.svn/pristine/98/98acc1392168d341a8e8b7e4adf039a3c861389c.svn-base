<template>
  <div class="jfk-pages jfk-pages__gift-list" :class="theme">
    <div class="jfk-pages__theme" v-if="!theme">
      <div class="jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
    </div>

    <template v-if="theme">

      <gift-bg :wish="wish" v-if="wish"></gift-bg>

      <template>
        <gift-list :list="giftList"></gift-list>
      </template>

    </template>

    <div class="gift-state jfk-ta-c" v-if="theme">
      <template v-if="status === 3">
        <a class="font-size--32 gift-state-finish" href="javascript:void(0)">手慢了，礼物已被领完</a>
      </template>

      <template v-else>
        <a class="font-size--32 gift-state-finish" href="javascript:void(0)">领取超时，礼物已被回收</a>
      </template>
    </div>

  </div>
</template>
<script>
  import giftBg from '@/components/gift/gift_background'
  import giftList from '@/components/gift/gift_list'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  const params = formatUrlParams.default(location.href)
  import { getPresentsInvalidGiftOrder } from '@/service/http'
  export default {
    components: {
      giftList,
      giftBg
    },
    data () {
      return {
        // 选择了哪个主题
        theme: '',
        // 礼物列表
        giftList: [],
        // 祝福语
        wish: '',
        // 总数
        total: '',
        // 已领取
        received: '',
        // 状态
        status: ''
      }
    },
    created () {
      const requestParams = {
        'gid': params['gid'] || ''
      }
      getPresentsInvalidGiftOrder(requestParams).then((res) => {
        const result = res['web_data']
        this.giftList = result['users']
        this.theme = `gift-theme_${result['theme_keyword']}`
        this.wish = result['message']
        this.total = parseInt(result['total'])
        this.received = parseInt(result['get_count'])
        this.status = parseInt(result['gift_status'])
      })
    }
  }
</script>
