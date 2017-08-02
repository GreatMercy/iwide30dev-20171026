<template>
  <div class="goods">

    <div class="no-data" v-if="cartNumber === 0">
      <p class="icon"></p>
      <p class="f24 ta-c">您的购物车是空的哦~ </p>
    </div>

    <ul v-else ref="goodsList" id="goodsList">
      <li v-for="(item, index) in cartList" :id="index" class="pr" :class="{'grayscale':item.gray }">
        <slider-delete @deleteItem="del(index,item)" :ind="index" :open="item.open" :border="border">
          <div class="product-item  pr">
            <selector :selected="item.selected" @select="select(index, item)" v-if="item.status ==='1'"></selector>
            <div v-if="item.status !=='1'" class="error-status f22 pa" v-html="item.status_name"></div>
            <div class="img pr">
              <img :src="item.goods_img" alt="">
            </div>
            <div class="content pr">
              <p class="name tofle f32" v-html="item.goods_name"></p>
              <div class="price price-icon">
                <span class="symbol f20">¥</span>
                <span v-html="item.goods_price" class="f42"></span>
                <span class="price-symbol f20">/</span>
                <span class="f24">份</span>
              </div>

              <div class="pack-input-number ta-r">
                <input-number
                  :disabled="item.gray"
                  :limit="item.gray"
                  :min="1"
                  :auto="false"
                  @minus="reduce(item, index)"
                  @plus="increase(item, index)"
                  :v-model="item.goods"
                  :max="item.goods_stock"
                  :defaultValue="item.goods_num">
                </input-number>
              </div>
              <div class="more-info f24 pa" :class="{'close': item.open !==true}"
                   @click="getMoreInfo(item.cart_id, index, item.open)">详情






              </div>
            </div>
          </div>
        </slider-delete>
        <div class="goods-detail pr" v-if="item.open">
          <div class="detail-content">
            <p v-html="item.goods_name" class="f28 tofle goods-name"></p>
            <p v-html="'规格：'+item.spu_name" class="f24 tofle goods-spec"></p>
            <p v-html="'预约：' + item.book_day" class="f24 tofle goods-book-time"></p>
          </div>
        </div>
      </li>
      <li>
        <watermark></watermark>
      </li>
    </ul>

  </div>
</template>
<script>
  import sliderDelete from './silderDelete' // 侧滑删除控件
  import inputNumber from '@components/inputNumber' // 数字输入框
  import selector from './selector' // 选择
  import watermark from '@components/watermark/index'

  export default {
    computed: {
      cartList () {
        return this.$store.getters.cartList
      },
      cartNumber () {
        return this.$store.getters.cartList.length || 0
      }
    },
    data () {
      return {
        border: ''
      }
    },
    created () {
    },
    methods: {
      // 获取更多信息
      getMoreInfo (id, index, open) {
        this.$store.commit('openMoreInfo', id, open)
        let itemOpen = !open
        if (itemOpen) {
          this.border = 'border-radius: 5px 5px 0 0'
        } else {
          this.border = 'border-radius: 5px'
        }
      },
      // 减少商品
      reduce (item, index) {
        if (parseInt(item['goods_stock']) > 0) {
          let number = parseInt(item.goods_num)
          number--
          if (number < 1) {
            number = 1
          }
          this.$store.dispatch('editCart', {
            'ind': index,
            'cartId': item['cart_id'],
            'goodsNum': number
          })
        }
      },
      // 增加商品
      increase (item, index) {
        if (parseInt(item['goods_stock']) > 0) {
          let number = parseInt(item.goods_num)
          number++
          if (number > parseInt(item['goods_stock'])) {
            number = parseInt(item['goods_stock'])
          }
          this.$store.dispatch('editCart', {
            'ind': index,
            'cartId': item['cart_id'],
            'goodsNum': number
          })
        }
      },
      // 删除商品
      del (index, item) {
        this.$store.dispatch('delCart', {
          'cartId': item.cart_id,
          'ind': index
        })
      },
      // 选择商品
      select (index, item) {
        this.$store.dispatch('selectCart', {
          'ind': index,
          'selected': item.selected,
          'cartId': item['cart_id']
        })
      }
    },
    components: {
      sliderDelete,
      inputNumber,
      selector,
      watermark
    }
  }
