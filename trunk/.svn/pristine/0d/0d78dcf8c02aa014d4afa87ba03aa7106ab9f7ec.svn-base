<template>
  <div class="order-info">
    <h2 class="f24">订单信息</h2>
    <ul>
      <li class="dp-f">
        <div class="title f28">订单状态</div>
        <div class="content tofle f30 flex-1" v-html="info.status_name"></div>
      </li>

      <li class="dp-f">
        <div class="title f28">订单编号</div>
        <div class="content tofle f30 flex-1" v-html="info.order_no"></div>
      </li>

      <li class="dp-f">
        <div class="title f28">下单时间</div>
        <div class="content tofle f30 flex-1" v-html="info.add_time"></div>
      </li>

    </ul>
  </div>
</template>

<script>
  export default {
    computed: {
      info () {
        return this.$store.getters.orderDetail['order'] || {}
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../common/scss/include';

  .order-info {
    padding: 0 4%;
    h2 {
      margin: px2rem(76) 0 px2rem(52) 0;
      color: $lightGray;
    }

    ul {
      li {
        margin-bottom: px2rem(36);
        height: px2rem(32);
        line-height: px2rem(32);
        .title {
          width: px2rem(168);
          color: $lightGray;
        }

        .content {
          color: $white;
        }

        &:last-child {
          margin-bottom: 0;
        }
      }
    }

  }
</style>
