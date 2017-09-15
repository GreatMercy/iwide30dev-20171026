webpackJsonp([9],{163:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var s=i(8),a=n(s),o=i(435),r=n(o);e.default=function(){new a.default({el:"#app",template:"<App/>",components:{App:r.default}})}},189:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{title:{type:String,default:""},list:{type:Array,default:function(){return[]}},onlyShowTitle:{type:Boolean,default:!1}}}},193:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{status:{type:Boolean,default:!1},info:{type:Object,default:function(){return{}}},number:{type:[Number,String],default:1}},watch:{number:function(){this.calcNumber()}},mounted:function(){this.calcNumber()},methods:{calcNumber:function(){var t=this;this.info&&this.number&&this.info.products&&this.info.products.length>0&&this.info.products.forEach(function(e){e.num=t.number*parseInt(e.num)})},changeStatus:function(){this.$emit("changeStatus")}}}},198:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(189),s=i.n(n),a=i(201),o=i(25),r=o(s.a,a.a,null,null,null);e.default=r.exports},200:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(193),s=i.n(n),a=i(202),o=i(25),r=o(s.a,a.a,null,null,null);e.default=r.exports},201:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[i("div",{staticClass:"jfk-clause jfk-ta-c jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"jfk-clause__title font-size--28"},[i("span",{domProps:{textContent:t._s(t.title)}})])]),t._v(" "),t._l(t.list,function(e,n){return t.onlyShowTitle?t._e():i("ul",{key:n,staticClass:"jfk-clause__list"},[i("li",{staticClass:"font-size--24",domProps:{textContent:t._s(e)}})])})],2)},s=[],a={render:n,staticRenderFns:s};e.a=a},202:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-package-info jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"jfk-package-info__content"},[i("div",{staticClass:"jfk-package-info__base-info"},[t._m(0),t._v(" "),i("div",{staticClass:"jfk-package-info__base-info--right"},[i("div",{staticClass:"jfk-package-info__base-info--content"},[t.info.name?i("p",{staticClass:"name font-size--32",domProps:{textContent:t._s(t.info.name)}}):t._e(),t._v(" "),t.info.time?i("p",{staticClass:"validity font-size--24",domProps:{textContent:t._s("有效期至"+t.info.time)}}):t._e(),t._v(" "),t.info&&t.info.products&&t.info.products.length>0?i("p",{staticClass:"more",on:{click:t.changeStatus}},[i("span",{staticClass:"font-size--24"},[t._v("详情")]),t._v(" "),i("span",{staticClass:"font-size--24 icon"},[t.status?t._e():i("i",{staticClass:"jfk-font icon-booking_icon_DN_norm"}),t._v(" "),t.status?i("i",{staticClass:"jfk-font icon-booking_icon_up_normal"}):t._e()])]):t._e()])])]),t._v(" "),t.status?i("ul",{staticClass:"jfk-package-info__more-info"},t._l(t.info.products,function(e,n){return t.info&&t.info.products&&t.info.products.length>0?i("li",{key:n,staticClass:"jfk-flex"},[i("span",{staticClass:"jfk-ta-l font-size--28",domProps:{textContent:t._s(e.name)}},[t._v("自助餐")]),t._v(" "),i("span",{staticClass:"jfk-ta-r font-size--28",domProps:{textContent:t._s(e.num)}})]):t._e()})):t._e()])])},s=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-package-info__base-info--left"},[i("div",{staticClass:"jfk-package-info__base-info--title jfk-flex is-align-middle is-justify-center"},[i("i",{staticClass:"jfk-font  icon-font_zh_li_1_qkbys"})])])}],a={render:n,staticRenderFns:s};e.a=a},379:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var s=i(198),a=n(s),o=i(200),r=n(o),c=i(26),f=i(57),_=i(27),l=_.default(location.href),u=f.v1.GET_GENERATE_GIFT_QRCODE;e.default={components:{clause:a.default,pack:r.default},computed:{size:function(){return{width:window.innerWidth*(443/750)+"px",height:window.innerWidth*(443/750)+"px"}}},methods:{generate:function(){window.history.go(-1)},changeStatus:function(){this.status=!this.status}},created:function(){var t=this;this.$pageNamespace(l),this.qrcode=window.location.host+u+"?gift_detail_id="+l.gift_detail_id+"&inter_id="+l.inter_id+"&request_token="+l.request_token,-1===this.qrcode.indexOf("http://")&&(this.qrcode="http://"+this.qrcode),this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,c.getGiftPackageDetail)({gift_detail_id:l.gift_detail_id||"",inter_id:l.inter_id||"",request_token:l.request_token}).then(function(e){var i=e.web_data;if(i.gift_record_info){var n="",s="",a="";i.gift_record_info&&i.gift_record_info.record_info&&(n="登记信息："+i.gift_record_info.record_info),s=i.gift_record_info&&i.gift_record_info.orther_remark?"其他："+i.gift_record_info.orther_remark:"其他：无",i.gift_record_info&&i.gift_record_info.gift_num&&(t.giftNumber=i.gift_record_info.gift_num||1,a="数量："+i.gift_record_info.gift_num),t.receiveInfo=[n,s,a]}var o="";i.expiration_date&&(o="该商品有效期至"+i.expiration_date);var r="";i.price_market&&(r="礼包原价"+e.web_data.price_market+"元"),t.notice=[o,"请在规定时间内使用",r,"仅供住店客人使用，使用时请出示劵码"],t.info={name:i.name||"",time:i.expiration_date||"",products:i.child_product_info||[]},t.toast.close()})},data:function(){return{info:{},status:!1,notice:[],qrcode:"",giftNumber:1,receiveInfo:[]}}}},435:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(379),s=i.n(n),a=i(461),o=i(25),r=o(s.a,a.a,null,null,null);e.default=r.exports},461:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-pages jfk-pages__scan-receive"},[i("div",{staticClass:"jfk-pages__theme"}),t._v(" "),i("div",{staticClass:"jfk-pl-30 jfk-pr-30 qrcode-wrap"},[i("div",{staticClass:"scan-receive__container"},[i("div",{staticClass:"scan-receive__qrcode jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image",style:t.size},[t.qrcode?i("img",{attrs:{src:t.qrcode}}):t._e()]),t._v(" "),t._m(0),t._v(" "),i("div",{staticClass:"scan-receive__btn"},[i("button",{staticClass:"jfk-button jfk-button--primary is-special jfk-button--free font-size--32",on:{click:t.generate}},[i("span",[t._v("重新生成")])])])])]),t._v(" "),t.notice.length>0?i("div",{staticClass:"scan-receive__notice"},[i("clause",{attrs:{title:"注意事项",list:t.notice}})],1):t._e(),t._v(" "),t.receiveInfo.length>0?i("div",{staticClass:"scan-receive__notice"},[i("clause",{attrs:{title:"领取信息",list:t.receiveInfo}})],1):t._e(),t._v(" "),i("div",{staticClass:"scan-receive__package"},[i("clause",{attrs:{title:"礼包内容"}}),t._v(" "),i("pack",{attrs:{status:t.status,info:t.info,number:t.giftNumber},on:{changeStatus:t.changeStatus}})],1)])},s=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"scan-receive__way font-size--24 jfk-ta-c"},[i("span",[t._v("使用方式")]),i("i",[t._v("（请在10分钟完成扫码，超时未领取请重新生成）")])])}],a={render:n,staticRenderFns:s};e.a=a}});