<template>
  <footer id="detail-footer">
    <div class="content">
      <div class="btn-group dp-f">
        <a :href="indexUrl" class="dp-b flex-1">
          <span class="icon home"></span>
          <span class="ta-c f20">首 页</span>
        </a>
        <a :href="cartUrl" class="dp-b flex-1">
          <span class="icon cart pr">
            <small class="number pa ta-c tofle f24" v-html="cart" v-if="cart > 0 && cart <= 99"></small>
            <small class="number pa ta-c tofle f24" v-else-if="cart > 0 && cart > 99">...</small>
          </span>
          <span class="ta-c f20">购物车</span>
        </a>
      </div>
      <a href="javascript:void(0)" class="add ta-c f30  pr" @click="addCart" :class="{'disabled': dateLength === 0}">加入购物车</a>
      <a href="javascript:void(0)" class="buy ta-c f30  pr" @click="buy"
         :class="{'disabled': dateLength === 0}">立即购买</a>
    </div>
  </footer>
</template>
<script>
  import { errorMessage } from '@js/popup'
  export default {
    computed: {
      cart () {
        return this.$store.getters.cartNumber || 0
      },
      date () {
        return this.$store.getters.calendarDate || {}
      },
      currentSpec () {
        return this.$store.getters.currentSpec || ''
      },
      cartUrl () {
        return this.$store.getters.config['cart_url'] || 'javascript:void(0)'
      },
      indexUrl () {
        return this.$store.getters.config['index_url'] || 'javascript:void(0)'
      },
      spec () {
        return this.$store.getters.currentSpec || ''
      },
      dateLength () {
        if (JSON.stringify(this.$store.getters.calendarDate) === '[]' || JSON.stringify(this.$store.getters.calendarDate) === '{}') {
          return 0
        } else {
          return 1
        }
      }
    },
    created () {
    },
    methods: {
      operation (type) {
        if (this.dateLength === 0) {
          return false
        } else {
          if (this.spec === '') {
            errorMessage('请选择规格')
          } else {
            this.$store.commit('updateBuyType', type) // 记录操作的状态
            this.$router.push('calendar')
          }
        }
      },
      addCart () {
        this.operation(1)
      },
      buy () {
        this.operation(2)
      }
    }
  }
</script>
<style lang="scss" scoped>
  @import '../../../common/scss/include';

  #detail-footer {
    .content {
      @include footer(px2rem(100));
      z-index: 9999999;
      overflow: hidden;

      a, .btn-group {
        float: left;
        height: px2rem(100);
        line-height: px2rem(100);
        color: $white;
      }

      .btn-group {
        width: 38%;
        background: $bgColor;
        height: px2rem(60);
        padding: px2rem(20) 0;

        a {
          height: px2rem(60);
          &:first-child {
            border-right: 1px solid #2f2f2e;
          }
          .icon {
            width: px2rem(33);
            height: px2rem(28);
            margin: 0 auto px2rem(14) auto;
          }

          .home {
            background: url(../img/home.png) center center no-repeat;
            background-size: contain;
          }

          .cart {
            background: url(../img/cart.png) center center no-repeat;
            background-size: contain;
            .number {
              width: px2rem(38);
              height: px2rem(38);
              line-height: px2rem(38);
              right: - px2rem(20);
              top: - px2rem(16);
              border: 1px solid $borderColor;
              transform: scale(0.5);
              background: $orange;
              border-radius: 50%;
              color: $white;
              z-index: 99;
            }
          }

          span {
            display: block;
            line-height: 1;
          }
        }
      }

      .add {
        width: 31%;
        background: $drakOrange;

        &.disabled {
          &:after {
            position: absolute;
            content: '';
            height: 100%;
            right: 0;
            top: 0;
            width: 1px;
            background: $borderColor;
          }
        }
      }

      .buy {
        width: 31%;
        background: $orange;
      }

      .add, .buy {
        &.disabled {
          background: $gray;
        }
      }
    }
  }


</style>
