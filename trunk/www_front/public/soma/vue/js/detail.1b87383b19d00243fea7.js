webpackJsonp([12],{138:function(t,i,e){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(i,"__esModule",{value:!0}),e(312);var n=e(8),o=s(n),a=e(312),c=s(a);i.default=function(){new o.default({el:"#app",template:"<App/>",components:{App:c.default}})}},180:function(t,i,e){"use strict";function s(t,i,e){var s=void 0;if(e)s=t[i?"price_market":"price_package"];else switch(t.tag){case 2:s=i?t.price_package:t.killsec.killsec_price;break;case 3:s=i?t.price_package:t.groupons.group_price;break;default:s=i?t.price_market:t.price_package}return i?(7!==t.tag?"￥":"")+s:(7!==t.tag?'<i class="jfk-font-number jfk-price__currency">￥</i>':"")+'<i class="jfk-font-number jfk-price__number">'+s+"</i>"}Object.defineProperty(i,"__esModule",{value:!0}),i.default=s},312:function(t,i,e){"use strict";Object.defineProperty(i,"__esModule",{value:!0});var s=e(333),n=e.n(s),o=e(443),a=e(27),c=a(n.a,o.a,null,null,null);i.default=c.exports},325:function(t,i,e){"use strict";Object.defineProperty(i,"__esModule",{value:!0}),i.default={can_refund_3:{label:"随时退款",desc:"该商品支持有效期内随时退款",icon:"icon-mall_icon_orderDetail_refund",key:"can_refund_3"},can_mail:{label:"邮寄到家",desc:"该商品可邮寄到家，足不出户便收到货品",icon:"icon-mall_icon_orderDetail_post",key:"can_mail"},can_gift:{label:"赠送好友",desc:"该商品随时可以通过微信转赠给您的好友",icon:"icon-mall_icon_orderDetai_gift",key:"can_gift"},can_pickup:{label:"到店自提",desc:"该商品支持您到店领取",icon:"icon-mall_icon_support_deliver",key:"can_pickup"},can_invoice:{label:"开具发票",desc:"该商品支持开具发票",icon:"icon-mall_icon_support_invoice",key:"can_invoice"},can_refund:{label:"七天退款",desc:"该商品支持七天内退款，超过规定时间不可退，请您合理安排使用时间",icon:"icon-mall_icon_orderDetail_refund",key:"can_refund"}}},326:function(t,i,e){"use strict";Object.defineProperty(i,"__esModule",{value:!0});var s=function(t,i,e){window.wx.ready(function(){"openLocation"===i&&n()})},n=function(t){window.wx.openLocation({latitude:parseFloat(t.latitude),longitude:parseFloat(t.longitude),name:t.name,address:t.address,scale:15,infoUrl:""})};i.wxApiCall=s,i.openLocation=n},333:function(t,i,e){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(i,"__esModule",{value:!0});var n=e(29),o=s(n),a=e(53),c=s(a),l=e(28),r=e(325),f=s(r),d=e(180),_=s(d),u=e(326),p=/(\d+(?:\.\d+)?)([^\d]+)?/,h={0:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_jing_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_xi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs"></i>',1:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_zhuan_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_shu_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',2:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_miao_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_sha_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',3:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_ren_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_tuan_fzdbs"></i>',4:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_jing_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_xi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',5:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_jing_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_xi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',6:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_chu_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_zhi_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">',7:'<i class="font-size--24 jfk-font price-tag-item icon-font_zh_ji_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_fen_fzdbs"></i><i class="font-size--24 jfk-font price-tag-item icon-font_zh_jia_fzdbs">'},k={gry_id:"-1",gry_intro:"",gry_url:"",product_id:""};i.default={name:"detail",components:{"product-killsec":function(){return e.e(28).then(e.bind(null,385))},"product-spec":function(){return e.e(29).then(e.bind(null,386))},"product-ticket":function(){return e.e(26).then(e.bind(null,387))}},beforeCreate:function(){var t=(0,c.default)(location.href);t.pid&&(this.productId=t.pid),this.maxHeight=document.documentElement.clientHeight,this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0})},created:function(){var t=this;(0,l.getPackageInfo)({pid:this.productId,openid:"123444xxa"}).then(function(i){var e=i.web_data,s=e.product_info,n=e.page_resource,a=e.saler_banner,c=e.hotel_info,l=e.public_info,r=e.fans_info;if(t.toast.close(),s.gallery&&s.gallery.length||(s.gallery=[k],t.productGalleryIsDefault=!0),t.productInfo=(0,o.default)({},t.productInfo,s),t.tag=t.productInfo.tag,t.hotelInfo=(0,o.default)({},t.hotelInfo,c),t.publicInfo=(0,o.default)({},t.publicInfo,l),t.fansInfo=(0,o.default)({},t.fansInfo,r),a.length){var f=[a[0]],d=p.exec(a[1])||["","",a[1]];f[1]=d[1],f[2]=d[2]||"",f[3]=a[2],t.salerBanner=f}var _=n.link,u=_.order,h=_.home,g=_.prepay;t.orderUrl=u,t.indexUrl=h,t.reserveUrl=g}),(0,l.getPackageRecommendation)({page:1,page_size:100}).then(function(i){var e=i.web_data,s=e.products,n=e.page_resource;t.recommendations=s;var o=n.link,a=o.detail,c=o.home;t.detailUrl=a,t.indexUrl=c})},data:function(){var t=this;return{indexUrl:"",detailUrl:"",orderUrl:"",reserveUrl:"",productInfo:{},hotelInfo:{},fansInfo:{},publicInfo:{},salerBanner:[],settingId:"-1",productGalleryIndex:1,productGalleryIsDefault:!1,bannerSwiperOptions:{autoplay:3e3,lazyLoading:!0,lazyLoadingInPrevNext:!0,lazyPreloaderClass:"jfk-image__lazy--preload",onSlideChangeEnd:function(i){t.productGalleryIndex=i.activeIndex+1}},recommendations:[],specTicketVisible:!1,serviceVisible:!1,killsecQrcodeVisible:!1,killsecQrcodeUrl:"",killsecQrcodeTip:"",killsecButtonDisabled:!0,killsecSubScribeStatus:!1,killsecStatus:0,showKillsecModule:!1,qrcodeVisible:!1,tag:-1,buttonText:"立即购买",priceTag:"",shouldTriggerSubmit:!1,tokenId:"",serviceListMaxHeight:0,currentLabel:""}},watch:{tag:function(t){this.buttonText=2===t?"立即秒杀":6===t?"储值购买":"立即购买",t=!t||t>7?"0":t,this.priceTag='<i class="mask color-golden"></i>'+h[t],2!==t?this.killsecButtonDisabled=!1:(this.showKillsecModule=!0,this.killsecSubScribeStatus=this.productInfo.killsec.is_subscribe)},tokenId:function(t){t&&this.submitOrder(1)},killsecStatus:function(t){1===t?this.killsecSubScribeStatus?this.buttonText="已订阅":this.buttonText="订阅提醒":2===t?this.buttonText="即将开始":3===t?this.buttonText="立即秒杀":4===t?this.tag=0:5===t&&(this.showKillsecModule=!1,this.buttonText="已售罄")}},computed:{pricePackage:function(){return(0,_.default)(this.productInfo,!1,!0)},priceMarket:function(){return(0,_.default)(this.productInfo,!0,!0)},serviceItems:function(){var t=this,i=["can_refund_3","can_mail","can_gift","can_pickup","can_invoice","can_refund"],e=[];return i.forEach(function(i,s){("can_refund_3"===i&&"3"===t.productInfo.can_refund||"1"===t.productInfo[i])&&e.push(f.default[i])}),e.length&&(this.serviceListMaxHeight=this.maxHeight-141+"px"),e},buttonDisabled:function(){var t=this.productInfo,i=this.killsecButtonDisabled;return!(2!==t.tag||!i)},productDetail:function(){var t=this.productInfo.compose,i="";if(t)for(var e in t)t[e].content&&(i+='<li class="item tr font-color-extra-light-gray">'+t[e].content+'<i class="right">'+t[e].num+"</i></li>");return i},productDetailInfo:function(){var t=this.productInfo,i="",e=[];return t.img_detail&&(e.push({label:"图文详情",key:"graphic"}),i+='<div class="graphic productinfo-detail-item jfk-pl-30 jfk-pr-30"><div class="title font-color-white font-size--32"><span>图文详情</span></div><div class="cont"  id="graphic">'+t.img_detail+"</div></div>"),t.order_notice&&(e.push({label:"订购须知",key:"notice"}),i+='<div class="notice productinfo-detail-item jfk-pl-30 jfk-pr-30"><div class="title font-color-white font-size--32"><span>订购须知</span></div><div id="notice" class="cont">'+t.order_notice+"</div></div>"),this.productDetail&&(e.push({label:"商品内容",key:"detail"}),i+='<div class="detail productinfo-detail-item jfk-pl-30 jfk-pr-30 font-size--28"><div class="title font-color-white font-size--32"><span>商品内容</span></div><ul class="cont" id="detail"><li class="item thead font-color-light-gray">商品名称<i class="right">数量</i></li>'+this.productDetail+"</ul></div>"),e.length&&(this.currentLabel=e[0].key),{labels:e,html:i}}},methods:{noticeSuccess:function(){this.$jfkToast({message:"已订阅，请耐心等待活动开始！",iconType:"success",duration:2e3})},showIllegalToast:function(){this.$jfkToast({message:"该商品暂不能购买",iconType:"error"})},handleKillsecStatus:function(t){this.killsecStatus=t},submitOrder:function(t){var i=this.reserveUrl;"-1"!==this.settingId&&(i+="&psp_id="+this.settingId),1===t?i+="&token="+this.tokenId+"&act_id="+this.productInfo.killsec.act_id+"&inid="+this.productInfo.killsec.instance.instance_id:2===t&&(i+="&common=1"),location.href=i},handleSpecTicket:function(){if(2===this.productInfo.tag&&this.showKillsecModule)return this.showIllegalToast();this.shouldTriggerSubmit=!0,this.specTicketVisible=!0},handleService:function(){this.serviceVisible=!0},handleQrcode:function(){this.qrcodeVisible=!0},handleShare:function(){this.$jfkShare()},handleLabel:function(t){this.currentLabel=t;var i=Math.max(document.documentElement.scrollTop,document.body.scrollTop)||0,e=document.getElementById(t).getBoundingClientRect().top;document.body.scrollTop=i+e-66},handleSubmitOrder:function(){var t=this.productInfo.tag,i=this.killsecStatus,e=this.killsecSubScribeStatus,s=this;if(2===t){if(1===i){if(e)return void this.noticeSuccess();var n=this.$jfkToast({message:"正在设置提醒，请稍候",duration:-1});return void(0,l.postKillsecNotice)({act_id:this.productInfo.killsec.act_id}).then(function(t){n.close(),t.web_data.data?(s.killsecQrcodeUrl=t.web_data.data,s.killsecQrcodeTip=t.msg,s.killsecQrcodeVisible=!0):s.noticeSuccess(),s.killsecSubScribeStatus=!0,s.buttonText="已订阅"}).catch(function(t){n.close(),1001===t.status&&(s.killsecSubScribeStatus=!0,s.buttonText="已订阅")})}if(2===i)return void this.$jfkToast({message:"活动还未开始，请耐心等候",iconType:"error"});if(3===i)return void(0,l.getKillsecRob)({act_id:this.productInfo.killsec.act_id,inid:this.productInfo.killsec.instance.instance_id}).then(function(t){var i=t.web_data,e=i.status,n=i.token;1===e?s.tokenId=n:s.$jfkToast({message:"活动太火被挤爆了，刷新页面重新试一下吧",iconType:"error"})});4===i?this.submitOrder():5===i&&(s.killsecButtonDisabled=!0)}else this.productInfo.spec_product?"-1"!==this.settingId?this.submitOrder(4===this.killsecStatus?2:void 0):(this.shouldTriggerSubmit=!0,this.specTicketVisible=!0):this.submitOrder()},handleSubmitOrderOriginal:function(){this.productInfo.spec_product?"-1"!==this.settingId?this.submitOrder(2):(this.shouldTriggerSubmit=!0,this.specTicketVisible=!0):this.submitOrder(2)},getSettingId:function(t){this.settingId=t,"-1"!==t&&this.shouldTriggerSubmit&&this.submitOrder(),this.shouldTriggerSubmit=!1},handleShowMap:function(){this.hotelInfo.latitude&&this.hotelInfo.longitude&&(0,u.openLocation)(this.hotelInfo)}}}},443:function(t,i,e){"use strict";var s=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("div",{staticClass:"jfk-pages jfk-pages__detail"},[e("div",{staticClass:"jfk-pages__theme"}),t._v(" "),t.productInfo.product_id?e("div",[t.salerBanner.length?e("div",{staticClass:"hotel-staff jfk-pl-30 jfk-pr-30"},[e("div",{staticClass:"cont color-golden font-size--24"},[e("span",{staticClass:"jfk-font notice-icon font-size--24 icon-mall_icon_notice"}),t._v(" "),e("span",{staticClass:"jfk-font notice-icon-1 font-size--24 icon-mall_icon_1_notice"}),t._v(t._s(t.salerBanner[0])+"\n        "),t.salerBanner[1]?e("span",{staticClass:"number jfk-font-number font-size--48"},[t._v(t._s(t.salerBanner[1]))]):t._e(),t._v(" "),t.salerBanner[2]?e("span",{staticClass:"unit"},[t._v(t._s(t.salerBanner[2]))]):t._e(),t._v(t._s(t.salerBanner[3]))])]):t._e(),t._v(" "),e("div",{staticClass:"detail-top",class:{"is-default":t.productGalleryIsDefault}},[e("div",{staticClass:"banners"},[e("swiper",{staticClass:"jfk-swiper",attrs:{options:t.bannerSwiperOptions}},t._l(t.productInfo.gallery,function(i,s){return e("swiper-slide",{key:i.gry_id,staticClass:"jfk-swiper__item",class:{"swiper-no-swiping":1===t.productInfo.gallery.length}},[e("div",{staticClass:"banners__item-box jfk-swiper__item-box"},[i.gry_url?e("div",{staticClass:"banners__item jfk-swiper__item-bg swiper-lazy",attrs:{"data-background":i.gry_url}},[e("div",{staticClass:"jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"})]):e("div",{staticClass:"banners__item jfk-swiper__item-bg"},[e("div",{staticClass:"jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"})])])])})),t._v(" "),e("div",{staticClass:"swiper-pagination font-size--24 swiper-pagination-fraction"},[e("span",{staticClass:"swiper-pagination-current"},[t._v(t._s(t.productGalleryIndex))]),t._v(" / "),e("span",{staticClass:"swiper-pagination-total"},[t._v(t._s(t.productInfo.gallery.length))])])],1),t._v(" "),e("div",{staticClass:"icons"},[t.hotelInfo.qrcode?e("i",{staticClass:"jfk-font font-size--36 icon-mall_icon_pay_focus",on:{click:t.handleQrcode}}):t._e(),t._v(" "),e("i",{staticClass:"jfk-font font-size--36 icon-mall_icon_pay_share",on:{click:t.handleShare}})]),t._v(" "),e("div",{staticClass:"info"},[e("div",{staticClass:"name font-size--38 font-color-white"},[e("span",{staticClass:"price-tag font-size--24",domProps:{innerHTML:t._s(t.priceTag)}}),t._v(t._s(t.productInfo.name)+"\n        ")]),t._v(" "),e("div",{staticClass:"sales font-color-light-gray font-size--24"},[t.publicInfo.name?e("span",{staticClass:"suppier"},[t._v(t._s(t.publicInfo.name)+"提供")]):t._e(),t._v(" "),"1"===t.productInfo.show_sales_cut?e("span",{staticClass:"sales_num"},[t._v("已售\n            "),e("i",{staticClass:"number"},[t._v(t._s(t.productInfo.sales_cnt))])]):t._e()]),t._v(" "),e("div",{staticClass:"others jfk-clearfix"},[e("div",{staticClass:"prices jfk-fl-l"},[t._m(0),t._v(" "),t._m(1)]),t._v(" "),t.productInfo.spec_product?e("div",{staticClass:"date-norm jfk-fl-r font-color-extra-light-gray font-size--24",on:{click:t.handleSpecTicket}},[t._v("\n            选择"+t._s(t.productInfo.isTicket?"日期":"规格")+"\n            "),e("i",{staticClass:"jfk-font icon-home_icon_Jump_norma color-golden triangle"})]):t._e()])])]),t._v(" "),2===t.productInfo.tag&&t.showKillsecModule?e("product-killsec",{attrs:{killsec:t.productInfo.killsec},on:{"killsec-status":t.handleKillsecStatus}}):t._e(),t._v(" "),t.serviceItems.length?t._m(3):t._e(),t._v(" "),e("div",{staticClass:"detail-box"},[2===t.productInfo.tag?e("div",{staticClass:"killsec-original jfk-ml-30 jfk-mr-30"},[e("div",{staticClass:"killsec-original__cont jfk-flex is-align-middle is-justify-space-between",on:{click:t.handleSubmitOrderOriginal}},[e("span",{staticClass:"font-size--30 font-color-extra-light-gray"},[t._v("原价去购买")]),t._v(" "),e("span",{staticClass:"font-size--28 color-golden"},[e("i",[t._v(t._s(t.priceMarket))]),t._v(" "),e("i",{staticClass:"jfk-font triangle font-size--24 font-color-extra-light-gray icon-user_icon_jump_normal"})])])]):t._e(),t._v(" "),t.productDetailInfo.labels.length?e("div",{ref:"productInfoDetail",staticClass:"productinfo-detail"},[e("jfk-sticky",[e("ul",{staticClass:"jfk-ml-30 jfk-mr-30 productinfo-detail-label"},t._l(t.productDetailInfo.labels,function(i){return e("li",{key:i.key,staticClass:"font-size-32 label",class:{"color-golden is-selected":t.currentLabel===i.key,"font-color-light-gray":t.currentLabel!==i.key},on:{click:function(e){t.handleLabel(i.key)}}},[e("div",[t._v(t._s(i.label))])])}))]),t._v(" "),e("div",{staticClass:"productinfo-detail-cont",domProps:{innerHTML:t._s(t.productDetailInfo.html)}})],1):t._e()])],1):t._e(),t._v(" "),t.hotelInfo.address?e("div",{staticClass:"hotel jfk-ml-30"},[e("div",{staticClass:"box"},[e("div",{staticClass:"cont",on:{click:t.handleShowMap}},[e("i",{staticClass:"jfk-font font-size--40 font-color-extra-light-gray icon-icon_location"}),t._v(" "),e("div",{staticClass:"name font-size--30 font-color-white"},[t._v(t._s(t.hotelInfo.name))]),t._v(" "),e("div",{staticClass:"address font-size--28 font-color-extra-light-gray"},[e("span",[t._v(t._s(t.hotelInfo.address))]),e("i",{staticClass:"jfk-font icon-user_icon_jump_normal"})])]),t._v(" "),e("div",{staticClass:"order"},[e("a",{staticClass:"jfk-button jfk-button--free font-size--30 jfk-button--primary is-plain",attrs:{href:t.orderUrl}},[t._m(4)])]),t._v(" "),e("div",{staticClass:"qrcode color-golden jfk-flex is-align-middle",on:{click:t.handleQrcode}},[t._m(5)])])]):t._e(),t._v(" "),t.recommendations.length?e("div",{staticClass:"recommendation jfk-pl-30"},[e("p",{staticClass:"font-size--24 font-color-light-gray tip"},[t._v("其他用户还看了")]),t._v(" "),e("div",{staticClass:"recommendations-list"},[e("jfk-recommendation",{attrs:{items:t.recommendations,linkPrefix:t.detailUrl,emptyLink:t.indexUrl}})],1)]):t._e(),t._v(" "),t._m(6),t._v(" "),e("footer",{staticClass:"footer jfk-footer jfk-clearfix"},[e("div",{staticClass:"links jfk-fl-l"},[e("div",{staticClass:"jfk-flex is-justify--center is-align-middle"},[e("a",{staticClass:"link font-color-white",attrs:{href:t.indexUrl}},[e("i",{staticClass:"jfk-font font-size--30 icon-mall_icon_home"}),t._v(" "),e("div",{staticClass:"text font-size--20"},[t._v("首页")])]),t._v(" "),e("a",{staticClass:"link font-color-white",attrs:{href:t.orderUrl}},[e("i",{staticClass:"jfk-font font-size--30 icon-user_icon_Onlineboo"}),t._v(" "),e("div",{staticClass:"text font-size--20"},[t._v("订单")])])])]),t._v(" "),e("div",{staticClass:"control jfk-fl-l"},[e("button",{staticClass:"jfk-button font-size--34 jfk-button--higher jfk-button--free jfk-button--primary",attrs:{href:"javascript:;"},on:{click:t.handleSubmitOrder}},[t._v(t._s(t.buttonText))])])]),t._v(" "),t.productInfo.spec_product?[t.productInfo.isTicket?e("product-ticket",{attrs:{productId:t.productInfo.product_id,"is-integral":7===t.productInfo.tag,price:t.productInfo.price_package,visible:t.specTicketVisible},on:{"submit-setting-id":t.getSettingId,"update:visible":function(i){t.specTicketVisible=i}}}):e("product-spec",{attrs:{productId:t.productInfo.product_id,"is-integral":7===t.productInfo.tag,price:t.productInfo.price_package,visible:t.specTicketVisible},on:{"submit-setting-id":t.getSettingId,"update:visible":function(i){t.specTicketVisible=i}}})]:t._e(),t._v(" "),t.serviceItems.length?[e("jfk-popup",{ref:"popupService",staticClass:"jfk-popup__service",attrs:{showCloseButton:!0},model:{value:t.serviceVisible,callback:function(i){t.serviceVisible=i},expression:"serviceVisible"}},[e("div",{staticClass:"popup-box"},[e("div",{staticClass:"title font-size--40 font-color-white"},[t._v("服务说明")]),t._v(" "),e("ul",{staticClass:"popup-service font-size--28",style:{"max-height":t.serviceListMaxHeight}},t._l(t.serviceItems,function(i){return e("li",{key:i.key,staticClass:"popup-service-item"},[e("i",{staticClass:"jfk-font icon",class:i.icon}),t._v(" "),e("p",{staticClass:"label"},[t._v(t._s(i.label))]),t._v(" "),e("p",{staticClass:"desc"},[t._v(t._s(i.desc))])])}))])])]:t._e(),t._v(" "),t.hotelInfo.qrcode?e("jfk-popup",{staticClass:"jfk-popup__qrcode jfk-ta-c",attrs:{showCloseButton:!0,closeOnClickModal:!1},model:{value:t.qrcodeVisible,callback:function(i){t.qrcodeVisible=i},expression:"qrcodeVisible"}},[e("div",{staticClass:"qrcode"},[e("img",{attrs:{src:t.hotelInfo.qrcode}})]),t._v(" "),t.fansInfo.is_fans?[e("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[t._v("长按识别关注公众号")]),t._v(" "),e("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[e("span",[t._v("享受")]),t._v(" "),e("span",{staticClass:"color-golden font-size--36"},[e("i",{staticClass:"jfk-font icon-font_zh_geng_qkbys"}),t._v(" "),e("i",{staticClass:"jfk-font icon-font_zh_duo_qkbys"}),t._v(" "),e("i",{staticClass:"jfk-font icon-font_zh_you__qkbys"}),t._v(" "),e("i",{staticClass:"jfk-font icon-font_zh_hui_qkbys"})])])]:[e("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[t._v("你还未关注公众号")]),t._v(" "),e("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[t._v("先长按识别关注公众号吧！")])]],2):t._e(),t._v(" "),e("jfk-popup",{staticClass:"jfk-popup__qrcode jfk-ta-c",attrs:{showCloseButton:!0,closeOnClickModal:!1},model:{value:t.killsecQrcodeVisible,callback:function(i){t.killsecQrcodeVisible=i},expression:"killsecQrcodeVisible"}},[e("div",{staticClass:"qrcode"},[e("img",{attrs:{src:t.killsecQrcodeUrl}})]),t._v(" "),e("div",{staticClass:"tip font-size--28 font-color-extra-light-gray jfk-pl-30 jfk-pr-30"},[t._v(t._s(t.killsecQrcodeTip))])])],2)},n=[function(){var t=this,i=t.$createElement;return(t._self._c||i)("span",{staticClass:"jfk-price product-price-package color-golden font-size--68",domProps:{innerHTML:t._s(t.pricePackage)}})},function(){var t=this,i=t.$createElement;return(t._self._c||i)("span",{staticClass:"jfk-price__original product-price-market font-size--24 font-color-light-gray",domProps:{innerHTML:t._s(t.priceMarket)}})},function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("p",{staticClass:"icon font-color-extra-light-gray"},[e("i")])},function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("div",{staticClass:"service jfk-ml-30 jfk-mr-30"},[e("ul",{staticClass:"service-list font-size--24",class:"service-list--"+(t.serviceItems.length<5?"single":"multiple"),on:{click:t.handleService}},[t._l(t.serviceItems,function(i){return e("li",{key:i.key,staticClass:"service-item"},[e("p",{staticClass:"icon"},[e("i",{staticClass:"jfk-font font-color-light-gray-common",class:i.icon})]),t._v(" "),e("p",{staticClass:"label font-color-extra-light-gray"},[t._v(t._s(i.label))])])}),t._v(" "),t.serviceItems.length>4?e("li",{staticClass:"more jfk-flex is-align-middle"},[t._m(2)]):t._e()],2)])},function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("span",{staticClass:"jfk-button__text"},[e("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_wo_qkbys"}),t._v(" "),e("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_de_qkbys"}),t._v(" "),e("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_ding_qkbys"}),t._v(" "),e("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_dan_qkbys"})])},function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("div",[e("i",{staticClass:"jfk-font icon-mall_icon_pay_focus"}),t._v(" "),e("p",{staticClass:"font-size--18"},[t._v("关注享优惠")])])},function(){var t=this,i=t.$createElement;return(t._self._c||i)("JfkSupport")}],o={render:s,staticRenderFns:n};i.a=o}});