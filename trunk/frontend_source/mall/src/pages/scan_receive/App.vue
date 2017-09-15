<template>
  <div class="jfk-pages jfk-pages__scan-receive">

    <div class="jfk-pages__theme"></div>
    <div class="jfk-pl-30 jfk-pr-30 qrcode-wrap">

      <div class="scan-receive__container">
        <div
          class="scan-receive__qrcode jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"
          :style="size"
        >
          <img :src="qrcode" v-if="qrcode">
        </div>

        <div class="scan-receive__way font-size--24 jfk-ta-c">
          <span>使用方式</span><i>（请在10分钟完成扫码，超时未领取请重新生成）</i>
        </div>

        <div class="scan-receive__btn">
          <button class="jfk-button jfk-button--primary is-special jfk-button--free font-size--32" @click="generate">
            <span>重新生成</span>
          </button>
        </div>
      </div>
    </div>


    <div class="scan-receive__notice" v-if="notice.length > 0">
      <clause :title="'注意事项'" :list="notice"></clause>
    </div>

    <div class="scan-receive__notice" v-if="receiveInfo.length > 0">
      <clause :title="'领取信息'" :list="receiveInfo"></clause>
    </div>

    <div class="scan-receive__package">
      <clause :title="'礼包内容'"></clause>
      <pack :status="status" @changeStatus="changeStatus" :info="info" :number="giftNumber"></pack>
    </div>

  </div>
</template>

<script>
  import clause from '@/components/clause/main'
  import pack from '@/components/package/main'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  const params = formatUrlParams.default(location.href)
  import { getGiftPackageDetail } from '@/service/http'
  import { v1 } from '@/service/api'
  const imgUrl = v1.GET_GENERATE_GIFT_QRCODE
  export default {
    components: {
      clause,
      pack
    },
    computed: {
      size () {
        return {
          'width': (window.innerWidth * (443 / 750)) + 'px',
          'height': (window.innerWidth * (443 / 750)) + 'px'
        }
      }
    },
    methods: {
      generate () {
        window.history.go(-1)
      },
      changeStatus () {
        this.status = !this.status
      }
    },
    created () {
      this.$pageNamespace(params)
      if (process.env.NODE_ENV === 'development') {
        this.qrcode = window.location.host + imgUrl + '?id=a450089706&openid=o9VbtwwUedrHzhXFSfegtSFMIKtU' + '&gift_detail_id=' + params['gift_detail_id'] + '&inter_id=' + params['inter_id'] + '&request_token=' + params['request_token']
      } else {
        this.qrcode = window.location.host + imgUrl + '?gift_detail_id=' + params['gift_detail_id'] + '&inter_id=' + params['inter_id'] + '&request_token=' + params['request_token']
      }
      if (this.qrcode.indexOf('http://') === -1) {
        this.qrcode = 'http://' + this.qrcode
      }
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      getGiftPackageDetail({
        'gift_detail_id': params['gift_detail_id'] || '',
        'inter_id': params['inter_id'] || '',
        'request_token': params['request_token']
      }).then((res) => {
        const content = res['web_data']
        // 领取信息
        if (content['gift_record_info']) {
          let room = ''
          let remark = ''
          let number = ''
          if (content['gift_record_info'] && content['gift_record_info']['record_info']) {
            room = `登记信息：${content['gift_record_info']['record_info']}`
          }
          if (content['gift_record_info'] && content['gift_record_info']['orther_remark']) {
            remark = `其他：${content['gift_record_info']['orther_remark']}`
          } else {
            remark = '其他：无'
          }
          if (content['gift_record_info'] && content['gift_record_info']['gift_num']) {
            this.giftNumber = content['gift_record_info']['gift_num'] || 1
            number = `数量：${content['gift_record_info']['gift_num']}`
          }
          this.receiveInfo = [room, remark, number]
        }
        // 注意事项
        // 有效期
        let validity = ''
        if (content['expiration_date']) {
          validity = `该商品有效期至${content['expiration_date']}`
        }
        // 价格
        let price = ''
        if (content['price_market']) {
          price = `礼包原价${res['web_data']['price_market']}元`
        }
        this.notice = [validity, '请在规定时间内使用', price, '仅供住店客人使用，使用时请出示劵码']
        this.info = {
          'name': content['name'] || '',
          'time': content['expiration_date'] || '',
          'products': content['child_product_info'] || []
        }
        this.toast.close()
      })
    },
    data () {
      return {
        info: {}, // 礼包信息
        status: false, // 礼包展开状态
        notice: [],
        qrcode: '',
        giftNumber: 1,
        receiveInfo: [] // 领取信息
      }
    }
  }
</script>
