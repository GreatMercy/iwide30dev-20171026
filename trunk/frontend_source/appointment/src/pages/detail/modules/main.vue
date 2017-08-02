<template>
  <div>
    <banner></banner>
    <spec></spec>
    <detail-desc></detail-desc>
    <detail-footer></detail-footer>
  </div>
</template>

<script>
  import banner from './banner'  // banner
  import spec from './spec' // 规格
  import desc from './desc' // 产品描述
  import footer from './footer' // 底部
  import axios from 'axios'
  import { wxApiCall } from '@js/wx'
  import { closeAll } from '@js/popup'

  export default {
    name: 'detail',
    components: {
      banner,
      spec,
      detailDesc: desc,
      detailFooter: footer
    },
    computed: {
      show () {
        return this.$store.getters.calendarShow
      },
      router () {
        return this.$router.history.current.fullPath
      }
    },
    created () {
      axios.all([this.$store.dispatch('getGoodsDetail', {}), this.$store.dispatch('getWxConfig')]).then((res) => {
        if (res) {
          wxApiCall(res[1]['data']['wx_config'], 'share', {
            'imgUrl': res[0]['data']['goods']['share_img'],
            'link': window.location.href,
            'title': res[0]['data']['goods']['share_title'],
            'desc': res[0]['data']['goods']['share_spec']
          })
          closeAll()
        }
      })
    }
  }
</script>
