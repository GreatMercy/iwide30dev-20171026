<template>
  <div id="order-detail">
    <div class="content">
      <ul>
        <li v-for="item in list">
          <p class="status f28 pr price-icon" v-if="status" v-html="item.order_name"></p>
          <p class="name f36 tofle" v-html="item.goods_name"></p>
          <div class="info dp-f">
            <div class="info_l">
              <p class="time f24 tofle" v-html="'预约：'+item.book_day"></p>
              <p class="spec f24 tofle" v-html="'规格：'+item.spu_name" v-if="item.spu_name"></p>
              <p class="spec f24 tofle" v-html="'规格：'+item.spec_name" v-if="item.spec_name"></p>
            </div>
            <div class="info_r ta-r flex-1 price-icon">
              <span class="symbol f30">¥</span>
              <span class="price f58" v-html="item.goods_price"></span>
              <span class="number f24" v-html="item.goods_num + '份'"></span>
            </div>
          </div>
        </li>

        <li class="payable">
          <div class="content">

            <div class="discount">
              <div class="title f28">优惠</div>
              <div class="price f32" v-html="'¥ '+total.discount_fee" v-if="total.discount_fee"></div>
            </div>

            <div class="pay">
              <div class="title f28" v-html="title"></div>
              <div class="price f40" v-html="'¥ '+total.total_fee" v-if="total.total_fee"></div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      status: {
        type: Boolean,
        default: true
      },
      list: Array,
      total: Object,
      title: {
        type: String,
        default: '需付'
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../common/scss/include';

  #order-detail {
    .content {
      padding: 0 4%;

      ul {
        border-radius: px2rem(5);
        overflow: hidden;

        li {
          padding: px2rem(52) 4% px2rem(94);
          background-color: $bgColor;

          .status {
            height: px2rem(32);
            margin-bottom: px2rem(52);
            line-height: 1.2;
            color: $white;
            padding-left: px2rem(30);
            letter-spacing: 2px;

            &:after {
              position: absolute;
              content: '';
              width: px2rem(20);
              height: px2rem(120);
              background: url(./img/shadow.png) center center no-repeat;
              background-size: px2rem(21) px2rem(90);
              left: 0;
              top: - px2rem(48);
            }
          }

          .name {
            color: $lightGray;
            line-height: 1.2;
          }

          .info {
            .info_l {
              width: 42%;
              p {
                line-height: 1.2;
                color: $gray;
              }

              .time {
                margin-top: px2rem(42);
              }

              .spec {
                margin-top: px2rem(24);
              }

            }

            .info_r {
              padding-top: px2rem(42);
              height: px2rem(118-42);
              line-height: px2rem(118-42);

              .price {
                margin: 0 px2rem(20) 0 px2rem(12);
              }
            }
          }
        }

        .payable {
          padding: 0 px2rem(30);
          .content {
            border-top: 1px dashed $borderColor;
            padding: px2rem(56) 0;

            .discount, .pay {
              @extend %clb;
            }

            .title {
              float: left;
              color: $lightGray;
            }

            .price {
              float: right;
            }

            .discount {
              margin-bottom: px2rem(50);

              .price {
                color: $lightGray;
              }
            }

            .pay {
              .price {
                color: $white;
              }
            }

          }
        }

      }

    }

  }

</style>
