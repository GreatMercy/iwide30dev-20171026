<template>
  <div class="jfk-pages">
    <div class="jfk-pages__theme" v-if="!theme">
      <div class="jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
    </div>

    <div class="jfk-pages__gift" v-if="theme" v-show="boxShow">
      <div class="gift-box">
        <div class="gift-box-envelope">
          <div class="gift-box-wish jfk-ta-c font-size--36" v-html="name + '送你一份礼物'"></div>
          <div class="gift-box-content"></div>
          <div class="gift-box-bg"></div>
          <div class="gift-box-btn jfk-ta-c font-size--34" @click="openGift">打开礼盒</div>
        </div>
      </div>
    </div>

    <gift-detail :info="goodsDetail" :theme="theme" v-if="theme" v-show="detailShow"></gift-detail>
  </div>
</template>
<script>
  import { getPresentsValidateGiftOrder, postPresentsReceiveProcess } from '@/service/http'
  import { JfkMessageBox } from 'jfk-ui'
  import giftDetail from './module/gift_detail'
  const formatUrlParams = require('jfk-ui/lib/format-urlparams.js')
  let params = formatUrlParams.default(location.href)
  export default {
    name: 'gift',
    components: {
      giftDetail
    },
    data () {
      return {
        // 送礼人姓名
        name: '',
        // 商品详情
        goodsDetail: {},
        // 主题
        theme: '',
        // 礼盒显示
        boxShow: false,
        // 详情显示
        detailShow: true
      }
    },
    created () {
      let requestParams = {
        gid: params['gid'] || '',
        sign: params['sign'] || ''
      }
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      getPresentsValidateGiftOrder(requestParams).then((res) => {
        const content = res['web_data']
        if (content && content['fans'] && content['fans']['nickname']) {
          this.name = content['fans']['nickname']
        } else {
          this.name = '你的好友'
        }
        this.goodsDetail = content['item']
        this.goodsDetail['used'] = parseInt(content['item']['qty_origin']) - parseInt(content['item']['qty'])
        this.goodsDetail['wish'] = content['message']
        this.goodsDetail['link'] = content['order_list_url']
        this.theme = `gift-theme_${content['theme_keyword']}`
        this.goodsDetail['goods_link'] = res['web_data']['redirect_url'] || ''
        // 判断之前是否曾经打开过礼物 （1 已领取  2 未领取）
        this.boxShow = parseInt(content['received']) === 1 ? 1 : 0
        this.toast.close()
      }).catch(() => {
        this.toast.close()
      })
    },
    methods: {
      openGift () {
        let requestParams = {
          gid: params['gid'] || '',
          sign: params['sign'] || '',
          bsn: params['bsn'] || ''
        }
        this.toast = this.$jfkToast({
          duration: -1,
          iconClass: 'jfk-loading__snake',
          isLoading: true
        })
        postPresentsReceiveProcess(requestParams, {REJECTERRORCONFIG: {serveError: true}}).then((res) => {
          this.boxShow = false
          this.toast.close()
          if (parseInt(res['web_data']['subscribe']) === 2) {
            JfkMessageBox({
              title: '提示',
              message: `您还没关注公众号，可能会影响礼品使用，先关注${res['web_data']['public_name']}`,
              showConfirmButton: true,
              showCancelButton: true,
              confirmButtonText: '立即关注',
              cancelButtonText: '现在使用'
            }).then(() => {
              this.$jfkShare()
            })
          }
        }).catch((err) => {
          this.toast.close()
          this.boxShow = false
          this.$jfkAlert(err['msg']).then(() => {
            this.boxShow = true
          })
        })
      }
    }
  }
</script>
