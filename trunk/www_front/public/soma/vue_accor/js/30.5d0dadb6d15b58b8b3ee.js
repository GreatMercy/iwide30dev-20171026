webpackJsonp([30],{165:function(t,e,s){!function(e,s){t.exports=s()}(0,function(){return function(t){function e(n){if(s[n])return s[n].exports;var i=s[n]={i:n,l:!1,exports:{}};return t[n].call(i.exports,i,i.exports,e),i.l=!0,i.exports}var s={};return e.m=t,e.c=s,e.i=function(t){return t},e.d=function(t,s,n){e.o(t,s)||Object.defineProperty(t,s,{configurable:!1,enumerable:!0,get:n})},e.n=function(t){var s=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(s,"a",s),s},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/",e(e.s=47)}({47:function(t,e,s){"use strict";function n(t){return(t<10?"0":"")+t}Object.defineProperty(e,"__esModule",{value:!0}),e.default=n}})})},175:function(t,e,s){!function(e,s){t.exports=s()}(0,function(){return function(t){function e(n){if(s[n])return s[n].exports;var i=s[n]={i:n,l:!1,exports:{}};return t[n].call(i.exports,i,i.exports,e),i.l=!0,i.exports}var s={};return e.m=t,e.c=s,e.i=function(t){return t},e.d=function(t,s,n){e.o(t,s)||Object.defineProperty(t,s,{configurable:!1,enumerable:!0,get:n})},e.n=function(t){var s=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(s,"a",s),s},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/",e(e.s=166)}({0:function(t,e){var s=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=s)},1:function(t,e,s){t.exports=!s(5)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},15:function(t,e,s){var n=s(19);t.exports=function(t,e,s){if(n(t),void 0===e)return t;switch(s){case 1:return function(s){return t.call(e,s)};case 2:return function(s,n){return t.call(e,s,n)};case 3:return function(s,n,i){return t.call(e,s,n,i)}}return function(){return t.apply(e,arguments)}}},16:function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},160:function(t,e,s){"use strict";function n(t){var e=parseInt(t/a),s=e*a,n=parseInt((t-s)/o),c=n*o,l=parseInt((t-s-c)/r);return{dates:e,hours:n,minutes:l,seconds:parseInt((t-s-c-l*r)/i)}}Object.defineProperty(e,"__esModule",{value:!0}),e.default=n;var i=1e3,r=6e4,o=60*r,a=24*o},161:function(t,e,s){"use strict";e.__esModule=!0,e.default=function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}},162:function(t,e,s){"use strict";e.__esModule=!0;var n=s(170),i=function(t){return t&&t.__esModule?t:{default:t}}(n);e.default=function(){function t(t,e){for(var s=0;s<e.length;s++){var n=e[s];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),(0,i.default)(t,n.key,n)}}return function(e,s,n){return s&&t(e.prototype,s),n&&t(e,n),e}}()},166:function(t,e,s){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var i=s(161),r=n(i),o=s(162),a=n(o),c=s(160),l=n(c),u=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return(0,r.default)(this,t),this.options=e,!1!==this.options.auto&&this.start(),this}return(0,a.default)(t,[{key:"start",value:function(t){var e=this;if(!e._hasStarted||t){e._hasStarted=!0;var s=this.options,n=s.callback,i=s.start,r=s.end,o=s.rate,a=void 0===o?1e3:o,c=s.countdown;if(t&&e.close(),this.status=1,c){var u=c;e.interval=setInterval(function(){e.process=2;var t=(0,l.default)(u);e.dates=t.dates,e.hours=t.hours,e.minutes=t.minutes,e.seconds=t.seconds,e._hasStartTrigger||(e.status&&n&&n("on-start",u,e),e._hasStartTrigger=!0),u<=0&&(e.process=0,e.status&&n&&n("on-finish",u,e),e.close()),e.status&&n&&n("is-change",u,e),u-=a,u=Math.max(0,u)},a)}else e.interval=setInterval(function(){var t=Date.now(),s=t-i,o=r-t;if(s<0){e.process=1;var a=(0,l.default)(-s);e.dates=a.dates,e.hours=a.hours,e.minutes=a.minutes,e.seconds=a.seconds}else if(o>0||0===s){e.process=2;var c=(0,l.default)(o);e.dates=c.dates,e.hours=c.hours,e.minutes=c.minutes,e.seconds=c.seconds,s>0&&!e._hasStartTrigger?(e._hasStartTrigger=!0,e.status&&n&&n("has-start",t,e)):0===s&&e.status&&n&&n("on-start",t,e)}else e.process=0,e.status&&n&&n(0===o?"on-finish":"has-finish",t,e),e.close();e.status&&n&&n("is-change",t,e)},a)}return this}},{key:"close",value:function(){return void 0!==this.interval&&(clearInterval(this.interval),this.status=0,!0)}}]),t}();e.default=u},17:function(t,e,s){var n=s(0),i=s(4),r=s(15),o=s(9),a=function(t,e,s){var c,l,u,f=t&a.F,d=t&a.G,v=t&a.S,p=t&a.P,h=t&a.B,m=t&a.W,_=d?i:i[e]||(i[e]={}),k=_.prototype,b=d?n:v?n[e]:(n[e]||{}).prototype;d&&(s=e);for(c in s)(l=!f&&b&&void 0!==b[c])&&c in _||(u=l?b[c]:s[c],_[c]=d&&"function"!=typeof b[c]?s[c]:h&&l?r(u,n):m&&b[c]==u?function(t){var e=function(e,s,n){if(this instanceof t){switch(arguments.length){case 0:return new t;case 1:return new t(e);case 2:return new t(e,s)}return new t(e,s,n)}return t.apply(this,arguments)};return e.prototype=t.prototype,e}(u):p&&"function"==typeof u?r(Function.call,u):u,p&&((_.virtual||(_.virtual={}))[c]=u,t&a.R&&k&&!k[c]&&o(k,c,u)))};a.F=1,a.G=2,a.S=4,a.P=8,a.B=16,a.W=32,a.U=64,a.R=128,t.exports=a},170:function(t,e,s){t.exports={default:s(171),__esModule:!0}},171:function(t,e,s){s(172);var n=s(4).Object;t.exports=function(t,e,s){return n.defineProperty(t,e,s)}},172:function(t,e,s){var n=s(17);n(n.S+n.F*!s(1),"Object",{defineProperty:s(7).f})},19:function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},20:function(t,e,s){var n=s(3),i=s(0).document,r=n(i)&&n(i.createElement);t.exports=function(t){return r?i.createElement(t):{}}},22:function(t,e,s){var n=s(3);t.exports=function(t,e){if(!n(t))return t;var s,i;if(e&&"function"==typeof(s=t.toString)&&!n(i=s.call(t)))return i;if("function"==typeof(s=t.valueOf)&&!n(i=s.call(t)))return i;if(!e&&"function"==typeof(s=t.toString)&&!n(i=s.call(t)))return i;throw TypeError("Can't convert object to primitive value")}},26:function(t,e,s){t.exports=!s(1)&&!s(5)(function(){return 7!=Object.defineProperty(s(20)("div"),"a",{get:function(){return 7}}).a})},3:function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},4:function(t,e){var s=t.exports={version:"2.4.0"};"number"==typeof __e&&(__e=s)},5:function(t,e){t.exports=function(t){try{return!!t()}catch(t){return!0}}},7:function(t,e,s){var n=s(8),i=s(26),r=s(22),o=Object.defineProperty;e.f=s(1)?Object.defineProperty:function(t,e,s){if(n(t),e=r(e,!0),n(s),i)try{return o(t,e,s)}catch(t){}if("get"in s||"set"in s)throw TypeError("Accessors not supported!");return"value"in s&&(t[e]=s.value),t}},8:function(t,e,s){var n=s(3);t.exports=function(t){if(!n(t))throw TypeError(t+" is not an object!");return t}},9:function(t,e,s){var n=s(7),i=s(16);t.exports=s(1)?function(t,e,s){return n.f(t,e,i(1,s))}:function(t,e,s){return t[e]=s,t}}})})},344:function(t,e,s){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var i=s(29),r=n(i),o=s(175),a=n(o),c=s(165),l=n(c),u=s(27);e.default={name:"product-killsec",data:function(){return{interval:0,visible:!1,killsecTime:{},killsecParams:{dates:"0",hours:"00",minutes:"00",seconds:"00",process:0},killsecStock:"0",killsecTotal:"0",killsecPercent:"0%",showKillsecModule:!1}},computed:{numClass:function(){return this.killsecParams.dates<10?"font-size--48":"font-size--44"}},methods:{getKillsecStockInfo:function(){var t=this;(0,u.getKillsecStock)({act_id:this.killsec.act_id}).then(function(e){var s=e.web_data,n=s.percent,i=s.stock,r=s.total;t.killsecStock=i,t.killsecTotal=r,t.killsecPercent=100-n+"%"}).catch(function(){t.stopCycleGetKillsecStock(),t.$emit("killsec-finish",0),t.visible=!1,t.killsecTime.close&&t.killsecTime.close()})},stopCycleGetKillsecStock:function(){clearInterval(this.interval)}},created:function(){var t=this,e=this.killsec,s=e.finish,n=e.killsec_time,i=e.end_time,o=e.stock_reflesh_rate;n=n.replace(/-/g,"/"),i=i.replace(/-/g,"/");var c=Date.now(),u=new Date(n).getTime(),f=new Date(i).getTime(),d=!1;if(!s&&c<f){t.getKillsecStockInfo();var v=1e3*u-6e4;t.killsecTime=new a.default({start:u,end:f,callback:function(e,s,n){t.visible=!0,0===n.process?(t.visible=!1,n.close(),t.stopCycleGetKillsecStock(),this.$emit("killsec-status",4)):2===n.process?d||(t.$emit("killsec-status",3),d=!0,t.interval=setInterval(function(){t.getKillsecStockInfo()},o)):1===n.process&&t.$emit("killsec-status",s<v?1:2),t.killsecParams=(0,r.default)({},t.killsecParams,{dates:""+n.dates,hours:(0,l.default)(n.hours),minutes:(0,l.default)(n.minutes),seconds:(0,l.default)(n.seconds),process:n.process})}})}else t.$emit("killsec-status",s?5:4),t.visible=!1},props:{killsec:{type:Object,required:!0}},beforeDestroy:function(){this.killsecTime.close&&this.killsecTime.close()}}},400:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=s(344),i=s.n(n),r=s(445),o=s(26),a=o(i.a,r.a,null,null,null);e.default=a.exports},445:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{directives:[{name:"show",rawName:"v-show",value:t.visible,expression:"visible"}],staticClass:"killsec-box",class:{"is-hidden":!t.visible,"is-show":t.visible}},[s("div",{staticClass:"killsec"},[s("div",{staticClass:"layer"}),t._v(" "),s("div",{staticClass:"box jfk-flex is-align-middle"},[s("div",{staticClass:"cont"},[s("div",{staticClass:"time"},[s("span",{staticClass:"tip jfk-d-ib color-golden font-size--24"},[t._v("距离"+t._s(1===t.killsecParams.process?"开始":"结束"))]),t._v(" "),s("span",{staticClass:"clock jfk-d-ib"},[s("i",{directives:[{name:"show",rawName:"v-show",value:t.killsecParams.dates>0,expression:"killsecParams.dates > 0"}],staticClass:"num jfk-d-ib font-color-white date",class:t.numClass},[t._v(t._s(t.killsecParams.dates))]),t._v(" "),s("i",{directives:[{name:"show",rawName:"v-show",value:t.killsecParams.dates>0,expression:"killsecParams.dates > 0"}],staticClass:"unit font-size--22 jfk-d-ib font-color-light-gray-common"},[t._v("天")]),t._v(" "),s("i",{staticClass:"num jfk-d-ib font-color-white",class:t.numClass},[t._v(t._s(t.killsecParams.hours))]),t._v(" "),s("i",{staticClass:"unit font-size--22 jfk-d-ib font-color-light-gray-common"},[t._v("时")]),t._v(" "),s("i",{staticClass:"num jfk-d-ib font-color-white",class:t.numClass},[t._v(t._s(t.killsecParams.minutes))]),t._v(" "),s("i",{staticClass:"unit font-size--22 jfk-d-ib font-color-light-gray-common"},[t._v("分")]),t._v(" "),s("i",{staticClass:"num jfk-d-ib font-color-white",class:t.numClass},[t._v(t._s(t.killsecParams.seconds))]),t._v(" "),s("i",{staticClass:"unit font-size--22 jfk-d-ib font-color-light-gray-common"},[t._v("秒")])])]),t._v(" "),s("div",{staticClass:"process"},[s("div",{staticClass:"line"},[s("div",{staticClass:"line-cont",style:{width:t.killsecPercent}},[s("div",{staticClass:"line-line"})])])]),t._v(" "),s("div",{staticClass:"number font-color-light-gray font-size--24"},[s("span",{staticClass:"tip jfk-d-ib"},[t._v("剩余库存")]),t._v(" "),s("span",{staticClass:"stock jfk-d-ib"},[t._v(t._s(t.killsecStock)+" /")]),t._v(" "),s("span",{staticClass:"total jfk-d-ib"},[t._v(t._s(t.killsecTotal))])])])]),t._v(" "),s("div",{staticClass:"mask"})])])},i=[],r={render:n,staticRenderFns:i};e.a=r}});