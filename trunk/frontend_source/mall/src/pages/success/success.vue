<template>
  <div class="jfk-pages jfk-pages__success">
    <div class="jfk-pages__theme"></div>
    <div class="shengguang">
      <img src="../../assets/image/shengguang.png">
    </div>
    <headTitle :headTitleMsg="headTitleMsg" />
    <div class="success_main color-golden">
      <div class="gou">
        <span class="mainbox">
        <i class="jfk-font icon-radio_icon_selected_default"></i>
        </span>
      </div>
      <div class="wenan font-size--46 ">
        <i class="jfk-font icon-font_zh_gong_1_qkbys"></i>
        <i class="jfk-font icon-font_zh_xi_qkbys"></i>
        <i class="jfk-font icon-font_zh_ni_qkbys" style="margin-right: 10px"></i>
        <i class="jfk-font icon-font_zh_gou_qkbys"></i>
        <i class="jfk-font icon-font_zh_mai_qkbys"></i>
        <i class="jfk-font icon-font_zh_cheng_qkbys"></i>
        <i class="jfk-font icon-font_zh_gong_qkbys"></i>
        <i class="jfk-font icon-font_zh_emark_qkbys"></i>
      </div>
      <div class="actionbtns">
        <a :href="productDetail" class="jfk-button jfk-button--primary is-plain font-size--30 product-button jfk-button--lower">
            <span >
              再次购买
            </span>
        </a>
        <a :href="orderDetail" class="jfk-button jfk-button--primary font-size--30 product-button jfk-button--lower">
            <span >
             查看订单
            </span>
        </a>
      </div>
      <!-- <div class="sharebtns">
        <div class="innner_box">
          <div class="item_btn">
            <i class="jfk-font icon-mall_icon_pay_share"></i>分享订单</div>
          <div class="item_btn" @click="handleQrcode">
            <i class="jfk-font icon-mall_icon_pay_focus"></i>关注享优惠</div>
        </div>
      </div> -->
    </div>
    <div class="recommendation jfk-pl-30" v-if="recommendations.length">
      <p class="font-size--24 font-color-light-gray-common tip">其他用户还看了</p>
      <div class="recommendations-list " :class="{'jfk-pr-30': recommendations.length == 1}">
        <jfk-recommendation :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></jfk-recommendation>
      </div>
    </div>
    <jfk-popup v-model="visible" :showCloseButton="true" class="jfk-ta-c success_qrcode">
      <img :src="qrCode" />
      <p class="font-color-extra-light-gray font-size--28 content" >你还未关注公众号
        <br>长按识别关注随时查看订单</p>
    </jfk-popup>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import headTitle from '../../components/common/headTitle'
  import { getPackageRecommendation, getSuccessPay } from '@/service/http'
  export default {
    name: 'success',
    components: {
      headTitle
    },
    data () {
      return {
        headTitleMsg: '',
        recommendations: [],
        visible: false,
        qrCode: '',
        productDetail: '',
        orderDetail: ''
      }
    },
    beforeCreate () {
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      let params = formatUrlParams(location.href)
      if (process.env.NODE_ENV === 'development' && !params.oid) {
        params.oid = '1000011950'
      }
      this.oid = params.oid
      this.$pageNamespace(params)
    },
    created () {
      let that = this
      getSuccessPay({
        oid: this.oid
      }).then(function (res) {
        that.toast.close()
        let successAbout = res.web_data
        that.productDetail = successAbout.page_resource.link.product_detail + successAbout.product_id
        that.orderDetail = successAbout.page_resource.link.order_detail
        that.headTitleMsg = '本商品由' + successAbout.hotel_name + '提供'
        if (successAbout.subscribe_status === 0) {
          that.qrCode = successAbout.qr_code
          that.visible = true
        }
      })
      // 推荐商品无分页，page_size设置大一些，一页全部请求完毕
      getPackageRecommendation({
        page: 1,
        page_size: 100
      }).then(function (res) {
        const { products, page_resource } = res.web_data
        that.recommendations = products
        let { detail, home } = page_resource.link
        if (process.env.NODE_ENV === 'development') {
          detail = '/detail?pid='
          home = '/'
        }
        that.detailUrl = detail
        that.indexUrl = home
      })
    },
    methods: {
      handleQrcode () {
        this.visible = true
      }
    }
  }
</script>
