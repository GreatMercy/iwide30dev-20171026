<template>
  <div class="goods-list">
    <scroll-view :more="getMore">
      <ul>
        <li v-for="item in goodsList">
          <a class="pr container" :href="item.url">

            <div class="img">
              <img :src="item.goods_img">
            </div>
            <div class="bg"></div>

            <div class="desc pa dp-f">
              <div class="title">
                <p class="main tofle f32" v-html="item.goods_name"></p>
                <p class="sub tofle f24" v-html="item.goods_alias"></p>
              </div>
              <div class="price price-icon ta-r flex-1">
                <span class="price-symbol f24 price-icon">¥</span><span v-html="item.goods_price"
                                                                        class="price-number f58"></span><span
                class="symbol f24">/</span><span class="symbol f24 price-icon">位</span>
              </div>

            </div>
          </a>
        </li>
      </ul>
    </scroll-view>
    <watermark v-if="goodsListLength > 0"></watermark>
  </div>
</template>

<script>
  import scrollView from '@components/scrollView'
  import axios from 'axios'
  import { wxApiCall } from '@js/wx'
  import { closeAll } from '@js/popup'
  import watermark from '@components/watermark/index'
  export default {
    data () {
      return {}
    },
    components: {
      scrollView,
      watermark
    },
    methods: {
      getMore () {
        this.$store.dispatch('getGoodsList', {})
      }
    },
    computed: {
      goodsList () {
        return this.$store.getters.goodsList || []
      },
      goodsListLength () {
        return this.$store.getters.goodsList.length || 0
      }
    },
    created () {
      axios.all([this.$store.dispatch('getGoodsList', {}), this.$store.dispatch('getWxConfig')]).then((res) => {
        if (res) {
          wxApiCall(res[1]['data']['wx_config'], 'share', {
            'imgUrl': res[0]['data']['shop']['share_img'],
            'link': window.location.href,
            'title': res[0]['data']['shop']['share_title'],
            'desc': res[0]['data']['shop']['share_spec']
          })
          closeAll()
        }
      })
    }
  }
</script>

<style lang="scss" scoped>

  @import "../../../common/scss/include";

  .goods-list {
    ul {
      li {
        .container {
          box-sizing: content-box;
          height: px2rem(400);
          display: block;
          padding: 0 4%;
          overflow: hidden;

          .img {
            @include paFull;
            @include imgWrap(center);
            background: url(../img/default.png) center center no-repeat;
            background-size: px2rem(172) px2rem(190);
          }

          .bg {
            @include paFull;
            background: url(../img/bg.png) center center no-repeat;
            background-size: cover;
          }

          .desc {
            bottom: px2rem(44);
            left: 0;
            width: 100%;
            overflow: hidden;
            height: px2rem(80);
            .title {
              width: 57%;
              padding-left: 4%;
              .main {
                color: $white;
                margin-bottom: px2rem(20);
                line-height: 1;
              }
              .sub {
                color: $lightGray;
                line-height: 1.2;
              }
            }
            .price {
              overflow: hidden;
              padding-right: 4%;
              height: px2rem(80);
              line-height: px2rem(80);
              .price-number {
                margin-right: px2rem(16);
              }
              .price-symbol {
                margin-right: px2rem(12);
              }
            }
          }
        }
      }

    }
    .watermark {
      margin-top: px2rem(-26);
      margin-bottom: px2rem(58 + 100);
    }
  }

</style>
