<template>
  <div id="index-page">
    <jperation-title :title="shop.shop_name" v-if="shop.shop_name"></jperation-title>
    <goods-list></goods-list>
    <jperation-footer :active="0" :cart="cart"></jperation-footer>
  </div>
</template>

<script>
  import { setTitle } from '@js/browser'
  import jperationTitle from '@components/title/index.vue' // 标题
  import jperationFooter from '@components/footer/index' // 定部
  import goodsList from './modules/goodsList' // 产品列表

  export default {
    name: 'index',
    computed: {
      shop () {
        return this.$store.getters.shop || {'shop_name': '', 'hotel_name': ''}
      },
      cart () {
        return this.$store.getters.cartNumber || 0
      }
    },
    watch: {
      shop (value) {
        setTitle(value.hotel_name)
      }
    },
    components: {
      jperationTitle,
      goodsList,
      jperationFooter
    }
  }

</script>

<style lang="scss" scoped>
  @import "../../common/scss/include";

  .jperation-title {
    margin: px2rem(48) auto px2rem(58);
  }
</style>
