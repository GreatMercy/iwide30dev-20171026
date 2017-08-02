<template>
  <div class="jfk-pages jfk-pages__send-gift">
    <div class="jfk-pages__theme jfk-pages__theme-list"></div>

    <div class="gift-theme-list">
      <swiper :options="swiperOption" ref="mySwiper">

        <swiper-slide v-for="(item, index) in giftInfo.gift_theme" :key="index">
          <div class="gift-theme-list__item jfk-ta-c">
            <div class="gift-theme-list__box">
              <div class="gift-theme-list__imgbox">
                <div class="jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
                <img :data-src="item.theme" class="swiper-lazy">
              </div>
              <div class="gift-theme-list__name jfk-ta-c font-size--36" v-html="item.theme_name"></div>
            </div>
          </div>
        </swiper-slide>


      </swiper>
    </div>

    <div class="button-box gift-theme-btn">
      <a href="javascript:void(0);" class="jfk-button jfk-button--default" @click="choiceTheme">确&nbsp;定</a>
    </div>

  </div>
</template>
<script>
  import { mapGetters, mapMutations } from 'vuex'
  export default {
    computed: {
      ...mapGetters([
        'giftInfo'
      ])
    },
    mounted () {
      this.$nextTick(() => {
        if (!this.giftInfo['gift_theme'] || this.giftInfo['gift_theme'].length === 0) {
          this.$router.push({path: '/info'})
          window.location.reload()
        }
      })
    },
    data () {
      return {
        swiperOption: {
          initialSlide: 0,
          lazyLoadingInPrevNext: true,
          loop: false,
          speed: 600,
          slidesPerView: 'auto',
          centeredSlides: true,
          followFinger: false,
          notNextTick: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          pagination: '.swiper-pagination',
          lazyLoading: true,
          onSlideChangeEnd: swiper => {
            console.log(swiper)
          }
        }
      }
    },
    methods: {
      ...mapMutations([
        'updateGiftCurrentTheme'
      ]),
      choiceTheme () {
        const activeIndex = this.$refs.mySwiper.swiper['activeIndex']
        const data = {
          name: this.giftInfo['gift_theme'][activeIndex]['theme_name'],
          id: this.giftInfo['gift_theme'][activeIndex]['theme_id']
        }
        this.updateGiftCurrentTheme(data)
        this.$router.push({path: '/info'})
      }
    }
  }
</script>
