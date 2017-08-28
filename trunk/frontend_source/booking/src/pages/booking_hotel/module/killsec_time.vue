<template>
  <div class="jfk-clock is-default">
    <template v-if="process">
      <span class="prefix">还有</span>
      <span class="dates font-color-white" v-show="dates">{{dates | fillStringLengthTWo}}</span>
      <span class="unit" v-show="dates">天</span>
      <span class="hours font-color-white">{{hours | fillStringLengthTWo}}</span>
      <span v-once class="unit">时</span>
      <span class="minutes font-color-white">{{minutes | fillStringLengthTWo}}</span>
      <span v-once class="unit">分</span>
      <span class="seconds font-color-white">{{seconds | fillStringLengthTWo}}</span>
      <span v-once class="unit">秒</span>
      <span class="status">{{process === 1 ? '开始' : '结束'}}</span>
    </template>
    <span class="tip" v-else>秒杀活动已结束，下次早点来哟！</span>
  </div>
</template>
<script>
  import { millsecondsToDHMS } from '@/utils/utils'
  export default {
    name: 'killsec-time',
    data () {
      return {
        process: 1,
        dates: 0,
        hours: 0,
        minutes: 0,
        seconds: 0
      }
    },
    created () {
      let that = this
      let reminders
      if (that.startTimeNodeReminder) {
        reminders = that.startTimeNodeReminder.concat()
      }
      this.interval = setInterval(function () {
        let now = Date.now()
        let gap1 = now - that.startTime
        let gap2 = that.endTime - now
        if (gap1 < 0) {
          that.process = 1
          let dhms = millsecondsToDHMS(gap1)
          that.dates = dhms.dates
          that.hours = dhms.hours
          that.minutes = dhms.minutes
          that.seconds = dhms.seconds
          if (reminders) {
            let index = reminders.indexOf(-gap1)
            if (index > -1) {
              that.$emit('on-start-time-node-reminder', reminders[index], 1)
              reminders.splice(index, 1)
            } else {
              let len = reminders.length
              let i = 0
              while (i < len) {
                if (reminders[i] > -gap1) {
                  that.$emit('on-start-time-node-reminder', reminders[i], 0)
                  reminders.splice(i, 1)
                  break
                }
                i++
              }
            }
          }
          that.$emit('has-start', now)
        } else if (gap2 > 0 || gap1 === 0) {
          if (gap1 === 0) {
            that.$emit('on-start', now)
          }
          that.process = 2
          let dhms = millsecondsToDHMS(gap2)
          that.dates = dhms.dates
          that.hours = dhms.hours
          that.minutes = dhms.minutes
          that.seconds = dhms.seconds
        } else {
          if (gap2 === 0) {
            that.$emit('on-finish', now)
          } else {
            that.$emit('has-finish', now)
          }
          that.process = 0
          clearInterval(that.interval)
        }
      }, 1000)
    },
    filters: {
      fillStringLengthTWo (value) {
        return (value < 10 ? '0' : '') + value
      }
    },
    computed: {
      startTime () {
        return new Date(this.start).getTime()
      },
      endTime () {
        return new Date(this.end).getTime()
      }
    },
    props: {
      start: {
        type: String,
        required: true
      },
      end: {
        type: String,
        required: true
      },
      'startTimeNodeReminder': {
        type: Array
      }
    }
  }
</script>
