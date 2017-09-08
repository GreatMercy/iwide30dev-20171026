<template>

  <div class="jfk-pages jfk-pages__refund-detail">
    <div class="jfk-pages__theme"></div>

    <template v-if="detail">
      <div class="refund-detail-step jfk-flex jfk-pl-30 jfk-pr-30">

        <!-- 已申请 -->
        <template v-if="status === 1">
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__right refund-detail-step__start">
                <i></i>
              </span>
            </p>
            <p class="font-size--30 jfk-ta-c refund-detail-step__name refund-detail-step__active">酒店审核中</p>
          </div>
        </template>

        <template v-else>
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__right refund-detail-step__start">
                <i></i>
              </span>
            </p>
            <p class="font-size--28 jfk-ta-c refund-detail-step__name">酒店审核中</p>
          </div>
        </template>

        <!-- 已审核 -->
        <template v-if="status === 2">
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__left refund-detail-step__right refund-detail-step__finish">
                <i></i>
              </span>
            </p>
            <p class="font-size--30 jfk-ta-c refund-detail-step__name refund-detail-step__active">同意退款</p>
          </div>
        </template>

        <template v-else>
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__left refund-detail-step__right refund-detail-step__default">
                <i></i>
              </span>
            </p>
            <p class="font-size--28 jfk-ta-c refund-detail-step__name">同意退款</p>
          </div>
        </template>


        <!-- 微信退款中 -->
        <template v-if="status === 6">
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__left refund-detail-step__right refund-detail-step__finish">
                <i></i>
              </span>
            </p>
            <p class="font-size--30 jfk-ta-c refund-detail-step__name refund-detail-step__active">微信退款中</p>
          </div>
        </template>
        <template v-else>
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__left refund-detail-step__right refund-detail-step__default">
                <i></i>
              </span>
            </p>
            <p class="font-size--28 jfk-ta-c refund-detail-step__name">微信退款中</p>
          </div>
        </template>


        <!-- 已退款 -->
        <template v-if="status === 3">
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__left refund-detail-step__end">
                <i></i>
              </span>
            </p>
            <p class="font-size--30 jfk-ta-c refund-detail-step__name refund-detail-step__active">退款成功</p>
          </div>
        </template>
        <template v-else>
          <div class="refund-detail-step__item">
            <p class="refund-detail-step__status">
              <span class="refund-detail-step__left refund-detail-step__default">
                <i></i>
              </span>
            </p>
            <p class="font-size--28 jfk-ta-c refund-detail-step__name">退款成功</p>
          </div>
        </template>

      </div>

      <div class="jfk-pl-30 jfk-pr-30">
        <div class="refund-detail-step__line"></div>
      </div>


      <div class="refund-order jfk-pl-30 jfk-pr-30">
        <div class="refund-order__main-title font-size--24">订单信息</div>
        <ul class="refund-order__info">
          <li class="jfk-flex is-align-middle" v-if="detail.order_id">
            <div class="refund-order__title font-size--28">订单编号</div>
            <div class="refund-order__content font-size--30" v-text="detail.order_id"></div>
          </li>

          <li class="jfk-flex is-align-middle">
            <div class="refund-order__title font-size--28">下单时间</div>
            <div class="refund-order__content font-size--30">2017/03/01 13:34:09</div>
          </li>

          <li class="jfk-flex is-align-middle" v-if="detail.total">
            <div class="refund-order__title font-size--28">订单总价</div>
            <div class="refund-order__content font-size--30">
            <span class="jfk-price font-size--38">
              <i class="jfk-font-number jfk-price__currency">¥</i>
              <i class="jfk-font-number jfk-price__number" v-text="detail.total"></i>
            </span>
            </div>
          </li>

          <li class="jfk-flex is-align-middle">
            <div class="refund-order__title font-size--28">退还方式</div>
            <div class="refund-order__content font-size--30">原路退回</div>
          </li>
        </ul>
      </div>
    </template>


    <div class="recommendation jfk-pl-30" v-if="recommendations.length" :class="{'jfk-pr-30': recommendations.length === 1}">
      <p class="font-size--24 font-color-light-gray tip">其他用户还看了</p>
      <div class="recommendations-list">
        <jfk-recommendation :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></jfk-recommendation>
      </div>
    </div>

    <jfk-support v-once></jfk-support>
  </div>
</template>
<script>
  import { getRefundDetail, getPackageRecommendation } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
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
      // 已申请: 酒店审核中
      // 已审核: 同意退款
      // 已退款: 退款成功
      // 微信退款中: 微信退款中
      getRefundDetail({
        'oid': params['oid']
      }).then((res) => {
        this.toast.close()
        this.detail = res['web_data']
        this.status = parseInt(res['web_data']['status'])
      }).catch(() => {
        this.toast.close()
      })

      getPackageRecommendation({
        page: 1,
        page_size: 100
      }).then((res) => {
        const {products, page_resource} = res.web_data
        this.recommendations = products
        let {detail, home} = page_resource.link
        if (process.env.NODE_ENV === 'development') {
          detail = '/detail?pid='
          home = '/'
        }
        this.detailUrl = detail
        this.indexUrl = home
      })
    },
    data () {
      return {
        detail: '',
        status: '',
        recommendations: [],
        detailUrl: '',
        indexUrl: ''
      }
    },
    watch: {}
  }
</script>

<style>
</style>
