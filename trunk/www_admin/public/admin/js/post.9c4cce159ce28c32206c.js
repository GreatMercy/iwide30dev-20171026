webpackJsonp([5],{227:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a(361),o=a.n(r);t.default={components:{jfkList:o.a},data:function(){return{activeName:"first"}},methods:{handleClick:function(e,t){}}}},228:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={methods:{loadAll:function(){return[{value:'三全鲜食（北新泾店）", "address": "长宁区新渔路144号'},{value:'Hot honey 首尔炸鸡（仙霞路）", "address": "上海市长宁区淞虹路661号'},{value:'新旺角茶餐厅", "address": "上海市普陀区真北路988号创邑金沙谷6号楼113'},{value:'泷千家(天山西路店)", "address": "天山西路438号'}]},querySearchAsync:function(e,t){var a=this.restaurants,r=e?a.filter(this.createStateFilter(e)):a;clearTimeout(this.timeout),this.timeout=setTimeout(function(){t(r)},3e3*Math.random())},createStateFilter:function(e){return function(t){return 0===t.value.indexOf(e.toLowerCase())}},handleSelect:function(e){},send:function(){this.$refs.form.validate(function(e){if(!e)return!1})}},props:{dialogFormVisible:{type:Boolean,default:!1}},data:function(){return{restaurants:[],timeout:null,rules:{orderNumber:[{required:!0,message:"请输入快递单号",trigger:"blur"}],orderProvider:[{required:!0,message:"请输入快递服务商",trigger:"blur"}]},gridData:[{date:"2016-05-02",name:"王小虎",address:"上海市普陀区金沙江路 1518 弄"},{date:"2016-05-04",name:"王小虎",address:"上海市普陀区金沙江路 1518 弄"},{date:"2016-05-01",name:"王小虎",address:"上海市普陀区金沙江路 1518 弄"},{date:"2016-05-03",name:"王小虎",address:"上海市普陀区金沙江路 1518 弄"}],form:{orderNumber:"",orderProvider:""},formLabelWidth:"120px"}}}},229:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a(360),o=a.n(r);t.default={components:{jfkDialog:o.a},methods:{handleSizeChange:function(e){},handleCurrentChange:function(e){}},data:function(){return{dialogFormVisible:!1,currentPage:1,tableData:[{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1518 弄"},{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1517 弄"},{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1519 弄"},{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1516 弄"},{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1516 弄"},{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1516 弄"},{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1516 弄"},{date:"123412341234 2017-06-30 20:45:45",name:"金房卡大酒店",address:"上海市普陀区金沙江路 1516 弄"}],pickerOptions:{shortcuts:[{text:"今天",onClick:function(e){e.$emit("pick",new Date)}},{text:"昨天",onClick:function(e){var t=new Date;t.setTime(t.getTime()-864e5),e.$emit("pick",t)}},{text:"一周前",onClick:function(e){var t=new Date;t.setTime(t.getTime()-6048e5),e.$emit("pick",t)}}]},value:"",input:""}}}},284:function(e,t,a){t=e.exports=a(75)(!1),t.push([e.i,".el-autocomplete[data-v-056660e0]{width:100%}",""])},308:function(e,t,a){t=e.exports=a(75)(!1),t.push([e.i,".post-pages.jfk-pages[data-v-b2ea8d94]{padding:0;margin:0}.post-pages .table-content[data-v-b2ea8d94]{margin-top:10px}.post-pages .el-col[data-v-b2ea8d94]{margin-bottom:10px}.post-pages .pagination[data-v-b2ea8d94]{margin-top:20px}.post-pages .pagination .el-pagination[data-v-b2ea8d94]{display:inline-block}",""])},310:function(e,t,a){t=e.exports=a(75)(!1),t.push([e.i,".jfk-pages[data-v-e8910c54]{padding:15px}.post-wrap .jfk-container[data-v-e8910c54]{padding:15px 20px}",""])},312:function(e,t,a){var r=a(284);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);a(76)("9ca19800",r,!0)},336:function(e,t,a){var r=a(308);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);a(76)("6d972a81",r,!0)},338:function(e,t,a){var r=a(310);"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);a(76)("29f837d6",r,!0)},359:function(e,t,a){a(338);var r=a(94)(a(227),a(394),"data-v-e8910c54",null);e.exports=r.exports},360:function(e,t,a){a(312);var r=a(94)(a(228),a(369),"data-v-056660e0",null);e.exports=r.exports},361:function(e,t,a){a(336);var r=a(94)(a(229),a(392),"data-v-b2ea8d94",null);e.exports=r.exports},369:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("el-dialog",{attrs:{title:"发货",visible:e.dialogFormVisible,"close-on-press-escape":!1,"close-on-click-modal":!1,size:"tiny"},on:{"update:visible":function(t){e.dialogFormVisible=t}}},[a("el-form",{ref:"form",attrs:{model:e.form,rules:e.rules}},[a("el-form-item",{attrs:{label:"快递单号","label-width":e.formLabelWidth,prop:"orderNumber"}},[a("el-row",[a("el-col",{attrs:{span:24}},[a("el-input",{attrs:{"auto-complete":"off"},model:{value:e.form.orderNumber,callback:function(t){e.form.orderNumber=t},expression:"form.orderNumber"}})],1)],1)],1),e._v(" "),a("el-form-item",{attrs:{label:"快递服务商","label-width":e.formLabelWidth,prop:"orderProvider"}},[a("el-row",[a("el-col",{attrs:{span:24}},[a("el-autocomplete",{attrs:{"fetch-suggestions":e.querySearchAsync,placeholder:"请输入快递服务商"},on:{select:e.handleSelect},model:{value:e.form.orderProvider,callback:function(t){e.form.orderProvider=t},expression:"form.orderProvider"}})],1)],1)],1)],1),e._v(" "),a("div",{staticClass:"dialog-footer",slot:"footer"},[a("el-button",{attrs:{type:"primary"},on:{click:e.send}},[e._v("确定发货")])],1)],1)],1)},staticRenderFns:[]}},392:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"post-pages jfk-pages"},[a("el-row",[a("el-col",{attrs:{span:12}},[a("el-date-picker",{attrs:{type:"datetime",placeholder:"选择日期时间",align:"left","picker-options":e.pickerOptions},model:{value:e.value,callback:function(t){e.value=t},expression:"value"}})],1),e._v(" "),a("el-col",{attrs:{span:12}},[a("el-row",[a("el-col",{attrs:{span:12}},[a("el-input",{attrs:{placeholder:"请输入内容"},model:{value:e.input,callback:function(t){e.input=t},expression:"input"}})],1),e._v(" "),a("el-col",{attrs:{span:4,offset:1}},[a("el-button",{attrs:{type:"primary",icon:"search"}},[e._v("查找")])],1),e._v(" "),a("el-col",{attrs:{span:4}},[a("el-button",{attrs:{type:"primary"}},[e._v("导出报表")])],1)],1)],1)],1),e._v(" "),a("el-row",[a("el-col",[a("el-button",{attrs:{type:"primary"}},[e._v("导入报表发货")])],1)],1),e._v(" "),a("el-row",[a("div",{staticClass:"table-content"},[a("el-table",{attrs:{data:e.tableData}},[a("el-table-column",{attrs:{prop:"date",label:"物流序号&提交时间",width:"108","show-overflow-tooltip":"",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"name",label:"商品名称",width:"180","show-overflow-tooltip":"",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"address",label:"订单价格&数量",width:"108","show-overflow-tooltip":"",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"address",label:"订单号／订单实付",width:"108","show-overflow-tooltip":"",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"address",label:"收件人&联系电话",width:"108","show-overflow-tooltip":"",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"address",label:"地址","show-overflow-tooltip":"",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{prop:"address",label:"分销员姓名&ID",width:"108","show-overflow-tooltip":"",align:"center"}}),e._v(" "),a("el-table-column",{attrs:{label:"物流公司&快递单号",width:"108","show-overflow-tooltip":"",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("el-button",{attrs:{type:"primary",size:"small"},on:{click:function(t){e.dialogFormVisible=!0}}},[e._v("发货")])]}}])}),e._v(" "),a("el-table-column",{attrs:{label:"详情",width:"108","show-overflow-tooltip":"",align:"center"},scopedSlots:e._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"primary",icon:"search",size:"small"}})]}}])})],1)],1)]),e._v(" "),a("el-row",[a("div",{staticClass:"pagination jfk-ta-c"},[a("el-pagination",{attrs:{"current-page":e.currentPage,"page-sizes":[100,200,300,400],"page-size":100,layout:"total, sizes, prev, pager, next, jumper",total:400},on:{"size-change":e.handleSizeChange,"current-change":e.handleCurrentChange}})],1)]),e._v(" "),a("jfk-dialog",{attrs:{dialogFormVisible:e.dialogFormVisible}})],1)},staticRenderFns:[]}},394:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"post-wrap jfk-pages"},[a("el-tabs",{attrs:{type:"card"},on:{"tab-click":e.handleClick},model:{value:e.activeName,callback:function(t){e.activeName=t},expression:"activeName"}},[a("el-tab-pane",{attrs:{label:"全部",name:"first"}},[a("div",{staticClass:"jfk-container"},[a("jfk-list")],1)]),e._v(" "),a("el-tab-pane",{attrs:{label:"未发货",name:"second"}}),e._v(" "),a("el-tab-pane",{attrs:{label:"已发货",name:"third"}})],1)],1)},staticRenderFns:[]}},87:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a(2),o=a(359),n=a.n(o);t.default=function(){new r.default({el:"#app",render:function(e){return e(n.a)}})}},94:function(e,t){e.exports=function(e,t,a,r){var o,n=e=e||{},l=typeof e.default;"object"!==l&&"function"!==l||(o=e,n=e.default);var s="function"==typeof n?n.options:n;if(t&&(s.render=t.render,s.staticRenderFns=t.staticRenderFns),a&&(s._scopeId=a),r){var i=Object.create(s.computed||null);Object.keys(r).forEach(function(e){var t=r[e];i[e]=function(){return t}}),s.computed=i}return{esModule:o,exports:n,options:s}}}});