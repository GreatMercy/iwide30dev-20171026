<template>
  <div v-if="item.re_pay === 1 && timeShow" class="count_down grayColorbf">
    支付倒计时
    <span class="goldColor font-size--28">{{time}}</span>
  </div>
</template>
<script>
  export default {
    name: 'orderTime',
    props: ['item'],
    created () {
      this.accountTimeout(this.time)
    },
    data () {
      return {
        time: '',
        timeShow: true
      }
    },
    methods: {
      // 计算倒计时
      accountTimeout (lastTime) {
        lastTime = this.item.orderstate.last_repay_time
        let newtime = new Date(this.getNowFormatDate())
        let oldtime = new Date(lastTime)
        let s1 = newtime.getTime()
        let s2 = oldtime.getTime()
        let total = (s2 - s1) / 1000
        let day = parseInt(total / (24 * 60 * 60))
        let afterDay = total - day * 24 * 60 * 60
        let hour = parseInt(afterDay / (60 * 60))
        let afterHour = total - day * 24 * 60 * 60 - hour * 60 * 60
        let min = parseInt(afterHour / 60)
        let afterMin = total - day * 24 * 60 * 60 - hour * 60 * 60 - min * 60
        if (total < 0) {
          return false
        }
        if (hour <= 0 && min <= 0 && afterMin <= 0) {
          clearTimeout()
          this.timeShow = false
        }
        // 补0
        if (hour >= 0 && hour <= 9) {
          hour = '0' + hour
        }
        if (min >= 0 && min <= 9) {
          min = '0' + min
        }
        if (afterMin >= 0 && afterMin <= 9) {
          afterMin = '0' + afterMin
        }
        this.time = hour + ':' + min + ':' + afterMin
        setTimeout(this.accountTimeout, 1000)
      },
      // 获取日期并格式化
      getNowFormatDate () {
        let date = new Date()
        let seperator1 = '-'
        let seperator2 = ':'
        let month = date.getMonth() + 1
        let strDate = date.getDate()
        if (month >= 1 && month <= 9) {
          month = '0' + month
        }
        if (strDate >= 0 && strDate <= 9) {
          strDate = '0' + strDate
        }
        let currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate + ' ' + date.getHours() + seperator2 +
          date.getMinutes() + seperator2 + date.getSeconds()
        return currentdate
      }
    }
  }
</script>
