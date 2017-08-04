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
      <div class="detail-top">
        <div class="banners">
          <swiper :options="bannerSwiperOptions" class="jfk-swiper">
            <swiper-slide v-for="(item, index) in productInfo.gallery" :key="item.gry_id" class="jfk-swiper__item" :class="{'swiper-no-swiping': productInfo.gallery.length === 1}">
              <div class="banners__item-box jfk-swiper__item-box">
                <div :data-background="item.gry_url" class="banners__item jfk-swiper__item-bg swiper-lazy">
                  <div class="jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"></div>
                </div>
              </div>
            </swiper-slide>
            <div class="swiper-pagination font-size--24" slot="pagination"></div>
          </swiper>
        </div>
        <div class="icons">
          <i class="jfk-font font-size--36 icon-mall_icon_pay_focus" v-if="hotelInfo.qrcode" @click="handleQrcode"></i>
          <i class="jfk-font font-size--36 icon-mall_icon_pay_share"></i>
        </div>
      </div>
      <div class="info">
        <div class="name font-size--38 font-color-white">
          <span class="price-tag font-size--24" v-html="priceTag"></span>{{productInfo.name}}
        </div>
        <div class="sales font-color-light-gray font-size--24">
          <span class="suppier" v-if="publicInfo.name">{{publicInfo.name}}提供</span>
          <span class="sales_num">已售
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
      <product-killsec v-if="productInfo.tag ===2 && showKillsecModule" @killsec-start="killsecStart" @killsecFinish="killsecFinish" :killsec="productInfo.killsec"></product-killsec>
      <div class="service jfk-ml-30 jfk-mr-30" v-if="serviceItems.length" v-once>
        <ul class="service-list font-size--24" :class="{'service-list--single': serviceItems.length < 5}" @click="handleService">
          <li class="service-item" v-for="item in serviceItems" :key="item.key">
            <p class="icon">
              <i class="jfk-font" :class="item.icon"></i>
            </p>
            <p class="label">{{item.label}}</p>
          </li>
          <li class="more jfk-flex is-align-middle" v-if="serviceItems.length > 4">
            <p class="icon">
              <i></i>
            </p>
          </li>
        </ul>
      </div>
      <div class="detail-box">
        <div v-if="productInfo.tag === 2 && !killsecButtonDisabled" class="killsec-original jfk-ml-30 jfk-mr-30">
          <div class="killsec-original__cont jfk-flex is-align-middle is-justify-space-between" @click="handleSubmitOrderOriginal">
            <span class="font-size--30 font-color-extra-light-gray">原价去购买</span>
            <span class="font-size--28 color-golden">
              <i>{{priceMarket}}</i>
              <i class="jfk-font triangle font-size--24 font-color-extra-light-gray icon-user_icon_jump_normal"></i>
            </span>
          </div>
        </div>
        <div class="graphic jfk-pl-30 jfk-pr-30" v-once v-if="productInfo.img_detail">
          <div class="title font-color-white font-size--32">
            <span>图文详情</span>
          </div>
          <div class="cont" v-html="productInfo.img_detail"></div>
        </div>
        <div class="notice jfk-pl-30 jfk-pr-30" v-once v-if="productInfo.order_notice">
          <div class="title font-color-white font-size--32">
            <span>订购须知</span>
          </div>
          <div class="cont" v-html="productInfo.order_notice"></div>
        </div>
        <div class="detail jfk-pl-30 jfk-pr-30 font-size--28" v-once v-if="productDetail">
          <div class="title font-color-white font-size--32">
            <span>商品内容</span>
          </div>
          <ul class="cont">
            <li class="item thead font-color-light-gray">
              商品名称
              <i class="right">数量</i>
            </li>
            <li class="item tr font-color-extra-light-gray" :key="index" v-for="(item,index) in productDetail">
              {{item.content}}
              <i class="right">{{item.num}}</i>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="hotel jfk-ml-30 jfk-mr-30" v-if="hotelInfo.show">
      <div class="box">
        <i class="jfk-font font-icon_location"></i>
        <div class="cont">
          <div class="name">{{hotelInfo.name}}</div>
          <div class="address">{{hotelInfo.address}}</div>
          <div class="order">
            <a :href="orderUrl" class="jfk-button jfk-button--primary is-plain">
              <i class="jfk-font icon-font_zh_wo_qkbys"></i>
              <i class="jfk-font icon-font_zh_de_qkbys"></i>
              <i class="jfk-font icon-font_zh_ding_qkbys"></i>
              <i class="jfk-font icon-font_zh_dan_qkbys"></i>
            </a>
          </div>
        </div>
        <div class="qrcode">
          <i class="jfk-font font-mall_icon_pay_focus"></i>
          <p>关注享优惠</p>
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
    <footer class="footer jfk-clearfix">
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
        <button href="javascript:;" :disabled="buttonDisabled" @click="handleSubmitOrder" class="jfk-button font-size--34 jfk-button--higher jfk-button--free jfk-button--primary">{{buttonText}}</button>
      </div>
    </footer>
    <template v-if="productInfo.spec_product">
      <product-ticket :productId="productInfo.product_id" @submit-setting-id="getSettingId" :price="productInfo.price_package" :visible.sync="specTicketVisible" v-if="productInfo.isTicket"></product-ticket>
      <product-spec :productId="productInfo.product_id" @submit-setting-id="getSettingId" :price="productInfo.price_package" :visible.sync="specTicketVisible" v-else></product-spec>
    </template>
    <template v-if="serviceItems.length">
      <jfk-popup v-model="serviceVisible" class="jfk-popup__service" position="bottom" :showCloseButton="true">
        <div class="popup-box">
          <div class="title font-size--40 font-color-white">服务说明</div>
          <ul class="popup-service font-size--28">
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
      <div class="tip font-size--28 font-color-extra-light-gray">长按识别关注公众号</div>
      <div class="tip font-size--28 font-color-extra-light-gray">
        <span>享受</span>
        <span class="color-golden font-size--34">
          <i class="jfk-font icon-font_zh_geng_qkbys"></i>
          <i class="jfk-font icon-font_zh_duo_qkbys"></i>
          <i class="jfk-font icon-font_zh_you__qkbys"></i>
          <i class="jfk-font icon-font_zh_hui_qkbys"></i>
        </span>
      </div>
    </jfk-popup>
  </div>
