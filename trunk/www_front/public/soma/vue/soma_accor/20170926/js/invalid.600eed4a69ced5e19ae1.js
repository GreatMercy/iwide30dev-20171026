webpackJsonp([22],{149:function(e,t,n){"use strict";function a(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var i=n(10),s=a(i),r=n(419),o=a(r);t.default=function(){new s.default({el:"#app",template:"<App/>",components:{App:o.default}})}},361:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=n(28),i=function(e){return e&&e.__esModule?e:{default:e}}(a),s=n(27);t.default={name:"invalid",data:function(){return{recommendations:[]}},beforeCreate:function(){var e=(0,i.default)(location.href);this.$pageNamespace(e)},created:function(){var e=this;(0,s.getPackageRecommendation)({page:1,page_size:100}).then(function(t){var n=t.web_data,a=n.products,i=n.page_resource;e.recommendations=a;var s=i.link,r=s.detail,o=s.home;e.detailUrl=r,e.indexUrl=o})}}},419:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=n(361),i=n.n(a),s=n(446),r=n(26),o=r(i.a,s.a,null,null,null);t.default=o.exports},446:function(e,t,n){"use strict";var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"jfk-pages jfk-pages__invalid"},[n("div",{staticClass:"jfk-pages__theme"}),e._v(" "),e._m(0),e._v(" "),e.recommendations.length?n("div",{staticClass:"recommendation jfk-pl-30"},[n("p",{staticClass:"font-size--24 font-color-light-gray-common tip"},[e._v("其他用户还看了")]),e._v(" "),n("div",{staticClass:"recommendations-list",class:{"jfk-pr-30":1==e.recommendations.length}},[n("jfk-recommendation",{attrs:{items:e.recommendations,linkPrefix:e.detailUrl,emptyLink:e.indexUrl}})],1)]):e._e(),e._v(" "),e._m(1)],1)},i=[function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"invalid_content"},[n("div",{staticClass:"invalid_icon"},[n("i",{staticClass:"jfk-font icon-mall_icon_remove"})]),e._v(" "),n("p",{staticClass:"font-size--28"},[e._v("很遗憾，商品已下架~")])])},function(){var e=this,t=e.$createElement;return(e._self._c||t)("JfkSupport")}],s={render:a,staticRenderFns:i};t.a=s}});