</script>
<style scoped lang="scss">
  @import "../../../common/scss/include";

  .goods {
    margin-top: px2rem(26);

    .no-data {
      .icon {
        width: px2rem(163);
        height: px2rem(186);
        margin: px2rem(410) auto px2rem(46);
        background: url(../img/cart.png) center center no-repeat;
        background-size: contain;
      }
      p {
        color: $gray;
      }
    }

    ul {
      margin-bottom: px2rem(120);
      li {
        width: 100%;
        overflow: hidden;
        margin-bottom: px2rem(30);

        .goods-detail {
          padding: 0 4%;
          .detail-content {
            border-radius: 0 0 5px 5px;
            border-top: 1px solid $borderColor;
            padding: px2rem(36) px2rem(36) px2rem(42) px2rem(36);
            background: $bgColor;
            p {
              line-height: 1;
            }

            .goods-name {
              color: $lightGray;
              margin-bottom: px2rem(36);
              line-height: 1.2;
            }

            .goods-spec {
              color: $gray;
              line-height: 1.2;
              margin-bottom: px2rem(20);
            }

            .goods-book-time {
              color: $gray;
              line-height: 1.2;
            }
          }
        }

        &:first-child {
          .goods-detail {
            display: block;
          }
        }

        .product-item {
          background: $bgColor;
          overflow: hidden;
          height: px2rem(260);
          @extend %clb;
          .error-status {
            color: $gray;
            right: px2rem(20);
            top: px2rem(20);
            z-index: 100;
          }

          .img {
            float: left;
            width: 34%;
            height: px2rem(260);
            background: $bgColor;
            left: 0;
            top: 0;
            z-index: 0;

            &:after {
              content: '';
              position: absolute;
              width: px2rem(84);
              height: px2rem(280);
              background: $bgColor;
              transform: rotate(15deg);
              top: 0;
              right: px2rem(-48);
              z-index: 0;
              overflow: hidden;
            }

            img {
              width: 100%;
              height: 100%;
              left: 0;
              top: 0;
              border: none;
            }

          }

          .content {
            float: left;
            width: 60%;
            height: px2rem(260 - 46);
            padding-top: px2rem(46);
            background: $bgColor;
            z-index: 99;

            .more-info {
              color: $gray;
              width: px(80);
              height: px2rem(24);
              left: px2rem(-28);
              bottom: px2rem(36);
              z-index: 999;
              &:after {
                content: '';
                position: absolute;
                width: px2rem(16);
                height: px2rem(9);
                right: 0;
                top: 50%;
                margin-top: px2rem(-9/2);
                background: url(../img/arrow.png) center center no-repeat;
                background-size: contain;
              }

              &.close {
                &:after {
                  transform: rotate(180deg)
                }
              }
            }

            .name {
              width: 75%;
              color: $white;
              line-height: 1.2;
            }
            .pack-input-number {
              margin-right: px2rem(30);
              margin-top: px2rem(14);
            }

            .price {
              margin-top: px2rem(28);
              font-size: 0;
              .symbol {
                margin-right: px2rem(10);
              }

              .price-symbol {
                margin-left: px2rem(6);
              }

            }
          }

        }

        &.grayscale {

          .product-item {
            img {
              filter: grayscale(100%);
            }
          }

          .content {
            .name {
              color: $gray;
            }
            .price {
              color: $gray;
            }

          }

        }

      }
    }

    .watermark {
      margin-top: px2rem(146-30);
      margin-bottom: px2rem(58 + 100 -30);
    }

  }


</style>
