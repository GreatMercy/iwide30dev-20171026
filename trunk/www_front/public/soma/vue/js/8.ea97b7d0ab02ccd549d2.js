webpackJsonp([8],{199:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={data:function(){return{types:["default","primary","ghost"]}},created:function(){this.$jfkPrompt("确认接口和","标题",{showCloseButton:!0}).then(function(t){console.log(t,"resolve")}).catch(function(t){console.log(t,"reject")})}}},217:function(t,e,n){e=t.exports=n(27)(!1),e.push([t.i,"li{padding:90px}",""])},239:function(t,e,n){var s=n(217);"string"==typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);n(28)("21fbccb4",s,!0)},273:function(t,e,n){n(239);var s=n(2)(n(199),n(300),null,null);t.exports=s.exports},300:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"jfk-pages"},[n("div",{staticClass:"jfk-pages__theme"}),t._v(" "),n("ul",t._l(t.types,function(e){return n("li",[n("a",{staticClass:"jfk-button",class:"jfk-button--"+e,attrs:{href:"javascript:;"}},[t._v("测试按钮")]),t._v(" "),n("a",{staticClass:"jfk-button is-plain",class:"jfk-button--"+e,attrs:{href:"javascript:;"}},[t._v("测试按钮")])])}))])},staticRenderFns:[]}},38:function(t,e,n){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=n(1),o=s(a),c=n(273),l=s(c);e.default=function(){new o.default({el:"#app",template:"<App/>",components:{App:l.default}})}}});