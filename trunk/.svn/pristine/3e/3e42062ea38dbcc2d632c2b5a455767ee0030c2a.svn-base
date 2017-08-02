<template>
  <div class="jperation-footer ta-c">
    <div class="flex dp-f">
      <a :href="indexUrl" class="cell pr flex-1 dp-b" :class="{'active': active === 0 }">
        <span class="home"></span><i class="f24">首页</i>
      </a>

      <a :href="cartUrl" class="cell pr flex-1 dp-b" :class="{'active': active === 1 }">
        <span class="cart pr"><small class="pa" v-if="cart > 0"></small></span><i class="f24">购物车</i>
      </a>

      <a :href="orderUrl" class="cell pr flex-1 dp-b" :class="{'active': active === 2 }">
        <span class="mine"></span><i class="f24">我的</i>
      </a>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      active: {
        type: Number,
        default: 0
      },
      cart: {
        type: Number,
        default: 0
      }
    },
    computed: {
      cartUrl () {
        return this.$store.getters.config['cart_url'] || 'javascript:void(0)'
      },
      indexUrl () {
        return this.$store.getters.config['index_url'] || 'javascript:void(0)'
      },
      orderUrl () {
        return this.$store.getters.config['order_url'] || 'javascript:void(0)'
      }
    },
    created () {
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../common/scss/include';

  .jperation-footer {
    height: px2rem(100);
    line-height: px2rem(100);
    color: $white;
    @include footer(px2rem(100));

    .flex {
      padding: 0 px2rem(30);
      height: 100%;
      align-items: center;

      .cell {

        &.active {
          &:after {
            position: absolute;
            content: '';
            width: px2rem(136);
            height: px2rem(22);
            background: url(./img/active.png) center center no-repeat;
            background-size: contain;
            bottom: px2rem(4);
            left: 50%;
            margin-left: - px2rem(136/2);
          }
        }

        i, span {
          display: inline-block;
          height: px2rem(32);
          line-height: px2rem(32);
        }

        i {
          font-style: normal;
          color: $white;
        }

        span {
          width: px2rem(32);
          background: #f80;
          vertical-align: middle;
          margin-right: px2rem(12);
        }

        small {
          width: 6px;
          height: 6px;
          background: $orange;
          border-radius: 100%;
          z-index: 99;
          right: -2px;
          top: 0;
          border: 1px solid $lightBlack;
        }

        .home {
          background: url(./img/home.png) center center no-repeat;
          background-size: contain;
        }

        .cart {
          background: url(./img/cart.png) center center no-repeat;
          background-size: contain;
        }

        .mine {
          background: url(./img/mine.png) center center no-repeat;
          background-size: contain;
        }

      }
    }
  }

</style>
