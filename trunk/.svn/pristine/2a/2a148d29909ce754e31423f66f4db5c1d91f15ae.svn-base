<template>
  <div>
    <tab></tab>
    <jperation-footer :active="2" :cart="cart"></jperation-footer>
  </div>
</template>

<script>
  import tab from './modules/tab' // tab 切换
  import footer from '@components/footer/index' // 底部
  import { wxApiCall } from '@js/wx'

  export default {
    components: {
      tab,
      jperationFooter: footer
    },
    computed: {
      cart () {
        return this.$store.getters.cartNumber || 0
      }
    },
    created () {
      this.$store.dispatch('getWxConfig').then((res) => {
        wxApiCall(res['data']['wx_config'], 'hideMenu')
      })
    }
  }
</script>

<style lang="scss" scoped>
</style>
