!function(e,t){if("object"==typeof exports&&"object"==typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var i=t();for(var n in i)("object"==typeof exports?exports:e)[n]=i[n]}}(this,function(){return function(e){function t(n){if(i[n])return i[n].exports;var r=i[n]={i:n,l:!1,exports:{}};return e[n].call(r.exports,r,r.exports,t),r.l=!0,r.exports}var i={};return t.m=e,t.c=i,t.i=function(e){return e},t.d=function(e,i,n){t.o(e,i)||Object.defineProperty(e,i,{configurable:!1,enumerable:!0,get:n})},t.n=function(e){var i=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(i,"a",i),i},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="/",t(t.s=67)}({124:function(e,t,i){"use strict";var n=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("swiper",{staticClass:"jfk-swiper jfk-swiper__recommendation",attrs:{options:e.recommendationSwiperOptions}},e._l(e.lists,function(t,n){return i("swiper-slide",{key:n,class:{"jfk-swiper__item":!0,"jfk-swiper__item--empty":t._isEmpty}},[t._isEmpty?i("a",{attrs:{href:t._link}},[i("div",{staticClass:"jfk-swiper__item-box"}),e._v(" "),i("div",{staticClass:"jfk-swiper__item-info"}),e._v(" "),i("div",{staticClass:"empty-tip",domProps:{innerHTML:e._s(t._html||e.defaultEmptyHtml)}})]):i("a",{attrs:{href:t._link}},[i("div",{staticClass:"jfk-swiper__item-box"},[i("div",{staticClass:"jfk-swiper__item-bg swiper-lazy",attrs:{"data-background":t._img}},[i("div",{staticClass:"jfk-image__lazy--preload jfk-image__lazy jfk-image__lazy--3-3 jfk-image__lazy--background-image"}),e._v(" "),i("div",{staticClass:"jfk-swiper__item-mask"})])]),e._v(" "),i("div",{staticClass:"jfk-swiper__item-info"},[i("div",{staticClass:"info-box"},[i("h5",{staticClass:"title font-size--28 font-color-silver",domProps:{innerHTML:e._s(t._name)}}),e._v(" "),i("p",{staticClass:"price"},[i("span",{staticClass:"jfk-price color-golden font-size--38"},[i("i",{staticClass:"jfk-font-number jfk-price__currency"},[e._v("￥")]),e._v(" "),i("i",{staticClass:"jfk-font-number jfk-price__number"},[e._v(e._s(t._pricePackage))])]),e._v(" "),i("span",{staticClass:"jfk-price__original font-size--24 font-color-extra-light-gray"},[e._v("￥"+e._s(t._priceMarket))])])])])])])}))},r=[],s={render:n,staticRenderFns:r};t.a=s},18:function(e,t){e.exports=function(e,t,i,n,r){var s,a=e=e||{},o=typeof e.default;"object"!==o&&"function"!==o||(s=e,a=e.default);var l="function"==typeof a?a.options:a;t&&(l.render=t.render,l.staticRenderFns=t.staticRenderFns),n&&(l._scopeId=n);var f;if(r?(f=function(e){e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,e||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),i&&i.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(r)},l._ssrRegister=f):i&&(f=i),f){var c=l.functional,p=c?l.render:l.beforeCreate;c?l.render=function(e,t){return f.call(t),p(e,t)}:l.beforeCreate=p?[].concat(p,f):[f]}return{esModule:s,exports:a,options:l}}},67:function(e,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=i(74),r=function(e){return e&&e.__esModule?e:{default:e}}(n);r.default.install=function(e){e.component(r.default.name,r.default)},t.default=r.default},74:function(e,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=i(81),r=i.n(n),s=i(124),a=i(18),o=a(r.a,s.a,null,null,null);t.default=o.exports},81:function(e,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"jfk-recommendation",data:function(){return{defaultEmptyHtml:'<div class="jfk-flex is-justify-center is-align-middle"><div class="box"><p class="font-size--28 font-color-extra-light-gray zh">查看更多</p><p class="en font-size--24 font-color-light-gray">VIEW&nbsp;&nbsp;&nbsp;MORE</p></div></div>',lists:[],recommendationSwiperOptions:{autoplay:0,lazyLoading:!0,lazyLoadingInPrevNext:!0,lazyPreloaderClass:"jfk-image__lazy--preload",spaceBetween:15,slidesPerView:2.3571}}},created:function(){var e=[],t=this,i=3-t.items.length;if(i>0)for(var n=0;n<i;)t.items.push({_isEmpty:!0}),n++;e=t.items.map(function(e,i){return t.formatProductInfo?t.formatProductInfo(e,i):t.formatProductInfoInner(e,i)}),t.lists=e},methods:{formatProductInfoInner:function(e){return e._isEmpty?{_link:e._link||this.emptyLink,_html:this.defaultEmptyHtml,_isEmpty:!0}:{_link:this.linkPrefix+e.product_id,_img:e.face_img,_name:e.name,_pricePackage:e.killsec?e.killsec.killsec_price:e.price_package,_priceMarket:e.price_market}}},props:{formatProductInfo:{type:Function},items:{type:Array,required:!0},linkPrefix:{type:String},emptyLink:{type:String}}}}})});