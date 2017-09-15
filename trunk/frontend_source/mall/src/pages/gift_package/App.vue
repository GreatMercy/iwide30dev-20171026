<template>
  <div class="jfk-pages jfk-pages__gift-package">
    <div class="jfk-pages__theme"></div>

    <pack :info="products" :status="status" @changeStatus="changeStatus" :number="giftNumber" v-if="products"></pack>

    <div class="package-box">
      <clause :title="'领取信息'" :list="info" v-if="info.length > 0"></clause>
    </div>


    <div class="package-box">
      <clause :title="'注意事项'" :list="notice" v-if="notice.length > 0"></clause>
    </div>


    <div class="package-btn">
      <button class="jfk-button jfk-button--primary is-special jfk-button--free font-size--32" @click="receive">
        <span>
          立即领取
        </span>
      </button>
    </div>

  </div>
</template>

<script>
  import clause from '@/components/clause/main'
  import pack from '@/components/package/main'
  import { JfkToast, JfkMessageBox } from 'jfk-ui'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  const params = formatUrlParams.default(location.href)
  import { getGiftPackageQrcodeDetail, postGenerateGiftOrder } from '@/service/http'
  export default {
    components: {
      clause,
      pack
    },
    computed: {},
    created () {
      this.$pageNamespace(params)
      this.loading()
      getGiftPackageQrcodeDetail({
        'gift_detail_id': params['gift_detail_id'] || '',
        'inter_id': params['inter_id'] || '',
        'gift_id': params['gift_id'] || '',
        'saler_id': params['saler_id'] || '',
        'request_token': params['request_token']
      }, {REJECTERRORCONFIG: {serveError: true}}).then((res) => {
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
          this.info = [room, remark, number]
        }
        // 注意事项
        let noticeTime = ''
        let price = ''
        if (content['expiration_date']) {
          noticeTime = '该商品有效期至' + content['expiration_date']
        }
        if (content['price_market']) {
          price = '礼包原价' + content['price_market'] + '元'
        }
        this.notice = [noticeTime, '请在规定时间内使用', price, '仅供住店客人使用，使用时请出示劵码']
        this.toast.close()
        // 套餐信息
        this.products = {
          'name': content['name'] || '',
          'time': content['expiration_date'] || '',
          'products': content['child_product_info'] || []
        }
      }).catch((err) => {
        console.log(err['status'])
        console.log(err)
        const toast = () => {
          JfkToast({
            iconType: 'error',
            title: '',
            message: err.msg || '',
            duration: 2000
          })
        }
        if (err['status'] === 1001) {
          console.log(err['web_data']['page_resource'])
          if (err['web_data'] && err['web_data']['page_resource'] && err['web_data']['page_resource']['gift_status'] && err['web_data']['page_resource']['gift_status'] === 2) {
            JfkMessageBox({
              showClose: false,
              showCloseButton: false,
              title: '',
              message: err.msg || '',
              showConfirmButton: true,
              showCancelButton: false,
              closeOnClickModal: false,
              confirmButtonText: '去商城逛逛',
              iconClass: 'jfk-font icon-user_icon_fail_norma'
            }).then(() => {
              window.location.href = err['web_data']['page_resource']['link']['gift_detail']
            })
          } else {
            toast()
          }
        } else {
          toast()
        }
        this.toast.close()
      })
    },
    methods: {
      loading () {
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
      },
      receive () {
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        postGenerateGiftOrder({
          'gift_detail_id': params['gift_detail_id'] || '',
          'inter_id': params['inter_id'] || '',
          'request_token': params['request_token']
        }).then((res) => {
          this.toast.close()
          window.location.href = res['web_data']['page_resource']['link']['gift_detail']
        }).catch(() => {
          this.toast.close()
        })
      },
      changeStatus () {
        this.status = !this.status
      }
    },
    data () {
      return {
        status: false,
        info: [],
        products: {},
        notice: [],
        giftNumber: 1
      }
    }
  }
</script>
