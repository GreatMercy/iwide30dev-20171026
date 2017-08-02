<template>
  <div id="tip">
    <h2>
      <span class="icon"></span>
      <span class="f24">温馨提示</span>
    </h2>

    <div class="content f24">订单订单支付成功后，不支持退换以及变更消费时间</div>
  </div>
</template>

<script>
  export default {
    props: {
      content: {
        type: String,
        default: '订单订单支付成功后，不支持退换以及变更消费时间'
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../common/scss/include';

  #tip {
    padding: 0 4%;

    h2 {
      margin-top: px2rem(94);
      @extend %clb;

      span {
        float: left;
        line-height: px2rem(26);
        color: $lightGray;
      }

      .icon {
        width: px2rem(26);
        height: px2rem(26);
        background: url(./img/tip.png) center center no-repeat;
        background-size: contain;
        margin-right: px2rem(14);
      }
    }

    .content {
      color: $gray;
      line-height: 1.3;
      margin-top: px2rem(30);
      padding-left: px2rem(14+26);
    }

  }
</style>
