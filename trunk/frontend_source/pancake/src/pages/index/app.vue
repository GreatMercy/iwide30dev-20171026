<template>
  <div class="jfk-pages jfk-pages__index">
    <div class="jfk-pages__theme is-game"></div>
    <div class="guide" v-show="isNewPlayer && hasDeviceMotion">
      <div class="phone"></div>
      <div class="tip font-size--32 font-color-light-gray">摇一摇，开始游戏</div>
      <div class="clock">
        <span class="num color-golden font-size--90">
          <transition name="clock" model="in-out">
            <i class="font-color-white">{{clockTime}}</i>
          </transition>
          </span>
        <span class="unit font-color-light-gray font-size--72">S</span>
      </div>
    </div>
    <div class="jfk-pages__body">
      <div class="game-info">
        <a href="javascript:;" class="font-size--24 font-color-extra-light-gray game-info__item game-raiders" @click="handleShowRaider">秘籍</a>
        <a href="javascript:;" class="font-size--24 font-color-extra-light-gray game-info__item game-desc" @click="handleShowDesc">说明</a>
      </div>
      <div class="game-music  font-color-extra-light-gray" @click="handleMusic" :class="{'is-closed': musicIsClosed, 'is-playing': !musicIsClosed && playStatus === 1}">
        <i class="jfk-font font-size--50 icon-bobing_icon_music_no"></i>
        <audio ref="audio" loop="true" perload="metadata" :src="diceSource"></audio>
      </div>
      <div class="game-cont">
        <div class="bowl-box">
        <div class="bowl">
          <div class="bowl-area  font-size--36" ref="bowl">
            <div class="dice-box"
              v-for="(item, index) in dices"
              :key="index"
              :style="{'-webkit-animation-name': diceBoxAnimationName, 'animation-name': diceBoxAnimationName}"
            >
              <div
                :style="{'-webkit-animation-name': diceAnimationName , 'animation-name': diceAnimationName}"
                :class="'dice-side-' + item"
                class="dice">
                <div class="side front">
                  <div class="dot center"></div>
                </div>
                <div class="side front inner"></div>
                <div class="side top">
                  <div class="dot dtop dleft"></div>
                  <div class="dot dbottom dright"></div>
                </div>
                <div class="side top inner"></div>
                <div class="side right">
                  <div class="dot dtop dleft"></div>
                  <div class="dot center"></div>
                  <div class="dot dbottom dright"></div>
                </div>
                <div class="side right inner"></div>
                <div class="side left">
                  <div class="dot dtop dleft"></div>
                  <div class="dot dtop dright"></div>
                  <div class="dot dbottom dleft"></div>
                  <div class="dot dbottom dright"></div>
                </div>
                <div class="side left inner"></div>
                <div class="side bottom">
                  <div class="dot center"></div>
                  <div class="dot dtop dleft"></div>
                  <div class="dot dtop dright"></div>
                  <div class="dot dbottom dleft"></div>
                  <div class="dot dbottom dright"></div>
                </div>
                <div class="side bottom inner"></div>
                <div class="side back">
                  <div class="dot dtop dleft"></div>
                  <div class="dot dtop dright"></div>
                  <div class="dot dbottom dleft"></div>
                  <div class="dot dbottom dright"></div>
                  <div class="dot center dleft"></div>
                  <div class="dot center dright"></div>
                </div>
                <div class="side back inner"></div>
                <div class="side cover x"></div>
                <div class="side cover y"></div>
                <div class="side cover z"></div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="tip font-color-light-gray font-size--30">可玩<i class="color-golden">{{+remainFreeTimes + +remainRewardTimes}}</i>局（免费可玩<i class="color-golden">{{remainFreeTimes}}</i>局，获得奖励<i class="color-golden">{{remainRewardTimes}}</i>局）</div>
        <div class="btn">
          <a href="javascript:;" @click="handlePlayGame" class="jfk-button font-size--34 jfk-button--primary jfk-button--free" :class="{'is-disabled': gameNotRight}">
            <template v-if="!hasDeviceMotion">开始游戏</template>
            <template v-else>
              <i class="jfk-font icon-bobing_icon_shake"></i>
              <i>摇一摇开始游戏</i>
            </template>
          </a>
        </div>
      </div>
      <jfk-support v-once></jfk-support>
    </div>
    <pancake-tabbar :selected="tabbarSelected"></pancake-tabbar>
    <jfk-popup
      v-model="timesVisible"
      :showCloseButton="true"
      class="jfk-popup__pancake">
      <div class="popup-cont">
        <div class="title font-color-white font-size--30 jfk-ta-c">您已用完今日免费次数</div>
        <div class="cont font-color-light-gray font-size--24">朋友一起来参与，随机可获得最多5次的奖励投掷机会</div>
      </div>
    </jfk-popup>
     <jfk-popup
      v-model="winNoCouponVisible"
      :showCloseButton="true"
      class="jfk-popup__pancake">
      <div class="popup-cont">
        <div class="title font-color-white font-size--30 jfk-ta-c">您今日领取此奖项已达上限</div>
        <div class="cont font-color-light-gray font-size--24">奖品已放至公众号下个人中心——我的优惠券进行查看，感谢您对我们一如既往的支持~
        </div>
        <div class="btns btns-2">
          <a href="javascript:;" class="jfk-button jfk-button--free jfk-button--primary is-plain" @click="handleCloseResult(2)">再来一把</a>
          <a href="javascript:;" class="jfk-button jfk-button--free jfk-button--primary" @click="handleUseCoupon">马上使用</a>
        </div>
      </div>
    </jfk-popup>
    <jfk-popup
      v-model="notWinVisible"
      class="jfk-popup__pancake-result not-win">
      <div class="popup-cont">
        <div class="cont">
          <div class="img"></div>
          <div class="tip font-color-white font-size--30">很遗憾什么都没有，不要灰心~</div>
        </div>
        <div class="btns btns-1">
          <a href="javascript:;" class="jfk-button jfk-button--free jfk-button--primary is-plain" @click="handleCloseResult(-1)">再来一把</a>
        </div>
      </div>
    </jfk-popup>
    <jfk-popup
      v-model="winVisible"
      class="jfk-popup__pancake-result is-win">
      <div class="popup-cont">
        <div class="cont">
          <div class="img">
            <div class="prize-name" :class="'prize-name-' + prizeType"></div>
          </div>
          <div class="tip font-color-white font-size--30">{{prizeContent ? '恭喜您获得了' + prizeContent : '你来晚啦，奖品领光啦'}}</div>
        </div>
        <div class="btns" :class="'btns-' + (isPrizeEnough ? 2 : 1)">
          <a href="javascript:;" class="jfk-button jfk-button--free jfk-button--primary is-plain" @click="handleCloseResult(1)">再来一把</a>
          <a href="javascript:;" class="jfk-button jfk-button--free jfk-button--primary" v-show="isPrizeEnough" @click="handleReceiveCoupon">立即领取</a>
        </div>
      </div>
    </jfk-popup>
    <jfk-popup
      :showCloseButton="true"
      position="bottom"
      v-model="descVisible"
      class="jfk-popup__desc">
      <div class="popup-box jfk-pl-30 jfk-pr-30" >
        <div class="desc-box" :style="{'max-height': maxHeight}">
          <section class="desc">
            <h5 class="title font-size--32 font-color-extra-light-gray"><span>玩法说明</span></h5>
            <p class="font-size--24 font-color-light-gray desc-tip" v-html="howToPlay"></p>
            <div class="play-img">
              <img :src="playImg" alt="玩法说明" width="100%"/>
            </div>
          </section>
          <section class="prizes">
            <h5 class="title font-size--32 font-color-extra-light-gray"><span>奖品说明</span></h5>
            <p class="desc-tip font-size--24 font-color-light-gray" v-html="prizeDescription"></p>
            <p class="desc-img" v-if="prizeDescImg">
              <img :src="prizeDescImg" width="100%"/>
            </p>
          </section>
        </div>
      </div>
    </jfk-popup>
    <jfk-popup
      v-model="raiderVisible"
      :showCloseButton="true"
      class="jfk-popup__pancake">
      <div class="popup-cont">
        <div class="title font-color-white font-size--30 jfk-ta-c">博饼秘籍</div>
        <div class="cont font-color-light-gray font-size--24">朋友一起来参与，随机可获得最多5次的奖励投掷机会</div>
      </div>
    </jfk-popup>
  </div>
