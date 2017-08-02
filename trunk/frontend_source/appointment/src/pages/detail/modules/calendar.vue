<template>
  <div class="calendar">
    <div class="wrap pr">

      <div ref="week" id="week">
        <h1 class="f32 ta-c">
          <i class="arrow arrow_l pa" @click="last" :class="{'disabled': !canLast}"></i>
          <span v-html="dateTitle"></span>
          <i class="arrow arrow_r pa" @click="next" :class="{'disabled': !canNext}"></i>
        </h1>

        <div class="date-week">
          <div class="dp-f week">
            <div class="f28 flex-1 ta-c">日</div>
            <div class="f28 flex-1 ta-c">一</div>
            <div class="f28 flex-1 ta-c">二</div>
            <div class="f28 flex-1 ta-c">三</div>
            <div class="f28 flex-1 ta-c">四</div>
            <div class="f28 flex-1 ta-c">五</div>
            <div class="f28 flex-1 ta-c">六</div>
          </div>
        </div>
      </div>


      <div class="table-container" :style="'height:' + containerHeight + 'px'">
        <div>
          <table ref="scroll">
            <tr v-for="(item, index) in calendarArray" :key="index">
              <td v-for="value in item"
                  @click="choiceDate(value.store, value.dateId, value.currentDate, value.disabled)">
                <p class="day f30 ta-c"
                   v-html="value.day"
                   v-if="value"
                   :class="{'disabled': value.disabled,
                          'active': value.dateId === dateId && value.dateId !== ''
                 }">
                </p>

                <p class="price f20 ta-c"
                   v-html="'¥' + value.price"
                   v-if="value"
                   :class="{'disabled': value.disabled}">
                </p>

                <p class=" store f20 ta-c"
                   v-if="value" v-html="'余' + value.store"
                   :class="{'disabled': value.disabled}">
                </p>
              </td>
            </tr>
          </table>
        </div>
      </div>


      <div id="number">
        <div class="number-container">
          <div class="number dp-f" ref="number">
            <div class="fl f28 flex-1">请选择消费份数</div>
            <div class="fl ta-r flex-1">
              <input-number :max="max" v-model="inputValue" :min="1" :defaultValue="inputValue"
                            :disabled="disabled"></input-number>
            </div>
          </div>
        </div>
      </div>

    </div>

    <a href="javascript:void(0)" class="f32 sure" @click="submit" :class="{'disabled': submitDisabled}"
       ref="btn">确 认</a>
  </div>
</template>

