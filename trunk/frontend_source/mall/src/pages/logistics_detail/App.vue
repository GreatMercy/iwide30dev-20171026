<template>
  <div class="jfk-pages jfk-pages__logistics-detail">
    <div class="jfk-pages__theme"></div>

    <!--已接单，已发货，已签收-->
    <div class="logistics-detail-state">
        <span class="jfk-button__text color-golden font-size--60" v-if="status && status === 1">
          <i class="jfk-font icon-font_zh_yi_qkbys"></i>
          <i class="jfk-font icon-font_zh_jie_qkbys"></i>
          <i class="jfk-font icon-font_zh_dan_qkbys"></i>
        </span>

      <span class="jfk-button__text color-golden font-size--60" v-if="status && status=== 2">
          <i class="jfk-font icon-font_zh_yi_qkbys"></i>
          <i class="jfk-font icon-font_zh_fa_qkbys"></i>
          <i class="jfk-font icon-font_zh_huo_qkbys"></i>
      </span>


      <span class="jfk-button__text color-golden font-size--60" v-if="status && status=== 5 ">
          <i class="jfk-font icon-font_zh_yi_qkbys"></i>
          <i class="jfk-font icon-font_zh_shou_qkbys"></i>
          <i class="jfk-font icon-font_zh_huo_qkbys"></i>
      </span>

    </div>

    <div class="logistics-detail-info jfk-pl-30 jfk-pr-30">
      <div class="logistics-detail-info__card">

        <div class="logistics-detail-info__product">
          <div
            v-lazy:background-image="product.face_img"
            class="logistics-detail-info__product--img jfk-image__lazy--3-3 jfk-image__lazy--background-image">
          </div>
          <div class="logistics-detail-info__product--content">
            <p class="font-size--34 name" v-text="product.name" v-if="product.name"></p>
            <p class="price jfk-flex is-align-middle">
                <span class="jfk-price font-size--50 color-golden-price" v-if="product.price_package">
                  <i class="jfk-font-number jfk-price__currency">￥</i>
                  <i class="jfk-font-number jfk-price__number" v-text="product.price_package"></i>
                </span>
              <span class="font-color-light-gray font-size--24 number" v-text="product.qty + '份'"
                    v-if="product.qty"></span>
            </p>
          </div>
        </div>

        <div class="logistics-detail-info__user">
          <p class="jfk-flex logistics-detail-info__user--name font-size--24">
            <span class="title">收<small class="font-size--24">件</small>人</span>
            <i class="font-size--28">
              <small class="font-size--28" v-text="userInfo.contact" v-if="userInfo.contact"></small>
              <span v-text="userInfo.phone" v-if="userInfo.phone"></span>
            </i>
          </p>
          <p class="jfk-flex font-size--24">
            <span class="title">收件地址</span>
            <i class="font-size--28" v-text="userInfo.address"></i>
          </p>
        </div>
      </div>
    </div>


    <div class="logistics-status jfk-pl-30 jfk-pr-30">
      <div class="logistics-status__title font-size--24">物流信息</div>

      <div class="font-size--30 logistics-status__no-info" v-if="logistic.length === 0">暂无物流信息</div>

      <div class="logistics-status__step" v-else>

        <div class="logistics-status__item" v-for="(item, index) in logistic" :key="index">
          <div class="logistics-status__item--logo">
            <span class="font-size--30 logistics-status__item--line"
                  :class="'logistics-status__item--' + item.class_name">
              <i></i>
            </span>
          </div>
          <div class="logistics-status__item--text" :class="{'is-active': item.status}">
            <p class="font-size--30" v-text="item.remark "></p>
            <p class="font-size--24" v-text="item.datetime"></p>
          </div>
        </div>

      </div>
    </div>

    <jfk-support v-once></jfk-support>
  </div>
</template>

<script>
  import { getExpressDetail } from '@/service/http'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    components: {},
    computed: {},
    beforeCreate () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    created () {
      // 已接单，已发货，已签收
      getExpressDetail({
        'spid': params['spid'] || ''
      }).then((res) => {
        const content = res['web_data']
        this.product = content['product']
        this.userInfo = content['contact']
        this.logistic = content['shipping_track']
        this.status = parseInt(content['status'])
        let len = this.logistic.length
        // 判断当前的状态 (1:邮寄申请 2：邮寄发货 4：异常挂起 5：已签收 6：待付运费 7：下单失败)
        if (this.logistic.length > 0) {
          for (let i = 0; i < this.logistic.length; i++) {
            this.logistic[i]['class_name'] = 'default'
            this.logistic[i]['status'] = false
          }
          // 如果当前的状态为 5 (已签收)
          if (this.status === 5) {
            this.logistic[0]['status'] = true
            this.logistic[0]['class_name'] = 'end'
            this.logistic[len - 1]['class_name'] = 'start'
          } else {
            this.logistic[0]['status'] = true
            this.logistic[0]['class_name'] = 'finish'
            this.logistic[len - 1]['class_name'] = 'start'
          }
        }
        this.toast.close()
      }).catch(() => {
        this.toast.close()
      })
    },
    watch: {},
    data () {
      return {
        product: {},
        userInfo: {},
        logistic: [],
        status: ''
      }
    }
  }
</script>
