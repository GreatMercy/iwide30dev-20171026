<template>
  <div class="jfk-pages jfk-pages__detail">
    <div class="jfk-pages__theme"></div>
    <div v-if="productInfo.product_id">
      <div class="hotel-staff jfk-pl-30 jfk-pr-30" v-if="salerBanner.length">
        <div class="cont color-golden font-size--24">
          <span class="jfk-font notice-icon font-size--24 icon-mall_icon_notice"></span>
          <span class="jfk-font notice-icon-1 font-size--24 icon-mall_icon_1_notice"></span>{{salerBanner[0]}}
          <span v-if="salerBanner[1]" class="number jfk-font-number font-size--48">{{salerBanner[1]}}</span>
          <span v-if="salerBanner[2]" class="unit">{{salerBanner[2]}}</span>{{salerBanner[3]}}</div>
      </div>
      <div class="detail-top" :class="{'is-default': productGalleryIsDefault}">
        <div class="banners">
          <swiper :options="bannerSwiperOptions" class="jfk-swiper">
            <swiper-slide v-for="(item, index) in productInfo.gallery" :key="item.gry_id" class="jfk-swiper__item" :class="{'swiper-no-swiping': productInfo.gallery.length === 1}">
              <div class="banners__item-box jfk-swiper__item-box">
                <div :data-background="item.gry_url" class="banners__item jfk-swiper__item-bg swiper-lazy" v-if="item.gry_url">
                  <div class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
                </div>
                <div class="banners__item jfk-swiper__item-bg" v-else>
                  <div class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
                </div>
              </div>
            </swiper-slide>
          </swiper>
          <div class="swiper-pagination font-size--24 swiper-pagination-fraction">
            <span class="swiper-pagination-current">{{productGalleryIndex}}</span> / <span class="swiper-pagination-total">{{productInfo.gallery.length}}</span>
          </div>
        </div>
        <div class="icons">
          <i class="jfk-font font-size--36 icon-mall_icon_pay_focus" v-if="hotelInfo.qrcode" @click="handleQrcode"></i>
          <i class="jfk-font font-size--36 icon-mall_icon_pay_share" @click="handleShare"></i>
        </div>
        <div class="info">
          <div class="name font-size--38 font-color-white">
            <span class="price-tag font-size--24" v-html="priceTag"></span>{{productInfo.name}}
          </div>
          <div class="sales font-color-light-gray font-size--24">
            <span class="suppier" v-if="publicInfo.name">{{publicInfo.name}}提供</span>
            <span class="sales_num" v-if="productInfo.show_sales_cut === '1'">已售
              <i class="number">{{productInfo.sales_cnt}}</i>
            </span>
          </div>
          <div class="others jfk-clearfix">
            <div class="prices jfk-fl-l">
              <span class="jfk-price product-price-package color-golden font-size--68" v-html="pricePackage" v-once></span>
              <span class="jfk-price__original product-price-market font-size--24 font-color-light-gray" v-once v-html="priceMarket"></span>
            </div>
            <div class="date-norm jfk-fl-r font-color-extra-light-gray font-size--24" v-if="productInfo.spec_product" @click="handleSpecTicket">
              选择{{productInfo.isTicket ? '日期' : '规格'}}
              <i class="jfk-font icon-home_icon_Jump_norma color-golden triangle"></i>
            </div>
          </div>
        </div>
      </div>
      <product-killsec v-if="productInfo.tag ===2 && showKillsecModule" @killsec-status="handleKillsecStatus" :killsec="productInfo.killsec"></product-killsec>
      <div class="service jfk-ml-30 jfk-mr-30" v-if="serviceItems.length" v-once>
        <ul class="service-list font-size--24" :class="'service-list--' + (serviceItems.length < 5 ? 'single' : 'multiple')" @click="handleService">
          <li class="service-item" v-for="item in serviceItems" :key="item.key">
            <p class="icon">
              <i class="jfk-font font-color-light-gray-common" :class="item.icon"></i>
            </p>
            <p class="label font-color-extra-light-gray">{{item.label}}</p>
          </li>
          <li class="more jfk-flex is-align-middle" v-if="serviceItems.length > 4">
            <p class="icon font-color-extra-light-gray">
              <i></i>
            </p>
          </li>
        </ul>
      </div>
      <div class="detail-box">
        <div v-if="productInfo.tag === 2" class="killsec-original jfk-ml-30 jfk-mr-30">
          <div class="killsec-original__cont jfk-flex is-align-middle is-justify-space-between" @click="handleSubmitOrderOriginal">
            <span class="font-size--30 font-color-extra-light-gray">原价去购买</span>
            <span class="font-size--28 color-golden">
              <i>{{priceMarket}}</i>
              <i class="jfk-font triangle font-size--24 font-color-extra-light-gray icon-user_icon_jump_normal"></i>
            </span>
          </div>
        </div>
        <div v-if="productDetailInfo.labels.length" class="productinfo-detail" ref="productInfoDetail">
          <jfk-sticky>
          <ul class="jfk-ml-30 jfk-mr-30 productinfo-detail-label">
            <li
              v-for="item in productDetailInfo.labels"
              :key="item.key"
              class="font-size-32 label"
              @click="handleLabel(item.key)"
              :class="{
                'color-golden is-selected': currentLabel === item.key,
                'font-color-light-gray': currentLabel !== item.key
              }"
            ><div>{{item.label}}</div></li>
          </ul>
          </jfk-sticky>
          <div class="productinfo-detail-cont" v-html="productDetailInfo.html"></div>
        </div>
      </div>
    </div>
    <div class="hotel jfk-ml-30" v-if="hotelInfo.address">
      <div class="box">
        <div class="cont" @click="handleShowMap">
          <i class="jfk-font font-size--40 font-color-extra-light-gray icon-icon_location"></i>
          <div class="name font-size--30 font-color-white">{{hotelInfo.name}}</div>
          <div class="address font-size--28 font-color-extra-light-gray"><span>{{hotelInfo.address}}</span><i class="jfk-font icon-user_icon_jump_normal"></i></div>
        </div>
        <div class="order">
          <a :href="orderUrl" class="jfk-button jfk-button--free font-size--30 jfk-button--primary is-plain">
            <span class="jfk-button__text">
            <i class="jfk-font jfk-button__text-item icon-font_zh_wo_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_de_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_ding_qkbys"></i>
            <i class="jfk-font jfk-button__text-item icon-font_zh_dan_qkbys"></i>
            </span>
          </a>
        </div>
        <div class="qrcode color-golden jfk-flex is-align-middle" @click="handleQrcode">
          <div>
          <i class="jfk-font icon-mall_icon_pay_focus"></i>
          <p class="font-size--18">关注享优惠</p>
          </div>
        </div>
      </div>
    </div>
    <div class="recommendation jfk-pl-30" v-if="recommendations.length">
      <p class="font-size--24 font-color-light-gray tip">其他用户还看了</p>
      <div class="recommendations-list">
        <jfk-recommendation :items="recommendations" :linkPrefix="detailUrl" :emptyLink="indexUrl"></jfk-recommendation>
      </div>
    </div>
    <JfkSupport v-once></JfkSupport>
    <footer class="footer jfk-footer jfk-clearfix">
      <div class="links jfk-fl-l">
        <div class="jfk-flex is-justify--center is-align-middle">
          <a :href="indexUrl" class="link font-color-white">
            <i class="jfk-font font-size--30 icon-mall_icon_home"></i>
            <div class="text font-size--20">首页</div>
          </a>
          <a :href="orderUrl" class="link font-color-white">
            <i class="jfk-font font-size--30 icon-user_icon_Onlineboo"></i>
            <div class="text font-size--20">订单</div>
          </a>
        </div>
      </div>
      <div class="control jfk-fl-l">
        <button href="javascript:;" @click="handleSubmitOrder" class="jfk-button font-size--34 jfk-button--higher jfk-button--free jfk-button--primary">{{buttonText}}</button>
      </div>
    </footer>
    <template v-if="productInfo.spec_product">
      <product-ticket :productId="productInfo.product_id" :is-integral="productInfo.tag === 7" @submit-setting-id="getSettingId" :price="productInfo.price_package" :visible.sync="specTicketVisible" v-if="productInfo.isTicket"></product-ticket>
      <product-spec :productId="productInfo.product_id" :is-integral="productInfo.tag === 7" @submit-setting-id="getSettingId" :price="productInfo.price_package" :visible.sync="specTicketVisible" v-else></product-spec>
    </template>
    <template v-if="serviceItems.length">
      <jfk-popup v-model="serviceVisible" ref="popupService" class="jfk-popup__service" :showCloseButton="true">
        <div class="popup-box">
          <div class="title font-size--40 font-color-white">服务说明</div>
          <ul class="popup-service font-size--28" :style="{'max-height': serviceListMaxHeight}">
            <li class="popup-service-item" v-for="item in serviceItems" :key="item.key">
              <i class="jfk-font icon" :class="item.icon"></i>
              <p class="label">{{item.label}}</p>
              <p class="desc">{{item.desc}}</p>
            </li>
          </ul>
        </div>
      </jfk-popup>
    </template>
    <jfk-popup class="jfk-popup__qrcode jfk-ta-c" :showCloseButton="true" :closeOnClickModal="false" v-model="qrcodeVisible" v-if="hotelInfo.qrcode">
      <div class="qrcode">
        <img :src="hotelInfo.qrcode" />
      </div>
      <template v-if="fansInfo.is_fans">
        <div class="tip font-size--28 font-color-extra-light-gray">长按识别关注公众号</div>
        <div class="tip font-size--28 font-color-extra-light-gray">
          <span>享受</span>
          <span class="color-golden font-size--36">
            <i class="jfk-font icon-font_zh_geng_qkbys"></i>
            <i class="jfk-font icon-font_zh_duo_qkbys"></i>
            <i class="jfk-font icon-font_zh_you__qkbys"></i>
            <i class="jfk-font icon-font_zh_hui_qkbys"></i>
          </span>
        </div>
      </template>
      <template v-else>
        <div class="tip font-size--28 font-color-extra-light-gray">你还未关注公众号</div>
        <div class="tip font-size--28 font-color-extra-light-gray">先长按识别关注公众号吧！</div>
      </template>
    </jfk-popup>
    <jfk-popup v-model="killsecQrcodeVisible" :showCloseButton="true" :closeOnClickModal="false" class="jfk-popup__qrcode jfk-ta-c">
      <div class="qrcode">
        <img :src="killsecQrcodeUrl" />
      </div>
      <div class="tip font-size--28 font-color-extra-light-gray jfk-pl-30 jfk-pr-30">{{killsecQrcodeTip}}</div>
    </jfk-popup>
  </div>
