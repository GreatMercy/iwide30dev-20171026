webpackJsonp([11],{145:function(t,e,s){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=s(8),n=i(a),o=s(408),f=i(o);e.default=function(){new n.default({el:"#app",template:"<App/>",components:{App:f.default}})}},181:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{wish:{type:String,default:""}}}},182:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=s(181),a=s.n(i),n=s(183),o=s(26),f=o(a.a,n.a,null,null,null);e.default=f.exports},183:function(t,e,s){"use strict";var i=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"gift-theme"},[s("div",{staticClass:"gift-theme-bg"}),t._v(" "),s("div",{staticClass:"gift-theme-logo"}),t._v(" "),s("div",{staticClass:"gift-theme-wish jfk-ta-c jfk-pl-30 jfk-pr-30"},[s("div",{staticClass:"gift-theme-wish__content",domProps:{innerHTML:t._s(t.wish)}})])])},a=[],n={render:i,staticRenderFns:a};e.a=n},352:function(t,e,s){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=s(53),n=i(a),o=s(27),f=s(409),l=i(f),c=s(28),r=c.default(location.href);e.default={name:"gift",components:{giftDetail:l.default},data:function(){return{name:"",goodsDetail:{},theme:"",boxShow:!0,detailShow:!0}},created:function(){var t=this,e={gid:r.gid||"",sign:r.sign||""};this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,o.getPresentsValidateGiftOrder)(e).then(function(e){var s=e.web_data;t.name=s.fans.nickname,t.goodsDetail=s.item,t.goodsDetail.used=parseInt(s.item.qty_origin)-parseInt(s.item.qty),t.goodsDetail.wish=s.message,t.goodsDetail.link=s.order_list_url,t.theme="gift-theme_"+s.theme_keyword,t.goodsDetail.goods_link=e.web_data.redirect_url||"",t.boxShow=1===parseInt(s.received)?0:1,t.toast.close()}).catch(function(){t.toast.close()})},methods:{openGift:function(){var t=this,e={gid:r.gid||"",sign:r.sign||"",bsn:r.bsn||""};this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,o.postPresentsReceiveProcess)(e,{REJECTERRORCONFIG:{serveError:!0}}).then(function(e){t.boxShow=!1,t.toast.close(),2===parseInt(e.web_data.subscribe)&&(0,n.default)({title:"提示",message:"您还没关注公众号，可能会影响礼品使用，先关注"+e.web_data.public_name,showConfirmButton:!0,showCancelButton:!0,confirmButtonText:"立即关注",cancelButtonText:"现在使用"}).then(function(){t.$jfkShare()})}).catch(function(e){t.toast.close(),t.boxShow=!1,t.$jfkAlert(e.msg).then(function(){t.boxShow=!0})})}}}},353:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=s(182),a=function(t){return t&&t.__esModule?t:{default:t}}(i);e.default={name:"giftDetail",props:{theme:{type:String,default:""},info:{type:Object}},methods:{link:function(t){t&&(window.location.href=t)}},components:{giftBg:a.default}}},408:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=s(352),a=s.n(i),n=s(461),o=s(26),f=o(a.a,n.a,null,null,null);e.default=f.exports},409:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=s(353),a=s.n(i),n=s(458),o=s(26),f=o(a.a,n.a,null,null,null);e.default=f.exports},458:function(t,e,s){"use strict";var i=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"jfk-pages jfk-pages__gift-detail jfk-ta-c",class:t.theme},[s("div",{staticClass:"gift-container"},[s("giftBg",{attrs:{wish:t.info.wish}}),t._v(" "),s("p",{staticClass:"gift-goods-img jfk-ta-c jfk-pl-30 jfk-pr-30"},[t.info.face_img?s("img",{attrs:{src:t.info.face_img}}):t._e()]),t._v(" "),s("p",{staticClass:"gift-goods-name jfk-ta-c font-size--30 jfk-pl-30 jfk-pr-30",domProps:{innerHTML:t._s(t.info.name)}}),t._v(" "),s("p",{staticClass:"gift-goods-number jfk-ta-c font-size--24 jfk-pl-30 jfk-pr-30",domProps:{innerHTML:t._s("已使用"+t.info.used+"/"+t.info.qty_origin+"份")}}),t._v(" "),s("p",{staticClass:"gift-goods-btn"},[s("button",{staticClass:"jfk-button jfk-button--primary  jfk-button--free",on:{click:function(e){t.link(t.info.goods_link)}}},[t._m(0)])]),t._v(" "),s("div",{staticClass:"gift-detail-bottom"},[s("div",{staticClass:"gift-detail-line"}),t._v(" "),s("a",{staticClass:"jfk-ta-c gift-detail-put-order",attrs:{href:t.info.link||"javascript:void(0)"}},[s("i",{staticClass:"font-size--28"},[t._v("暂不使用，放至订单中心")]),t._v(" "),s("span",{staticClass:"jfk-d-ib jfk-font icon-user_icon_jump_normal"})])])],1)])},a=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("span",{staticClass:"jfk-button__text font-size--34"},[s("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_li_qkbys"}),t._v(" "),s("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_ji_qkbys"}),t._v(" "),s("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_cha_qkbys"}),t._v(" "),s("i",{staticClass:"jfk-font jfk-button__text-item icon-font_zh_kan_qkbys"})])}],n={render:i,staticRenderFns:a};e.a=n},461:function(t,e,s){"use strict";var i=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"jfk-pages"},[t.theme?t._e():s("div",{staticClass:"jfk-pages__theme"},[s("div",{staticClass:"jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"})]),t._v(" "),t.theme?s("div",{directives:[{name:"show",rawName:"v-show",value:t.boxShow,expression:"boxShow"}],staticClass:"jfk-pages__gift"},[s("div",{staticClass:"gift-box"},[s("div",{staticClass:"gift-box-envelope"},[s("div",{staticClass:"gift-box-wish jfk-ta-c font-size--36",domProps:{innerHTML:t._s(t.name+"送你一份礼物")}}),t._v(" "),s("div",{staticClass:"gift-box-content"}),t._v(" "),s("div",{staticClass:"gift-box-bg"}),t._v(" "),s("div",{staticClass:"gift-box-btn jfk-ta-c font-size--34",on:{click:t.openGift}},[t._v("打开礼盒")])])])]):t._e(),t._v(" "),t.theme?s("gift-detail",{directives:[{name:"show",rawName:"v-show",value:t.detailShow,expression:"detailShow"}],attrs:{info:t.goodsDetail,theme:t.theme}}):t._e()],1)},a=[],n={render:i,staticRenderFns:a};e.a=n}});