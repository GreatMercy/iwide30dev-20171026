webpackJsonp([11],{142:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var s=i(8),a=n(s),o=i(408),r=n(o);e.default=function(){new a.default({el:"#app",template:"<App/>",components:{App:r.default}})}},183:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{title:{type:String,default:""},list:{type:Array,default:function(){return[]}},onlyShowTitle:{type:Boolean,default:!1}}}},187:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{status:{type:Boolean,default:!1},info:{type:Object,default:function(){return{}}},number:{type:[Number,String],default:1}},watch:{number:function(){this.calcNumber()}},mounted:function(){this.calcNumber()},methods:{calcNumber:function(){var t=this;this.info&&this.number&&this.info.products&&this.info.products.length>0&&this.info.products.forEach(function(e){e.num=t.number*parseInt(e.num)})},changeStatus:function(){this.$emit("changeStatus")}}}},192:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(183),s=i.n(n),a=i(195),o=i(25),r=o(s.a,a.a,null,null,null);e.default=r.exports},194:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(187),s=i.n(n),a=i(196),o=i(25),r=o(s.a,a.a,null,null,null);e.default=r.exports},195:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[i("div",{staticClass:"jfk-clause jfk-ta-c jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"jfk-clause__title font-size--28"},[i("span",{domProps:{textContent:t._s(t.title)}})])]),t._v(" "),t._l(t.list,function(e,n){return t.onlyShowTitle?t._e():i("ul",{key:n,staticClass:"jfk-clause__list"},[i("li",{staticClass:"font-size--24",domProps:{textContent:t._s(e)}})])})],2)},s=[],a={render:n,staticRenderFns:s};e.a=a},196:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-package-info jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"jfk-package-info__content"},[i("div",{staticClass:"jfk-package-info__base-info"},[t._m(0),t._v(" "),i("div",{staticClass:"jfk-package-info__base-info--right"},[i("div",{staticClass:"jfk-package-info__base-info--content"},[t.info.name?i("p",{staticClass:"name font-size--32",domProps:{textContent:t._s(t.info.name)}}):t._e(),t._v(" "),t.info.time?i("p",{staticClass:"validity font-size--24",domProps:{textContent:t._s("有效期至"+t.info.time)}}):t._e(),t._v(" "),t.info&&t.info.products&&t.info.products.length>0?i("p",{staticClass:"more",on:{click:t.changeStatus}},[i("span",{staticClass:"font-size--24"},[t._v("详情")]),t._v(" "),i("span",{staticClass:"font-size--24 icon"},[t.status?t._e():i("i",{staticClass:"jfk-font icon-booking_icon_DN_norm"}),t._v(" "),t.status?i("i",{staticClass:"jfk-font icon-booking_icon_up_normal"}):t._e()])]):t._e()])])]),t._v(" "),t.status?i("ul",{staticClass:"jfk-package-info__more-info"},t._l(t.info.products,function(e,n){return t.info&&t.info.products&&t.info.products.length>0?i("li",{key:n,staticClass:"jfk-flex"},[i("span",{staticClass:"jfk-ta-l font-size--28",domProps:{textContent:t._s(e.name)}},[t._v("自助餐")]),t._v(" "),i("span",{staticClass:"jfk-ta-r font-size--28",domProps:{textContent:t._s(e.num)}})]):t._e()})):t._e()])])},s=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-package-info__base-info--left"},[i("div",{staticClass:"jfk-package-info__base-info--title jfk-flex is-align-middle is-justify-center"},[i("i",{staticClass:"jfk-font  icon-font_zh_li_1_qkbys"})])])}],a={render:n,staticRenderFns:s};e.a=a},350:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var s=i(53),a=n(s),o=i(55),r=n(o),c=i(192),f=n(c),u=i(194),l=n(u),_=i(26),d=i(27),p=d.default(location.href);e.default={components:{clause:f.default,pack:l.default},computed:{},created:function(){var t=this;this.$pageNamespace(p),this.loading(),(0,_.getGiftPackageQrcodeDetail)({gift_detail_id:p.gift_detail_id||"",inter_id:p.inter_id||"",gift_id:p.gift_id||"",saler_id:p.saler_id||"",request_token:p.request_token},{REJECTERRORCONFIG:{serveError:!0}}).then(function(e){var i=e.web_data;if(i.gift_record_info){var n="",s="",a="";i.gift_record_info&&i.gift_record_info.record_info&&(n="登记信息："+i.gift_record_info.record_info),s=i.gift_record_info&&i.gift_record_info.orther_remark?"其他："+i.gift_record_info.orther_remark:"其他：无",i.gift_record_info&&i.gift_record_info.gift_num&&(t.giftNumber=i.gift_record_info.gift_num||1,a="数量："+i.gift_record_info.gift_num),t.info=[n,s,a]}var o="",r="";i.expiration_date&&(o="该商品有效期至"+i.expiration_date),i.price_market&&(r="礼包原价"+i.price_market+"元"),t.notice=[o,"请在规定时间内使用",r,"仅供住店客人使用，使用时请出示劵码"],t.toast.close(),t.products={name:i.name||"",time:i.expiration_date||"",products:i.child_product_info||[]}}).catch(function(e){var i=function(){(0,r.default)({iconType:"error",title:"",message:e.msg||"",duration:2e3})};1001===e.status&&e.web_data&&e.web_data.page_resource&&e.web_data.page_resource.gift_status&&2===e.web_data.page_resource.gift_status?(0,a.default)({showClose:!1,showCloseButton:!1,title:"",message:e.msg||"",showConfirmButton:!0,showCancelButton:!1,closeOnClickModal:!1,confirmButtonText:"去商城逛逛",iconClass:"jfk-font icon-user_icon_fail_norma"}).then(function(){window.location.href=e.web_data.page_resource.link.gift_detail}):i(),t.toast.close()})},methods:{loading:function(){this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0})},receive:function(){var t=this;this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,_.postGenerateGiftOrder)({gift_detail_id:p.gift_detail_id||"",inter_id:p.inter_id||"",request_token:p.request_token}).then(function(e){t.toast.close(),window.location.href=e.web_data.page_resource.link.gift_detail}).catch(function(){t.toast.close()})},changeStatus:function(){this.status=!this.status}},data:function(){return{status:!1,info:[],products:{},notice:[],giftNumber:1}}}},408:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(350),s=i.n(n),a=i(450),o=i(25),r=o(s.a,a.a,null,null,null);e.default=r.exports},450:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-pages jfk-pages__gift-package"},[i("div",{staticClass:"jfk-pages__theme"}),t._v(" "),t.products?i("pack",{attrs:{info:t.products,status:t.status,number:t.giftNumber},on:{changeStatus:t.changeStatus}}):t._e(),t._v(" "),i("div",{staticClass:"package-box"},[t.info.length>0?i("clause",{attrs:{title:"领取信息",list:t.info}}):t._e()],1),t._v(" "),i("div",{staticClass:"package-box"},[t.notice.length>0?i("clause",{attrs:{title:"注意事项",list:t.notice}}):t._e()],1),t._v(" "),i("div",{staticClass:"package-btn"},[i("button",{staticClass:"jfk-button jfk-button--primary is-special jfk-button--free font-size--32",on:{click:t.receive}},[i("span",[t._v("\n        立即领取\n      ")])])])],1)},s=[],a={render:n,staticRenderFns:s};e.a=a}});