webpackJsonp([23],{142:function(t,e,s){"use strict";function o(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=s(8),n=o(a),i=s(403),c=o(i);e.default=function(){new n.default({el:"#app",template:"<App/>",components:{App:c.default}})}},346:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=s(26),a=s(27),n=a.default(location.href);e.default={components:{},computed:{size:function(){return{width:window.innerWidth*(382/750)+"px",height:window.innerWidth*(382/750)+"px"}}},created:function(){var t=this;this.$pageNamespace(n),this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,o.getOrderPackageUsage)({aiid:n.aiid||"",code_id:n.code_id||""}).then(function(e){t.product=e.web_data.product,t.code=e.web_data.code.code,t.qrcode=e.web_data.code.qrcode_url,t.toast.close()}).catch(function(){t.toast.close()})},data:function(){return{product:{},code:"",qrcode:!1,message:"此张套票使用后，您的订单将不能退款"}}}},403:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=s(346),a=s.n(o),n=s(471),i=s(25),c=i(a.a,n.a,null,null,null);e.default=c.exports},471:function(t,e,s){"use strict";var o=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"jfk-pages jfk-pages__coupon"},[s("div",{staticClass:"jfk-pages__theme"}),t._v(" "),s("jfk-notification",{staticClass:"font-size--24",attrs:{message:t.message}}),t._v(" "),s("div",{staticClass:"coupon-base-info jfk-pl-30 jfk-pr-30 is-align-middle"},[s("div",{staticClass:"coupon-base-info__name font-size--38 is-align-middle jfk-flex"},[s("div",{staticClass:"coupon-base-info__shadow color-golden"}),t._v(" "),s("span",{domProps:{textContent:t._s(t.product.name)}})]),t._v(" "),s("div",{staticClass:"coupon-base-info__hotel font-size--24",domProps:{textContent:t._s(t.product.hotel_name)}}),t._v(" "),s("ul",{staticClass:"coupon-base-info__service font-size--24"},t._l(t.product.compose,function(e,o){return e.content&&e.num&&"0"!==e.num&&0!==e.num?s("li",[s("i",{domProps:{textContent:t._s(e.content)}}),s("span",{domProps:{textContent:t._s(e.num)}})]):t._e()}))]),t._v(" "),s("div",{staticClass:"coupon-way jfk-pr-30 jfk-pl-30"},[t._m(0),t._v(" "),s("div",{staticClass:"coupon-way__qrcode"},[s("p",{staticClass:"font-size--28 coupon-way__name"},[t._v("方式一：向商家出示券码／二维码")]),t._v(" "),s("p",{staticClass:"font-size--34 coupon-way__code jfk-ta-c"},[s("jfk-text-split",{attrs:{text:t.code,split:4}})],1),t._v(" "),s("div",{staticClass:"coupon-way__img jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image",style:t.size},[t.qrcode?s("img",{attrs:{src:t.qrcode}}):t._e()])])]),t._v(" "),t._m(1)],1)},a=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"coupon-way__title font-size--24"},[s("i",[t._v("使用方式")])])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("jfk-support")}],n={render:o,staticRenderFns:a};e.a=n}});