</template>
<script>
  // 秒杀与多规格不并存
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getPackageInfo, getPackageRecommendation, getKillsecRob } from '@/service/http'
  import serviceMaps from '@/utils/service'
  import formatPrice from '@/utils/price'
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
  export default {
    name: 'detail',
    components: {
      'product-killsec': () => import('./module/killsec'),
      'product-spec': () => import('./module/spec'),
      'product-ticket': () => import('./module/ticket')
    },
    data () {
      return {
        indexUrl: '',
        detailUrl: '',
        orderUrl: '',
        reserveUrl: '',
        productInfo: {},
        hotelInfo: {},
        publicInfo: {},
        salerBanner: [],
        settingId: '-1',
        bannerSwiperOptions: {
          autoplay: 3000,
          lazyLoading: false,
          lazyLoadingInPrevNext: true,
          lazyPreloaderClass: 'jfk-image__lazy--preload',
          pagination: '.swiper-pagination',
          paginationType: 'fraction'
        },
        recommendations: [],
        specTicketVisible: false,
        serviceVisible: false,
        killsecButtonDisabled: true,
        showKillsecModule: false,
        qrcodeVisible: false,
        tag: -1,
        buttonText: '立即购买',
        priceTag: '',
        // 通过弹层触发提交
        shouldTriggerSubmit: false,
        tokenId: ''
      }
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      if (params.pid) {
        this.productId = params.pid
      } else {
        // 跳转到404页面
        console.log(404)
      }
    },
    created () {
      let that = this
      getPackageInfo({
        pid: this.productId
      }).then(function (res) {
        const { product_info, page_resource, saler_banner: salerBanner, hotel_info, public_info } = res.web_data
        that.productInfo = Object.assign({}, that.productInfo, product_info)
        that.tag = that.productInfo.tag
        that.hotelInfo = Object.assign({}, that.hotelInfo, hotel_info)
        that.publicInfo = Object.assign({}, that.publicInfo, public_info)
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
          order = '/order'
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
    watch: {
      tag (val) {
        this.buttonText = val === 2 ? '立即秒杀' : val === 6 ? '储值购买' : '立即购买'
        val = (!val || val > 7) ? '0' : val
        this.priceTag = '<i class="mask color-golden"></i>' + priceTagMap[val]
        if (val !== 2) {
          this.killsecButtonDisabled = false
        } else {
          this.showKillsecModule = true
        }
      },
      tokenId (val) {
        if (val) {
          this.submitOrder(true)
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
        return items
      },
      productDetail () {
        const { compose } = this.productInfo
        if (compose) {
          let result = []
          let j = 0
          for (let i in compose) {
            if (compose[i].content) {
              j++
              result.push(compose[i])
            }
          }
          if (j) {
            return result
          }
        }
        return false
      },
      buttonDisabled () {
        const { productInfo, killsecButtonDisabled, settingId } = this
        if (productInfo.tag === 2 && killsecButtonDisabled) {
          return true
        }
        if (productInfo.spec_product && settingId === '-1') {
          return true
        }
        return false
      }
    },
    methods: {
      showIllegalToast () {
        this.$jfkToast({
          message: '该商品暂不能购买',
          iconType: 'error'
        })
      },
      killsecStart () {
        this.killsecButtonDisabled = false
      },
      killsecFinish (type) {
        // 秒杀活动结束，变普通商品
        if (type === 2) {
          this.tag = 0
        } else {
          this.showKillsecModule = false
          this.killsecButtonDisabled = true
          this.buttontext = '已售罄'
        }
      },
      submitOrder (killsec) {
        location.href = this.reserveUrl + (this.settingId !== '-1' ? '&psp_id=' + this.settingId : '') + (killsec ? '&token=' + this.tokenId : '')
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
      handleSubmitOrder () {
        if (!this.buttonDisabled) {
          const { tag } = this.productInfo
          let that = this
          if (tag === 2) {
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
          } else {
            this.submitOrder()
          }
        }
      },
      handleSubmitOrderOriginal () {
        // 原价购买
        if (this.productInfo.spec_product) {
          if (this.settingId !== '-1') {
            this.submitOrder()
          } else {
            this.shouldTriggerSubmit = true
            this.specTicketVisible = true
          }
        } else {
          this.submitOrder()
        }
      },
      getSettingId (settingId) {
        this.settingId = settingId
        if (settingId !== '-1' && this.shouldTriggerSubmit) {
          this.submitOrder()
        }
        this.shouldTriggerSubmit = false
      }
    }
  }
</script>
