!function(t,e){if("object"==typeof exports&&"object"==typeof module)module.exports=e();else if("function"==typeof define&&define.amd)define([],e);else{var n=e();for(var r in n)("object"==typeof exports?exports:t)[r]=n[r]}}(this,function(){return function(t){function e(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,e),o.l=!0,o.exports}var n={};return e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/",e(e.s=64)}([function(t,e){var n=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=n)},function(t,e,n){t.exports=!n(5)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(t,e){var n=t.exports={version:"2.5.0"};"number"==typeof __e&&(__e=n)},function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},function(t,e){t.exports=function(t,e,n,r,o){var i,a=t=t||{},u=typeof t.default;"object"!==u&&"function"!==u||(i=t,a=t.default);var s="function"==typeof a?a.options:a;e&&(s.render=e.render,s.staticRenderFns=e.staticRenderFns),r&&(s._scopeId=r);var f;if(o?(f=function(t){t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,t||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),n&&n.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},s._ssrRegister=f):n&&(f=n),f){var c=s.functional,l=c?s.render:s.beforeCreate;c?s.render=function(t,e){return f.call(e),l(t,e)}:s.beforeCreate=l?[].concat(l,f):[f]}return{esModule:i,exports:a,options:s}}},function(t,e){t.exports=function(t){try{return!!t()}catch(t){return!0}}},function(t,e,n){var r=n(21),o=n(13);t.exports=function(t){return r(o(t))}},function(t,e,n){var r=n(8),o=n(26),i=n(22),a=Object.defineProperty;e.f=n(1)?Object.defineProperty:function(t,e,n){if(r(t),e=i(e,!0),r(n),o)try{return a(t,e,n)}catch(t){}if("get"in n||"set"in n)throw TypeError("Accessors not supported!");return"value"in n&&(t[e]=n.value),t}},function(t,e,n){var r=n(3);t.exports=function(t){if(!r(t))throw TypeError(t+" is not an object!");return t}},function(t,e,n){var r=n(7),o=n(18);t.exports=n(1)?function(t,e,n){return r.f(t,e,o(1,n))}:function(t,e,n){return t[e]=n,t}},,function(t,e,n){var r=n(0),o=n(2),i=n(17),a=n(9),u=function(t,e,n){var s,f,c,l=t&u.F,p=t&u.G,d=t&u.S,_=t&u.P,y=t&u.B,v=t&u.W,m=p?o:o[e]||(o[e]={}),h=m.prototype,g=p?r:d?r[e]:(r[e]||{}).prototype;p&&(n=e);for(s in n)(f=!l&&g&&void 0!==g[s])&&s in m||(c=f?g[s]:n[s],m[s]=p&&"function"!=typeof g[s]?n[s]:y&&f?i(c,r):v&&g[s]==c?function(t){var e=function(e,n,r){if(this instanceof t){switch(arguments.length){case 0:return new t;case 1:return new t(e);case 2:return new t(e,n)}return new t(e,n,r)}return t.apply(this,arguments)};return e.prototype=t.prototype,e}(c):_&&"function"==typeof c?i(Function.call,c):c,_&&((m.virtual||(m.virtual={}))[s]=c,t&u.R&&h&&!h[s]&&a(h,s,c)))};u.F=1,u.G=2,u.S=4,u.P=8,u.B=16,u.W=32,u.U=64,u.R=128,t.exports=u},function(t,e){var n={}.hasOwnProperty;t.exports=function(t,e){return n.call(t,e)}},function(t,e){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on  "+t);return t}},function(t,e){var n=Math.ceil,r=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?r:n)(t)}},function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},function(t,e){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},function(t,e,n){var r=n(15);t.exports=function(t,e,n){if(r(t),void 0===e)return t;switch(n){case 1:return function(n){return t.call(e,n)};case 2:return function(n,r){return t.call(e,n,r)};case 3:return function(n,r,o){return t.call(e,n,r,o)}}return function(){return t.apply(e,arguments)}}},function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},function(t,e,n){var r=n(31),o=n(25);t.exports=Object.keys||function(t){return r(t,o)}},function(t,e,n){var r=n(3),o=n(0).document,i=r(o)&&r(o.createElement);t.exports=function(t){return i?o.createElement(t):{}}},function(t,e,n){var r=n(16);t.exports=Object("z").propertyIsEnumerable(0)?Object:function(t){return"String"==r(t)?t.split(""):Object(t)}},function(t,e,n){var r=n(3);t.exports=function(t,e){if(!r(t))return t;var n,o;if(e&&"function"==typeof(n=t.toString)&&!r(o=n.call(t)))return o;if("function"==typeof(n=t.valueOf)&&!r(o=n.call(t)))return o;if(!e&&"function"==typeof(n=t.toString)&&!r(o=n.call(t)))return o;throw TypeError("Can't convert object to primitive value")}},function(t,e){var n=0,r=Math.random();t.exports=function(t){return"Symbol(".concat(void 0===t?"":t,")_",(++n+r).toString(36))}},function(t,e){e.f={}.propertyIsEnumerable},function(t,e){t.exports="constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",")},function(t,e,n){t.exports=!n(1)&&!n(5)(function(){return 7!=Object.defineProperty(n(20)("div"),"a",{get:function(){return 7}}).a})},function(t,e,n){var r=n(28)("keys"),o=n(23);t.exports=function(t){return r[t]||(r[t]=o(t))}},function(t,e,n){var r=n(0),o=r["__core-js_shared__"]||(r["__core-js_shared__"]={});t.exports=function(t){return o[t]||(o[t]={})}},function(t,e){e.f=Object.getOwnPropertySymbols},function(t,e,n){t.exports={default:n(37),__esModule:!0}},function(t,e,n){var r=n(12),o=n(6),i=n(35)(!1),a=n(27)("IE_PROTO");t.exports=function(t,e){var n,u=o(t),s=0,f=[];for(n in u)n!=a&&r(u,n)&&f.push(n);for(;e.length>s;)r(u,n=e[s++])&&(~i(f,n)||f.push(n));return f}},function(t,e,n){var r=n(14),o=Math.min;t.exports=function(t){return t>0?o(r(t),9007199254740991):0}},function(t,e,n){var r=n(13);t.exports=function(t){return Object(r(t))}},,function(t,e,n){var r=n(6),o=n(32),i=n(36);t.exports=function(t){return function(e,n,a){var u,s=r(e),f=o(s.length),c=i(a,f);if(t&&n!=n){for(;f>c;)if((u=s[c++])!=u)return!0}else for(;f>c;c++)if((t||c in s)&&s[c]===n)return t||c||0;return!t&&-1}}},function(t,e,n){var r=n(14),o=Math.max,i=Math.min;t.exports=function(t,e){return t=r(t),t<0?o(t+e,0):i(t,e)}},function(t,e,n){n(40),t.exports=n(2).Object.assign},,function(t,e,n){"use strict";var r=n(19),o=n(29),i=n(24),a=n(33),u=n(21),s=Object.assign;t.exports=!s||n(5)(function(){var t={},e={},n=Symbol(),r="abcdefghijklmnopqrst";return t[n]=7,r.split("").forEach(function(t){e[t]=t}),7!=s({},t)[n]||Object.keys(s({},e)).join("")!=r})?function(t,e){for(var n=a(t),s=arguments.length,f=1,c=o.f,l=i.f;s>f;)for(var p,d=u(arguments[f++]),_=c?r(d).concat(c(d)):r(d),y=_.length,v=0;y>v;)l.call(d,p=_[v++])&&(n[p]=d[p]);return n}:s},function(t,e,n){var r=n(11);r(r.S+r.F,"Object",{assign:n(39)})},,,,,,,,,,,,,,,,,,,,,,,,function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(85),o=function(t){return t&&t.__esModule?t:{default:t}}(r);o.default.install=function(t){t.component(o.default.name,o.default)},e.default=o.default},,,,,,,,,,,,,,,,,,,,,function(t,e,n){var r=n(4)(n(98),n(153),null,null,null);t.exports=r.exports},,,,,,,,,,,,,function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(30),o=function(t){return t&&t.__esModule?t:{default:t}}(r),i=/^http:\/\/\s*$/,a={autoplay:3e3,lazyLoading:!0,lazyLoadingInPrevNext:!0,lazyPreloaderClass:"jfk-image__lazy--preload",slidesPerView:1,pagination:".swiper-pagination",paginationType:"fraction"};e.default={name:"JfkBanner",data:function(){return{bannerSwiperOptions:(0,o.default)({},a,this.swiperOptions,"full"!==this.type?{spaceBetween:12,slidesPerView:1.12}:{loop:!0,autoplayDisableOnInteraction:!1})}},methods:{hrefMethod:function(t){if(this.linkMethod)return this.linkMethod(t);if(this.linkKey){var e=t[this.linkKey]||"javascript:;";return i.test(e)?"javascript:;":e}return"javascript:;"},imgUrlMethod:function(t){return t[this.imgUrlKey]}},computed:{swiperBoxClass:function(){var t=this.swiperClass||"";return"full"!==this.type?t+" jfk-pt-30 jfk-ml-30":t}},props:{items:{type:Array,required:!0},type:{type:String,default:"full"},linkMethod:{type:Function},linkKey:{type:String,default:"link"},imgUrlKey:{type:String,default:"logo"},swiperClass:{type:String,default:""},swiperOptions:{type:Object}}}},,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"jfk-banner",class:{"is-full":"full"===t.type,"not-full":"full"!==t.type}},[1===t.items.length?t._m(0):n("swiper",{staticClass:"jfk-swiper",class:t.swiperBoxClass,attrs:{options:t.bannerSwiperOptions}},[t._l(t.items,function(e,r){return n("swiper-slide",{key:r,staticClass:"jfk-swiper__item"},[n("a",{staticClass:"jfk-swiper__item-box",attrs:{href:t.hrefMethod(e)}},[n("div",{staticClass:"jfk-banner__item-content jfk-swiper__item-bg swiper-lazy",attrs:{"data-background":t.imgUrlMethod(e)}},[n("div",{staticClass:"jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--4-2 jfk-image__lazy--background-image"}),t._v(" "),n("div",{staticClass:"jfk-banner__item-mask"})])])])}),t._v(" "),n("div",{staticClass:"swiper-pagination font-size--24",slot:"pagination"})],2)],1)},staticRenderFns:[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"jfk-banner__item is-one-item"},[n("a",{staticClass:"jfk-swiper__item-box",attrs:{href:t.hrefMethod(t.items[0])}},[n("div",{directives:[{name:"lazy",rawName:"v-lazy:background-image",value:t.imgUrlMethod(t.items[0]),expression:"imgUrlMethod(items[0])",arg:"background-image"}],staticClass:"jfk-swiper__item-bg jfk-banner__item-content jfk-image__lazy jfk-image__lazy--4-2 jfk-swiper__slide-content jfk-image__lazy-background-image"},[n("div",{staticClass:"jfk-banner__item-mask"})])])])}]}}])});