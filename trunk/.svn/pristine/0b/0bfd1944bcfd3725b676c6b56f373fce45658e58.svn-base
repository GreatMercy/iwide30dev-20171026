<template>
  <div class="killsec-time">
    <i class="jfk-font icon-mall_icon_countdown color-golden font-size--30"></i>
    <span class="font-size--22 font-color-light-gray">支付截止时间</span>
    <span class="time color-golden font-size--30">{{minutes}}:{{seconds}}</span>
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
        killsecTime: {}
      }
    },
    created () {
      let start = Date.now()
      let that = this
      this.killsecTime = new KillsecTime({
        start,
        end: this.end,
        callback: function (type, val, ctx) {
          if (ctx.process === 0) {
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
      end: {
        type: String,
        required: true
      }
    }
  }
</script>
