webpackJsonp([3],{150:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(8),o=n(a),r=i(413),s=n(r);e.default=function(){new o.default({el:"#app",template:"<App/>",components:{App:s.default}})}},179:function(t,e,i){"use strict";function n(t,e,i){for(var n=t.length,a=Math.min(i||0,n);a<n;){if(e(t[a]))return a;a++}return-1}function a(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:location.href,n=arguments[3],a=(0,r.default)({t:Date.now()},t);window.history.pushState(a,e,i),window.addEventListener("popstate",function(){setTimeout(function(){n&&n()},100)})}Object.defineProperty(e,"__esModule",{value:!0});var o=i(29),r=function(t){return t&&t.__esModule?t:{default:t}}(o);e.findIndex=n,e.showFullLayer=a},180:function(t,e,i){!function(e,i){t.exports=i()}(0,function(){return function(t){function e(n){if(i[n])return i[n].exports;var a=i[n]={i:n,l:!1,exports:{}};return t[n].call(a.exports,a,a.exports,e),a.l=!0,a.exports}var i={};return e.m=t,e.c=i,e.i=function(t){return t},e.d=function(t,i,n){e.o(t,i)||Object.defineProperty(t,i,{configurable:!1,enumerable:!0,get:n})},e.n=function(t){var i=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(i,"a",i),i},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/",e(e.s=165)}({0:function(t,e){var i=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=i)},1:function(t,e,i){t.exports=!i(5)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},15:function(t,e,i){var n=i(19);t.exports=function(t,e,i){if(n(t),void 0===e)return t;switch(i){case 1:return function(i){return t.call(e,i)};case 2:return function(i,n){return t.call(e,i,n)};case 3:return function(i,n,a){return t.call(e,i,n,a)}}return function(){return t.apply(e,arguments)}}},16:function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},160:function(t,e,i){"use strict";function n(t){var e=parseInt(t/s),i=e*s,n=parseInt((t-i)/r),c=n*r,u=parseInt((t-i-c)/o);return{dates:e,hours:n,minutes:u,seconds:parseInt((t-i-c-u*o)/a)}}Object.defineProperty(e,"__esModule",{value:!0}),e.default=n;var a=1e3,o=6e4,r=60*o,s=24*r},161:function(t,e,i){"use strict";e.__esModule=!0,e.default=function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}},162:function(t,e,i){"use strict";e.__esModule=!0;var n=i(169),a=function(t){return t&&t.__esModule?t:{default:t}}(n);e.default=function(){function t(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),(0,a.default)(t,n.key,n)}}return function(e,i,n){return i&&t(e.prototype,i),n&&t(e,n),e}}()},165:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(161),o=n(a),r=i(162),s=n(r),c=i(160),u=n(c),l=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return(0,o.default)(this,t),this.options=e,!1!==this.options.auto&&this.start(),this}return(0,s.default)(t,[{key:"start",value:function(t){var e=this;if(!e._hasStarted||t){e._hasStarted=!0;var i=this.options,n=i.callback,a=i.start,o=i.end,r=i.rate,s=void 0===r?1e3:r,c=i.countdown;if(t&&e.close(),this.status=1,c){var l=c;e.interval=setInterval(function(){e.process=2;var t=(0,u.default)(l);e.dates=t.dates,e.hours=t.hours,e.minutes=t.minutes,e.seconds=t.seconds,e._hasStartTrigger||(e.status&&n&&n("on-start",l,e),e._hasStartTrigger=!0),l<=0&&(e.process=0,e.status&&n&&n("on-finish",l,e),e.close()),e.status&&n&&n("is-change",l,e),l-=s,l=Math.max(0,l)},s)}else e.interval=setInterval(function(){var t=Date.now(),i=t-a,r=o-t;if(i<0){e.process=1;var s=(0,u.default)(-i);e.dates=s.dates,e.hours=s.hours,e.minutes=s.minutes,e.seconds=s.seconds}else if(r>0||0===i){e.process=2;var c=(0,u.default)(r);e.dates=c.dates,e.hours=c.hours,e.minutes=c.minutes,e.seconds=c.seconds,i>0&&!e._hasStartTrigger?(e._hasStartTrigger=!0,e.status&&n&&n("has-start",t,e)):0===i&&e.status&&n&&n("on-start",t,e)}else e.process=0,e.status&&n&&n(0===r?"on-finish":"has-finish",t,e),e.close();e.status&&n&&n("is-change",t,e)},s)}return this}},{key:"close",value:function(){return void 0!==this.interval&&(clearInterval(this.interval),this.status=0,!0)}}]),t}();e.default=l},169:function(t,e,i){t.exports={default:i(170),__esModule:!0}},17:function(t,e,i){var n=i(0),a=i(4),o=i(15),r=i(9),s=function(t,e,i){var c,u,l,f=t&s.F,d=t&s.G,_=t&s.S,p=t&s.P,h=t&s.B,g=t&s.W,v=d?a:a[e]||(a[e]={}),k=v.prototype,m=d?n:_?n[e]:(n[e]||{}).prototype;d&&(i=e);for(c in i)(u=!f&&m&&void 0!==m[c])&&c in v||(l=u?m[c]:i[c],v[c]=d&&"function"!=typeof m[c]?i[c]:h&&u?o(l,n):g&&m[c]==l?function(t){var e=function(e,i,n){if(this instanceof t){switch(arguments.length){case 0:return new t;case 1:return new t(e);case 2:return new t(e,i)}return new t(e,i,n)}return t.apply(this,arguments)};return e.prototype=t.prototype,e}(l):p&&"function"==typeof l?o(Function.call,l):l,p&&((v.virtual||(v.virtual={}))[c]=l,t&s.R&&k&&!k[c]&&r(k,c,l)))};s.F=1,s.G=2,s.S=4,s.P=8,s.B=16,s.W=32,s.U=64,s.R=128,t.exports=s},170:function(t,e,i){i(171);var n=i(4).Object;t.exports=function(t,e,i){return n.defineProperty(t,e,i)}},171:function(t,e,i){var n=i(17);n(n.S+n.F*!i(1),"Object",{defineProperty:i(7).f})},19:function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},20:function(t,e,i){var n=i(3),a=i(0).document,o=n(a)&&n(a.createElement);t.exports=function(t){return o?a.createElement(t):{}}},22:function(t,e,i){var n=i(3);t.exports=function(t,e){if(!n(t))return t;var i,a;if(e&&"function"==typeof(i=t.toString)&&!n(a=i.call(t)))return a;if("function"==typeof(i=t.valueOf)&&!n(a=i.call(t)))return a;if(!e&&"function"==typeof(i=t.toString)&&!n(a=i.call(t)))return a;throw TypeError("Can't convert object to primitive value")}},26:function(t,e,i){t.exports=!i(1)&&!i(5)(function(){return 7!=Object.defineProperty(i(20)("div"),"a",{get:function(){return 7}}).a})},3:function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},4:function(t,e){var i=t.exports={version:"2.4.0"};"number"==typeof __e&&(__e=i)},5:function(t,e){t.exports=function(t){try{return!!t()}catch(t){return!0}}},7:function(t,e,i){var n=i(8),a=i(26),o=i(22),r=Object.defineProperty;e.f=i(1)?Object.defineProperty:function(t,e,i){if(n(t),e=o(e,!0),n(i),a)try{return r(t,e,i)}catch(t){}if("get"in i||"set"in i)throw TypeError("Accessors not supported!");return"value"in i&&(t[e]=i.value),t}},8:function(t,e,i){var n=i(3);t.exports=function(t){if(!n(t))throw TypeError(t+" is not an object!");return t}},9:function(t,e,i){var n=i(7),a=i(16);t.exports=i(1)?function(t,e,i){return n.f(t,e,a(1,i))}:function(t,e,i){return t[e]=i,t}}})})},188:function(t,e,i){"use strict";function n(t,e,i){var n=void 0;if(i)n=t[e?"price_market":"price_package"];else switch(t.tag){case 2:n=e?t.price_package:t.killsec.killsec_price;break;case 3:n=e?t.price_package:t.groupons.group_price;break;default:n=e?t.price_market:t.price_package}return e?(7!==t.tag?"￥":"")+n:(7!==t.tag?'<i class="jfk-font-number jfk-price__currency">￥</i>':"")+'<i class="jfk-font-number jfk-price__number">'+n+"</i>"}Object.defineProperty(e,"__esModule",{value:!0}),e.default=n},209:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(180),o=n(a),r=i(27),s=i(188),c=n(s),u={1:'<i class="jfk-font jfk-price-tag__word icon-font_zh_zhuan_fzdbs"></i><i class="jfk-font jfk-price-tag__word icon-font_zh_shu_fzdbs"></i>',2:'<i class="jfk-font jfk-price-tag__word icon-font_zh_miao_fzdbs"></i><i class="jfk-font jfk-price-tag__word icon-font_zh_sha_fzdbs"></i>',3:'<i class="jfk-font jfk-price-tag__word icon-font_zh_pin_fzdbs"></i><i class="jfk-font jfk-price-tag__word icon-font_zh_tuan_fzdbs"></i>',4:'<i class="jfk-font jfk-price-tag__word icon-font_zh_man_fzdbs"></i><i class="jfk-font jfk-price-tag__word icon-font_zh_jian_fzdbs"></i>',5:'<i class="jfk-font jfk-price-tag__word icon-font_zh_zu_fzdbs"></i><i class="jfk-font jfk-price-tag__word icon-font_zh_he_fzdbs"></i>',6:'<i class="jfk-font jfk-price-tag__word icon-font_zh_chu_fzdbs"></i><i class="jfk-font jfk-price-tag__word icon-font_zh_zhi_fzdbs"></i>',7:'<i class="jfk-font jfk-price-tag__word icon-font_zh_ji_fzdbs"></i><i class="jfk-font jfk-price-tag__word icon-font_zh_fen_fzdbs"></i>'},l={1:'<i class="jfk-font jfk-button__text-item icon-font_zh_li_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_ji_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_gou_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_mai_qkbys"></i>',2:'<i class="jfk-font jfk-button__text-item icon-font_zh_qu_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_miao_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_sha_qkbys"></i>',3:'<i class="jfk-font jfk-button__text-item icon-font_zh_ding_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_yue_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_ti_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_xing_qkbys"></i>',4:'<i class="jfk-font jfk-button__text-item icon-font_zh_yi_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_ding_qkbys"></i><i class="jfk-font jfk-button__text-item icon-font_zh_yue_qkbys"></i>'},f=function(t,e){return 1===t?"card"===e:2!==t&&3!==t},d=function(t,e){return'<button class="jfk-button jfk-button--primary'+(f(t,e)?" is-plain":"")+' font-size--30 product-button"><span class="jfk-button__text">'+l[t]+"</span></button>"};e.default={data:function(){return{killsecTime:{},buttonText:"",buttonType:1}},created:function(){var t=this,e=this.layout;if(2===t.product.tag){var i=t.product.killsec,n=i.killsec_time,a=i.end_time,r=1e3*n-6e4;t.killsecTime=new o.default({start:1e3*n,end:1e3*a,callback:function(i,n,a){"has-finish"===i||"on-finish"===i||"has-start"===i||"on-start"===i||"is-change"===i&&1===a.process&&n>r?(t.buttonText=d(2,e),t.buttonType=1,a.close()):1===t.product.killsec.subscribe_status?(t.buttonText=d(4,e),t.buttonType=3):(t.buttonText=d(3,e),t.buttonType=2)}})}else t.buttonText=d(1,e)},computed:{pricePackage:function(){return(0,c.default)(this.product,!1,!0)},priceMarket:function(){return(0,c.default)(this.product,!0,!0)},priceTagText:function(){return u[this.product.tag]},productNumber:function(){return 2===this.product.tag?"限"+this.product.killsec.killsec_count:"1"===this.product.show_sales_cut?"已售"+this.product.sales_cnt:void 0},detailUrl:function(){return this.detailUrlPrefix+this.product.product_id}},methods:{noticeSuccess:function(){this.$jfkToast({message:"已订阅，请耐心等待活动开始！",iconType:"success",duration:2e3})},noticeSuccessWithQrcode:function(){this.$jfkAlert({message:this.qrcodeTip})},handleButtonClick:function(){if(1===this.buttonType)location.href=this.detailUrl;else if(2===this.buttonType){var t=this.$jfkToast({message:"正在设置提醒，请稍候",duration:-1}),e=this;(0,r.postKillsecNotice)({act_id:this.product.killsec.act_id}).then(function(i){e.killsecTime.close&&e.killsecTime.close(),t.close(),i.web_data.data?e.$emit("qrcode-change",{url:i.web_data.data,tip:i.msg}):e.noticeSuccess(),e.product.killsec.subscribe_status=1,e.buttonText=d(4,e.layout),e.buttonType=3}).catch(function(){t.close()})}else 3===this.buttonType&&this.noticeSuccess()}},props:{product:{type:Object,required:!0},detailUrlPrefix:{type:String,required:!0},layout:{type:String,default:"card"}},beforeDestroy:function(){this.killsecTime.close&&this.killsecTime.close()}}},342:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={name:"tabbar",computed:{},props:{selected:{type:Number,default:0},tabbarItems:{type:Array,required:!0}}}},357:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(28),o=n(a),r=i(179),s=i(27),c=i(399),u=n(c),l=i(415),f=n(l),d=["card","pic"];e.default={name:"app",components:{Tabbar:u.default,GoodList:f.default,"accor-header":function(){return i.e(33).then(i.bind(null,414))}},beforeCreate:function(){var t=(0,o.default)(location.href),e="card";void 0!==t.layout&&(e=d[t.layout]||d[0]),this.$pageNamespace(t),this.fcid=t.fcid||"-1",this.layout=e,this.isAccor="accor"===i.i({NODE_ENV:"production"}).INTER_ID},data:function(){var t=this;return{advs:[],products:[],disableLoadProduct:!1,isLoadProduct:!1,categories:[],tabbarItems:[],page:1,detailUrlPrefix:"javascript:;",showAdsCat:1,pageSize:20,showFullLoading:!0,curCategoryIndex:0,tabSwiperOptions:{autoplay:0,slidesPerView:"auto",slideToClickedSlide:!0,notNextTick:!0,onTap:function(e){var i=e.clickedIndex;if(i!==t.curCategoryIndex){t.curCategoryIndex=i;try{var n=e.clickedSlide.dataset.cid;n&&(t.fcid=n,t.disableLoadProduct=!0,t.page=1,t.showFullLoading=!0,t.loadPackages(!0))}catch(t){}}}}}},watch:{categories:function(t){var e=this.fcid,i=(0,r.findIndex)(t,function(t){return t.cat_id===e});-1===i&&(this.fcid="-1",i=0),this.curCategoryIndex=i}},methods:{loadPackages:function(t){var e=this,i=void 0,n={page:e.page,show_ads_cat:e.showAdsCat,page_size:e.pageSize};e.fcid>0&&(n.fcid=e.fcid),this.showFullLoading&&(i=this.$jfkToast({iconClass:"jfk-loading__snake",duration:-1,isLoading:!0})),e.isLoadProduct=!0,(0,s.getPackageLists)(n).then(function(n){e.showFullLoading=!1,i&&i.close(),e.isLoadProduct=!1;var a=n.web_data,o=a.advs,r=a.categories,s=a.products,c=a.page_resource,u=c.page,l=void 0===u?1:u,f=c.size,d=void 0===f?20:f,_=c.count,p=void 0===_?0:_,h=c.link,g=void 0===h?{}:h;e.products=t?s:e.products.concat(s),1===e.showAdsCat&&(e.detailUrlPrefix=g.detail,e.showAdsCat=2,e.advs=o,e.categories=[{cat_id:"-1",cat_name:"全部商品"}].concat(r),e.tabbarItems=[{link:g.home,text:"首页",icon:"icon-mall_icon_home"},{link:g.order,text:"订单",icon:"icon-user_icon_Onlineboo"},{link:g.center,text:"我的",icon:"icon-mall_icon_home_user"}]),e.disableLoadProduct=l*d>=p,e.disableLoadProduct||(e.page=+l+1)}).catch(function(t){e.isLoadProduct=!1})},loadMore:function(){this.disableLoadProduct=!0,this.loadPackages()}}}},359:function(t,e,i){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(416),o=n(a),r=i(417),s=n(r);e.default={name:"good-list",data:function(){return{viewsMap:{card:"GoodListCard",pic:"GoodListImage"},qrcodeVisible:!1,qrcodeUrl:"",qrcodeTip:""}},components:{GoodListCard:o.default,GoodListImage:s.default},methods:{qrCodeChange:function(t){this.qrcodeUrl=t.url,this.qrcodeTip=t.tip,this.qrcodeVisible=!0}},props:{products:{type:Array,required:!0},layout:{type:String,required:!0,default:"card"},detailUrlPrefix:{type:String,required:!0},showEmptyTip:{type:Boolean}}}},360:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(209),a=function(t){return t&&t.__esModule?t:{default:t}}(n);e.default={name:"good-list-card",mixins:[a.default]}},361:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(209),a=function(t){return t&&t.__esModule?t:{default:t}}(n);e.default={name:"good-list-image",mixins:[a.default]}},399:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(342),a=i.n(n),o=i(467),r=i(26),s=r(a.a,o.a,null,null,null);e.default=s.exports},413:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(357),a=i.n(n),o=i(470),r=i(26),s=r(a.a,o.a,null,null,null);e.default=s.exports},415:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(359),a=i.n(n),o=i(469),r=i(26),s=r(a.a,o.a,null,null,null);e.default=s.exports},416:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(360),a=i.n(n),o=i(476),r=i(26),s=r(a.a,o.a,null,null,null);e.default=s.exports},417:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(361),a=i.n(n),o=i(453),r=i(26),s=r(a.a,o.a,null,null,null);e.default=s.exports},453:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("li",[i("a",{staticClass:"item-cont",attrs:{href:t.detailUrl}},[i("div",{staticClass:"product-box"},[t.product.tag>0&&t.priceTagText?t._m(0):t._e(),t._v(" "),i("div",{staticClass:"product-image"},[t.product.face_img?i("div",{directives:[{name:"lazy",rawName:"v-lazy:background-image",value:t.product.face_img,expression:"product.face_img",arg:"background-image"}],staticClass:"jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image"}):i("div",{staticClass:"jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image --preload"})])]),t._v(" "),i("div",{staticClass:"product-info"},[i("div",{staticClass:"product-info__box jfk-clearfix"},[i("div",{staticClass:"jfk-fl-l product-info--left"},[t._m(1),t._v(" "),t.product.price_market?i("div",{staticClass:"product-price"},[t._m(2),t._v(" "),t._m(3),t._v(" "),i("span",{staticClass:"font-size--24 goods-number font-color-light-gray",domProps:{innerHTML:t._s(t.productNumber)}})]):t._e()]),t._v(" "),i("div",{staticClass:"product-control jfk-fl-r jfk-ta-r"},[t.buttonText?i("div",{staticClass:"product-button-box jfk-d-ib",domProps:{innerHTML:t._s(t.buttonText)},on:{click:function(e){e.preventDefault(),t.handleButtonClick(e)}}}):t._e()])])])])])},a=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-price-tag jfk-price-tag--large font-size--32",class:"jfk-price-tag--theme-"+t.product.tag},[i("div",{staticClass:"jfk-price-tag__mask"}),t._v(" "),i("div",{staticClass:"jfk-price-tag__words is-justify-space-between",domProps:{innerHTML:t._s(t.priceTagText)}})])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("h3",{staticClass:"product-title font-size--32 font-color-dark-white"},[t._v(t._s(t.product.name))])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("span",{staticClass:"jfk-price product-price-package color-golden-price font-size--54",domProps:{innerHTML:t._s(t.pricePackage)}})},function(){var t=this,e=t.$createElement;return(t._self._c||e)("span",{staticClass:"jfk-price__original product-price-market font-size--24 font-color-extra-light-gray",class:{"is-integral":7===t.product.tag}},[t._v(t._s(t.priceMarket))])}],o={render:n,staticRenderFns:a};e.a=o},467:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-tabbar jfk-footer"},t._l(t.tabbarItems,function(e,n){return i("a",{key:n,staticClass:"jfk-tabbar__item",class:{"is-selected color-golden":n===t.selected,"font-color-white":n!==t.selected},attrs:{href:e.link}},[i("div",{staticClass:"jfk-tabbar__cont"},[i("i",{staticClass:"jfk-font jfk-tabbar__icon",class:e.icon}),t._v(" "),i("span",{staticClass:"jfk-tabbar__label"},[t._v(t._s(e.text))])])])}))},a=[],o={render:n,staticRenderFns:a};e.a=o},469:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"products-layout",class:"products-layout--"+t.layout},[i("div",{staticClass:"products-layout__body"},[i("ul",{directives:[{name:"show",rawName:"v-show",value:t.products.length,expression:"products.length"}],class:"card"===t.layout?"jfk-pl-30 jfk-pr-30":""},t._l(t.products,function(e){return i(t.viewsMap[t.layout],{key:e.product_id,tag:"component",staticClass:"products-list__item",attrs:{layout:t.layout,product:e,detailUrlPrefix:t.detailUrlPrefix},on:{"qrcode-change":t.qrCodeChange}})})),t._v(" "),i("div",{directives:[{name:"show",rawName:"v-show",value:t.showEmptyTip&&!t.products.length,expression:"showEmptyTip && !products.length"}],staticClass:"empty-area"},[t._m(0)])]),t._v(" "),i("jfk-popup",{staticClass:"jfk-popup__qrcode jfk-ta-c",attrs:{showCloseButton:!0,closeOnClickModal:!1},model:{value:t.qrcodeVisible,callback:function(e){t.qrcodeVisible=e},expression:"qrcodeVisible"}},[i("div",{staticClass:"qrcode"},[i("img",{attrs:{src:t.qrcodeUrl}})]),t._v(" "),i("div",{staticClass:"tip font-size--28 font-color-extra-light-gray jfk-pl-30 jfk-pr-30"},[t._v(t._s(t.qrcodeTip))])])],1)},a=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"empty-area__cont"},[i("i",{staticClass:"jfk-font empty-area__icon icon-blankpage_icon_nohotel_bg font-color-extra-light-gray font-size--120"}),t._v(" "),i("p",{staticClass:"jfk-font font-size--28 empty-area__text font-color-light-gray"},[t._v("没有商品")])])}],o={render:n,staticRenderFns:a};e.a=o},470:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-pages jfk-pages__index",class:t.pageNamespace},[i("div",{staticClass:"jfk-pages__theme"}),t._v(" "),i("div",{staticClass:"page__header"},[t.isAccor?i("accor-header"):t._e(),t._v(" "),t.advs.length?i("jfk-banner",{attrs:{items:t.advs}}):t._e()],1),t._v(" "),i("div",{staticClass:"categories jfk-pl-30"},[i("swiper",{staticClass:"jfk-swiper",attrs:{options:t.tabSwiperOptions}},t._l(t.categories,function(e,n){return i("swiper-slide",{key:e.cat_id,staticClass:"category__item",class:{"is-selected color-golden":n===t.curCategoryIndex,"font-color-extra-light-gray":n!==t.curCategoryIndex},attrs:{"data-cid":e.cat_id}},[i("span",{staticClass:"category__label font-size--32"},[t._v(t._s(e.cat_name))])])}))],1),t._v(" "),i("good-list",{directives:[{name:"infinite-scroll",rawName:"v-infinite-scroll",value:t.loadMore,expression:"loadMore"}],staticClass:"jfk-tab__body-item",attrs:{"show-empty-tip":!t.showFullLoading,products:t.products,detailUrlPrefix:t.detailUrlPrefix,layout:t.layout,"infinite-scroll-disabled":"disableLoadProduct","infinite-scroll-distance":"60"}}),t._v(" "),i("p",{directives:[{name:"show",rawName:"v-show",value:!t.showFullLoading&&t.isLoadProduct,expression:"!showFullLoading && isLoadProduct"}],staticClass:"products-list__loading"},[t._m(0)]),t._v(" "),t._m(1),t._v(" "),i("tabbar",{staticClass:"font-size--24",attrs:{tabbarItems:t.tabbarItems}})],1)},a=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("span",{staticClass:"jfk-loading__triple-bounce color-golden font-size--24"},[i("i",{staticClass:"jfk-loading__triple-bounce-item"}),t._v(" "),i("i",{staticClass:"jfk-loading__triple-bounce-item"}),t._v(" "),i("i",{staticClass:"jfk-loading__triple-bounce-item"})])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("jfk-support")}],o={render:n,staticRenderFns:a};e.a=o},476:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("li",[i("a",{staticClass:"item-cont",attrs:{href:t.detailUrl}},[i("div",{staticClass:"product-box"},[t.product.tag>0&&t.priceTagText?t._m(0):t._e(),t._v(" "),i("div",{staticClass:"product-image"},[t.product.face_img?i("div",{directives:[{name:"lazy",rawName:"v-lazy:background-image",value:t.product.face_img,expression:"product.face_img",arg:"background-image"}],staticClass:"jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image"}):i("div",{staticClass:"jfk-image__lazy product-image-cont jfk-image__lazy--3-3 jfk-image__lazy--background-image jfk-image__lazy--preload"})]),t._v(" "),i("div",{staticClass:"product-info"},[i("div",{staticClass:"product-info-cont"},[t._m(1),t._v(" "),t.product.price_market?i("div",{staticClass:"product-price"},[t._m(2),t._v(" "),t._m(3)]):t._e(),t._v(" "),i("p",{staticClass:"font-size--24 product-number font-color-light-gray-common",domProps:{innerHTML:t._s(t.productNumber)}}),t._v(" "),t.buttonText?i("div",{staticClass:"product-button-box jfk-d-ib",domProps:{innerHTML:t._s(t.buttonText)},on:{click:function(e){e.preventDefault(),t.handleButtonClick(e)}}}):t._e()])])])])])},a=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-price-tag jfk-price-tag--small font-size--32",class:"jfk-price-tag--theme-"+t.product.tag},[i("div",{staticClass:"jfk-price-tag__mask"}),t._v(" "),i("div",{staticClass:"jfk-price-tag__words is-justify-center",domProps:{innerHTML:t._s(t.priceTagText)}})])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("h3",{staticClass:"product-title font-size--32 font-color-dark-white"},[t._v(t._s(t.product.name))])},function(){var t=this,e=t.$createElement;return(t._self._c||e)("span",{staticClass:"jfk-price product-price-package color-golden-price font-size--54",domProps:{innerHTML:t._s(t.pricePackage)}})},function(){var t=this,e=t.$createElement;return(t._self._c||e)("span",{staticClass:"jfk-price__original product-price-market font-size--24 font-color-light-gray",class:{"is-integral":7===t.product.tag}},[t._v(t._s(t.priceMarket))])}],o={render:n,staticRenderFns:a};e.a=o}});