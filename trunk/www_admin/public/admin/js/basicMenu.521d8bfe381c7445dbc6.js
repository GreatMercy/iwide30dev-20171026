webpackJsonp([42],{158:function(e,t){e.exports=function(e,t,l,c){var n,a=e=e||{},o=typeof e.default;"object"!==o&&"function"!==o||(n=e,a=e.default);var r="function"==typeof a?a.options:a;if(t&&(r.render=t.render,r.staticRenderFns=t.staticRenderFns),l&&(r._scopeId=l),c){var i=Object.create(r.computed||null);Object.keys(c).forEach(function(e){var t=c[e];i[e]=function(){return t}}),r.computed=i}return{esModule:n,exports:a,options:r}}},565:function(e,t,l){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var c=1e3;t.default={data:function(){return{menuData:[{id:1,label:"一级 1",children:[{id:4,label:"二级 1-1"}]},{id:2,label:"一级 2",children:[{id:5,label:"二级 2-1"},{id:6,label:"二级 2-2"}]},{id:3,label:"一级 3",children:[{id:7,label:"二级 3-1"},{id:8,label:"二级 3-2"}]}],defaultProps:{children:"children",label:"label"}}},created:function(){},methods:{append:function(e,t){e.append({id:c++,label:"testtest",children:[]},t)},remove:function(e,t){e.remove(t)},renderContent:function(e,t){var l=this,c=t.node,n=t.data,a=t.store;return e("span",null,[e("span",null,[e("span",null,[c.label])]),e("span",{style:"float: right; margin-right: 20px"},[e("i",{class:"el-icon-edit"},[]),e("i",{class:"el-icon-close",on:{click:function(){return l.remove(a,n)}}},[])])])}}}},728:function(e,t,l){t=e.exports=l(75)(!1),t.push([e.i,".page_menu .el-tree .el-checkbox{display:none}",""])},78:function(e,t,l){"use strict";function c(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var n=l(2),a=c(n),o=l(850),r=c(o);t.default=function(){new a.default({el:"#app",template:"<App/>",components:{App:r.default}})}},839:function(e,t,l){var c=l(728);"string"==typeof c&&(c=[[e.i,c,""]]),c.locals&&(e.exports=c.locals);l(76)("6b72c03c",c,!0)},850:function(e,t,l){l(839);var c=l(158)(l(565),l(954),null,null);e.exports=c.exports},954:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,l=e._self._c||t;return l("div",{staticClass:"jfk-pages page_menu"},[l("el-row",{attrs:{gutter:20,type:"flex",align:"middle"}},[l("el-col",{attrs:{span:12}},[l("el-tree",{staticStyle:{padding:"22px"},attrs:{data:e.menuData,props:e.defaultProps,"show-checkbox":"","node-key":"id","default-expand-all":"","expand-on-click-node":!1,"render-content":e.renderContent}})],1),e._v(" "),l("el-col",{staticStyle:{border:"1px solid rgb(209, 219, 229)",padding:"22px"},attrs:{span:12}},[l("el-form",{attrs:{"label-width":"90px"}},[l("el-form-item",{attrs:{label:"菜单名称"}},[l("el-input")],1),e._v(" "),l("el-form-item",{attrs:{label:"菜单类型"}},[l("el-input")],1),e._v(" "),l("el-form-item",{attrs:{label:"链接地址"}},[l("el-input")],1),e._v(" "),l("el-form-item",{attrs:{label:"适用公众号"}},[l("el-button",{attrs:{type:"text"}},[e._v("获取我管理的所有公众号")]),e._v(" "),l("p",[e._v("碧桂园酒店集团")]),e._v(" "),l("div",[l("div",[l("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("全选")])],1),e._v(" "),l("el-row",{attrs:{gutter:20}},[l("el-col",{attrs:{span:8}},[l("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("南京金陵酒店")])],1),e._v(" "),l("el-col",{attrs:{span:8}},[l("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("南京金陵酒店")])],1),e._v(" "),l("el-col",{attrs:{span:8}},[l("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("南京金陵酒店")])],1),e._v(" "),l("el-col",{attrs:{span:8}},[l("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("南京金陵酒店")])],1),e._v(" "),l("el-col",{attrs:{span:8}},[l("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("南京金陵酒店")])],1)],1),e._v(" "),l("p",[e._v("注：将重新设置所选酒店的公众号菜单")]),e._v(" "),l("div",{staticStyle:{"padding-left":"30px"}},[l("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("锁定(锁定后只能由多号管理员角色修改此菜单)")])],1)],1)],1)],1),e._v(" "),l("div",{staticStyle:{"text-align":"center"}},[l("el-button",[e._v("保存")])],1)],1)],1),e._v(" "),l("el-row",{staticStyle:{"margin-top":"22px"},attrs:{gutter:20}},[l("el-col",{staticStyle:{"text-align":"center"},attrs:{span:12}},[l("el-button",[e._v("新增一级菜单")]),e._v(" "),l("el-button",{attrs:{type:"primary"}},[e._v("生成菜单")])],1)],1)],1)},staticRenderFns:[]}}});