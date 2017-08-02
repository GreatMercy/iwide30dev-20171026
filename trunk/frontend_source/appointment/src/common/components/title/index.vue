<template>
  <div class="jperation-title pr ta-c f32">
    <div v-html="title" class="title"></div>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        default: ''
      }
    }
  }
</script>

<style scoped lang="scss">
  @import "../../../common/scss/include";

  .jperation-title {
    color: $white;
    line-height: 1;

    .title {
      min-height: px2rem(32);
      line-height: 1;
    }

    &:after {
      @extend %pa;
      content: '';
      width: px2rem(370);
      height: px2rem(22);
      background: url(./img/shadow.png) center center no-repeat;
      background-size: contain;
      bottom: px2rem(-30);
      left: 50%;
      margin-left: - px2rem(370/2);
    }
  }


</style>
