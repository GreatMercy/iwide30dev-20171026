<template>
  <div class="jfk-pages jfk-pages__reservation">
    <div class="jfk-pages__theme"></div>

    <div class="reservation-base-info jfk-pl-30 jfk-pr-30 is-align-middle">
      <div class="reservation-base-info__name font-size--38 is-align-middle jfk-flex">
        <div class="reservation-base-info__shadow color-golden"></div>
        <span v-if="detail && detail.room" v-text="detail.room.name"></span>
      </div>
      <div class="reservation-base-info__hotel font-size--24" v-if="detail && detail.hotel"
           v-text="detail.hotel.name"></div>
    </div>

    <div class="jfk-pl-30 jfk-pr-30 reservation-form">
      <form class="jfk-form font-size--28">
        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">入住券码</span>
            <div class="form-item__body">
              <jfk-text-split :text="detail.code.code" :split="4" v-if="detail && detail.code"></jfk-text-split>
            </div>
          </label>
        </div>

        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">入住人</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" placeholder="请输入入住人" v-model="form.name">
              <div class="form-item__status is-error" v-show="validResult.name.show" @click="handleHiddenError('name')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                    <i class="form-item__status-cont" v-text="validResult.name.message"></i>
                    <i class="form-item__status-trigger">重新输入</i>
                  </span>
              </div>
            </div>
          </label>
        </div>

        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">联系方式</span>
            <div class="form-item__body">
              <input type="tel" class="font-color-white" placeholder="请输入入住人手机" v-model="form.phone" maxlength="11">
              <div class="form-item__status is-error" v-show="validResult.phone.show"
                   @click="handleHiddenError('phone')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                    <i class="form-item__status-cont" v-text="validResult.phone.message"></i>
                    <i class="form-item__status-trigger">重新输入</i>
                  </span>
              </div>
            </div>
          </label>
        </div>

        <div class="form-item" @click="goCalendar">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">入住时间</span>
            <div class="form-item__body">
              <p class="tip" v-if="reservationCheckInDate" v-text="reservationCheckInDate"></p>
              <p class="tip font-color-light-gray" v-else>请选择入住时间</p>
              <div class="form-item__status is-error" v-show="validResult.checkInDate.show"
                   @click="handleHiddenError('checkInDate')">
                <i class="form-item__status-icon jfk-font icon-msg_icon_error_norma"></i>
                <span class="form-item__status-tip">
                    <i class="form-item__status-cont" v-text="validResult.checkInDate.message"></i>
                    <i class="form-item__status-trigger">重新选择</i>
                  </span>
              </div>
            </div>
            <i class="jfk-font icon-user_icon_jump_normal reservation-check-in__arrow font-size--24"></i>
          </label>
        </div>
      </form>
    </div>

    <div class="reservation-order jfk-pl-30 jfk-pr-30">
      <div class="reservation-order__main-title font-size--24">订单信息</div>
      <ul class="reservation-order__info">
        <li class="jfk-flex is-align-middle">
          <div class="reservation-order__title font-size--28"><i>购</i><span
            class="reservation-order__title--word-3">买</span><i>人</i>
          </div>
          <div class="reservation-order__content font-size--30" v-text="detail.customer.name"
               v-if="detail.customer"></div>
        </li>

        <li class="jfk-flex is-align-middle">
          <div class="reservation-order__title font-size--28">联系电话</div>
          <div class="reservation-order__content font-size--30" v-text="detail.customer.mobile"
               v-if="detail.customer"></div>
        </li>

        <li class="jfk-flex is-align-middle">
          <div class="reservation-order__title font-size--28"><i>订</i><span
            class="reservation-order__title--word-3">单</span><i>号</i>
          </div>
          <div class="reservation-order__content font-size--30" v-text="detail.customer.order_id"
               v-if="detail.customer"></div>
        </li>

        <li class="jfk-flex is-align-middle">
          <div class="reservation-order__title font-size--28"><i>有</i><span
            class="reservation-order__title--word-3">效</span><i>期</i>
          </div>
          <div class="reservation-order__content font-size--30" v-text="detail.validity"></div>
        </li>
      </ul>
    </div>

    <jfk-support v-once></jfk-support>

    <div class="reservation-btn">
      <button class="jfk-button jfk-button--primary jfk-button--higher jfk-button--free font-size--32" @click="booking">
        <span>预订</span>
      </button>
    </div>

  </div>
