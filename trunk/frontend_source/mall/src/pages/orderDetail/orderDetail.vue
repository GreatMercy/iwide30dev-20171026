<template>
  <div class="jfk-pages jfk-page__orderCoupon">
    <div class="jfk-pages__theme"></div>
    <headTitle :headTitleMsg="headTitleMsg"/>
    <div class="orderDetail__state jfk-pl-30 jfk-pr-30 " v-if="orderStatusMsg">
      <div class="orderDetail__state__main font-color-light-gray-common" v-if="used || overdue || refunded">
        <div class="orderDetail__state__type  font-size--60" v-html="orderStatusMsg">
        </div>
      </div>
      <div class="orderDetail__state__main color-golden" v-else>
        <div class="orderDetail__state__type  font-size--60" v-html="orderStatusMsg">
        </div>
      </div>
    </div>
    <div class="orderCoupon jfk-pl-30 jfk-pr-30">
      <div class="orderCoupon__main">
        <ordergiftinfo :giftinfo="giftinfo"></ordergiftinfo>
        <div class="jfk-menuList" v-if="validCoupon.status === '2'&& !used && !overdue && !refunded && menuListBtnShow">
          <div class="menu-inn jfk-clearfix color-golden">
            <div class="item" v-if="menuList.canReserve"><a
              :href="pageResource.package_booking + '&code_id='+validCoupon.code_id + '&oid=' + product.order_id"><i
              class="jfk-font icon-user_icon_Checkin_normal"></i>
              <p class="font-size--24">预约</p></a></div>
            <div class="item" v-if="menuList.canCheck"><a
              :href="pageResource.package_usage+'&aiid='+validCoupon.asset_item_id+'&code_id='+validCoupon.code_id"><i
              class="jfk-font icon-mall_icon_orderDetail_verify"></i>
              <p class="font-size--24">验券</p></a></div>
            <div class="item" v-if="menuList.canPost"><a
              :href="pageResource.show_shipping_info+'&oid='+validCoupon.order_id">
              <i class="jfk-font icon-mall_icon_orderDetail_post"></i>
              <p class="font-size--24">邮寄</p></a>
            </div>
            <div class="item" v-if="menuList.canWxBooking"><a
              :href="pageResource.wx_select_hotel+'&oid='+validCoupon.order_id+'&aiid='+validCoupon.asset_item_id">
              <i class="jfk-font icon-user_icon_Reservatio"></i>
              <p class="font-size--24">订房</p></a>
            </div>
            <div class="item" v-if="menuList.canSend"><a
              :href="pageResource.package_send+'&aiid='+validCoupon.asset_item_id+'&oid='+validCoupon.order_id"><i
              class="jfk-font icon-mall_icon_orderDetai_gift"></i>
              <p class="font-size--24">转赠</p></a></div>
          </div>
        </div>
      </div>
      <div class="orderCoupon__detail" v-if="!refunded && coupons.length && goodsType!== '3'">
        <h3 class="coupon__detail__title font-size--24">包含券码</h3>
        <div class="coupon__inn">
          <div class="coupon__detail__list">
            <template v-for="(item ,idx) in currentshowCoupons">
              <div class="item jfk-flex"
                   :class="{ item__invalid : item.status=='3'&&item.shipping_id=='0',item__post: item.status=='3'&&item.shipping_id!='0',item__send: item.status=='4'}">
                <div class="item__left">
                  <span class="title font-size--28">券 码</span>
                  <span class="number fot-size--32">
                          <jfk-text-split :text="item.code" :split="4"></jfk-text-split>
                        </span>
                </div>
                <div class="item__right" v-if="item.status=='2'" @click="handleQrcode(item.code,item.qrcode_url)">
                  <a href="javascript:;">
                    <i class="jfk-font icon-mall_icon_pay_focus qrcode font-size--44"></i>
                    <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                  </a>
                </div>
                <div class="item__right" v-else-if="item.status=='4'">
                  <a :href="pageResource.get_received_list+'&gid='+item.gid">
                    <span class="coupon__state font-size--24">已赠送</span>
                    <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                  </a>
                </div>
                <div class="item__right" v-else-if="item.status=='3'&&item.shipping_id!='0'">
                  <a :href="pageResource.shipping_detail+'&spid='+item.shipping_id">
                    <span class="coupon__state font-size--24">已邮寄</span>
                    <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                  </a>
                </div>
                <div class="item__right" v-else-if="item.status=='3'&&item.shipping_id=='0'">
                  <a
                    :href="pageResource.package_review+'&ciid='+item.consumer_item_id+'&aiid='+item.asset_item_id+'&code_id='+item.code_id">
                    <span class="coupon__state font-size--24">已使用</span>
                    <i class="jfk-font icon-user_icon_jump_normal arrow"></i>
                  </a>
                </div>
              </div>
            </template>
          </div>
          <div class="coupon__showhide jfk-ta-c font-size--24" :class="{hideCoupon:couponsShow}" @click="couponShowHide"
               v-if='coupons.length>1'>
            <div class="inn">
              <span v-if="couponsShow">收起</span>
              <span v-else>查看其他{{coupons.length - 1}}张券</span>
              <i class="jfk-font icon-home_icon_Jump_norma"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="orderInfo jfk-pl-30 jfk-pr-30">
      <h3 class="font-size--24">订单信息</h3>
      <div class="moreinfo__item"><span class="item__name font-size--28">订单编号</span><span
        class="item__value font-size--30">{{product.order_id}}</span></div>
      <div class="moreinfo__item"><span class="item__name font-size--28">下单时间</span><span
        class="item__value font-size--30">{{product.create_time}}</span></div>
      <div class="moreinfo__item"><span class="item__name font-size--28">订单总价</span><span
        class="jfk-price  font-size--38 item__value"><i class="jfk-font-number jfk-price__currency">￥</i><i
        class="jfk-font-number jfk-price__number">{{product.real_grand_total}}</i></span><span
        class="item__showTrade font-size--24" @click="handleTradePhoto">交易快照<i
        class="jfk-font icon-user_icon_jump_normal"></i></span></div>
    </div>
    <div class="orderBtns jfk-pl-30 jfk-pr-30">
      <div class="jfk-flex btn-box ">
        <div class="btn-item font-size--28" v-if="canRefundOrder && !refundSchedule">
          <a :href="pageResource.refund_index + product.order_id">
            <span class="jfk-font icon-mall_icon_orderDetail_refund color-golden font-size--32"></span>
            申请退款
          </a>
        </div>
        <div class="btn-item font-size--28" v-if="refundSchedule">
          <a :href="pageResource.refund_detail">
            <span class="jfk-font icon-mall_icon_orderDetail_refund color-golden font-size--32"></span>
            查看退款
          </a>
        </div>
        <div class="btn-item font-size--28" v-if="canDeleteOrder" @click="handleDeleteOrder(pageResource.del_order)">
          <a>
            <span class="jfk-font icon-mall_icon_orderDetail_delete color-golden font-size--32"></span>
            删除订单
          </a>
        </div>
        <div class="btn-item font-size--28" @click="handleHotelPhone(productPackage.hotel_tel)">
          <a>
            <span class="jfk-font icon-mall_icon_orderDetail_contact color-golden font-size--32"></span>
            客服电话
          </a>
        </div>
      </div>
    </div>
    <jfk-popup v-model="showQrcode" :showCloseButton="true" class="coupon-qrcode jfk-ta-c">
      <p class="font-color-extra-light-gray font-size--32 content">
        <jfk-text-split :text="popQrcodeNum" :split="3"></jfk-text-split>
      </p>
      <img :src="popQrcodeUrl">
    </jfk-popup>
    <jfk-popup v-model="showTradePhoto" :showCloseButton="true" class="trade-photo">
      <div class="tradeBox">
        <div class="tradeBox-cont" :style="{'max-height': maxHeight}">
          <div class="order-timeId font-size--24">
            <p class="item"><span>订单号</span>{{product.order_id}}</p>
            <p class="item"><span>下单时间</span>{{product.create_time}}</p>
          </div>
          <div class="order__gift__info jfk-clearfix">
            <div v-if="giftinfo.imgUrl"
                 class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image productimg"
                 v-lazy:background-image="giftinfo.imgUrl"></div>
            <div v-else
                 class="jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image jfk-image__lazy--preload"></div>
            <div class="content jfk-pl-30 ">
              <h2 class="font-size--32">{{giftinfo.title}}</h2>
              <p class="font-size--24 validate">{{productPackage.hotel_name}}</p>
              <div class="price_box color-golden-price"><span class="jfk-price  font-size--38"><i
                class="jfk-font-number jfk-price__currency">￥</i><i
                class="jfk-font-number jfk-price__number">{{giftinfo.price}}</i></span><span
                class="number font-size--24">{{giftinfo.number}}份</span></div>
            </div>
          </div>
          <a class="jfk-button jfk-button--primary is-plain font-size--30 product-button"
             :href="pageResource.package_detail+productPackage.product_id"><span>再次购买</span></a>
          <div class="trade-service">
            <ul class="jfk-clearfix jfk-ta-c ">
              <li class="font-size--40"><i class="jfk-font icon-mall_icon_support_ensure"></i>
                <p class="font-size--28">品质保证</p>
              </li>
              <li class="font-size--40" v-if="menuList.canRefund"><i
                class="jfk-font icon-mall_icon_orderDetail_refund"></i>
                <p class="font-size--28">随时退款</p>
              </li>
              <li class="font-size--40" v-if="menuList.canPost"><i class="jfk-font icon-mall_icon_orderDetail_post"></i>
                <p class="font-size--28">邮寄到家</p>
              </li>
              <li class="font-size--40" v-if="menuList.canSend"><i class="jfk-font icon-mall_icon_orderDetai_gift"></i>
                <p class="font-size--28">赠送好友</p>
              </li>
              <li class="font-size--40" v-if="menuList.canCheck"><i class="jfk-font icon-mall_icon_support_deliver"></i>
                <p class="font-size--28">到店自提</p>
              </li>
              <!-- <li class="font-size--40" v-if="menuList.canInvoice"><i
                class="jfk-font icon-mall_icon_support_invoice"></i>
                <p class="font-size--28">开具发票</p>
              </li> -->
              <li class="font-size--40" v-if="menuList.canWxBooking"><i class="jfk-font icon-user_icon_Reservatio"></i>
                <p class="font-size--28">微信订房</p>
              </li>
            </ul>
          </div>
          <div class="trade-moreinfo">
            <h3 class="font-size--24">使用截至时间</h3>
            <p class="font-size--28">{{giftinfo.validate}}</p>
            <template v-if="productPackage.order_notice">
              <h3 class="font-size--24">订购需知</h3>
              <div v-html="productPackage.order_notice" class="font-size--28 order_notice"></div>
            </template>
            <template v-if="showProductimg">
              <template v-if="productPackage.img_detail">
                <h3 class="font-size--24">商品详情</h3>
                <div v-html="productPackage.img_detail" class="font-size--28"></div>
              </template>
              <template v-if="productDetail">
                <h3 class="font-size--24">商品内容</h3>
                <div class="productDetail font-size--28">
                  <p :key="index" v-for="(item, index) in productDetail"><span>{{item.content}}<i
                    class="num">({{item.num}}份)</i></span>
                  </p>
                </div>
              </template>
            </template>
          </div>
          <div class="trade-product font-size--24 jfk-ta-c " :class="{hideProductimg:showProductimg}"
               @click="handleProductimg" v-if="productPackage.img_detail||productDetail">
            <p><span v-if="showProductimg">收起</span><span v-else>查看商品详情</span><i
              class="jfk-font icon-home_icon_Jump_norma"></i></p>
          </div>
        </div>
      </div>
    </jfk-popup>
    <JfkSupport v-once></JfkSupport>
  </div>
