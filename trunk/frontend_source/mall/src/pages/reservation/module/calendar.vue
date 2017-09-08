<template>
  <div class="jfk-pages jfk-pages__reservation">
    <div class="jfk-pages__theme"></div>
    <div class="reservation-calendar jfk-pl-30 jfk-pr-30">
      <jfk-calendar ref="jfkCalendar"
                    :dateCellRender="dateCellRender"
                    :minDate="min"
                    :maxDate="max"
                    :defaultValue="defaultValue"
                    :dateTextRender="dateTextRender"
                    :disabledDate="disabledDate"
                    @date-click="handleDateClick"
                    format="yyyy/MM/dd" class="font-size--28">
      </jfk-calendar>
    </div>
  </div>
</template>

<script>
  import stringLengthToTwo from 'jfk-ui/lib/string-length-to-two.js'
  import moment from 'moment'
  export default {
    components: {},
    computed: {
      min () {
        return this.$store.getters.reservationCalendarDate.min || null
      },
      max () {
        return this.$store.getters.reservationCalendarDate.max || null
      },
      calendarDate () {
        return this.$store.getters.reservationCalendarDate
      },
      today () {
        return this.$store.getters.reservationCalendarDate.today || null
      }
    },
    data () {
      return {
        defaultValue: null
      }
    },
    watch: {},
    methods: {
      disabledDate (date, disabled, y, m, d) {
        let container = y + '-' + stringLengthToTwo(m)
        let key = y + '-' + stringLengthToTwo(m) + '-' + String(parseInt(d))
        if (this.calendarDate[container]) {
          // 1 可订、2 不可定、3 满房
          const obj = parseInt(this.calendarDate[container][key]['can_booking'])
          if (obj === 2 || obj === 3) {
            return true
          }
        }
      },
      dateTextRender (date, disabled, y, m, d) {
        let container = y + '-' + stringLengthToTwo(m)
        let key = y + '-' + stringLengthToTwo(m) + '-' + String(parseInt(d))
        // 用于转换 时间戳 对比  2018-01-01
        let contrastKey = y + '-' + stringLengthToTwo(m) + '-' + stringLengthToTwo(String(parseInt(d)))
        if (this.calendarDate[container]) {
          const obj = parseInt(this.calendarDate[container][key]['num'])
          // 判断是否是今天
          if (this.today['key'] === key) {
            return obj === 0 ? '满房' : '今天'
          }
          // 判断是否小于今天
          if (moment(contrastKey).valueOf() < moment(this.today).valueOf()) {
            return d
          }
          if (obj === 0) {
            return '满房'
          }
        }
      },
      dateCellRender (date, y, m, d) {
        return ''
      },
      handleDateClick (value, isChecked) {
        this.$store.commit('updateReservationCheckInDate', value)
        this.defaultValue = new Date(value)
        this.$router.push('/form')
      }
    },
    created () {
      if (this.min === null) {
        this.$router.push('/form')
      }
    }
  }
</script>
