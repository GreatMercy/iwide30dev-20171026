<template>
  <div class="jfk-pages jfk-pages__success jfk-pages_sendSuccess">
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
        <i class="jfk-font icon-font_zh_wei_qkbys"></i><i class="jfk-font icon-font_zh_xin_qkbys"></i><i class="jfk-font icon-font_zh_zhuan_qkbys"></i><i class="jfk-font icon-font_zh_zeng_qkbys"></i><i class="jfk-font icon-font_zh_cheng_qkbys"></i><i class="jfk-font icon-font_zh_gong_qkbys"></i>
      </div>
      <div class="zz">好友24小时未点击领取，将会自动退回至您的账户</div>
      <div class="actionbtns">
        <a :href="productDetail">
        <button class="jfk-button jfk-button--primary is-plain font-size--30 product-button">
          <span class="jfk-button__text">
            <i class="jfk-font jfk-button__text-item icon-font_zh_zai__qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_ci_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_gou_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_mai_qkbys"></i>
          </span>
        </button>
        </a>
        <a :href="orderDetail">
        <button class="jfk-button jfk-button--primary font-size--30 product-button">
          <span class="jfk-button__text">
            <i class="jfk-font jfk-button__text-item icon-font_zh_cha_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_kan_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_ding_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_dan_qkbys"></i>
          </span>
        </button>
        </a>
      </div>
    </div>
    <div class="recommendation jfk-pl-30" v-if="recommendations.length">
      <p class="font-size--24 font-color-light-gray tip">其他用户还看了</p>
      <div class="recommendations-list">
        <jfk-recommendation :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></jfk-recommendation>
      </div>
    </div>   
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import headTitle from '../../components/common/headTitle'
  import { getPackageRecommendation, getSendSuccess } from '@/service/http'
  export default {
    name: 'sendSuccess',
    components: {
      headTitle
    },
    data () {
      return {
        headTitleMsg: '',
        recommendations: [],
        productDetail: '',
        orderDetail: ''
      }
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      if (process.env.NODE_ENV === 'development' && !params.gid) {
        params.gid = '1000002031'
      }
      this.gid = params.gid
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
      let param = {
        gid: this.gid
      }
      if (process.env.NODE_ENV === 'development') {
        param.id = 'a450089706'
        param.openid = 'o9Vbtw1W0ke-eb0g6kE4SD1eh6qU'
      }
      getSendSuccess(param).then(function (res) {
        that.productDetail = res.web_data.product_detail_url
        that.orderDetail = res.web_data.order_list_url
      })
    },
    mounted: function () {
      document.title = this.name
    }
  }
</script>
