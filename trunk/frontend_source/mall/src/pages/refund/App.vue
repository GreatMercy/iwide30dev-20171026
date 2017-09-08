<template>
  <div class="jfk-pages jfk-pages__refund">
    <div class="jfk-pages__theme"></div>
    <jfk-notification :message="message" class="font-size--24" v-if="message"></jfk-notification>

    <template v-if="detail">
      <div class="refund-information jfk-pl-30 jfk-pr-30 is-align-middle">
        <div class="refund-information__name font-size--38 is-align-middle jfk-flex">
          <div class="refund-information__shadow"></div>
          <span v-if="detail.item_name" v-text="detail.item_name"></span>
        </div>
        <div class="refund-information__hotel font-size--24" v-if="detail.hotel_name"
             v-text="detail.hotel_name + '提供'"></div>
        <div class="jfk-price font-size--54 refund-information__price color-golden-price" v-if="detail.real_grand_total">
          <i class="jfk-font-number jfk-price__currency">¥</i>
          <i class="jfk-font-number jfk-price__number" v-text="detail.real_grand_total"></i>
        </div>
      </div>

      <div class="refund-order jfk-pl-30 jfk-pr-30">
        <div class="refund-order__main-title font-size--24">订单信息</div>
        <ul class="refund-order__info">

          <li class="jfk-flex is-align-middle">
            <div class="refund-order__title font-size--28">订单编号</div>
            <div class="refund-order__content font-size--30" v-if="detail.order_id" v-text="detail.order_id"></div>
          </li>

          <li class="jfk-flex is-align-middle">
            <div class="refund-order__title font-size--28">下单时间</div>
            <div class="refund-order__content font-size--30" v-if="detail.create_time"
                 v-text="detail.create_time"></div>
          </li>

          <li class="jfk-flex is-align-middle" v-if="detail.real_grand_total">
            <div class="refund-order__title font-size--28">订单总价</div>
            <div class="refund-order__content font-size--30">
            <span class="jfk-price font-size--38">
              <i class="jfk-font-number jfk-price__currency">¥</i>
              <i class="jfk-font-number jfk-price__number" v-text="detail.real_grand_total"></i>
            </span>
            </div>
          </li>

          <li class="jfk-flex is-align-middle">
            <div class="refund-order__title font-size--28">退还方式</div>
            <div class="refund-order__content font-size--30">原路退回</div>
          </li>

        </ul>
      </div>

      <div class="refund-reason jfk-pl-30 jfk-pr-30">
        <div class="refund-reason__title font-size--24" v-if="list.length > 0">退款原因（至少选择一项）</div>
        <ul class="refund-reason__list" v-if="list.length > 0">

          <li class="font-size--28" v-for="(item, index) in list" :key="index"
              :class="{'refund-reason__list-active': item.selected}" @click="choiceReason(index)">
            <span class="refund-reason__list-text" v-text="item.text"></span>
            <i class="refund-reason__list-select jfk-fl-r">
            <span class="jfk-radio jfk-radio--shape-circle color-golden" :class="{'is-checked': item.selected}">
              <label class="jfk-radio__label">
                <span class="jfk-radio__icon">
                  <i class="jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"></i>
                </span>
              </label>
           </span>
            </i>
          </li>

        </ul>

        <div class="refund-btn">
          <button class="jfk-button jfk-button--primary  font-size--30 jfk-button--free"
                  @click="apply"
                  :class="{'is-disabled': buttonDisabled, 'is-special': !buttonDisabled }">
            <span>提交</span>
          </button>
        </div>
      </div>
    </template>
    <jfk-support v-once></jfk-support>
  </div>
</template>
<script>
  import { getRefund, postRefundApply } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    components: {},
    computed: {
      buttonDisabled () {
        return this.result.length > 0 ? 0 : 1
      }
    },
    beforeCreate () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    methods: {
      choiceReason (index) {
        this.list[index]['selected'] = !this.list[index]['selected']
        let result = []
        for (let j = 0; j < this.list.length; j++) {
          if (this.list[j]['selected'] === true) {
            result.push(this.list[j]['text'])
          }
        }
        this.result = result
      },
      apply () {
        if (this.result.length === 0) {
          return false
        }
        let parameter = {
          'oid': params['oid'] || '',
          'rtype': this.type || '',
          'cause': this.result.join(';') || ''
        }
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        postRefundApply(parameter).then((res) => {
          this.toast.close()
          const link = res['web_data']['page_resource']['link']['refund_detail']
          if (process.env.NODE_ENV === 'development') {
            window.location.href = '/refund_detail?oid=' + formatUrlParams.default(link)['oid']
          } else {
            window.location.href = link
          }
        }).catch(() => {
          this.toast.close()
        })
      }
    },
    created () {
      let parameter = {
        'oid': params['oid'] || ''
      }
      getRefund(parameter).then((res) => {
        this.toast.close()
        this.detail = res['web_data']['order_detail']
        this.message = res['web_data']['tip']
        this.type = res['web_data']['rtype']
        // 处理list 的数组
        for (let i = 0; i < res['web_data']['refund_cause'].length; i++) {
          let item = res['web_data']['refund_cause'][i]
          let newItem = {
            'text': item,
            'selected': false
          }
          this.list.push(newItem)
        }
      }).catch(() => {
        this.toast.close()
      })
    },
    data () {
      return {
        // 提醒的信息
        message: '',
        // 订单详情
        detail: '',
        // 退款原因的列表
        list: [],
        // 选中的退款原因
        result: [],
        // 退款类型
        type: ''
      }
    },
    watch: {}
  }
</script>

<style>
</style>
