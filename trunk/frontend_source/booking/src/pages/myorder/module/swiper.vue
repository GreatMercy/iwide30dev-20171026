<template>
  <div class="jfk-swiper" :class="{'jfk-swiper--single': items.length === 1}">
    <div class="jfk-swiper__container">
      <div class="jfk-swiper__wrapper">
        <div class="jfk-swiper__slide" :style="{ width: sliderWidth }" v-for="(item, index) in items">
          <a :href="item.link ? item.link : 'javascript:;'">
            <div v-lazy:background-image="item.logo" class="jfk-image__lazy jfk-image__lazy--3-3 jfk-swiper__slide-content jfk-image__lazy--background-image">
              <div class="jfk-swiper__slide-mask"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="jfk-swiper__pagination" :style="{'text-align': paginationAlign, right: paginationRight}" v-if="pagination && items.length > 1">
        <span class="jfk-swiper__pagination-current font-color-white">{{paginationCurrent}}</span>
        <span class="jfk-swiper__pagination-separator font-color-white">/</span>
        <span class="jfk-swiper__pagination-total font-color-white">{{items.length}}</span>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'jfk-swiper',
    data () {
      return {
        paginationCurrent: this.initialIndex
      }
    },
    beforeCreate () {
      this.windowWidth = window.innerWidth
    },
    computed: {
      paginationRight () {
        let right = 26
        if (this.items.length > 1) {
          right += 27
        }
        return right + 'px'
      },
      sliderWidth () {
        if (this.items.length > 1) {
          let width = parseInt(this.windowWidth - 12 - 15 - 56 / 750 * this.windowWidth)
          return width + 'px'
        } else {
          return '100%'
        }
      }
    },
    methods: {
      swipeLeft () {
        console.log(event)
      },
      swipeRight () {
        console.log(event)
      }
    },
    props: {
      items: {
        type: Array,
        require: true
      },
      'initialIndex': {
        type: Number,
        default: 1
      },
      pagination: {
        type: Boolean,
        default: true
      },
      paginationType: {
        type: String,
        default: 'number'
      },
      paginationAlign: {
        type: String,
        default: 'right'
      }
    }
  }
</script>
<style lang="postcss" scoped>
  .jfk-swiper{
    overflow: hidden;
    position: relative;
    z-index: 1;
    padding-left: px2rem(30);
    &__wrapper{
      display: flex;
      width: 100%;
      height: 100%;
      position: relative;
      z-index: 1;
    }

    &__slide{
      flex-shrink: 0;
      width: 100%;
      /*padding-bottom: 50%;*/
      position: relative;
      margin-right: px2rem(24);
      a{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }
      &-content, a{
        width: 100%;
        height: 100%;
      }
      &-content{
        position: relative;
      }
      &-mask{
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
        z-index: -1;
        display: none;
      }
      &-content[lazy="loaded"] &-mask{
        display: block;
      }
    }
    &__pagination{
      position: absolute;
      bottom: 0;
      z-index: 2;
      &-current{
        font-size: px2rem(32);
      }
      &-separator,&-total {
        font-size: px2rem(24)
      }
    }
    &--single {
      padding-left: 0;
      .jfk-swiper__slide {
        padding-bottom: calc(318 / 750 * 100%);
      }
    }
  }
</style>
