!function(e,t){if("object"==typeof exports&&"object"==typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var n=t();for(var r in n)("object"==typeof exports?exports:e)[r]=n[r]}}(this,function(){return function(e){function t(r){if(n[r])return n[r].exports;var u=n[r]={i:r,l:!1,exports:{}};return e[r].call(u.exports,u,u.exports,t),u.l=!0,u.exports}var n={};return t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:r})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="/",t(t.s=69)}({1:function(e,t){e.exports=function(e,t,n,r,u){var i,a=e=e||{},o=typeof e.default;"object"!==o&&"function"!==o||(i=e,a=e.default);var s="function"==typeof a?a.options:a;t&&(s.render=t.render,s.staticRenderFns=t.staticRenderFns),r&&(s._scopeId=r);var c;if(u?(c=function(e){e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,e||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(u)},s._ssrRegister=c):n&&(c=n),c){var l=s.functional,f=l?s.render:s.beforeCreate;l?s.render=function(e,t){return c.call(t),f(e,t)}:s.beforeCreate=f?[].concat(f,c):[c]}return{esModule:i,exports:a,options:s}}},101:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"jfkRater",created:function(){this.currentValue=this.value},mounted:function(){this.updateStyle()},props:{max:{type:Number,default:5},value:{type:Number,default:0},disabled:Boolean,star:{type:String,default:"★"},margin:{type:Number,default:2},fontSize:{type:Number,default:25}},computed:{sliceValue:function(){var e=this.currentValue.toFixed(2).split(".");return 1===e.length?[e[0],0]:e},cutIndex:function(){return 1*this.sliceValue[0]},cutPercent:function(){return 1*this.sliceValue[1]}},methods:{handleClick:function(e,t){this.disabled&&!t||(this.currentValue===e+1?(this.currentValue=e,this.updateStyle()):this.currentValue=e+1)},updateStyle:function(){for(var e=0;e<this.max;e++)e<=this.currentValue-1?this.$set(this.colors,e,this.activeColor):this.$set(this.colors,e,"#ccc")}},data:function(){return{colors:[],currentValue:0}},watch:{currentValue:function(e){this.updateStyle(),this.$emit("input",e)},value:function(e){this.currentValue=e}}}},146:function(e,t,n){"use strict";var r=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"jfk-rater"},[n("input",{directives:[{name:"model",rawName:"v-model",value:e.currentValue,expression:"currentValue"}],staticStyle:{display:"none"},domProps:{value:e.currentValue},on:{input:function(t){t.target.composing||(e.currentValue=t.target.value)}}}),e._v(" "),e._l(e.max,function(t){return n("a",{staticClass:"jfk-rater-box jfk-rater__default",class:{"jfk-rater__active":e.currentValue>0&&e.currentValue>t-1&&e.cutIndex!==t-1},style:{marginRight:e.margin+"px",fontSize:e.fontSize+"px",width:e.fontSize+"px",height:e.fontSize+"px",lineHeight:e.fontSize+"px"},on:{click:function(n){e.handleClick(t-1)}}},[n("span",{staticClass:"jfk-rater-inner"},[e._v(e._s(e.star)),e.cutPercent>0&&e.cutIndex===t-1?n("span",{staticClass:"jfk-rater-outer jfk-rater__active",style:{width:e.cutPercent+"%"}},[e._v(e._s(e.star))]):e._e()])])})],2)},u=[],i={render:r,staticRenderFns:u};t.a=i},69:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n(83),u=function(e){return e&&e.__esModule?e:{default:e}}(r);u.default.install=function(e){e.component(u.default.name,u.default)},t.default=u.default},83:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n(101),u=n.n(r),i=n(146),a=n(1),o=a(u.a,i.a,null,null,null);t.default=o.exports}})});