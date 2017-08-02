<template>
  <div>
    <div class="footer" v-if="isShow">
      <div class="content dp-f">
        <a href="javascript:void(0)" class="f32 ta-c flex-1" v-if="info.order_btn === 4" @click="cancel()">取消订单</a>
        <a :href="info.pay_url" class="f32 ta-c flex-1" v-if="info.order_btn === 4 && info.pay_url">立即支付</a>
      </div>
    </div>

    <div class="footer order-again" v-if="againShow">
      <div class="content dp-f">
        <a :href="indexUrl" class="f32 ta-c flex-1">
          再来一单<span class="arrow"></span>
        </a>
      </div>
    </div>

  </div>
</template>

<script>
  import { popup, closeAll } from '@js/popup'
  export default {
    data () {
      return {
        isShow: false,
        againShow: false
      }
    },
    watch: {
      info (val) {
        if (val) {
          // 1-待消费，2-已消费，3-已取消, 4-未支付
          if (parseInt(val['order_btn']) === 1) {
            this.isShow = false
          } else if (parseInt(val['order_btn']) === 2) {
            this.isShow = false
          } else if (parseInt(val['order_btn']) === 3) {
            this.isShow = false
            this.againShow = true
          } else if (parseInt(val['order_btn']) === 4) {
            this.isShow = true
          }
        }
      }
    },
    computed: {
      info () {
        return this.$store.getters.orderDetail['order'] || {}
      },
      indexUrl () {
        return this.$store.getters.config['index_url'] || 'javascript:void(0)'
      }
    },
    methods: {
      cancel () {
        closeAll()
        popup({
          'type': 'message',
          'title': '提示',
          'zIndex': 9999999999999999,
          'shade': true,
          'btn': ['取 消', '确 定'],
          'content': '您确定取消订单？'
        }, () => {
          closeAll()
        }, () => {
          this.$store.dispatch('cancelOrder', {})
        })
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../common/scss/include';

  .footer {
    @include footer(px(100));

    &.order-again {
      .content {
        background: $orange;

        .arrow {
          display: inline-block;
          width: px2rem(42);
          height: px2rem(100);
          vertical-align: top;
          background: url(../img/arrow.png) center center no-repeat;
          background-size: contain;
          margin-left: px2rem(50);
        }
      }
    }

    .content {
      a {
        height: px(100);
        line-height: px(100);
        color: $white;
        &:first-child {
          background: $bgColor;
        }

        &:last-child {
          background: $orange;
        }
      }

    }
  }
</style>
