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
  export default {
    components: {},
    computed: {
      min () {
        return this.$store.getters.reservationCalendarDate.min || null
      },
      max () {
        return this.$store.getters.reservationCalendarDate.max || null
      },
      defaultValue () {
        return this.$store.getters.reservationCalendarDate.defaultValue || null
      },
      calendarDate () {
        return this.$store.getters.reservationCalendarDate
      },
      today () {
        return this.$store.getters.reservationCalendarDate.today || null
      }
    },
    data () {
      return {}
    },
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
        if (this.calendarDate[container]) {
          const obj = parseInt(this.calendarDate[container][key]['num'])
          // 判断是否是今天
          if (this.today === key) {
            return obj === 0 ? '满房' : '今天'
          }
          if (obj === 0) {
            return '满房'
          }
        }
      },
      dateCellRender (date, y, m, d) {
        let container = y + '-' + stringLengthToTwo(m)
        let key = y + '-' + stringLengthToTwo(m) + '-' + String(parseInt(d))
        let str = '<p></p>'
        if (this.calendarDate[container]) {
          const obj = parseInt(this.calendarDate[container][key]['num'])
          if (obj === 0) {
            str = `<p class="font-size--20 font-color-extra-light-gray tip reservation__opacity">${obj}间</p>`
          }
          if (obj > 0 && obj <= 10) {
            str = `<p class="font-size--20 font-color-extra-light-gray tip">${obj}间</p>`
          } else if (obj > 100) {
            str = `<p class="font-size--20 font-color-extra-light-gray tip">>100</p>`
          }
        }
        return str
      },
      handleDateClick (value, isChecked) {
        this.$store.commit('updateReservationCheckInDate', value)
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

