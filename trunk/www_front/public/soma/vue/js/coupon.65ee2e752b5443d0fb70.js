webpackJsonp([17],{138:function(t,e,o){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var n=o(52),a=s(n),i=o(251),c=s(i);e.default=function(){new a.default({el:"#app",template:"<App/>",components:{App:c.default}})}},201:function(t,e,o){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=o(28),n=o(53),a=n.default(location.href);e.default={components:{},computed:{size:function(){return{width:window.innerWidth*(382/750)+"px",height:window.innerWidth*(382/750)+"px"}}},created:function(){var t=this;this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,s.getOrderPackageUsage)({aiid:a.aiid||"",code_id:a.code_id||""}).then(function(e){t.product=e.web_data.product,t.code=e.web_data.code.code,t.qrcode=e.web_data.code.qrcode_url,t.toast.close()}).catch(function(){t.toast.close()})},data:function(){return{product:{},code:"",qrcode:!1,message:"此张套票使用后，您的订单将不能退款"}}}},251:function(t,e,o){var s=o(27)(o(201),o(305),null,null);t.exports=s.exports},305:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"jfk-pages jfk-pages__coupon"},[o("div",{staticClass:"jfk-pages__theme"}),t._v(" "),o("jfk-notification",{staticClass:"font-size--24",attrs:{message:t.message}}),t._v(" "),o("div",{staticClass:"coupon-base-info jfk-pl-30 jfk-pr-30 is-align-middle"},[o("div",{staticClass:"coupon-base-info__name font-size--38 is-align-middle jfk-flex"},[o("div",{staticClass:"coupon-base-info__shadow"}),t._v(" "),o("span",{domProps:{textContent:t._s(t.product.name)}})]),t._v(" "),o("div",{staticClass:"coupon-base-info__hotel font-size--24",domProps:{textContent:t._s(t.product.hotel_name)}}),t._v(" "),o("ul",{staticClass:"coupon-base-info__service font-size--24"},t._l(t.product.compose,function(e,s){return e.content&&e.num&&"0"!==e.num&&0!==e.num?o("li",[o("i",{domProps:{textContent:t._s(e.content)}}),o("span",{domProps:{textContent:t._s(e.num)}})]):t._e()}))]),t._v(" "),o("div",{staticClass:"coupon-way jfk-pr-30 jfk-pl-30"},[t._m(0),t._v(" "),o("div",{staticClass:"coupon-way__qrcode"},[o("p",{staticClass:"font-size--28 coupon-way__name"},[t._v("方式一：向商家出示券码／二维码")]),t._v(" "),o("p",{staticClass:"font-size--34 coupon-way__code jfk-ta-c"},[o("jfk-text-split",{attrs:{text:t.code,split:3}})],1),t._v(" "),o("div",{staticClass:"coupon-way__img jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image",style:t.size},[t.qrcode?o("img",{attrs:{src:t.qrcode}}):t._e()])])]),t._v(" "),t._m(1)],1)},staticRenderFns:[function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"coupon-way__title font-size--24"},[o("i",[t._v("使用方式")])])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("jfk-support")}]}}});