<script>
  import moment from 'moment'
  import inputNumber from '@components/inputNumber' // 数字输入框
  import { successMessage, errorMessage } from '@js/popup'

  export default {
    components: {
      inputNumber
    },
    computed: {
      maxDate () {
        return Math.max.apply(null, this.getAllDate())
      },
      minDate () {
        return Math.min.apply(null, this.getAllDate())
      },
      duplicateYearMonthArray () {
        return Array.from(new Set(this.yearMonthArray))
      },
      contrastDate () {
        return this.currentYear + '-' + this.currentMonth
      },
      buyType () {
        return this.$store.getters.buyType
      },
      goodsDetail () {
        return this.$store.getters.goodsDetail
      },
      show () {
        return this.$store.getters.calendarShow
      },
      spec () {
        return this.$store.getters.currentSpec || ''
      },
      date () {
        return this.$store.getters.date || {}
      }
    },
    watch: {
      spec (val) {
        if (val) {
          this.currentDate = ''
          this.defaultDay = {}
          this.getCalendar()
        }
      }
    },
    data () {
      return {
        containerHeight: 0, // 滚动区域的高度
        submitDisabled: false, // 是否可以提交
        defaultDay: {}, // 默认选中的日期
        inputValue: 1, // 选中的库存
        max: 1, // 库存的最大数量
        dateTitle: '', // 当前的年份和月份
        dateId: '', // 选中的dateId
        calendarArray: [],  // 日历的数组
        monthArray: [], // 所有的月份
        yearArray: [], // 所有的年份
        yearMonthArray: [], // 所有年月的数组
        currentDate: '', // 用户当前选中的日期
        currentYear: '', // 当前的年份
        currentMonth: '', // 当前的月份(1-12)
        currentDay: '', // 当前的日期
        canNext: true, // 能否点击下一步
        canLast: true, // 能否点击上一步
        disabled: true // 能否使用输入框
      }
    },
    created () {
      // 如果当前日历没有数据 跳转回详情页面
      if (JSON.stringify(this.date) === '{}') {
        this.$router.push('/')
      } else {
        this.getCalendar()
      }
    },
    methods: {
      checkSubmitDisabled () {
        let goodsNumber = this.inputValue
        let currentDate = this.currentDate
        const titleTime = parseInt(this.dateTitle.substr(0, 4)) + '-' + parseInt(this.dateTitle.substr(5, 2))
        const currentTime = moment(currentDate).format('YYYY') + '-' + moment(currentDate).format('M')
        if (goodsNumber <= 0 || !!currentDate === false || titleTime !== currentTime) {
          this.submitDisabled = true
          this.disabled = true
        } else {
          this.submitDisabled = false
        }
      },
      submit () {
        // 如果没有选中份数 无法加入购物车
        let goodsNumber = this.inputValue
        let currentDate = this.currentDate
        if (this.submitDisabled) {
          return false
        }
        this.$store.dispatch('addCart', {
          'goods_num': goodsNumber,
          'book_day': currentDate
        }).then((res) => {
          if (res.status !== 200) {
            errorMessage(res.msg)
          } else {
            switch (this.buyType) {
              case 1:
                this.clearCalendar()
                this.getCalendar()
                successMessage(res.msg)
                this.$router.push('/')
                break
              case 2:
                location.href = res.data.url
                break
            }
          }
        })
      },
      getAllDate () {
        let arr = this.duplicateYearMonthArray
        let result = []
        arr.forEach((item) => {
          result.push(moment(item).valueOf())
        })
        return result
      },
      choiceDate (store, dateId, currentDate, disabled) {
        if (store > 0 && disabled !== 1) {
          this.disabled = false
          this.dateId = dateId
          this.currentDate = currentDate
          this.inputValue = 1
          this.max = parseInt(store)
          let key = currentDate.substr(0, currentDate.length - 3)
          this.defaultDay[key] = {
            'dateId': dateId,
            'store': store,
            'currentDate': currentDate
          }
          this.checkSubmitDisabled()
        }
      },
      isLeap (year) {
        return year % 4 === 0 ? (year % 100 !== 0 ? 1 : (year % 400 === 0 ? 1 : 0)) : 0
      },
      getDateDetail (date) {
        if (this.date[date] && this.date[date][this.spec]) {
          return this.date[date][this.spec]
        } else {
          return {
            'date_id': '',
            'inter_id': '',
            'spu_id': '',
            'goods_id': '',
            'date': '',
            'goods_price': '',
            'goods_stock': 0,
            'shop_id': ''
          }
        }
      },
      setDefaultDay () {
        // 判断默认选中的日期是否是今天
        if (JSON.stringify(this.defaultDay) === '{}') {
          let store, content, dateId
          if (moment(this.goodsDetail['today_date']).valueOf() > moment(this.goodsDetail['default_day']).valueOf()) {
            content = this.getDateDetail(this.goodsDetail['today_date'])
          } else if (moment(this.goodsDetail['today_date']).valueOf() === moment(this.goodsDetail['default_day']).valueOf()) {
            if (parseInt(this.goodsDetail['today_status']) === 0) {
              this.checkSubmitDisabled()
              return false
            } else {
              content = this.getDateDetail(this.goodsDetail['today_date'])
            }
          } else {
            content = this.getDateDetail(this.goodsDetail['default_day'])
          }
          store = content['goods_stock']
          dateId = content['date_id']
          this.choiceDate(store, dateId, this.goodsDetail['default_day'])
        } else {
          let key = this.currentYear + '-' + this.currentMonth
          const content = this.defaultDay[key]
          if (!!content === true) {
            this.choiceDate(content.store, content.dateId, content.currentDate)
          } else {
            this.checkSubmitDisabled()
          }
        }
      },
      getCalendar (currentYear, currentMonth) {
        const endDate = moment(this.goodsDetail['today_date']).add(parseInt(this.goodsDetail['book_day']), 'days').format('YYYY-MM-DD')
        const endDateNumber = moment(endDate).valueOf()
        // 获取日历的数组
        this.calendarArray = []
        let keys = []
        // 数据中的所有月份 和 年数
        for (let key in this.date) {
          keys.push(key)
        }
        keys = keys.sort()
        for (let i = 0; i < keys.length; i++) {
          let key = keys[i]
          let monthItem = parseInt(moment(key).format('MM')) - 1
          let yearItem = parseInt(moment(key).format('YYYY'))
          this.monthArray.push(monthItem)
          this.yearArray.push(yearItem)
          let pushMonthDate = (monthItem + 1) < 10 ? '0' + (monthItem + 1) : (monthItem + 1)
          this.yearMonthArray.push(yearItem + '-' + pushMonthDate)
        }
        let i, k
        // 进来显示的年份
        const y = currentYear || this.yearArray[0]  // 年份
        // 进来需要显示的月份 （0-11）
        const m = currentMonth || this.monthArray[0] // 月份
        // 这个月份的第一天
        let firstDay = new Date(y, m, 1)
        // 这个星期第一天是星期几
        let dayOfWeek = firstDay.getDay()
        let daysPerMonth = [31, 28 + this.isLeap(y), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
        let strNum = Math.ceil((dayOfWeek + daysPerMonth[m]) / 7)
        this.dateTitle = y + '年' + (m + 1) + '月'
        this.currentYear = y + ''
        this.currentMonth = (m + 1) < 10 ? '0' + (m + 1) : (m + 1)
        for (i = 0; i < strNum; i += 1) {
          this.calendarArray.push([])
          for (k = 0; k < 7; k++) {
            let idx = 7 * i + k
            let date = idx - dayOfWeek + 1
            if (date <= 0 || date > daysPerMonth[m]) {
              this.calendarArray[i].push('')
            } else {
              let d = idx - dayOfWeek + 1
              let showDay = d < 10 ? '0' + d : d
              // 显示的月份
              let showMonth = this.currentMonth
              // 当前的日期
              let currentDate = y + '-' + showMonth + '-' + showDay
              // 获取库存
              let content = this.getDateDetail(currentDate)
              let store = content['goods_stock']
              // 判断今天是否可以预约
              if (this.goodsDetail['today_date'] === currentDate) {
                store = this.goodsDetail['today_status'] ? store : 0
              }
              // 判断日期是否过去
              if (moment(this.goodsDetail['today_date']).valueOf() > moment(currentDate).valueOf()) {
                store = 0
              }
              // date_id
              let dateId = content['date_id']
              // 价格
              let price = content['goods_price']
              if (price === '') {
                price = 0
              }
              // 是否可选
              let disabled = store > 0 ? 0 : 1
              // 判断日期是否过了最大的限制
              if (moment(currentDate).valueOf() > endDateNumber) {
                disabled = 1
              }
              this.calendarArray[i].push({
                'day': d,
                'store': store,
                'disabled': disabled,
                'dateId': dateId,
                'price': price,
                'currentDate': currentDate
              })
            }
          }
        }
        this.checkCanClick()
        this.setDefaultDay()
        this.$nextTick(() => {
          this.containerHeight = (i * 82) + 118
          document.getElementsByTagName('body')[0].scrollTop = 0
        })
      },
      // 清空日历的数据
      clearCalendar () {
        this.defaultDay = {}  // 默认的日期
        this.dateId = ''  // 选中的dateId
        this.calendarArray = [] // 日历的数组
        this.monthArray = [] // 月份的数组
        this.yearArray = [] // 年份的数组
        this.currentDate = ''
        this.max = 0
        this.yearMonthArray = []
        this.inputValue = 1
      },
      getCurrent (status) {
        const contrastDate = this.currentYear + '-' + this.currentMonth
        let ind = this.duplicateYearMonthArray.indexOf(contrastDate)
        let nextDate = status ? this.duplicateYearMonthArray[ind + 1] : this.duplicateYearMonthArray[ind - 1]
        let currentMonth = parseInt(moment(nextDate).format('MM')) - 1
        let currentYear = parseInt(moment(nextDate).format('YYYY'))
        return {
          currentMonth,
          currentYear
        }
      },
      // 检测是否能够点击切换上下月
      checkCanClick () {
        if (moment(this.contrastDate).valueOf() <= this.minDate) {
          this.canLast = false
        } else {
          this.canLast = true
        }
        if (moment(this.contrastDate).valueOf() >= this.maxDate) {
          this.canNext = false
        } else {
          this.canNext = true
        }
      },
      // 点击上一个月
      last () {
        if (moment(this.contrastDate).valueOf() <= this.minDate) {
          return false
        }
        let current = this.getCurrent(false)
        this.getCalendar(current.currentYear, current.currentMonth)
        this.max = 1
      },
      // 点击下一个月
      next () {
        // 当前的月份大于最大的月份表示 不能继续下一个月
        if (moment(this.contrastDate).valueOf() >= this.maxDate) {
          return false
        }
        let current = this.getCurrent(true)
        this.getCalendar(current.currentYear, current.currentMonth)
        this.max = 1
      }
    }
  }
</script>

<style scoped lang='scss'>
  @import '../../../common/scss/include';

  .calendar {
    .sure {
      @include fixedBtn();
      &.disabled {
        background: $gray;
      }
    }
    z-index: 999999999;

    .wrap {
      padding: 0 4%;

      .table-container {
        margin-top: px2rem(280);
      }

      #week {
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 99;
        background: $darkBlack;
      }

      #number {
        position: fixed;
        width: 100%;
        left: 0;
        bottom: px2rem(100);
        background: $darkBlack;
        z-index: 99;
        .number-container {
          padding: 0 px2rem(26);
        }
      }

      h1 {
        padding-top: px2rem(62);
        padding-bottom: px2rem(72);
        color: $white;

        .arrow {
          width: px2rem(60);
          height: px2rem(114);
          top: 0;

          &:after {
            content: '';
            position: absolute;
            width: px2rem(14);
            height: px2rem(14);
            transform: rotate(45deg);
            top: px2rem(8+60);
          }
        }

        .arrow_r {
          right: px2rem(100);
          &:after {
            right: 0;
            border-top: 1px solid $white;
            border-right: 1px solid $white;
          }

          &.disabled {
            &:after {
              border-top: 1px solid $arrowDisabledColor;
              border-right: 1px solid $arrowDisabledColor;
            }
          }
        }

        .arrow_l {
          left: px2rem(100);
          &:after {
            left: 0;
            border-bottom: 1px solid $white;
            border-left: 1px solid $white;
          }

          &.disabled {
            &:after {
              border-bottom: 1px solid $arrowDisabledColor;
              border-left: 1px solid $arrowDisabledColor;
            }
          }
        }
      }

      .date-week {
        padding: 0 4%;
      }
      .week {
        border-bottom: 1px solid $borderColor;
        padding-bottom: px2rem(40);
        color: $fontColor;
      }

      table {
        width: 100%;
        tr {

          td {
            padding-bottom: px2rem(26);

            p {
              margin: 0 auto;
            }

            .day {
              width: px2rem(78);
              height: px2rem(78);
              line-height: px2rem(78);
              color: $white;
              border-radius: 100%;

              &.disabled {
                color: $disabledColor;
              }

              &.active {
                background: $orange;
                box-shadow: 0 0 8px $orange;
              }
            }

            .price {
              margin-top: px2rem(6);
              color: $gray;
              &.disabled {
                color: $disabledColor;
              }
            }

            .store {
              color: $gray;
              margin-top: px2rem(14);
              &.disabled {
                color: $disabledColor;
              }
            }

            &:last-child {
              padding-bottom: 0;
            }

          }
        }

      }

      .number {
        border-top: 1px solid $borderColor;
        padding: px2rem(24) 0 px2rem(26);
        width: 100%;
        height: px2rem(68);
        overflow: hidden;
        .fl {
          overflow: hidden;
          vertical-align: top;
          &:first-child {
            height: px2rem(68);
            line-height: px2rem(68);
            color: $lightGray;
            padding-left: px2rem(20);
          }
        }
      }

    }
  }
</style>
