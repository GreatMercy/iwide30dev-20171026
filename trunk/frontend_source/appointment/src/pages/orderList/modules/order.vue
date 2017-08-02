<template>
  <div>
    <div v-if="orderLength > 0" class="wrap">
      <scroll-view :more="getMore">
        <ul class="order-list">
          <li v-for="(item, index) in orderList.list" :key="index">
            <div class="order">
              <div class="order-info dp-f">
                <div class="order-number f28 tofle" v-html="'订单号：' + item.info.order_no"></div>
                <div class="order-state f28 flex-1 ta-r" v-html="item.info.status_name"></div>
              </div>

              <div class="orders" v-for="value in item.goods">
                <a :href="item.info.url">
                  <div class="img pr">
                    <img :src="value.goods_img">
                  </div>
                  <div class="desc flex-1">
                    <p class="name tofle f36" v-html="value.goods_name"></p>
                    <p class="spec tofle f24" v-html="'规格：' + value.spec_name"></p>
                    <p class="price price-icon">
                      <span class="symbol f26">¥</span><span v-html="value.goods_price" class="f42"></span>
                      <span class="number f26" v-html="value.goods_num + '份'"></span>
                    </p>
                  </div>
                </a>
              </div>


              <div class="operation ta-r">
                <div class="total f26">
                  <span class="number">共{{item.info.goods_num}}份商品</span>实付：<span class="price f32"
                                                                                  v-html="'¥'+item.info.pay_fee"></span>
                </div>
                <a :href="item.info.again_url" v-if="item.info.again_url && item.info.status_btn !== 4"
                   class="price-icon">再来一单</a>
                <a :href="item.info.pay_url" v-if="item.info.pay_url" class="price-icon">立即支付</a>
              </div>

            </div>
          </li>


        </ul>
      </scroll-view>
      <watermark></watermark>
    </div>

    <div v-else class="no-data">
      <p class="f24 ta-c">暂无相关订单~ </p>
    </div>

  </div>
</template>

<script>
  import scrollView from '@components/scrollView'
  import watermark from '@components/watermark/index'
  export default {
    computed: {
      currentActiveId () {
        return this.$store.getters.currentActiveId
      }
    },
    components: {
      scrollView,
      watermark
    },
    props: {
      orderList: {
        type: Object,
        default: function () {
          return {}
        }
      },
      orderLength: {
        type: Number
      }
    },
    methods: {
      getMore () {
        this.$store.dispatch('getOrderList', {
          'type': this.currentActiveId,
          'operation': 'scroll'
        })
      }
    }
  }
</script>

<style scoped lang="scss">
  @import "../../../common/scss/include";

  .order-list {
    margin: px2rem(98) 0 0 0;
    li {
      padding: 0 4%;
      margin-bottom: px2rem(98);
      &:last-child {
        margin-bottom: 0;
      }
    }
  }

  .wrap {
    .scroll-view {
      margin-bottom: 0;
    }
  }

  .watermark {
    margin-top: px2rem(146);
    margin-bottom: px2rem(100 + 58);
  }

  .no-data {
    margin-top: px(408);
    .icon {
      margin: 0 auto;
      width: px2rem(163);
      height: px2rem(186);
    }
    p {
      color: $gray;
    }
  }

  .order {

    .order-info {
      padding: 0 px2rem(30);

      .order-number {
        width: 70%;
        color: $gray;
      }

      .order-state {
        color: $orange;
      }
    }

    .orders {
      a {
        height: px2rem(180);
        padding: px2rem(50) px2rem(30) px2rem(72);
        display: -webkit-box;

        .img {
          width: px2rem(174);
          height: px2rem(174);
          margin-right: px2rem(20);
          overflow: hidden;
          background-color: #090909;
          border-radius: 3px;
          background-image: url(../img/default.png);
          background-position: center center;
          background-size: px2rem(88) px2rem(93);
          background-repeat: no-repeat;
          img {
            max-width: 100%;
          }
        }

        .desc {
          .name {
            color: $white;
            line-height: 1.2;
          }

          .spec {
            line-height: 1.2;
            margin-top: px2rem(20);
            color: $gray;
          }

          .price {
            margin-top: px2rem(30);
            line-height: px(44);

            .symbol {
              margin-right: px2rem(12);
            }

            .number {
              margin-left: px2rem(20);
            }
          }

        }

        &:first-child {
          padding-top: px2rem(40);
        }
      }
    }

    .operation {
      padding-right: px2rem(30);
      padding-bottom: px2rem(52);
      border-bottom: 1px solid $borderColor;
      @extend %clb;
      .total {
        float: left;
        padding-left: px2rem(30);
        height: px2rem(68);
        line-height: px2rem(68);
        vertical-align: top;

        color: $lightGray;
        .number {
          margin-right: px2rem(16);
        }

        .price {
          color: $white;
        }
      }
      a {
        @include btn(1);

        &:first-child {
          @include btn(2);
        }

        &:last-child {
          margin-left: px2rem(30);
        }
      }
    }

  }

</style>
