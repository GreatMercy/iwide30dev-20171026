webpackJsonp([0],{101:function(e,t,a){"use strict";function l(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=a(2),o=l(r),s=a(677),i=l(s);t.default=function(){new o.default({el:"#app",template:"<App/>",components:{App:i.default}})}},132:function(e,t){e.exports=function(e,t,a,l,r){var o,s=e=e||{},i=typeof e.default;"object"!==i&&"function"!==i||(o=e,s=e.default);var n="function"==typeof s?s.options:s;t&&(n.render=t.render,n.staticRenderFns=t.staticRenderFns),l&&(n._scopeId=l);var d;if(r?(d=function(e){e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,e||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),a&&a.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(r)},n._ssrRegister=d):a&&(d=a),d){var c=n.functional,p=c?n.render:n.beforeCreate;c?n.render=function(e,t){return d.call(t),p(e,t)}:n.beforeCreate=p?[].concat(p,d):[d]}return{esModule:o,exports:s,options:n}}},438:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"addrole",data:function(){return{activeBreadcrumb:!0,projectActiveName:"first",activeStep:1,checkAll:!0,cities:[],steps:[{step:1,title:"基础信息"},{step:2,title:"角色权限"}]}},methods:{}}},441:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={name:"roleList",data:function(){return{tableData:[{number:12333,name:"速八国际酒店",role_type:"管理员",create_time:"2017-04-23",status:"有效"},{number:345555,name:"七天连锁酒店",role_type:"管理员",create_time:"2017-08-03",status:"有效"}],methods:{deleteRow:function(e,t){t.splice(e,1)}}}}}},513:function(e,t,a){t=e.exports=a(76)(!1),t.push([e.i,'.add-role-outer .el-form-item .el-input,.add-role-outer .el-form-item .el-select{width:500px}.add-role-outer .table-outer{width:100%;border-collapse:collapse;border:1px solid #eee;margin-bottom:20px}.add-role-outer .table-outer .table-header{background-color:#f6f6f6}.add-role-outer .table-outer td{padding:10px 0;color:#1f2d3d;text-align:center;border:1px solid #eee;text-align:left;padding-left:20px}.add-role-outer .el-steps{width:1060px;overflow:hidden;margin-bottom:20px}.add-role-outer .all-outer{padding:15px 0}.add-role-outer .sub-item-list{margin-top:20px}.add-role-outer .sub-item-list li{list-style:none;padding-bottom:20px}.add-role-outer .sub-item-list li .table-inner{border:0;width:100%}.add-role-outer .sub-item-list li .table-inner tr{width:100%}.add-role-outer .sub-item-list li .table-inner td{border:0;padding:0}.add-role-outer .sub-item-list li:after{clear:both;height:0;display:block;content:""}.add-role-outer .sub-item-list li .sub-item{width:25%}.add-role-outer .sub-item-list li .sub-item-control{width:55%}.add-role-outer .sub-item-list li .sub-item-control .el-checkbox{margin-left:15px;margin-bottom:10px}.add-role-outer .el-tabs .el-tabs__header{border-bottom:0;background-color:#fff}.add-role-outer .el-tabs .el-tabs__nav{width:100%}.add-role-outer .el-tabs .el-tabs__nav .el-tabs__item{text-align:center;width:100px;height:30px;line-height:30px;background-color:#f6f6f6;padding:0;margin-left:30px}.add-role-outer .el-tabs .el-tabs__nav .el-tabs__item.is-active{background-color:#e9a801;color:#fff;border:0;border-radius:2px}',""])},528:function(e,t,a){t=e.exports=a(76)(!1),t.push([e.i,".role-list-outer[data-v-59ef131d]{color:#333;position:relative}.title[data-v-59ef131d]{font-size:16px;padding:15px;font-weight:700;background-color:#eef1f6}.add-new-btn[data-v-59ef131d]{float:right;margin-top:15px}.tips[data-v-59ef131d]{padding:20px;text-align:center;font-size:15px}.paging-block[data-v-59ef131d]{width:60%;height:32px;margin:0 auto;margin-top:20px;text-align:center}.paging-el[data-v-59ef131d]{float:right;vertical-align:middle;margin-left:10px}.page-infor[data-v-59ef131d]{float:left}.el-pagination[data-v-59ef131d]{float:right}",""])},611:function(e,t,a){var l=a(513);"string"==typeof l&&(l=[[e.i,l,""]]),l.locals&&(e.exports=l.locals);a(77)("1161ea8f",l,!0)},626:function(e,t,a){var l=a(528);"string"==typeof l&&(l=[[e.i,l,""]]),l.locals&&(e.exports=l.locals);a(77)("7b180c8a",l,!0)},674:function(e,t,a){"use strict";function l(e){a(611)}Object.defineProperty(t,"__esModule",{value:!0});var r=a(438),o=a.n(r),s=a(693),i=a(132),n=l,d=i(o.a,s.a,n,null,null);t.default=d.exports},677:function(e,t,a){"use strict";function l(e){a(626)}Object.defineProperty(t,"__esModule",{value:!0});var r=a(441),o=a.n(r),s=a(708),i=a(132),n=l,d=i(o.a,s.a,n,"data-v-59ef131d",null);t.default=d.exports},693:function(e,t,a){"use strict";var l=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"jfk-pages add-role-outer"},[a("el-row",[a("el-col",{attrs:{span:24}},[a("div",{staticClass:"grid-content bg-purple"},[a("el-steps",{staticClass:"jfk-steps--bg-gray jfk-steps",attrs:{space:1e3,active:e.activeStep,"finish-status":"success"}},[a("el-step",{attrs:{title:"基础信息"}}),e._v(" "),a("el-step",{attrs:{title:"角色权限"}})],1),e._v(" "),a("el-form",{ref:"form",attrs:{"label-width":"200px"}},[a("el-form-item",{attrs:{label:"选择公众号"}},[a("el-select",{attrs:{placeholder:"选择公众号"}},[a("el-option",{attrs:{label:"速八酒店",value:"速八酒店"}}),e._v(" "),a("el-option",{attrs:{label:"七天酒店",value:"七天酒店"}})],1)],1),e._v(" "),a("el-form-item",{attrs:{label:"关联角色"}},[a("el-select",{attrs:{placeholder:"关联角色"}},[a("el-option",{attrs:{label:"速八酒店前台",value:"速八酒店前台"}}),e._v(" "),a("el-option",{attrs:{label:"七天酒店前台",value:"七天酒店前台"}})],1)],1),e._v(" "),a("el-form-item",{attrs:{label:"自定义角色名称"}},[a("el-input")],1),e._v(" "),a("el-form-item",{attrs:{label:"状态"}},[a("el-select",{attrs:{placeholder:"状态"}},[a("el-option",{attrs:{label:"有效",value:"有效"}}),e._v(" "),a("el-option",{attrs:{label:"无效",value:"无效"}})],1)],1),e._v(" "),a("el-form-item",[a("el-button",{attrs:{type:"primary",size:"small"}},[e._v("下一步")])],1)],1),e._v(" "),a("el-form",{ref:"form",attrs:{"label-width":"200px"}},[a("el-form-item",{attrs:{label:"角色类型"}},[a("el-select",{attrs:{placeholder:"角色类型"}},[a("el-option",{attrs:{label:"标准角色",value:"标准角色"}}),e._v(" "),a("el-option",{attrs:{label:"管理员角色",value:"管理员角色"}})],1)],1),e._v(" "),a("el-form-item",{attrs:{label:"角色名称"}},[a("el-select",{attrs:{placeholder:"角色名称"}},[a("el-option",{attrs:{label:"速八酒店前台",value:"速八酒店前台"}}),e._v(" "),a("el-option",{attrs:{label:"七天酒店前台",value:"七天酒店前台"}})],1)],1),e._v(" "),a("el-form-item",{attrs:{label:"状态"}},[a("el-select",{attrs:{placeholder:"状态"}},[a("el-option",{attrs:{label:"有效",value:"有效"}}),e._v(" "),a("el-option",{attrs:{label:"无效",value:"无效"}})],1)],1),e._v(" "),a("el-form-item",[a("el-button",{attrs:{type:"primary",size:"small"}},[e._v("下一步")])],1)],1),e._v(" "),a("el-tabs",{attrs:{type:"card"},model:{value:e.projectActiveName,callback:function(t){e.projectActiveName=t},expression:"projectActiveName"}},[a("el-tab-pane",{attrs:{label:"订房",name:"first"}},[a("div",{staticClass:"all-outer"},[a("el-checkbox",{attrs:{indeterminate:e.isIndeterminate},on:{change:e.handleCheckAllChange}},[e._v("全选当前页所有\n              ")]),e._v(" "),a("el-checkbox",{attrs:{indeterminate:e.isIndeterminate},on:{change:e.handleCheckAllChange}},[e._v("\n                默认开通全部（含未来新功能）\n              ")])],1),e._v(" "),a("table",{staticClass:"table-outer"},[a("tr",{staticClass:"table-header"},[a("td",{attrs:{width:"30%"}},[e._v("权限")]),e._v(" "),a("td",{attrs:{width:"70%"}},[e._v("子项及操作")])]),e._v(" "),a("tr",[a("td",[a("el-checkbox",{staticStyle:{"margin-bottom":"5px"}},[e._v("订单管理")]),e._v(" "),a("br"),e._v(" "),a("el-checkbox",[e._v("全选")]),e._v(" "),a("el-checkbox",[e._v("全部")])],1),e._v(" "),a("td",[a("ul",{staticClass:"sub-item-list"},[a("li",[a("table",{staticClass:"table-inner"},[a("tr",[a("td",{staticClass:"sub-item"},[a("el-checkbox",[e._v("管理列表")])],1),e._v(" "),a("td",{staticClass:"sub-item-control"},[a("el-checkbox",[e._v("显示订单金额")]),e._v(" "),a("el-checkbox",[e._v("显示订单号")]),e._v(" "),a("el-checkbox",[e._v("显示昵称")])],1)])])]),e._v(" "),a("li",[a("table",{staticClass:"table-inner"},[a("tr",[a("td",{staticClass:"sub-item"},[a("el-checkbox",{model:{value:e.checked,callback:function(t){e.checked=t},expression:"checked"}},[e._v("查看列表")])],1),e._v(" "),a("td",{staticClass:"sub-item-control"},[a("el-checkbox",[e._v("显示订单金额")]),e._v(" "),a("el-checkbox",[e._v("显示订单号")]),e._v(" "),a("el-checkbox",[e._v("显示昵称")])],1)])])])]),e._v(" "),a("ul")])])])]),e._v(" "),a("el-tab-pane",{attrs:{label:"商城",name:"second"}}),e._v(" "),a("el-tab-pane",{attrs:{label:"会员",name:"third"}},[e._v("会员")]),e._v(" "),a("el-tab-pane",{attrs:{label:"分销",name:"fourth"}},[e._v("分销")]),e._v(" "),a("el-tab-pane",{attrs:{label:"快乐送",name:"fifth"}},[e._v("快乐送")]),e._v(" "),a("el-tab-pane",{attrs:{label:"快乐付",name:"sixth"}},[e._v("快乐付")])],1),e._v(" "),a("div",{staticStyle:{"text-align":"center"}},[a("el-button",{attrs:{type:"primary",size:"large"}},[e._v("完成")])],1)],1)])],1)],1)},r=[],o={render:l,staticRenderFns:r};t.a=o},708:function(e,t,a){"use strict";var l=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"jfk-pages role-list-outer"},[a("el-row",{staticClass:"title"},[a("el-col",{attrs:{span:24}},[a("div",{staticClass:"grid-content"},[e._v("角色列表")])])],1),e._v(" "),a("el-row",[a("el-col",{attrs:{span:4}},[a("div",{staticClass:"grid-content"},[a("div",{staticStyle:{"margin-top":"15px"}},[a("el-input",{attrs:{placeholder:"请输入名称/角色类型"}},[a("el-button",{attrs:{icon:"search"},slot:"append"},[e._v("搜索")])],1)],1)])]),e._v(" "),a("el-col",{attrs:{span:20}},[a("div",{staticClass:"grid-content"},[a("el-button",{staticClass:"add-new-btn",attrs:{type:"primary",size:"small",icon:"plus"}},[e._v("新增角色")])],1)])],1),e._v(" "),a("el-row",{staticClass:"role-list"},[a("el-col",{attrs:{span:24}},[a("div",{staticClass:"grid-content"},[a("div",{staticClass:"tips"},[e._v("您当前还未创建任何一个角色，赶紧新增一个吧！")]),e._v(" "),a("el-table",{attrs:{data:e.tableData,border:"",width:"100%"}},[a("el-table-column",{attrs:{prop:"number",label:"编号"}}),e._v(" "),a("el-table-column",{attrs:{prop:"name",label:"名称",width:"400"}}),e._v(" "),a("el-table-column",{attrs:{prop:"role_type",label:"角色类型"}}),e._v(" "),a("el-table-column",{attrs:{prop:"create_time",label:"创建时间"}}),e._v(" "),a("el-table-column",{attrs:{prop:"status",label:"状态"}}),e._v(" "),a("el-table-column",{attrs:{label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("el-button",{attrs:{type:"text",size:"small"},nativeOn:{click:function(a){a.preventDefault(),e.editRow(t.$index,e.tableData)}}},[e._v("\n                编辑\n              ")])]}}])})],1)],1)])],1),e._v(" "),a("div",{staticClass:"block paging-block"},[e._m(0),e._v(" "),a("el-pagination",{attrs:{"page-size":20,layout:"total, prev, pager, next",total:56}})],1)],1)},r=[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"page-infor"},[e._v("当前显示第  "),a("span",[e._v("3")]),e._v(" 纪录从  "),a("span",[e._v("1")]),e._v(" 到  "),a("span",[e._v("20")]),e._v(" ,共  "),a("span",[e._v("100")]),e._v(" 条\n    ")])}],o={render:l,staticRenderFns:r};t.a=o},98:function(e,t,a){"use strict";function l(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var r=a(2),o=l(r),s=a(674),i=l(s);t.default=function(){new o.default({el:"#app",template:"<App/>",components:{App:i.default}})}}});