</template>
<script>
  import pancakeTabbar from '@/components/tabbar'
  import diceSource from '@/assets/music/dice.mp3'
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getPancakeGameRoll, getPancakeGameParam, getPancakeGameShare } from '@/service/http'
  import parseTextareaValue from '@/utils/parseTextareaValue'
  import Shake from 'shake.js'
  import VueCookie from 'vue-cookie'
  import Vue from 'vue'
  Vue.use(VueCookie)
  // 检测是否有
  const shakeEvent = new Shake({
    timeout: 500
  })
  let jfkConfig = window.jfkConfig
  if (process.env.NODE_ENV === 'development') {
    jfkConfig = {
      couponUrl: '/coupon?a=b'
    }
  }
  export default {
    name: 'pancake-index',
    components: {
      pancakeTabbar
    },
    beforeCreate () {
      let urlParams = formatUrlParams(location.href)
      this.actNum = urlParams.act_num
      this.maxHeight = document.documentElement.clientHeight - 30 - 35 - 33 + 'px'
      this.hasDeviceMotion = shakeEvent.hasDeviceMotion
      this.isNewPlayer = !this.$cookie.get('pancake-user-id')
      this.diceSource = diceSource
    },
    created () {
      let vm = this
      getPancakeGameParam({
        act_num: this.actNum,
        url: location.href
      }).then(function (res) {
        vm.gameNotRight = false
        vm.remainFreeTimes = res.web_data.remain_free_times
        vm.remainRewardTimes = res.web_data.remain_reward_times
        vm.prizeDescription = parseTextareaValue(res.web_data.prize_description)
        vm.prizeDescImg = res.web_data.prize_img
        vm.howToPlay = parseTextareaValue(res.web_data.how_to_play)
        vm.playImg = res.web_data.play_img
        vm.timeStamp = Date.now()
        vm.startClock()
      }).catch(function () {
        vm.gameNotRight = true
        vm.isNewPlayer = false
      })
    },
    data () {
      return {
        clockTime: 3,
        dices: [6, 6, 6, 6, 1, 1],
        notWinVisible: false,
        winVisible: false,
        descVisible: false,
        timesVisible: false,
        musicIsClosed: false,
        raiderVisible: false,
        winNoCouponVisible: false,
        gameNotRight: true,
        popup: {
          title: '测试',
          cont: '测试',
          btns: ['确认', '取消']
        },
        tabbarSelected: 0,
        diceAnimationName: 'empty',
        diceBoxAnimationName: 'empty',
        playStatus: 0,
        playTimeStamp: 0,
        playImg: '',
        prizeType: -1,
        prizeName: '',
        prizeContent: '',
        prizeDescription: '',
        prizeDescImg: '',
        howToPlay: '',
        isPrizeEnough: false,
        canReceive: false,
        prizeId: -1,
        diceDuration: 1440,
        timer: null,
        remainFreeTimes: 0,
        remainRewardTimes: 0,
        timeStamp: 0
      }
    },
    watch: {
      timeStamp () {
        this.startShake()
      }
    },
    computed: {
      diceTimes () {
        return 3 * this.diceDuration
      }
    },
    methods: {
      startClock () {
        let vm = this
        let timer = setInterval(function () {
          vm.clockTime = vm.clockTime - 1
          if (vm.clockTime === 0) {
            vm.$cookie.set('pancake-user-id', Date.now())
            vm.isNewPlayer = false
            clearInterval(timer)
          }
        }, 1000)
      },
      handleMusic () {
        this.musicIsClosed = !this.musicIsClosed
        if (this.playStatus === 1) {
          this.$refs.audio[this.musicIsClosed ? 'pause' : 'play']()
        }
      },
      handleShowRaider () {
        this.raiderVisible = true
      },
      handleShowDesc () {
        this.descVisible = true
      },
      handleCloseResult (type) {
        let vm = this
        switch (type) {
          case -1:
            vm.notWinVisible = false
            break
          case 1:
            vm.winVisible = false
            break
          default:
            vm.winNoCouponVisible = false
        }
        this.startShake()
      },
      playGame () {
        let vm = this
        if (this.playStatus === 1) {
          return
        }
        this.prizeType = -1
        this.playTimeStamp = Date.now()
        this.diceBoxAnimationName = 'rotate'
        this.diceAnimationName = 'spin-duplicate'
        this.playStatus = 1
        this.stopShake()
        if (!this.musicIsClosed) {
          this.$refs.audio.play()
        }
        getPancakeGameRoll({
          act_num: this.actNum
        }).then(function (res) {
          const { prize_type: prizeType, throw_num: throwNum, prize_id: prizeId, can_receive: canReceive, is_prize_enough: isPrizeEnough, prize_name: prizeName, prize_content: prizeContent } = res.web_data
          vm.prizeType = prizeType
          vm.dices = throwNum.split(',')
          vm.prizeId = prizeId
          vm.isPrizeEnough = isPrizeEnough
          vm.canReceive = canReceive
          vm.prizeName = prizeName
          vm.prizeContent = prizeContent
          let times = vm.remainFreeTimes - 1
          if (times < 0) {
            times = vm.remainRewardTimes - 1
            vm.remainRewardTimes = times
          } else {
            vm.remainFreeTimes = times
          }
          vm.stopGameByTime(true)
        }).catch(function () {
          vm.dices = [2, 2, 6, 5, 2, 1]
          vm.stopGameByTime()
        })
      },
      handlePlayGame () {
        this.readyPlayGame()
      },
      stopGameByTime (showDiceResult) {
        let time = Date.now()
        let vm = this
        let gap = time - vm.playTimeStamp
        let t
        clearTimeout(vm.timer)
        if (gap < vm.diceTimes) {
          t = vm.diceTimes - gap
        } else if (gap % vm.diceDuration) {
          t = vm.diceDuration - gap % vm.diceDuration
        }
        if (t) {
          vm.timer = setTimeout(function () {
            vm.stopGame()
            showDiceResult && vm.showDiceResult()
          }, t)
        } else {
          vm.stopGame()
          showDiceResult && vm.showDiceResult()
        }
      },
      stopGame () {
        this.diceBoxAnimationName = 'empty'
        this.diceAnimationName = 'empty'
        this.playStatus = 0
        if (!this.musicIsClosed) {
          this.$refs.audio.pause()
          this.$refs.audio.currentTime = 0
        }
      },
      showDiceResult () {
        if (this.prizeType === 0) {
          this.notWinVisible = true
        } else if (this.isPrizeEnough) {
          if (this.canReceive) {
            this.winVisible = true
          } else {
            this.winNoCouponVisible = true
          }
        } else {
          this.winVisible = true
        }
      },
      readyPlayGame () {
        if (this.remainFreeTimes || this.remainRewardTimes) {
          this.playGame()
        } else {
          this.timesVisible = true
        }
      },
      startShake () {
        shakeEvent.start()
        window.addEventListener('shake', this.readyPlayGame, false)
      },
      stopShake () {
        window.removeEventListener('shake', this.shakeEvent, false)
        shakeEvent.stop()
      },
      shareSuccess () {
        let vm = this
        getPancakeGameShare({
          act_num: this.actNum
        }).then(function (res) {
          vm.remainRewardTimes = vm.remainRewardTimes + (Number(res.web_data.reward_times) || 0)
        })
      },
      handleReceiveCoupon () {
        location.href = jfkConfig.couponUrl + '&prize_id=' + this.prizeId
      },
      handleUseCoupon () {
        if (process.env.NODE_ENV === 'development') {
          alert('个人中心')
        }
        location.href = jfkConfig.memberCenterUrl
      }
    }
  }
</script>
