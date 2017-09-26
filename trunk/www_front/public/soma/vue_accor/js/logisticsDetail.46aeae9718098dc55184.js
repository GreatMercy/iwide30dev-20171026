webpackJsonp([21],{146:function(t,s,i){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(s,"__esModule",{value:!0});var e=i(8),o=a(e),n=i(416),c=a(n);s.default=function(){new o.default({el:"#app",template:"<App/>",components:{App:c.default}})}},358:function(t,s,i){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var a=i(26),e=i(27),o=e.default(location.href);s.default={components:{},computed:{},beforeCreate:function(){this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),this.$pageNamespace(o)},created:function(){var t=this;(0,a.getExpressDetail)({spid:o.spid||""}).then(function(s){var i=s.web_data;t.product=i.product,t.userInfo=i.contact,t.logistic=i.shipping_track,t.status=parseInt(i.status);var a=t.logistic.length;if(t.logistic.length>0){for(var e=0;e<t.logistic.length;e++)t.logistic[e].class_name="default",t.logistic[e].status=!1;5===t.status?(t.logistic[0].status=!0,t.logistic[0].class_name="end",t.logistic[a-1].class_name="start"):(t.logistic[0].status=!0,t.logistic[0].class_name="finish",t.logistic[a-1].class_name="start")}t.toast.close()}).catch(function(){t.toast.close()})},watch:{},data:function(){return{product:{},userInfo:{},logistic:[],status:""}}}},416:function(t,s,i){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var a=i(358),e=i.n(a),o=i(440),n=i(25),c=n(e.a,o.a,null,null,null);s.default=c.exports},440:function(t,s,i){"use strict";var a=function(){var t=this,s=t.$createElement,i=t._self._c||s;return i("div",{staticClass:"jfk-pages jfk-pages__logistics-detail"},[i("div",{staticClass:"jfk-pages__theme"}),t._v(" "),i("div",{staticClass:"logistics-detail-state color-golden"},[t.status&&1===t.status?i("span",{staticClass:"jfk-button__text color-golden font-size--60"},[i("i",{staticClass:"jfk-font icon-font_zh_yi_qkbys"}),t._v(" "),i("i",{staticClass:"jfk-font icon-font_zh_jie_qkbys"}),t._v(" "),i("i",{staticClass:"jfk-font icon-font_zh_dan_qkbys"})]):t._e(),t._v(" "),t.status&&2===t.status?i("span",{staticClass:"jfk-button__text color-golden font-size--60"},[i("i",{staticClass:"jfk-font icon-font_zh_yi_qkbys"}),t._v(" "),i("i",{staticClass:"jfk-font icon-font_zh_fa_qkbys"}),t._v(" "),i("i",{staticClass:"jfk-font icon-font_zh_huo_qkbys"})]):t._e(),t._v(" "),t.status&&5===t.status?i("span",{staticClass:"jfk-button__text color-golden font-size--60"},[i("i",{staticClass:"jfk-font icon-font_zh_yi_qkbys"}),t._v(" "),i("i",{staticClass:"jfk-font icon-font_zh_shou_qkbys"}),t._v(" "),i("i",{staticClass:"jfk-font icon-font_zh_huo_qkbys"})]):t._e()]),t._v(" "),i("div",{staticClass:"logistics-detail-info jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"logistics-detail-info__card"},[i("div",{staticClass:"logistics-detail-info__product"},[i("div",{directives:[{name:"lazy",rawName:"v-lazy:background-image",value:t.product.face_img,expression:"product.face_img",arg:"background-image"}],staticClass:"logistics-detail-info__product--img jfk-image__lazy--3-3 jfk-image__lazy--background-image"}),t._v(" "),i("div",{staticClass:"logistics-detail-info__product--content"},[t.product.name?i("p",{staticClass:"font-size--34 name",domProps:{textContent:t._s(t.product.name)}}):t._e(),t._v(" "),i("p",{staticClass:"price jfk-flex is-align-middle"},[t.product.price_package?i("span",{staticClass:"jfk-price font-size--50 color-golden-price"},[i("i",{staticClass:"jfk-font-number jfk-price__currency"},[t._v("￥")]),t._v(" "),i("i",{staticClass:"jfk-font-number jfk-price__number",domProps:{textContent:t._s(t.product.price_package)}})]):t._e(),t._v(" "),t.product.qty?i("span",{staticClass:"font-color-light-gray font-size--24 number",domProps:{textContent:t._s(t.product.qty+"份")}}):t._e()])])]),t._v(" "),i("div",{staticClass:"logistics-detail-info__user"},[i("p",{staticClass:"jfk-flex logistics-detail-info__user--name font-size--24"},[t._m(0),t._v(" "),i("i",{staticClass:"font-size--28"},[t.userInfo.contact?i("small",{staticClass:"font-size--28",domProps:{textContent:t._s(t.userInfo.contact)}}):t._e(),t._v(" "),t.userInfo.phone?i("span",{domProps:{textContent:t._s(t.userInfo.phone)}}):t._e()])]),t._v(" "),i("p",{staticClass:"jfk-flex font-size--24"},[i("span",{staticClass:"title"},[t._v("收件地址")]),t._v(" "),i("i",{staticClass:"font-size--28",domProps:{textContent:t._s(t.userInfo.address)}})])])])]),t._v(" "),i("div",{staticClass:"logistics-status jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"logistics-status__title font-size--24"},[t._v("物流信息")]),t._v(" "),0===t.logistic.length?i("div",{staticClass:"font-size--30 logistics-status__no-info"},[t._v("暂无物流信息")]):i("div",{staticClass:"logistics-status__step"},t._l(t.logistic,function(s,a){return i("div",{key:a,staticClass:"logistics-status__item"},[i("div",{staticClass:"logistics-status__item--logo"},[i("span",{staticClass:"font-size--30 logistics-status__item--line",class:"logistics-status__item--"+s.class_name},[i("i",{staticClass:"color-golden"},["end"===s.class_name?i("span",{staticClass:"jfk-font icon-radio_icon_selected_default"}):t._e()])])]),t._v(" "),i("div",{staticClass:"logistics-status__item--text",class:{"is-active":s.status}},[i("p",{staticClass:"font-size--30",domProps:{textContent:t._s(s.remark)}}),t._v(" "),i("p",{staticClass:"font-size--24",domProps:{textContent:t._s(s.datetime)}})])])}))]),t._v(" "),t._m(1)],1)},e=[function(){var t=this,s=t.$createElement,i=t._self._c||s;return i("span",{staticClass:"title"},[t._v("收"),i("small",{staticClass:"font-size--24"},[t._v("件")]),t._v("人")])},function(){var t=this,s=t.$createElement;return(t._self._c||s)("jfk-support")}],o={render:a,staticRenderFns:e};s.a=o}});