</template>
<script>
  import moment from 'moment'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  import stringLengthToTwo from 'jfk-ui/lib/string-length-to-two.js'
  let params = formatUrlParams.default(location.href)
  import { getHotelInfo, getHotelTime, postHotelBooking } from '@/service/http'
  import validator from 'jfk-ui/lib/validator.js'
  import axios from 'axios'
  export default {
    computed: {
      reservationCheckInDate () {
        return this.$store.getters.reservationCheckInDate || ''
      }
    },
    beforeCreate () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    created () {
      getHotelInfo({
        'aiid': params['aiid'] || '',
        'id': params['id'] || '',
        'hid': params['hid'] || '',
        'rmid': params['rmid'] || '',
        'code_id': params['code_id'] || '',
        'cdid': params['cdid'] || ''
      }).then((res) => {
        this.detail = res['web_data']
        const attach = res['web_data']['attach']
        this.bookingDate = attach['booking_date']
        const allDate = attach['code_use_date']
        this.detail['validity'] = `${allDate['begin_date']} - ${allDate['end_date']}`
        this.order_params = attach['order_params']
        this.currentDate = attach['current_date']
        this.toast.close()
      }).catch(() => {
        this.toast.close()
      })
    },
    data () {
      return {
        order_params: {},
        detail: '',
        checkInDateBol: false,
        currentDate: '',
        canbook: true,
        bookingDate: '',
        form: {
          name: '',
          phone: '',
          checkInDate: ''
        },
        rules: {
          name: [{
            required: true, message: '入住人为空'
          }, {
            max: 10, length: true, message: '入住人必须在10个字符内'
          }],
          phone: [{
            required: true, message: '入住人手机为空'
          }, {
            max: 11, length: true, message: '手机号码必须是11位'
          }, {
            type: 'phone', message: '入住人手机号码错误'
          }],
          checkInDate: [{
            required: true, message: '入住时间为空'
          }]
        },
        validResult: {
          name: {
            passed: false,
            message: ''
          },
          phone: {
            passed: false,
            message: ''
          },
          checkInDate: {
            passed: false,
            message: ''
          }
        }
      }
    },
    watch: {
      reservationCheckInDate (val) {
        this.form.checkInDate = val
      }
    },
    methods: {
      getFormItemVal (key) {
        switch (key) {
          case 'name':
            return this.form.name
          case 'phone':
            return this.form.phone
          case 'checkInDate':
            return this.form.checkInDate
          default:
            return ''
        }
      },
      handleHiddenError (type) {
        this.validResult = Object.assign({}, this.validResult, {
          [type]: {
            show: false
          }
        })
      },
      // 预定
      booking () {
        let rules = this.rules
        let passed = true
        for (let i in rules) {
          let r = validator(this.getFormItemVal(i), rules[i])
          this.validResult = Object.assign({}, this.validResult, {
            [i]: {
              ...r,
              show: !r.passed
            }
          })
          if (!r.passed) {
            passed = false
          }
        }
        if (passed) {
          this.toast = this.$jfkToast({
            duration: -1,
            iconClass: 'jfk-loading__snake',
            isLoading: true
          })
          let postParams = Object.assign({}, this.order_params)
          this.toast = this.$jfkToast({
            duration: -1,
            iconClass: 'jfk-loading__snake',
            isLoading: true
          })
          postParams['post_name'] = this.form.name || ''
          postParams['post_phone'] = this.form.phone || ''
          postParams['post_start'] = moment(this.form.checkInDate).format('YYYY-MM-DD')
          postParams['post_end'] = moment(this.form.checkInDate).add(1, 'days').format('YYYY-MM-DD')
          postHotelBooking(postParams).then((res) => {
            window.location.href = res['web_data']['page_resource']['link']['pay_success_stay']
            this.toast.close()
          }).catch(() => {
            this.toast.close()
          })
        }
      },
      // 选择入住时间
      goCalendar () {
        if (this.checkInDateBol === true) {
          if (this.canbook) {
            this.$router.push('/calendar')
          } else {
            this.$jfkToast('抱歉，房间已经被订完了~')
          }
          return false
        }
        const current = moment(this.currentDate * 1000)
        const next = moment(this.currentDate * 1000).add(1, 'month')
        const after = moment(this.currentDate * 1000).add(2, 'month')
        let baseParams = {
          'id': params['id'] || '',
          'oid': params['oid'] || '',
          'hid': params['hid'] || '',
          'rmid': params['rmid'] || '',
          'cdid': params['cdid'] || ''
        }
        let currentParams = Object.assign({}, baseParams)
        currentParams['year'] = current.format('YYYY')
        currentParams['month'] = current.format('MM')
        let nextParams = Object.assign({}, baseParams)
        nextParams['year'] = next.format('YYYY')
        nextParams['month'] = next.format('MM')
        let afterParams = Object.assign({}, baseParams)
        afterParams['year'] = after.format('YYYY')
        afterParams['month'] = after.format('MM')
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        axios.all([getHotelTime(currentParams), getHotelTime(nextParams), getHotelTime(afterParams)]).then((res) => {
          this.toast.close()
          this.checkInDateBol = true
          // 判断是否允许跳转日历
          let canBooking = [false, false, false]
          const checkCanBooking = (index) => {
            for (let j in res[index]['web_data']['data']) {
              const book = parseInt(res[index]['web_data']['data'][j]['can_booking'])
              if (book === 1) {
                canBooking[index] = true
              }
            }
          }
          for (let i = 0; i < canBooking.length; i++) {
            checkCanBooking(i)
          }
          if (!canBooking[0] && !canBooking[1] && !canBooking[2]) {
            this.$jfkToast('抱歉，房间已经被订完了~')
            this.canbook = false
            return false
          } else {
            this.$router.push('/calendar')
          }
          let calendarDate = {
            min: null,
            max: null,
            defaultValue: null,
            today: null
          }
          calendarDate['today'] = {
            'key': currentParams['year'] + '-' + currentParams['month'] + '-' + String(parseInt(current.format('Do'))),
            'all': currentParams['year'] + '-' + currentParams['month'] + '-' + stringLengthToTwo(String(parseInt(current.format('Do'))))
          }
          calendarDate['min'] = new Date(this.bookingDate['begin_date'])
          calendarDate['max'] = new Date(this.bookingDate['end_date'])
          calendarDate[currentParams['year'] + '-' + currentParams['month']] = res[0]['web_data']['data']
          calendarDate[nextParams['year'] + '-' + nextParams['month']] = res[1]['web_data']['data']
          calendarDate[afterParams['year'] + '-' + afterParams['month']] = res[2]['web_data']['data']
          this.$store.commit('updateReservationCalendarDate', calendarDate)
        }).catch(() => {
          this.toast.close()
        })
      }
    }
  }
</script>
