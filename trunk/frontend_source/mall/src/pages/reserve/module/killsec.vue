<template>
  <div class="killsec-time jfk-ml-30 jfk-mr-30">
    <div class="cont card jfk-flex is-align-middle">
      <span class="jfk-font icon-mall_icon_countdown color-golden font-size--30"></span>
      <template v-if="!killsecFinished">
      <span class="font-size--22 font-color-light-gray">支付截止时间</span>
      <span class="time color-golden font-size--30">{{minutes}}:{{seconds}}</span>
      </template>
      <span v-else class="font-size--22 error font-color-light-gray">支付超时</span>
    </div>
  </div>
</template>
<script>
  import KillsecTime from 'jfk-ui/lib/killsec-time'
  import stringLengthToTwo from 'jfk-ui/lib/string-length-to-two.js'
  export default {
    name: 'reverse-killsec-time',
    data () {
      return {
        minutes: '00',
        seconds: '00',
        killsecTime: {},
        killsecFinished: false
      }
    },
    created () {
      // 倒计时5分钟
      let that = this
      this.killsecTime = new KillsecTime({
        countdown: this.countdown,
        callback: function (type, val, ctx) {
          console.log(ctx.minutes)
          console.log(ctx.seconds)
          if (ctx.process === 0) {
            that.killsecFinished = true
            ctx.close()
            that.$emit('killsec-finish', 2)
          }
          if (ctx.process === 2) {
            that.minutes = stringLengthToTwo(ctx.minutes)
            that.seconds = stringLengthToTwo(ctx.seconds)
          }
        }
      })
    },
    props: {
      countdown: {
        type: Number,
        required: true
      }
    }
  }
</script>
