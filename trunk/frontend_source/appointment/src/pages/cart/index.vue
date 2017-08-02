<template>
  <div id="detail-page">
    <jperation-title :title="cartShopName" v-if="cartNumber > 0"></jperation-title>
    <goods></goods>
    <pay-footer v-if="cartNumber > 0" :price="price" @pay="pay"></pay-footer>
  </div>
</template>

<script>
  import title from '@components/title/index'  // 标题
  import goods from './modules/goods' // 购物车内的列表
  import payFooter from '@components/payFooter' // 底部
  import { errorMessage, closeAll } from '@js/popup'
  import axios from 'axios'
  import { wxApiCall } from '@js/wx'
  export default {
    name: 'cart',
    data () {
      return {
        payUrl: ''
      }
    },
    computed: {
      cartList () {
        return this.$store.getters.cartList
      },
      cartNumber () {
        return this.$store.getters.cartList.length || 0
      },
      cartShopName () {
        return this.$store.getters.cartShopName || ''
      },
      price () {
        return this.$store.getters.cartTotal || '0.00'
      },
      payUrlPrefix () {
        return this.$store.getters.config['checkout_url'] || ''
      },
      cartIdList () {
        return this.$store.getters.cartIdList || ''
      }
    },
    created () {
      axios.all([this.$store.dispatch('getCartList', {}), this.$store.dispatch('getWxConfig')]).then((res) => {
        if (res) {
          wxApiCall(res[1]['data']['wx_config'], 'hideMenu')
          closeAll()
        }
      })
    },
    watch: {
      payUrlPrefix () {
        this.payUrl = this.payUrlPrefix + '&cart_id=' + this.cartIdList
      },
      cartIdList () {
        this.payUrl = this.payUrlPrefix + '&cart_id=' + this.cartIdList
      }
    },
    methods: {
      pay () {
        if (parseFloat(this.price) === 0) {
          errorMessage('请选中商品')
        } else {
          window.location.href = this.payUrl
        }
      }
    },
    components: {
      jperationTitle: title,
      goods,
      payFooter
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../common/scss/include.scss";

  .jperation-title {
    margin: px2rem(48) auto px2rem(62);
  }
</style>
