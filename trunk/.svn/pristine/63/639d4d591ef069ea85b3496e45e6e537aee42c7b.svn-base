<template>
  <div class="jfk-pages jfk-pages__reservation">
    <!--:dateCellRender="dateCellRender"-->
    <div class="jfk-pages__theme"></div>

    <div class="reservation-calendar jfk-pl-30 jfk-pr-30">
      <jfk-calendar ref="jfkCalendar"
                    :minDate="min"
                    :maxDate="max"
                    :defaultValue="defaultValue"
                    :disabledDate="disabledDate"
                    @date-click="handleDateClick"
                    format="yyyy/MM/dd" class="font-size--28">
      </jfk-calendar>
    </div>

  </div>
</template>

<script>
  export default {
    components: {},
    data () {
      return {
        // 最少日期
        min: null,
        // 最大日期
        max: null,
        // 默认值
        defaultValue: null
      }
    },
    methods: {
      disabledDate (date, disabled, y, m, d) {
        console.log(y, m, d)
        // let key = y + '/' + stringLengthToTwo(m) + '/' + stringLengthToTwo(d)
        // let data = this.list[key]
        // if (key < this.today || !data || data.spec_stock === '0') {
        //  return true
        // }
      },
      handleDateClick (value, isChecked) {
        console.log(value, isChecked)
      }
    },
    created () {
    }
  }
</script>