</template>
<script>
  import formatUrlParams from 'jfk-ui/lib/format-urlparams.js'
  import { getOrderDetail, deleteOrder } from '@/service/http'
  import headTitle from '@/components/common/headTitle'
  import orderStatus from '@/components/orderDetail/orderStatus.vue'
  import ordergiftinfo from '@/components/orderDetail/orderGiftinfo.vue'
  const orderStatusMap = {
    success: '<i class="jfk-font icon-font_zh_gou_qkbys"></i><i class="jfk-font icon-font_zh_mai_qkbys"></i><i class="jfk-font icon-font_zh_cheng_qkbys"></i><i class="jfk-font icon-font_zh_gong_qkbys"></i>',
    refund: '<i class="jfk-font icon-font_zh_yi_qkbys"></i><i class="jfk-font icon-font_zh_tui_qkbys"></i><i class="jfk-font icon-font_zh_kuan_qkbys"></i>',
    used: '<i class="jfk-font icon-font_zh_shi_qkbys"></i><i class="jfk-font icon-font_zh_yong_qkbys"></i><i class="jfk-font icon-font_zh_wan_qkbys"></i><i class="jfk-font icon-font_zh_bi_qkbys"></i>',
    invalid: '<i class="jfk-font icon-font_zh_yi_qkbys"></i><i class="jfk-font icon-font_zh_guo_qkbys"></i><i class="jfk-font icon-font_zh_qi_qkbys"></i>',
    refunding: '<i class="jfk-font icon-font_zh_tui_qkbys"></i><i class="jfk-font icon-font_zh_kuan_qkbys"></i><i class="jfk-font icon-font_zh_zhong_qkbys"></i>'
  }
  const orderStatusFn = function (type) {
    return orderStatusMap[type]
  }
  export default {
    name: 'orderDetail',
    components: {
      headTitle,
      orderStatus,
      ordergiftinfo
    },
    data () {
      return {
        headTitleMsg: '',
        showQrcode: false,
        showTradePhoto: false,
        showDeleteOrder: true,
        giftinfo: {
          imgUrl: '',
          title: '',
          number: '1',
          price: '',
          validate: '',
          showValidate: true
        },
        menuList: {
          canReserve: true,
          canCheck: true,
          canPost: true,
          canSend: true,
          canRefund: true,
          canInvoice: true,
          canWxBooking: true
        },
        canDeleteOrder: false,
        canRefundOrder: false,
        orderStatusMsg: '',
        orderInfoObject: {
          orderNumber: '1208328478',
          offerTime: '2017/05/01',
          orderPrice: '987'
        },
        coupons: [],
        currentshowCoupons: [],
        pageResource: {},
        couponsShow: false,
        validCoupon: {},
        product: {},
        productPackage: {},
        popQrcodeNum: '',
        popQrcodeUrl: '',
        overdue: false,
        used: false,
        refunded: false,
        compose: {},
        showProductimg: false,
        refundSchedule: false,
        goodsType: ''
      }
    },
    beforeCreate () {
      let params = formatUrlParams(location.href)
      this.oid = params.oid || ''
      this.maxHeight = document.documentElement.clientHeight - 90 + 'px'
      this.toast = this.$jfkToast({
        duration: -1,
        iconClass: 'jfk-loading__snake',
        isLoading: true
      })
      this.$pageNamespace(params)
    },
    created () {
      let that = this
      getOrderDetail({
        oid: this.oid
      }).then(function (res) {
        that.toast.close()
        let product = res.web_data.product
        let productPackage = product.package[0]
        let code = res.web_data.code
        that.headTitleMsg = '该商品由' + res.web_data.public.name + '提供'
        that.giftinfo.imgUrl = productPackage.face_img
        that.giftinfo.title = productPackage.name
        that.giftinfo.validate = productPackage.expiration_date
        that.giftinfo.price = product.real_grand_total
        that.giftinfo.number = product.row_qty
        that.coupons = code
        that.currentshowCoupons = [that.coupons[0]]
        that.pageResource = res.web_data.page_resource.link
        if (process.env.NODE_ENV === 'development') {
          let bookingUrl = that.pageResource.package_booking
          if (that && that.pageResource && bookingUrl) {
            const bookingParams = formatUrlParams(bookingUrl)
            that.pageResource.package_booking = `/reservation_list?id=${bookingParams.id}&aiid=${bookingParams.aiid}&aiidi=${bookingParams.aiidi}&bsn=${bookingParams.bsn}`
          }
        }
        that.product = product
        that.menuList.canReserve = productPackage.can_reserve === '1' ? 'true' : false
        that.menuList.canCheck = productPackage.can_pickup === '1' ? 'true' : false
        that.menuList.canPost = productPackage.can_mail === '1' ? 'true' : false
        that.menuList.canSend = productPackage.can_gift === '1' ? 'true' : false
        that.menuList.canRefund = productPackage.can_refund !== '2' ? 'false' : true
        that.menuList.canInvoice = productPackage.can_invoice === '1' ? 'true' : false
        that.menuList.canWxBooking = productPackage.can_wx_booking === '1' ? 'true' : false
        that.productPackage = productPackage
        that.overdue = new Date() > new Date(that.giftinfo.validate) ? 'true' : false
        that.used = product.consume_status === '23' ? 'true' : false
        that.refunded = product.refund_info_status === '3' ? 'true' : false
        that.compose = productPackage.composes
        that.goodsType = product.package[0].goods_type
        if (code[0] && code[0].status === '2') {
          that.validCoupon = code[0]
        }
        if (that.overdue || product.consume_status === '23' || product.refund_info_status === '3' || product.package[0].type === '3' || product.package[0].type === '5') {
          that.canDeleteOrder = true
        }
        if (that.menuList.canRefund && product.consume_status === '21' && !that.overdue && product.refund_info_status !== '3' && product.refund_info_status !== '5' && product.refund_info_status !== '6' && product.package[0].type !== '3' && product.package[0].type !== '5') {
          that.canRefundOrder = true
        }
        if (product.status === '12') {
          that.orderStatusMsg = orderStatusFn('success')
        }
        if (that.refunded) {
          that.orderStatusMsg = orderStatusFn('refund')
        } else if (product.refund_info_status === '1' || product.refund_info_status === '2' || product.refund_info_status === '6') {
          that.orderStatusMsg = orderStatusFn('refunding')
          that.refundSchedule = true
        } else if (that.overdue) {
          that.orderStatusMsg = orderStatusFn('invalid')
        } else if (that.used) {
          that.orderStatusMsg = orderStatusFn('used')
        }
      })
    },
    computed: {
      productDetail () {
        const compose = this.compose
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
      menuListBtnShow () {
        const menuList = this.menuList
        let j = 0
        for (let i in menuList) {
          if (menuList[i] === 'true') {
            j++
          }
        }
        if (j) {
          return true
        } else {
          return false
        }
      }
    },
    methods: {
      couponShowHide () {
        if (!this.couponsShow) {
          this.couponsShow = true
          this.currentshowCoupons = this.coupons
        } else {
          this.couponsShow = false
          this.currentshowCoupons = [this.coupons[0]]
        }
      },
      handleQrcode (code, qrcodeurl) {
        this.popQrcodeNum = code
        this.popQrcodeUrl = qrcodeurl
        this.showQrcode = true
      },
      handleTradePhoto () {
        this.showTradePhoto = true
      },
      handleDeleteOrder () {
        this.$jfkConfirm('确定删除订单？').then(action => {
          if (action === 'confirm') {
            this.toast = this.$jfkToast({
              duration: -1,
              iconClass: 'jfk-loading__snake',
              isLoading: true
            })
            deleteOrder(this.oid).then((res) => {
              this.toast.close()
              this.$jfkToast('删除成功')
              window.location.href = res.web_data.page_resource.link.order
            }).catch(() => {
              this.toast.close()
            })
          }
        }).catch(() => {
        })
      },
      handleHotelPhone (tel) {
        this.$jfkConfirm('确定拨打电话' + tel + '？').then(action => {
          if (action === 'confirm') {
            window.location.href = 'tel:' + tel
          }
        }).catch(() => {
        })
      },
      handleProductimg () {
        this.showProductimg = (this.showProductimg) === false ? 'true' : false
      }
    }
  }
</script>
