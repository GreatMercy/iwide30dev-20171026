<template>
  <div class="selector pa" @click="select" :class="{'active': (selected === '1') ? true : false}"></div>
</template>

<script>
  export default {
    props: {
      selected: [String, Number]
    },
    methods: {
      select () {
        this.$emit('select')
      }
    }
  }
</script>

<style scoped lang="scss">
  @import "../../../common/scss/include";

  .selector {
    width: px2rem(30);
    height: px2rem(30);
    border: 1px solid #777777;
    border-radius: 50%;
    right: px2rem(20);
    top: px2rem(20);
    z-index: 100;

    &.active {
      width: px2rem(32);
      height: px2rem(32);
      border: none;
      background: url(../img/selector.png) center center no-repeat;
      background-size: 100% 100%;
    }

    input {
      display: none;
    }

  }
</style>
