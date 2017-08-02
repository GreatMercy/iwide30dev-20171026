<template>
  <div class="count-down">
    <div class="content ta-c f22">
      订单将在<span class="time f28" v-html="time"></span>后自动取消，请您尽快完成支付！


    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        time: '00:00',
        timeLeft: 60000
      }
    },
    props: {
      remainingTime: {
        type: Number,
        default: 60000
      }
    },
    watch: {
      remainingTime (value, oldValue) {
        if (value) {
          this.timeLeft = value
        }
      }
    },
    created () {
      this.timeLeft = this.remainingTime
    },
    methods: {
      countTime () {
        if (this.timeLeft === 0) {
          this.time = '00:00'
          window.location.reload()
          this.$emit('end')
          return false
        }
        let minutes = parseInt(this.timeLeft / (60 * 1000), 10)
        let startMinutes = minutes > 9 ? minutes : '0' + minutes
        let second = parseInt((this.timeLeft - startMinutes * 60 * 1000) / 1000)
        let startSec = second > 9 ? second : '0' + second
        this.timeLeft = this.timeLeft - 1000
        this.time = startMinutes + ':' + startSec
        setTimeout(this.countTime, 1000)
      }
    },
    mounted () {
      this.countTime()
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../common/scss/include';

  .count-down {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: px2rem(66);
    z-index: 999;
    background: -webkit-linear-gradient(left, rgba(18, 18, 18, 1), rgba(28, 28, 28, 1), rgba(28, 28, 28, 1), rgba(18, 18, 18, 1));

    .content {
      height: px2rem(66);
      line-height: px2rem(66);
      color: $gray;
    }

    .time {
      color: $countColor;
      margin: 0 px(12);
    }
  }
</style>
