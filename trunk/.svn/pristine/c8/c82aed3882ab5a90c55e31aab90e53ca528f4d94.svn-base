<template>
  <div class="jfk-pages jfk-pages__reservation">
    <div class="jfk-pages__theme"></div>

    <div class="reservation-base-info jfk-pl-30 jfk-pr-30 is-align-middle">
      <div class="reservation-base-info__name font-size--38 is-align-middle jfk-flex">
        <div class="reservation-base-info__shadow"></div>
        <span>高级大床房</span>
      </div>
      <div class="reservation-base-info__hotel font-size--24">金房卡大酒店岗顶店</div>
    </div>

    <div class="jfk-pl-30 jfk-pr-30 reservation-form">
      <form class="jfk-form font-size--28">
        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">入住券码</span>
            <div class="form-item__body">
              <jfk-text-split :text="code" :split="3"></jfk-text-split>
            </div>
          </label>
        </div>

        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray form-item__label--word-3">入住人</span>
            <div class="form-item__body">
              <input type="text" class="font-color-white" placeholder="请输入入住人">
            </div>
          </label>
        </div>

        <div class="form-item">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">联系方式</span>
            <div class="form-item__body">
              <input type="tel" class="font-color-white" placeholder="请输入入住人手机">
            </div>
          </label>
        </div>

        <div class="form-item" @click="goCalendar">
          <label>
            <span class="form-item__label  font-color-extra-light-gray">入住时间</span>
            <div class="form-item__body">
              <p>2017/03/19</p>
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
          <div class="reservation-order__content font-size--30">王有才</div>
        </li>

        <li class="jfk-flex is-align-middle">
          <div class="reservation-order__title font-size--28">联系电话</div>
          <div class="reservation-order__content font-size--30">18312341234</div>
        </li>

        <li class="jfk-flex is-align-middle">
          <div class="reservation-order__title font-size--28"><i>订</i><span
            class="reservation-order__title--word-3">单</span><i>号</i>
          </div>
          <div class="reservation-order__content font-size--30">1000001314</div>
        </li>

        <li class="jfk-flex is-align-middle">
          <div class="reservation-order__title font-size--28"><i>有</i><span
            class="reservation-order__title--word-3">效</span><i>期</i>
          </div>
          <div class="reservation-order__content font-size--30">2017/03/01-2017/03/10</div>
        </li>
      </ul>
    </div>

    <jfk-support v-once></jfk-support>

    <div class="reservation-btn">
      <button class="jfk-button jfk-button--primary jfk-button--higher jfk-button--free font-size--32">预订</button>
    </div>

  </div>
</template>
<script>
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  import { getHotelInfo } from '@/service/http'
  export default {
    components: {},
    beforeCreate () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    created () {
      console.log(params)
      getHotelInfo({
        'aiid': params['aiid'],
        'id': params['id'],
        'hid': params['hid'],
        'rmid': params['rmid']
      }).then((res) => {
        console.log(res)
        this.toast.close()
      }).catch(() => {
        this.toast.close()
      })
    },
    data () {
      return {
        code: '123412341234',
        detail: ''
      }
    },
    methods: {
      // 选择入住时间
      goCalendar () {
        this.$router.push('/calendar')
      }
    }
  }
</script>
