webpackJsonp([15],{144:function(t,e,i){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0}),i(326);var o=i(8),a=s(o),n=i(326),l=s(n);e.default=function(){new a.default({el:"#app",template:"<App/>",components:{App:l.default}})}},188:function(t,e,i){"use strict";function s(t,e,i){var s=void 0;if(i)s=t[e?"price_market":"price_package"];else switch(t.tag){case 2:s=e?t.price_package:t.killsec.killsec_price;break;case 3:s=e?t.price_package:t.groupons.group_price;break;default:s=e?t.price_market:t.price_package}return e?(7!==t.tag?"￥":"")+s:(7!==t.tag?'<i class="jfk-font-number jfk-price__currency">￥</i>':"")+'<i class="jfk-font-number jfk-price__number">'+s+"</i>"}Object.defineProperty(e,"__esModule",{value:!0}),e.default=s},326:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i(348),o=i.n(s),a=i(469),n=i(26),l=n(o.a,a.a,null,null,null);e.default=l.exports},340:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={can_refund_3:{label:"随时退款",desc:"该商品支持有效期内随时退款",icon:"icon-mall_icon_orderDetail_refund",key:"can_refund_3"},can_mail:{label:"邮寄到家",desc:"该商品可邮寄到家，足不出户便收到货品",icon:"icon-mall_icon_orderDetail_post",key:"can_mail"},can_gift:{label:"赠送好友",desc:"该商品随时可以通过微信转赠给您的好友",icon:"icon-mall_icon_orderDetai_gift",key:"can_gift"},can_pickup:{label:"到店自提",desc:"该商品支持您到店领取",icon:"icon-mall_icon_support_deliver",key:"can_pickup"},can_invoice:{label:"开具发票",desc:"该商品支持开具发票",icon:"icon-mall_icon_support_invoice",key:"can_invoice"},can_refund:{label:"七天退款",desc:"该商品支持七天内退款，超过规定时间不可退，请您合理安排使用时间",icon:"icon-mall_icon_orderDetail_refund",key:"can_refund"}}},341:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=function(t,e,i){window.wx.ready(function(){"openLocation"===e&&o()})},o=function(t){window.wx.openLocation({latitude:parseFloat(t.latitude),longitude:parseFloat(t.longitude),name:t.name,address:t.address,scale:15,infoUrl:""})};e.wxApiCall=s,e.openLocation=o},348:function(t,e,i){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var o=i(29),a=s(o),n=i(28),l=s(n),c=i(27),r=i(340),d=s(r),f=i(188),u=s(f),p=i(341),_=/(\d+(?:\.\d+)?)([^\d]+)?/,h={0:"惊喜价",1:"专属价",2:"秒杀价",3:"人团",4:"惊喜价",5:"惊喜价",6:"储值价",7:"积分价"},v={gry_id:"-1",gry_intro:"",gry_url:"",product_id:""};e.default={name:"detail",components:{"product-killsec":function(){return i.e(31).then(i.bind(null,405))},"product-spec":function(){return i.e(32).then(i.bind(null,406))},"product-ticket":function(){return i.e(29).then(i.bind(null,407))}},beforeCreate:function(){var t=(0,l.default)(location.href);t.pid&&(this.productId=t.pid),this.$pageNamespace(t),this.maxHeight=document.documentElement.clientHeight,this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0})},created:function(){var t=this;(0,c.getPackageInfo)({pid:this.productId}).then(function(e){var i=e.web_data,s=i.product_info,o=i.page_resource,n=i.saler_banner,l=i.hotel_info,c=i.public_info,r=i.fans_info;if(t.toast.close(),s.gallery&&s.gallery.length||(s.gallery=[v],t.productGalleryIsDefault=!0),t.productInfo=(0,a.default)({},t.productInfo,s),t.tag=t.productInfo.tag,t.hotelInfo=(0,a.default)({},t.hotelInfo,l),t.publicInfo=(0,a.default)({},t.publicInfo,c),t.fansInfo=(0,a.default)({},t.fansInfo,r),n.length){var d=[n[0]],f=_.exec(n[1])||["","",n[1]];d[1]=f[1],d[2]=f[2]||"",d[3]=n[2],t.salerBanner=d}var u=o.link,p=u.order,h=u.home,g=u.prepay;t.orderUrl=p,t.indexUrl=h,t.reserveUrl=g}),(0,c.getPackageRecommendation)({page:1,page_size:100}).then(function(e){var i=e.web_data,s=i.products,o=i.page_resource;t.recommendations=s;var a=o.link,n=a.detail,l=a.home;t.detailUrl=n,t.indexUrl=l})},data:function(){var t=this;return{indexUrl:"",detailUrl:"",orderUrl:"",reserveUrl:"",productInfo:{},hotelInfo:{},fansInfo:{},publicInfo:{},salerBanner:[],settingId:"-1",productGalleryIndex:1,productGalleryIsDefault:!1,bannerSwiperOptions:{autoplay:3e3,lazyLoading:!0,lazyLoadingInPrevNext:!0,lazyPreloaderClass:"jfk-image__lazy--preload",onSlideChangeEnd:function(e){t.productGalleryIndex=e.activeIndex+1}},recommendations:[],specTicketVisible:!1,serviceVisible:!1,killsecQrcodeVisible:!1,killsecQrcodeUrl:"",killsecQrcodeTip:"",killsecButtonDisabled:!0,killsecSubScribeStatus:!1,killsecStatus:0,showKillsecModule:!1,qrcodeVisible:!1,tag:-1,buttonText:"立即购买",priceTag:"",shouldTriggerSubmit:!1,tokenId:"",serviceListMaxHeight:0,currentLabel:""}},watch:{tag:function(t){this.buttonText=2===t?"立即秒杀":6===t?"储值购买":"立即购买",t=!t||t>7?"0":t,this.priceTag='<i class="mask color-golden"></i><i class="text">'+h[t]+"</i>",2!==t?this.killsecButtonDisabled=!1:(this.showKillsecModule=!0,this.killsecSubScribeStatus=this.productInfo.killsec.is_subscribe)},tokenId:function(t){t&&this.submitOrder(1)},killsecStatus:function(t){1===t?this.killsecSubScribeStatus?this.buttonText="已订阅":this.buttonText="订阅提醒":2===t?this.buttonText="即将开始":3===t?this.buttonText="立即秒杀":4===t?this.tag=0:5===t&&(this.showKillsecModule=!1,this.buttonText="已售罄")}},computed:{pricePackage:function(){return(0,u.default)(this.productInfo,!1,!0)},priceMarket:function(){return(0,u.default)(this.productInfo,!0,!0)},serviceItems:function(){var t=this,e=["can_refund_3","can_mail","can_gift","can_pickup","can_invoice","can_refund"],i=[];return e.forEach(function(e,s){("can_refund_3"===e&&"3"===t.productInfo.can_refund||"1"===t.productInfo[e])&&i.push(d.default[e])}),i.length&&(this.serviceListMaxHeight=this.maxHeight-141+"px"),i},buttonDisabled:function(){var t=this.productInfo,e=this.killsecButtonDisabled;return!(2!==t.tag||!e)},productDetail:function(){var t=this.productInfo.compose,e="";if(t)for(var i in t)t[i].content&&(e+='<li class="item tr font-color-extra-light-gray">'+t[i].content+'<i class="right">'+t[i].num+"</i></li>");return e},productDetailInfo:function(){var t=this.productInfo,e="",i=[];return t.img_detail&&(i.push({label:"图文详情",key:"graphic"}),e+='<div class="graphic productinfo-detail-item jfk-pl-30 jfk-pr-30"><div class="title font-color-white font-size--32"><span>图文详情</span></div><div class="cont"  id="graphic">'+t.img_detail+"</div></div>"),t.order_notice&&(i.push({label:"订购须知",key:"notice"}),e+='<div class="notice productinfo-detail-item jfk-pl-30 jfk-pr-30"><div class="title font-color-white font-size--32"><span>订购须知</span></div><div id="notice" class="cont">'+t.order_notice+"</div></div>"),this.productDetail&&(i.push({label:"商品内容",key:"detail"}),e+='<div class="detail productinfo-detail-item jfk-pl-30 jfk-pr-30 font-size--28"><div class="title font-color-white font-size--32"><span>商品内容</span></div><ul class="cont" id="detail"><li class="item thead font-color-light-gray-common">商品名称<i class="right">数量</i></li>'+this.productDetail+"</ul></div>"),i.length&&(this.currentLabel=i[0].key),{labels:i,html:e}}},methods:{noticeSuccess:function(){this.$jfkToast({message:"已订阅，请耐心等待活动开始！",iconType:"success",duration:2e3})},showIllegalToast:function(){this.$jfkToast({message:"该商品暂不能购买",iconType:"error"})},handleKillsecStatus:function(t){this.killsecStatus=t},submitOrder:function(t){var e=this.reserveUrl;"-1"!==this.settingId&&(e+="&psp_id="+this.settingId),1===t?e+="&token="+this.tokenId+"&act_id="+this.productInfo.killsec.act_id+"&inid="+this.productInfo.killsec.instance.instance_id:2===t&&(e+="&common=1"),location.href=e},handleSpecTicket:function(){if(2===this.productInfo.tag&&this.showKillsecModule)return this.showIllegalToast();this.shouldTriggerSubmit=!0,this.specTicketVisible=!0},handleService:function(){this.serviceVisible=!0},handleQrcode:function(){this.qrcodeVisible=!0},handleShare:function(){this.$jfkShare()},handleLabel:function(t){this.currentLabel=t;var e=Math.max(document.documentElement.scrollTop,document.body.scrollTop)||0,i=document.getElementById(t).getBoundingClientRect().top;document.body.scrollTop=e+i-66},handleSubmitOrder:function(){var t=this.productInfo.tag,e=this.killsecStatus,i=this.killsecSubScribeStatus,s=this;if(2===t){if(1===e){if(i)return void this.noticeSuccess();var o=this.$jfkToast({message:"正在设置提醒，请稍候",duration:-1});return void(0,c.postKillsecNotice)({act_id:this.productInfo.killsec.act_id}).then(function(t){o.close(),t.web_data.data?(s.killsecQrcodeUrl=t.web_data.data,s.killsecQrcodeTip=t.msg,s.killsecQrcodeVisible=!0):s.noticeSuccess(),s.killsecSubScribeStatus=!0,s.buttonText="已订阅"}).catch(function(t){o.close(),1001===t.status&&(s.killsecSubScribeStatus=!0,s.buttonText="已订阅")})}if(2===e)return void this.$jfkToast({message:"活动还未开始，请耐心等候",iconType:"error"});if(3===e)return void(0,c.getKillsecRob)({act_id:this.productInfo.killsec.act_id,inid:this.productInfo.killsec.instance.instance_id}).then(function(t){var e=t.web_data,i=e.status,o=e.token;1===i?s.tokenId=o:s.$jfkToast({message:"活动太火被挤爆了，刷新页面重新试一下吧",iconType:"error"})});4===e?this.submitOrder():5===e&&(s.killsecButtonDisabled=!0)}else this.productInfo.spec_product?"-1"!==this.settingId?this.submitOrder(4===this.killsecStatus?2:void 0):(this.shouldTriggerSubmit=!0,this.specTicketVisible=!0):this.submitOrder()},handleSubmitOrderOriginal:function(){this.productInfo.spec_product?"-1"!==this.settingId?this.submitOrder(2):(this.shouldTriggerSubmit=!0,this.specTicketVisible=!0):this.submitOrder(2)},getSettingId:function(t){this.settingId=t,"-1"!==t&&this.shouldTriggerSubmit&&this.submitOrder(),this.shouldTriggerSubmit=!1},handleShowMap:function(){this.hotelInfo.latitude&&this.hotelInfo.longitude&&(0,p.openLocation)(this.hotelInfo)}}}},469:function(t,e,i){"use strict";var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-pages jfk-pages__detail"},[i("div",{staticClass:"jfk-pages__theme"}),t._v(" "),t.productInfo.product_id?i("div",[t.salerBanner.length?i("div",{staticClass:"hotel-staff jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"cont font-color-light-gray-common font-size--24"},[i("span",{staticClass:"jfk-font notice-icon font-size--24 icon-mall_icon_notice"}),t._v(" "),i("span",{staticClass:"jfk-font notice-icon-1 font-size--24 icon-mall_icon_1_notice"}),t._v(t._s(t.salerBanner[0])+"\n        "),t.salerBanner[1]?i("span",{staticClass:"number jfk-font-number font-size--48 color-golden-price"},[t._v(t._s(t.salerBanner[1]))]):t._e(),t._v(" "),t.salerBanner[2]?i("span",{staticClass:"unit color-golden-price"},[t._v(t._s(t.salerBanner[2]))]):t._e(),t._v(t._s(t.salerBanner[3]))])]):t._e(),t._v(" "),i("div",{staticClass:"detail-top",class:{"is-default":t.productGalleryIsDefault}},[i("div",{staticClass:"banners"},[i("swiper",{staticClass:"jfk-swiper",attrs:{options:t.bannerSwiperOptions}},t._l(t.productInfo.gallery,function(e,s){return i("swiper-slide",{key:e.gry_id,staticClass:"jfk-swiper__item",class:{"swiper-no-swiping":1===t.productInfo.gallery.length}},[i("div",{staticClass:"banners__item-box jfk-swiper__item-box"},[e.gry_url?i("div",{staticClass:"banners__item jfk-swiper__item-bg swiper-lazy",attrs:{"data-background":e.gry_url}},[i("div",{staticClass:"jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"})]):i("div",{staticClass:"banners__item jfk-swiper__item-bg"},[i("div",{staticClass:"jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"})])])])})),t._v(" "),i("div",{staticClass:"swiper-pagination font-size--24 swiper-pagination-fraction"},[i("span",{staticClass:"swiper-pagination-current"},[t._v(t._s(t.productGalleryIndex))]),t._v(" / "),i("span",{staticClass:"swiper-pagination-total"},[t._v(t._s(t.productInfo.gallery.length))])])],1),t._v(" "),i("div",{staticClass:"icons"},[t.hotelInfo.qrcode?i("i",{staticClass:"jfk-font font-size--36 icon-mall_icon_pay_focus",on:{click:t.handleQrcode}}):t._e(),t._v(" "),i("i",{staticClass:"jfk-font font-size--36 icon-mall_icon_pay_share",on:{click:t.handleShare}})]),t._v(" "),i("div",{staticClass:"info"},[i("div",{staticClass:"name font-size--38 font-color-white"},[i("span",{staticClass:"price-tag font-size--24",domProps:{innerHTML:t._s(t.priceTag)}}),t._v(t._s(t.productInfo.name)+"\n        ")]),t._v(" "),i("div",{staticClass:"sales font-color-light-gray-common font-size--24"},[t.publicInfo.name?i("span",{staticClass:"suppier"},[t._v(t._s(t.publicInfo.name)+"提供")]):t._e(),t._v(" "),"1"===t.productInfo.show_sales_cnt?i("span",{staticClass:"sales_num"},[t._v("已售\n            "),i("i",{staticClass:"number"},[t._v(t._s(t.productInfo.sales_cnt))])]):t._e()]),t._v(" "),i("div",{staticClass:"others jfk-clearfix"},[i("div",{staticClass:"prices jfk-fl-l"},[t._m(0),t._v(" "),t._m(1)]),t._v(" "),t.productInfo.spec_product?i("div",{staticClass:"date-norm jfk-fl-r font-color-extra-light-gray font-size--24",on:{click:t.handleSpecTicket}},[t._v("\n            选择"+t._s(t.productInfo.isTicket?"日期":"规格")+"\n            "),i("i",{staticClass:"jfk-font icon-home_icon_Jump_norma color-golden triangle"})]):t._e()])])]),t._v(" "),2===t.productInfo.tag&&t.showKillsecModule?i("product-killsec",{attrs:{killsec:t.productInfo.killsec},on:{"killsec-status":t.handleKillsecStatus}}):t._e(),t._v(" "),t.serviceItems.length?t._m(3):t._e(),t._v(" "),i("div",{staticClass:"detail-box"},[2===t.productInfo.tag?i("div",{staticClass:"killsec-original jfk-ml-30 jfk-mr-30"},[i("div",{staticClass:"killsec-original__cont jfk-flex is-align-middle is-justify-space-between",on:{click:t.handleSubmitOrderOriginal}},[i("span",{staticClass:"font-size--30 font-color-extra-light-gray"},[t._v("原价去购买")]),t._v(" "),i("span",{staticClass:"font-size--28 color-golden"},[i("i",[t._v(t._s(t.priceMarket))]),t._v(" "),i("i",{staticClass:"jfk-font triangle font-size--24 font-color-extra-light-gray icon-user_icon_jump_normal"})])])]):t._e(),t._v(" "),t.productDetailInfo.labels.length?i("div",{ref:"productInfoDetail",staticClass:"productinfo-detail"},[i("jfk-sticky",[i("div",{staticClass:"productinfo-detail-box jfk-pl-30 jfk-pr-30",class:{"great-then-2":t.productDetailInfo.labels.length>1}},[i("ul",{staticClass:"productinfo-detail-label",class:"productinfo-detail-label--"+t.productDetailInfo.labels.length},t._l(t.productDetailInfo.labels,function(e){return i("li",{key:e.key,staticClass:"font-size-32 label",class:{"color-golden is-selected":t.currentLabel===e.key,"font-color-light-gray-common":t.currentLabel!==e.key},on:{click:function(i){t.handleLabel(e.key)}}},[i("div",[t._v(t._s(e.label))])])}))])]),t._v(" "),i("div",{staticClass:"productinfo-detail-cont",domProps:{innerHTML:t._s(t.productDetailInfo.html)}})],1):t._e()])],1):t._e(),t._v(" "),t.hotelInfo.address?i("div",{staticClass:"hotel jfk-ml-30"},[i("div",{staticClass:"box"},[i("div",{staticClass:"cont",on:{click:t.handleShowMap}},[i("i",{staticClass:"jfk-font font-size--40 font-color-extra-light-gray icon-icon_location"}),t._v(" "),i("div",{staticClass:"name font-size--30 font-color-white"},[t._v(t._s(t.hotelInfo.name))]),t._v(" "),i("div",{staticClass:"address font-size--28 font-color-extra-light-gray"},[i("span",[i("i",[t._v(t._s(t.hotelInfo.address))])]),i("i",{directives:[{name:"show",rawName:"v-show",value:t.hotelInfo.latitude&&t.hotelInfo.longitude,expression:"hotelInfo.latitude && hotelInfo.longitude"}],staticClass:"jfk-font icon-user_icon_jump_normal"})])]),t._v(" "),i("div",{staticClass:"order"},[i("a",{staticClass:"jfk-button jfk-button--free font-size--30 jfk-button--primary is-plain",attrs:{href:t.orderUrl}},[t._v("我的订单")])]),t._v(" "),i("div",{staticClass:"qrcode color-golden-price jfk-flex is-align-middle",on:{click:t.handleQrcode}},[t._m(4)])])]):t._e(),t._v(" "),t.recommendations.length?i("div",{staticClass:"recommendation jfk-pl-30",class:{"jfk-pr-30":1===t.recommendations.length}},[i("p",{staticClass:"font-size--24 font-color-light-gray-common tip"},[t._v("其他用户还看了")]),t._v(" "),i("div",{staticClass:"recommendations-list"},[i("jfk-recommendation",{attrs:{items:t.recommendations,linkPrefix:t.detailUrl,emptyLink:t.indexUrl}})],1)]):t._e(),t._v(" "),t._m(5),t._v(" "),i("footer",{staticClass:"footer jfk-footer jfk-clearfix"},[i("div",{staticClass:"links jfk-fl-l"},[i("div",{staticClass:"jfk-flex is-justify--center is-align-middle"},[i("a",{staticClass:"link font-color-white",attrs:{href:t.indexUrl}},[i("i",{staticClass:"jfk-font font-size--30 icon-mall_icon_home"}),t._v(" "),i("div",{staticClass:"text font-size--20"},[t._v("首页")])]),t._v(" "),i("a",{staticClass:"link font-color-white",attrs:{href:t.orderUrl}},[i("i",{staticClass:"jfk-font font-size--30 icon-user_icon_Onlineboo"}),t._v(" "),i("div",{staticClass:"text font-size--20"},[t._v("订单")])])])]),t._v(" "),i("div",{staticClass:"control jfk-fl-l"},[i("button",{staticClass:"jfk-button font-size--34 jfk-button--higher jfk-button--suspension jfk-button--free",attrs:{href:"javascript:;"},on:{click:t.handleSubmitOrder}},[t._v(t._s(t.buttonText))])])]),t._v(" "),t.productInfo.spec_product?[t.productInfo.isTicket?i("product-ticket",{attrs:{productId:t.productInfo.product_id,"is-integral":7===t.productInfo.tag,price:t.productInfo.price_package,visible:t.specTicketVisible},on:{"submit-setting-id":t.getSettingId,"update:visible":function(e){t.specTicketVisible=e}}}):i("product-spec",{attrs:{productId:t.productInfo.product_id,"is-integral":7===t.productInfo.tag,price:t.productInfo.price_package,visible:t.specTicketVisible},on:{"submit-setting-id":t.getSettingId,"update:visible":function(e){t.specTicketVisible=e}}})]:t._e(),t._v(" "),t.serviceItems.length?[i("jfk-popup",{ref:"popupService",staticClass:"jfk-popup__service",attrs:{showCloseButton:!0},model:{value:t.serviceVisible,callback:function(e){t.serviceVisible=e},expression:"serviceVisible"}},[i("div",{staticClass:"popup-box"},[i("div",{staticClass:"title font-size--40 font-color-white"},[t._v("服务说明")]),t._v(" "),i("ul",{staticClass:"popup-service font-size--28",style:{"max-height":t.serviceListMaxHeight}},t._l(t.serviceItems,function(e){return i("li",{key:e.key,staticClass:"popup-service-item"},[i("i",{staticClass:"jfk-font icon",class:e.icon}),t._v(" "),i("p",{staticClass:"label"},[t._v(t._s(e.label))]),t._v(" "),i("p",{staticClass:"desc"},[t._v(t._s(e.desc))])])}))])])]:t._e(),t._v(" "),t.hotelInfo.qrcode?i("jfk-popup",{staticClass:"jfk-popup__qrcode jfk-ta-c",attrs:{showCloseButton:!0,closeOnClickModal:!1},model:{value:t.qrcodeVisible,callback:function(e){t.qrcodeVisible=e},expression:"qrcodeVisible"}},[i("div",{staticClass:"qrcode"},[i("img",{attrs:{src:t.hotelInfo.qrcode}})]),t._v(" "),t.fansInfo.is_fans?[i("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[t._v("你还未关注公众号")]),t._v(" "),i("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[t._v("先长按识别关注公众号吧！")])]:[i("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[t._v("长按识别关注公众号")]),t._v(" "),i("div",{staticClass:"tip font-size--28 font-color-extra-light-gray"},[i("span",[t._v("享受")]),t._v(" "),i("span",{staticClass:"color-golden font-size--36"},[t._v("更多优惠")])])]],2):t._e(),t._v(" "),i("jfk-popup",{staticClass:"jfk-popup__qrcode jfk-ta-c",attrs:{showCloseButton:!0,closeOnClickModal:!1},model:{value:t.killsecQrcodeVisible,callback:function(e){t.killsecQrcodeVisible=e},expression:"killsecQrcodeVisible"}},[i("div",{staticClass:"qrcode"},[i("img",{attrs:{src:t.killsecQrcodeUrl}})]),t._v(" "),i("div",{staticClass:"tip font-size--28 font-color-extra-light-gray jfk-pl-30 jfk-pr-30"},[t._v(t._s(t.killsecQrcodeTip))])])],2)},o=[function(){var t=this,e=t.$createElement;return(t._self._c||e)("span",{staticClass:"jfk-price product-price-package color-golden-price font-size--68",domProps:{innerHTML:t._s(t.pricePackage)}})},function(){var t=this,e=t.$createElement;return(t._self._c||e)("span",{staticClass:"jfk-price__original product-price-market font-size--24 font-color-light-gray",domProps:{innerHTML:t._s(t.priceMarket)}})},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("p",{staticClass:"icon font-color-extra-light-gray"},[i("i")])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"service jfk-pl-30 jfk-pr-30"},[i("ul",{staticClass:"service-list font-size--24",class:"service-list--"+(t.serviceItems.length<5?"single":"multiple"),on:{click:t.handleService}},[t._l(t.serviceItems,function(e){return i("li",{key:e.key,staticClass:"service-item"},[i("p",{staticClass:"icon"},[i("i",{staticClass:"jfk-font font-color-light-gray-common",class:e.icon})]),t._v(" "),i("p",{staticClass:"label font-color-extra-light-gray"},[t._v(t._s(e.label))])])}),t._v(" "),t.serviceItems.length>4?i("li",{staticClass:"more jfk-flex is-align-middle"},[t._m(2)]):t._e()],2)])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[i("i",{staticClass:"jfk-font icon-mall_icon_pay_focus"}),t._v(" "),i("p",{staticClass:"font-size--18"},[t._v("关注享优惠")])])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("JfkSupport")}],a={render:s,staticRenderFns:o};e.a=a}});