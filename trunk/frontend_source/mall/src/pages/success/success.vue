<template>
  <div class="jfk-pages jfk-pages__success">
    <div class="jfk-pages__theme"></div>
    <div class="shengguang">
      <img src="../../assets/image/shengguang.png">
    </div>
    <headTitle :headTitleMsg="headTitleMsg" />
    <div class="success_main">
      <div class="gou">
        <img src="../../assets/image/gou.png">
      </div>
      <div class="wenan">
        <i class="jfk-font icon-font_zh_gong_qkbys1"></i>
        <i class="jfk-font icon-font_zh_xi_qkbys"></i>
        <i class="jfk-font icon-font_zh_ni_qkbys"></i>
        <i class="jfk-font icon-font_zh_gou_qkbys"></i>
        <i class="jfk-font icon-font_zh_mai_qkbys"></i>
        <i class="jfk-font icon-font_zh_cheng_qkbys"></i>
        <i class="jfk-font icon-font_zh_gong_qkbys"></i>
      </div>
      <div class="actionbtns">
        <a :href="productDetail">
          <button class="jfk-button jfk-button--primary is-plain font-size--30 product-button jfk-button--lower">
            <span class="jfk-button__text">
              <i class="jfk-font jfk-button__text-item icon-font_zh_zai__qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_ci_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_gou_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_mai_qkbys"></i>
            </span>
          </button>
        </a>
        <a :href="orderDetail">
          <button class="jfk-button jfk-button--primary font-size--30 product-button jfk-button--lower">
            <span class="jfk-button__text">
              <i class="jfk-font jfk-button__text-item icon-font_zh_cha_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_kan_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_ding_qkbys"></i>
              <i class="jfk-font jfk-button__text-item icon-font_zh_dan_qkbys"></i>
            </span>
          </button>
        </a>
      </div>
      <div class="sharebtns">
        <div class="innner_box">
          <div class="item_btn">
            <i class="jfk-font icon-mall_icon_pay_share"></i>分享订单</div>
          <div class="item_btn" @click="handleQrcode">
            <i class="jfk-font icon-mall_icon_pay_focus"></i>关注享优惠</div>
        </div>
      </div>
    </div>
    <div class="recommendation jfk-pl-30" v-if="recommendations.length">
      <p class="font-size--24 font-color-light-gray tip">其他用户还看了</p>
      <div class="recommendations-list">
        <jfk-recommendation :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></jfk-recommendation>
      </div>
    </div>
    <jfk-popup v-model="visible" :showCloseButton="true" class="jfk-ta-c success_qrcode">
      <img :src="qrCode" />
      <p class="font-color-extra-light-gray font-size--28 content" v-if="qrCodeContent">你还未关注公众号
        <br>先长按识别关注公众号吧！</p>
      <p class="font-color-extra-light-gray font-size--28 content" v-else>长按识别关注公众号
        <br>享受
        <span class="color-golden font-size--34"><i class="jfk-font icon-font_zh_geng_qkbys"></i><i class="jfk-font icon-font_zh_duo_qkbys"></i><i class="jfk-font icon-font_zh_you__qkbys"></i><i class="jfk-font icon-font_zh_hui_qkbys"></i></span>
      </p>
    </jfk-popup>
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
        headTitleMsg: '本商品由柚子酒店提供',
        recommendations: [],
        visible: false,
        qrCode: '',
        qrCodeContent: false,
        productDetail: '',
        orderDetail: ''
      }
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      if (process.env.NODE_ENV === 'development' && !params.oid) {
        params.oid = '1000011950'
      }
      this.oid = params.oid
    },
    created () {
      let that = this
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
      getSuccessPay({
        oid: this.oid
      }).then(function (res) {
        let successAbout = res.web_data
        that.qrCode = successAbout.qr_code
        that.productDetail = successAbout.page_resource.link.product_detail + successAbout.product_id
        that.orderDetail = successAbout.page_resource.link.order_detail
        if (successAbout.subscribe_status === 0) {
          that.qrCodeContent = true
        }
      })
    },
    methods: {
      handleQrcode () {
        this.visible = true
      }
    }
  }
</script>
