!function(t,e){if("object"==typeof exports&&"object"==typeof module)module.exports=e();else if("function"==typeof define&&define.amd)define([],e);else{var n=e();for(var r in n)("object"==typeof exports?exports:t)[r]=n[r]}}(this,function(){return function(t){function e(r){if(n[r])return n[r].exports;var i=n[r]={i:r,l:!1,exports:{}};return t[r].call(i.exports,i,i.exports,e),i.l=!0,i.exports}var n={};return e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/",e(e.s=70)}([function(t,e){var n=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=n)},function(t,e,n){t.exports=!n(5)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(t,e){t.exports=function(t,e,n,r,i){var o,s=t=t||{},a=typeof t.default;"object"!==a&&"function"!==a||(o=t,s=t.default);var c="function"==typeof s?s.options:s;e&&(c.render=e.render,c.staticRenderFns=e.staticRenderFns),r&&(c._scopeId=r);var u;if(i?(u=function(t){t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,t||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),n&&n.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},c._ssrRegister=u):n&&(u=n),u){var f=c.functional,l=f?c.render:c.beforeCreate;f?c.render=function(t,e){return u.call(e),l(t,e)}:c.beforeCreate=l?[].concat(l,u):[u]}return{esModule:o,exports:s,options:c}}},function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},function(t,e){var n=t.exports={version:"2.4.0"};"number"==typeof __e&&(__e=n)},function(t,e){t.exports=function(t){try{return!!t()}catch(t){return!0}}},function(t,e,n){var r=n(21),i=n(12);t.exports=function(t){return r(i(t))}},function(t,e,n){var r=n(8),i=n(26),o=n(22),s=Object.defineProperty;e.f=n(1)?Object.defineProperty:function(t,e,n){if(r(t),e=o(e,!0),r(n),i)try{return s(t,e,n)}catch(t){}if("get"in n||"set"in n)throw TypeError("Accessors not supported!");return"value"in n&&(t[e]=n.value),t}},function(t,e,n){var r=n(3);t.exports=function(t){if(!r(t))throw TypeError(t+" is not an object!");return t}},function(t,e,n){var r=n(7),i=n(16);t.exports=n(1)?function(t,e,n){return r.f(t,e,i(1,n))}:function(t,e,n){return t[e]=n,t}},,function(t,e){var n={}.hasOwnProperty;t.exports=function(t,e){return n.call(t,e)}},function(t,e){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on  "+t);return t}},function(t,e){var n=Math.ceil,r=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?r:n)(t)}},function(t,e){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},function(t,e,n){var r=n(19);t.exports=function(t,e,n){if(r(t),void 0===e)return t;switch(n){case 1:return function(n){return t.call(e,n)};case 2:return function(n,r){return t.call(e,n,r)};case 3:return function(n,r,i){return t.call(e,n,r,i)}}return function(){return t.apply(e,arguments)}}},function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},function(t,e,n){var r=n(0),i=n(4),o=n(15),s=n(9),a=function(t,e,n){var c,u,f,l=t&a.F,p=t&a.G,_=t&a.S,d=t&a.P,m=t&a.B,v=t&a.W,y=p?i:i[e]||(i[e]={}),h=y.prototype,g=p?r:_?r[e]:(r[e]||{}).prototype;p&&(n=e);for(c in n)(u=!l&&g&&void 0!==g[c])&&c in y||(f=u?g[c]:n[c],y[c]=p&&"function"!=typeof g[c]?n[c]:m&&u?o(f,r):v&&g[c]==f?function(t){var e=function(e,n,r){if(this instanceof t){switch(arguments.length){case 0:return new t;case 1:return new t(e);case 2:return new t(e,n)}return new t(e,n,r)}return t.apply(this,arguments)};return e.prototype=t.prototype,e}(f):d&&"function"==typeof f?o(Function.call,f):f,d&&((y.virtual||(y.virtual={}))[c]=f,t&a.R&&h&&!h[c]&&s(h,c,f)))};a.F=1,a.G=2,a.S=4,a.P=8,a.B=16,a.W=32,a.U=64,a.R=128,t.exports=a},function(t,e,n){var r=n(32),i=n(25);t.exports=Object.keys||function(t){return r(t,i)}},function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},function(t,e,n){var r=n(3),i=n(0).document,o=r(i)&&r(i.createElement);t.exports=function(t){return o?i.createElement(t):{}}},function(t,e,n){var r=n(14);t.exports=Object("z").propertyIsEnumerable(0)?Object:function(t){return"String"==r(t)?t.split(""):Object(t)}},function(t,e,n){var r=n(3);t.exports=function(t,e){if(!r(t))return t;var n,i;if(e&&"function"==typeof(n=t.toString)&&!r(i=n.call(t)))return i;if("function"==typeof(n=t.valueOf)&&!r(i=n.call(t)))return i;if(!e&&"function"==typeof(n=t.toString)&&!r(i=n.call(t)))return i;throw TypeError("Can't convert object to primitive value")}},function(t,e){var n=0,r=Math.random();t.exports=function(t){return"Symbol(".concat(void 0===t?"":t,")_",(++n+r).toString(36))}},function(t,e){e.f={}.propertyIsEnumerable},function(t,e){t.exports="constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",")},function(t,e,n){t.exports=!n(1)&&!n(5)(function(){return 7!=Object.defineProperty(n(20)("div"),"a",{get:function(){return 7}}).a})},function(t,e,n){var r=n(28)("keys"),i=n(23);t.exports=function(t){return r[t]||(r[t]=i(t))}},function(t,e,n){var r=n(0),i=r["__core-js_shared__"]||(r["__core-js_shared__"]={});t.exports=function(t){return i[t]||(i[t]={})}},,function(t,e){e.f=Object.getOwnPropertySymbols},function(t,e,n){t.exports={default:n(37),__esModule:!0}},function(t,e,n){var r=n(11),i=n(6),o=n(35)(!1),s=n(27)("IE_PROTO");t.exports=function(t,e){var n,a=i(t),c=0,u=[];for(n in a)n!=s&&r(a,n)&&u.push(n);for(;e.length>c;)r(a,n=e[c++])&&(~o(u,n)||u.push(n));return u}},function(t,e,n){var r=n(13),i=Math.min;t.exports=function(t){return t>0?i(r(t),9007199254740991):0}},function(t,e,n){var r=n(12);t.exports=function(t){return Object(r(t))}},function(t,e,n){var r=n(6),i=n(33),o=n(36);t.exports=function(t){return function(e,n,s){var a,c=r(e),u=i(c.length),f=o(s,u);if(t&&n!=n){for(;u>f;)if((a=c[f++])!=a)return!0}else for(;u>f;f++)if((t||f in c)&&c[f]===n)return t||f||0;return!t&&-1}}},function(t,e,n){var r=n(13),i=Math.max,o=Math.min;t.exports=function(t,e){return t=r(t),t<0?i(t+e,0):o(t,e)}},function(t,e,n){n(40),t.exports=n(4).Object.assign},,function(t,e,n){"use strict";var r=n(18),i=n(30),o=n(24),s=n(34),a=n(21),c=Object.assign;t.exports=!c||n(5)(function(){var t={},e={},n=Symbol(),r="abcdefghijklmnopqrst";return t[n]=7,r.split("").forEach(function(t){e[t]=t}),7!=c({},t)[n]||Object.keys(c({},e)).join("")!=r})?function(t,e){for(var n=s(t),c=arguments.length,u=1,f=i.f,l=o.f;c>u;)for(var p,_=a(arguments[u++]),d=f?r(_).concat(f(_)):r(_),m=d.length,v=0;m>v;)l.call(_,p=d[v++])&&(n[p]=_[p]);return n}:c},function(t,e,n){var r=n(17);r(r.S+r.F,"Object",{assign:n(39)})},,,,,,,,,,,,,,,,,,,,,,,,,,,,,,function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(84),i=function(t){return t&&t.__esModule?t:{default:t}}(r);i.default.install=function(t){t.component(i.default.name,i.default)},e.default=i.default},,,,,,,,,,,,,,function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(102),i=n.n(r),o=n(157),s=n(2),a=s(i.a,o.a,null,null,null);e.default=a.exports},,,,,,,,,,,,,,,,,,function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(31),i=function(t){return t&&t.__esModule?t:{default:t}}(r);e.default={name:"jfk-recommendation",data:function(){return{defaultEmptyHtml:'<div class="jfk-flex is-justify-center is-align-middle"><div class="box"><p class="font-size--28 font-color-extra-light-gray zh">查看更多</p><p class="en  font-color-light-gray-common font-size--24"><span><i>V</i><i>I</i><i>E</i><i>W</i></span><span><i>M</i><i>O</i><i>R</i><i>E</i></span></p></div></div>',lists:[],recommendationSwiperOptions:{autoplay:0,lazyLoading:!0,lazyLoadingInPrevNext:!0,lazyPreloaderClass:"jfk-image__lazy--preload",spaceBetween:15,slidesPerView:2.3571}}},created:function(){var t=[],e=this,n=3-e.items.length,r=e.items.concat();n>0&&(r.push({_isEmpty:!0}),2===n&&(this.recommendationSwiperOptions=(0,i.default)({},this.recommendationSwiperOptions,{slidesPerView:2}))),t=r.map(function(t,n){return e.formatProductInfo?e.formatProductInfo(t,n):e.formatProductInfoInner(t,n)}),e.lists=t},methods:{formatProductInfoInner:function(t){return t._isEmpty?{_link:t._link||this.emptyLink,_html:this.defaultEmptyHtml,_isEmpty:!0}:{_link:this.linkPrefix+t.product_id,_img:t.face_img,_name:t.name,_pricePackage:t.killsec?t.killsec.killsec_price:t.price_package,_priceMarket:t.price_market,_integral:"5"===t.type}}},props:{formatProductInfo:{type:Function},items:{type:Array,required:!0},linkPrefix:{type:String},emptyLink:{type:String}}}},,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,function(t,e,n){"use strict";var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("swiper",{staticClass:"jfk-swiper jfk-swiper__recommendation",attrs:{options:t.recommendationSwiperOptions}},t._l(t.lists,function(e,r){return n("swiper-slide",{key:r,class:{"jfk-swiper__item":!0,"jfk-swiper__item--empty":e._isEmpty}},[e._isEmpty?n("a",{attrs:{href:e._link}},[n("div",{staticClass:"jfk-swiper__item-box"}),t._v(" "),n("div",{staticClass:"jfk-swiper__item-info"}),t._v(" "),n("div",{staticClass:"empty-tip",domProps:{innerHTML:t._s(e._html||t.defaultEmptyHtml)}})]):n("a",{attrs:{href:e._link}},[n("div",{staticClass:"jfk-swiper__item-box"},[n("div",{staticClass:"jfk-swiper__item-bg swiper-lazy",attrs:{"data-background":e._img}},[n("div",{staticClass:"jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"}),t._v(" "),n("div",{staticClass:"jfk-swiper__item-mask"})])]),t._v(" "),n("div",{staticClass:"jfk-swiper__item-info"},[n("div",{staticClass:"info-box"},[n("h5",{staticClass:"title font-color-silver-common font-size--28",domProps:{innerHTML:t._s(e._name)}}),t._v(" "),n("p",{staticClass:"price",class:{"is-integral":e._integral},attrs:{title:e.type}},[n("span",{staticClass:"jfk-price color-golden-price font-size--38"},[e._integral?t._e():n("i",{staticClass:"jfk-font-number jfk-price__currency"},[t._v("￥")]),t._v(" "),n("i",{staticClass:"jfk-font-number jfk-price__number"},[t._v(t._s(e._pricePackage))])]),t._v(" "),n("span",{staticClass:"jfk-price__original font-color-extra-light-gray-common font-size--24"},[e._integral?t._e():n("i",[t._v("￥")]),t._v(t._s(e._priceMarket))])])])])])])}))},i=[],o={render:r,staticRenderFns:i};e.a=o}])});