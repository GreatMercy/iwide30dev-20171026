<template>
  <div id="spec">

    <div class="item-container">
      <a href="javascript:void(0)" class="spec-item pr" v-for="item in spec" :class="{'active':item.selected}"
         @click="selectSpec(item.spu_id)">
        <span v-html="item.spu_name" class="dp-b f24"></span>
      </a>
    </div>

    <div class="price-container">
      <div class="price pr f40 dp-f">
        <div class="discount price-icon">
          <span class="price-symbol f30">¥</span><span v-html="specPrice" class="f58"></span><span
          class="symbol f24">/位</span>
        </div>
        <div class="original pr f24" v-html="'¥' + original"></div>
      </div>
    </div>

  </div>
</template>
<script>
  export default {
    watch: {
      spec (val) {
        if (val) {
          this.$store.commit('getSpecPrice')
        }
      }
    },
    computed: {
      spec () {
        return this.$store.getters.spec
      },
      goodsDetail () {
        return this.$store.getters.goodsDetail
      },
      original () {
        return this.$store.getters.original || '0.00'
      },
      specPrice () {
        return this.$store.getters.specPrice || '0.00'
      }
    },
    methods: {
      selectSpec (id) {
        this.$store.commit('selectSpec', id)
        this.$store.commit('getSpecPrice')
      }
    },
    mounted () {
      this.$store.commit('getSpecPrice')
    }
  }
</script>
<style lang="scss" scoped>
  @import '../../../common/scss/include';

  #spec {
    .item-container {
      font-size: 0;
      padding-left: 9%;
      padding-right: 10%;

      .spec-item {
        display: inline-block;
        color: $white;
        overflow: hidden;
        margin: px2rem(20) px2rem(12) 0 0;
        border: 1px solid #505050;
        border-radius: 3px;
        padding: px2rem(16) px2rem(30);
        span {
          line-height: 1.2;
        }

        &.active {
          border: 1px solid $orange;
          &:after {
            position: absolute;
            content: '';
            width: px2rem(34);
            height: px2rem(32);
            right: -1px;
            top: 0;
            background: url(../img/selected.png) center center no-repeat;
            background-size: contain;
          }
        }

      }
    }

    .price-container {
      padding: 0 4%;

      .price {
        padding: 0 px2rem(30);
        height: px2rem(166);
        line-height: px2rem(166);
        overflow: hidden;
        border-bottom: 1px solid $borderColor;

        .discount {
          .price-symbol {
            margin-right: px2rem(12);
          }

          .symbol {
            margin: 0 px2rem(20) 0 px2rem(10);
          }
        }

        .original {
          left: 0;
          top: px2rem(12);
          color: $gray;
          text-decoration: line-through;
        }

      }

    }
  }
</style>