</template>
<script>
  // 秒杀与多规格不并存
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getPackageInfo, getPackageRecommendation, getKillsecRob, postKillsecNotice } from '@/service/http'
  import serviceMaps from '@/utils/service'
  import formatPrice from '@/utils/price'
  import { openLocation } from '@/utils/wx'
  // 5.5元 => 5.5 元   5% => 5 %
  const salerBannerReg = /(\d+(?:\.\d+)?)([^\d]+)?/
  const priceTagMap = {
    // 0: 默认 惊喜价 1：专属 2：秒杀 3：拼团 4：满减 5：组合 6：储值 7：积分
    '0': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_jing_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_xi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs"></i>',
    '1': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_zhuan_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_shu_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',
    '2': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_miao_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_sha_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',
    '3': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_ren_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_tuan_fzdbs"></i>',
    '4': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_jing_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_xi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',
    '5': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_jing_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_xi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',
    '6': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_chu_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_zhi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',
    '7': '<i class="font-size--24 jfk-font price-tag-item icon-font_zh_ji_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_fen_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">'
  }
  const defaultGallery = {
    gry_id: '-1',
    gry_intro: '',
    gry_url: '',
    product_id: ''
  }
  export default {
    name: 'detail',
    components: {
      'product-killsec': () => import('./module/killsec'),
      'product-spec': () => import('./module/spec'),
      'product-ticket': () => import('./module/ticket')
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      if (params.pid) {
        this.productId = params.pid
      } else {
        // 跳转到404页面
        console.log(404)
      }
      this.maxHeight = document.documentElement.clientHeight
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
    },
    created () {
      let that = this
      getPackageInfo({
        pid: this.productId,
        openid: '123444xxa'
      }).then(function (res) {
        const { product_info, page_resource, saler_banner: salerBanner, hotel_info, public_info, fans_info } = res.web_data
        that.toast.close()
        if (!product_info.gallery || !product_info.gallery.length) {
          product_info.gallery = [defaultGallery]
          that.productGalleryIsDefault = true
        }
        that.productInfo = Object.assign({}, that.productInfo, product_info)
        that.tag = that.productInfo.tag
        that.hotelInfo = Object.assign({}, that.hotelInfo, hotel_info)
        that.publicInfo = Object.assign({}, that.publicInfo, public_info)
        that.fansInfo = Object.assign({}, that.fansInfo, fans_info)
        if (salerBanner.length) {
          let _salerBanner = [salerBanner[0]]
          let arr = salerBannerReg.exec(salerBanner[1]) || ['', '', salerBanner[1]]
          _salerBanner[1] = arr[1]
          _salerBanner[2] = arr[2] || ''
          _salerBanner[3] = salerBanner[2]
          that.salerBanner = _salerBanner
        }
        let { order, home, prepay } = page_resource.link
        if (process.env.NODE_ENV === 'development') {
          order = '/order_center'
          home = '/'
          prepay = '/reserve?pid=' + that.productId
        }
        that.orderUrl = order
        that.indexUrl = home
        that.reserveUrl = prepay
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
    data () {
      let that = this
      return {
        indexUrl: '',
        detailUrl: '',
        orderUrl: '',
        reserveUrl: '',
        productInfo: {},
        hotelInfo: {},
        fansInfo: {},
        publicInfo: {},
        salerBanner: [],
        settingId: '-1',
        productGalleryIndex: 1,
        // 无gallery图片，添加默认图片
        productGalleryIsDefault: false,
        bannerSwiperOptions: {
          autoplay: 3000,
          lazyLoading: true,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          onSlideChangeEnd: function (swiper) {
            that.productGalleryIndex = swiper.activeIndex + 1
          }
        },
        recommendations: [],
        specTicketVisible: false,
        serviceVisible: false,
        killsecQrcodeVisible: false,
        killsecQrcodeUrl: '',
        killsecQrcodeTip: '',
        killsecButtonDisabled: true,
        killsecSubScribeStatus: false,
        killsecStatus: 0,
        showKillsecModule: false,
        qrcodeVisible: false,
        tag: -1,
        buttonText: '立即购买',
        priceTag: '',
        // 通过弹层触发提交
        shouldTriggerSubmit: false,
        tokenId: '',
        // 服务弹框最大高度
        serviceListMaxHeight: 0,
        currentLabel: ''
      }
    },
    watch: {
      tag (val) {
        this.buttonText = val === 2 ? '立即秒杀' : val === 6 ? '储值购买' : '立即购买'
        val = (!val || val > 7) ? '0' : val
        this.priceTag = '<i class="mask color-golden"></i>' + priceTagMap[val]
        if (val !== 2) {
          this.killsecButtonDisabled = false
        } else {
          this.showKillsecModule = true
          this.killsecSubScribeStatus = this.productInfo.killsec.is_subscribe
        }
      },
      tokenId (val) {
        if (val) {
          this.submitOrder(1)
        }
      },
      killsecStatus (val) {
        // killsec-status 大于10分钟 1 小于10分钟2 开始3 时间结束4 库存结束 5
        if (val === 1) {
          if (this.killsecSubScribeStatus) {
            this.buttonText = '已订阅'
          } else {
            this.buttonText = '订阅提醒'
          }
        } else if (val === 2) {
          this.buttonText = '即将开始'
        } else if (val === 3) {
          this.buttonText = '立即秒杀'
        } else if (val === 4) {
          this.tag = 0
        } else if (val === 5) {
          this.showKillsecModule = false
          this.buttonText = '已售罄'
        }
      }
    },
    computed: {
      pricePackage () {
        return formatPrice(this.productInfo, false, true)
      },
      priceMarket () {
        return formatPrice(this.productInfo, true, true)
      },
      serviceItems () {
        let services = ['can_refund_3', 'can_mail', 'can_gift', 'can_pickup', 'can_invoice', 'can_refund']
        let items = []
        services.forEach((item, index) => {
          if (item === 'can_refund_3' && this.productInfo['can_refund'] === '3' || this.productInfo[item] === '1') {
            items.push(serviceMaps[item])
          }
        })
        if (items.length) {
          this.serviceListMaxHeight = (this.maxHeight - 141) + 'px'
        }
        return items
      },
      buttonDisabled () {
        const { productInfo, killsecButtonDisabled } = this
        if (productInfo.tag === 2 && killsecButtonDisabled) {
          return true
        }
        return false
      },
      productDetail () {
        const { compose } = this.productInfo
        let html = ''
        if (compose) {
          for (let i in compose) {
            if (compose[i].content) {
              html += `<li class="item tr font-color-extra-light-gray">${compose[i].content}<i class="right">${compose[i].num}</i></li>`
            }
          }
        }
        return html
      },
      productDetailInfo () {
        let p = this.productInfo
        let html = ''
        let labels = []
        // 图文详情
        if (p.img_detail) {
          labels.push({label: '图文详情', key: 'graphic'})
          html += `<div class="graphic productinfo-detail-item jfk-pl-30 jfk-pr-30"><div class="title font-color-white font-size--32"><span>图文详情</span></div><div class="cont"  id="graphic">${p.img_detail}</div></div>`
        }
        if (p.order_notice) {
          labels.push({label: '订购须知', key: 'notice'})
          html += `<div class="notice productinfo-detail-item jfk-pl-30 jfk-pr-30"><div class="title font-color-white font-size--32"><span>订购须知</span></div><div id="notice" class="cont">${p.order_notice}</div></div>`
        }
        if (this.productDetail) {
          labels.push({label: '商品内容', key: 'detail'})
          html += `<div class="detail productinfo-detail-item jfk-pl-30 jfk-pr-30 font-size--28"><div class="title font-color-white font-size--32"><span>商品内容</span></div><ul class="cont" id="detail"><li class="item thead font-color-light-gray">商品名称<i class="right">数量</i></li>${this.productDetail}</ul></div>`
        }
        if (labels.length) {
          this.currentLabel = labels[0].key
        }
        return {
          labels,
          html
        }
      }
    },
    methods: {
      noticeSuccess () {
        this.$jfkToast({
          message: '已订阅，请耐心等待活动开始！',
          iconType: 'success',
          duration: 2000
        })
      },
      showIllegalToast () {
        this.$jfkToast({
          message: '该商品暂不能购买',
          iconType: 'error'
        })
      },
      handleKillsecStatus (val) {
        this.killsecStatus = val
      },
      submitOrder (killsecType) {
        let href = this.reserveUrl
        if (this.settingId !== '-1') {
          href += '&psp_id=' + this.settingId
        }
        if (killsecType === 1) {
          href += '&token=' + this.tokenId + '&act_id=' + this.productInfo.killsec.act_id + '&inid=' + this.productInfo.killsec.instance.instance_id
        } else if (killsecType === 2) {
          href += '&common=1'
        }
        location.href = href
      },
      handleSpecTicket () {
        if (this.productInfo.tag === 2 && this.showKillsecModule) {
          return this.showIllegalToast()
        }
        this.shouldTriggerSubmit = true
        this.specTicketVisible = true
      },
      handleService () {
        this.serviceVisible = true
      },
      handleQrcode () {
        this.qrcodeVisible = true
      },
      handleShare () {
        this.$jfkShare()
      },
      handleLabel (key) {
        this.currentLabel = key
        let scrollHeight = Math.max(document.documentElement.scrollTop, document.body.scrollTop) || 0
        let clientTop = document.getElementById(key).getBoundingClientRect().top
        document.body.scrollTop = scrollHeight + clientTop - 66
      },
      handleSubmitOrder () {
        const { tag } = this.productInfo
        const { killsecStatus, killsecSubScribeStatus } = this
        let that = this
        if (tag === 2) { // 秒杀
          // 区分订阅与提醒
          if (killsecStatus === 1) {
            if (killsecSubScribeStatus) {
              this.noticeSuccess()
              return
            } else {
              let toast = this.$jfkToast({
                message: '正在设置提醒，请稍候',
                duration: -1
              })
              postKillsecNotice({
                act_id: this.productInfo.killsec.act_id
              }).then(function (res) {
                toast.close()
                if (res.web_data.data) {
                  that.killsecQrcodeUrl = res.web_data.data
                  that.killsecQrcodeTip = res.msg
                  that.killsecQrcodeVisible = true
                } else {
                  that.noticeSuccess()
                }
                that.killsecSubScribeStatus = true
                that.buttonText = '已订阅'
              }).catch(function (err) {
                toast.close()
                // 防止服务器返回数据错误
                if (err.status === 1001) {
                  that.killsecSubScribeStatus = true
                  that.buttonText = '已订阅'
                }
              })
              return
            }
          } else if (killsecStatus === 2) {
            this.$jfkToast({
              message: '活动还未开始，请耐心等候',
              iconType: 'error'
            })
            return
          } else if (killsecStatus === 3) {
            getKillsecRob({
              act_id: this.productInfo.killsec.act_id,
              inid: this.productInfo.killsec.instance.instance_id
            }).then(function (res) {
              const { status, token } = res.web_data
              if (status === 1) {
                that.tokenId = token
              } else {
                that.$jfkToast({
                  message: '活动太火被挤爆了，刷新页面重新试一下吧',
                  iconType: 'error'
                })
              }
            })
            return
          } else if (killsecStatus === 4) {
            this.submitOrder()
          } else if (killsecStatus === 5) {
            that.killsecButtonDisabled = true
          }
        } else if (this.productInfo.spec_product) { // 规格
          if (this.settingId !== '-1') {
            this.submitOrder(this.killsecStatus === 4 ? 2 : undefined)
          } else {
            this.shouldTriggerSubmit = true
            this.specTicketVisible = true
          }
        } else {
          this.submitOrder()
        }
      },
      handleSubmitOrderOriginal () {
        // 原价购买
        if (this.productInfo.spec_product) {
          if (this.settingId !== '-1') {
            this.submitOrder(2)
          } else {
            this.shouldTriggerSubmit = true
            this.specTicketVisible = true
          }
        } else {
          this.submitOrder(2)
        }
      },
      getSettingId (settingId) {
        this.settingId = settingId
        if (settingId !== '-1' && this.shouldTriggerSubmit) {
          this.submitOrder()
        }
        this.shouldTriggerSubmit = false
      },
      handleShowMap () {
        if (this.hotelInfo.latitude && this.hotelInfo.longitude) {
          openLocation(this.hotelInfo)
        }
      }
    }
  }
</script>
