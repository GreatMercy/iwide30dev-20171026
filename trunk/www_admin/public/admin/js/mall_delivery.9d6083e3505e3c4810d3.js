webpackJsonp([18],{138:function(e,t){e.exports=function(e,t,r,o){var n,a=e=e||{},s=typeof e.default;"object"!==s&&"function"!==s||(n=e,a=e.default);var i="function"==typeof a?a.options:a;if(t&&(i.render=t.render,i.staticRenderFns=t.staticRenderFns),r&&(i._scopeId=r),o){var l=Object.create(i.computed||null);Object.keys(o).forEach(function(e){var t=o[e];l[e]=function(){return t}}),i.computed=l}return{esModule:n,exports:a,options:i}}},238:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={components:{},data:function(){return{formLabelWidth:"120px",fileList:[],form:{postProvider:""},rules:{postProvider:[{required:!0,message:"请输入快递服务商",trigger:"blur"}]}}},methods:{handleRemove:function(e,t){},handlePreview:function(e){},querySearchAsync:function(){return!1},send:function(){this.$refs.form.validate(function(e){if(!e)return!1})}}}},312:function(e,t,r){t=e.exports=r(75)(!1),t.push([e.i,".jfk-pages[data-v-2f47de26]{padding:15px}.post-wrap .jfk-container[data-v-2f47de26]{padding:15px 20px}.post-wrap .el-autocomplete[data-v-2f47de26]{width:100%}.post-wrap .delivery-btn[data-v-2f47de26]{margin-left:120px;text-align:center}",""])},341:function(e,t,r){var o=r(312);"string"==typeof o&&(o=[[e.i,o,""]]),o.locals&&(e.exports=o.locals);r(76)("53b655fd",o,!0)},378:function(e,t,r){r(341);var o=r(138)(r(238),r(400),"data-v-2f47de26",null);e.exports=o.exports},400:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"post-wrap jfk-pages"},[r("el-form",{ref:"form",attrs:{model:e.form,rules:e.rules}},[r("el-form-item",{attrs:{label:"快递服务商","label-width":e.formLabelWidth,prop:"postProvider"}},[r("el-row",[r("el-col",{attrs:{span:12}},[r("el-autocomplete",{attrs:{"fetch-suggestions":e.querySearchAsync,placeholder:"请输入快递服务商"},model:{value:e.form.postProvider,callback:function(t){e.form.postProvider=t},expression:"form.postProvider"}})],1)],1)],1),e._v(" "),r("el-form-item",{attrs:{label:"发货文件","label-width":e.formLabelWidth}},[r("el-row",[r("el-col",{attrs:{span:12}},[r("el-upload",{attrs:{action:"https://jsonplaceholder.typicode.com/posts/","on-preview":e.handlePreview,"on-remove":e.handleRemove,accept:"text/csv","file-list":e.fileList}},[r("el-button",{attrs:{size:"small",type:"primary"}},[e._v("点击上传")]),e._v(" "),r("div",{staticClass:"el-upload__tip",slot:"tip"},[e._v("请上传csv格式的文件，并确保快递单号无误")])],1)],1)],1)],1)],1),e._v(" "),r("el-row",[r("div",{staticClass:"delivery-btn"},[r("el-col",{attrs:{span:12}},[r("el-button",{attrs:{type:"primary"},on:{click:e.send}},[e._v("确定发货")])],1)],1)])],1)},staticRenderFns:[]}},88:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=r(2),n=r(378),a=r.n(n);t.default=function(){new o.default({el:"#app",render:function(e){return e(a.a)}})}}});