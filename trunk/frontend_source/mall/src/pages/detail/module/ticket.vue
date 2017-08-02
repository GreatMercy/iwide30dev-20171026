<template>
  <div class="good-spec">
    <jfk-popup class="jfk-popup__specTicket" :onClose="onClose" v-model="specVisible" position="bottom" :showCloseButton="true" :closeOnClickModal="false" :lockScroll="true">
      <div class="popup-box">
        <div class="popup-ticket" >
          <div ref="sectionTip" class="section-title font-size--24 font-color-extra-light-gray">选择日期</div>
          <div class="ticket-calendar">
            <jfk-calendar ref="jfkCalendar" :minDate="min" :maxDate="max" :defaultValue="defaultValue" :dateCellRender="dateCellRender" :disabledDate="disabledDate" @date-click="handleDateClick" format="yyyy/MM/dd" class="font-size--28"></jfk-calendar>
          </div>
        </div>
      </div>
    </jfk-popup>
    <div class="good-spec__footer" v-show="specVisible">
      <div class="jfk-clearfix">
        <div class="jfk-fl-l price color-golden jfk-flex is-align-middle">
          <div class="cont ">
          <span class="jfk-price__currency font-size--24">￥</span>
          <span class="jfk-price__number font-size--48">{{pricePackage}}</span>
          </div>
        </div>
        <div class="jfk-fl-r control">
          <button :disabled="buttonDisabled" @click="handleSubmitSettingId" class="jfk-button jfk-button--free jfk-button--higher jfk-button--primary font-size--34">立即购买</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import mixin from './mixin'
  import stringLengthToTwo from 'jfk-ui/lib/string-length-to-two.js'
  import { getPackageTickTime } from '@/service/http'
  const parseList = function (data) {
    const { data: d, enddate, startdate, settlement } = data
    let list = {}
    for (let i in d) {
      let dd = d[i]
      dd.spec_price = Number(dd.spec_price)
      list[dd.date] = d[i]
    }
    return {
      list,
      startdate,
      enddate,
      settlement
    }
  }
  export default {
    name: 'good-spec',
    mixins: [mixin],
    data () {
      return {
        list: {},
        min: null,
        max: null,
        settlement: '',
        defaultValue: null
      }
    },
    created () {
      let that = this
      getPackageTickTime({
        pid: this.productId,
        bsn: ''
      }).then(function (res) {
        let data = res.web_data.setting_list
        let result = parseList(data)
        that.list = result.list
        let min = new Date(result.startdate * 1000)
        let max = new Date(result.enddate * 1000)
        let today = new Date()
        let defaultValue = today
        if (max < today) {
          max = today
        }
        if (min > today) {
          defaultValue = min
        }
        that.min = min
        that.max = max
        that.defaultValue = defaultValue
        that.settlement = result.settlement
      }).catch(function (err) {
        console.log(err)
      })
    },
    computed: {
      today () {
        let d = new Date()
        return d.getFullYear() + '/' + stringLengthToTwo(d.getMonth() + 1) + '/' + stringLengthToTwo(d.getDate())
      }
    },
    mounted () {
      // 更新calendar的最大高度
      // 85 顶部 底部相加高度  34 20 poup 顶部 底部高度
      let screenHeight = window.innerHeight - 85 - 20 - 34
      let $tools = this.$refs.jfkCalendar.$el.querySelector('.jfk-calendar__tools')
      let $thead = this.$refs.jfkCalendar.$el.querySelector('.jfk-calendar__thead')
      let $tbody = this.$refs.jfkCalendar.$el.querySelector('.jfk-calendar__tbody')
      let $sectionTip = this.$refs.sectionTip
      let toolHeight = Math.ceil(parseFloat(window.getComputedStyle($tools, null).getPropertyValue('height')))
      let theadHeight = Math.ceil(parseFloat(window.getComputedStyle($thead, null).getPropertyValue('height')))
      let sectionTipHeight = Math.ceil(parseFloat(window.getComputedStyle($sectionTip, null).getPropertyValue('height')))
      let maxHeight = screenHeight - toolHeight - theadHeight - sectionTipHeight
      $tbody.style.maxHeight = maxHeight + 'px'
    },
    methods: {
      dateCellRender (date, y, m, d) {
        let key = y + '/' + stringLengthToTwo(m) + '/' + stringLengthToTwo(d)
        let data = this.list[key]
        let str = ''
        if (data) {
          str = '<p class="font-size--18 font-color-extra-light-gray price">￥' + data.spec_price + '</p>'
          if (data.spec_stock > 0) {
            str += '<p class="font-size--16 font-color-extra-light-gray tip">'
            if (data.spec_stock < 99) {
              str += '余' + data.spec_stock
            } else {
              str += '充足'
            }
            str += '</p>'
          }
        }
        return str
      },
      disabledDate (date, disabled, y, m, d) {
        let key = y + '/' + stringLengthToTwo(m) + '/' + stringLengthToTwo(d)
        let data = this.list[key]
        if (key < this.today || !data || data.spec_stock === '0') {
          return true
        }
      },
      handleDateClick (value, isChecked) {
        let settingId = '-1'
        let pricePackage = this.price
        if (isChecked) {
          let data = this.list[value]
          settingId = data.setting_id
          pricePackage = data.spec_price
        }
        this.settingId = settingId
        this.pricePackage = pricePackage
      }
    }
  }
</script>
