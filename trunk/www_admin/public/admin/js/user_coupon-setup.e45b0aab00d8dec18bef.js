webpackJsonp([17],{232:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={name:"coupon-setup",data:function(){return{form:{msg:""}}},methods:{}}},290:function(t,e,s){e=t.exports=s(75)(!1),e.push([t.i,"#coupon-setup .el-form-item__label{width:150px;margin-right:15px}#coupon-setup .steup-auto-width .el-form-item__content{margin-left:165px}#coupon-setup .steup-msg-title{margin-bottom:10px}#coupon-setup .steup-msg-word{font-size:15px;color:gray}",""])},318:function(t,e,s){var a=s(290);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);s(76)("29825c0c",a,!0)},364:function(t,e,s){s(318);var a=s(94)(s(232),s(375),null,null);t.exports=a.exports},375:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{attrs:{id:"coupon-setup"}},[t._m(0),t._v(" "),s("div",[s("el-row",[s("el-col",{attrs:{span:11}},[s("el-col",{staticClass:"choice-step-num",attrs:{span:4}},[t._v("\n\t\t\t  \t \t01\n\t\t\t  \t")]),t._v(" "),s("el-col",{attrs:{span:20}},[s("p",{staticClass:"choice-step-title"},[t._v("选择优惠券发放内容和目标用户")]),t._v(" "),s("p",{staticClass:"choice-step-word"},[t._v("选择发送的优惠券或礼包，并选择需要发送的用户群体")])])],1),t._v(" "),s("el-col",{staticClass:"jfk-ta-c",attrs:{span:2}},[s("div",{staticClass:"choice-line"})]),t._v(" "),s("el-col",{attrs:{span:11}},[s("el-col",{staticClass:"choice-step-num choice-step-active",attrs:{span:4}},[t._v("\n\t\t\t  \t \t02\n\t\t\t  \t")]),t._v(" "),s("el-col",{attrs:{span:20}},[s("p",{staticClass:"choice-step-title"},[t._v("设置模版消息")]),t._v(" "),s("p",{staticClass:"choice-step-word"},[t._v("设置一个模版消息，给收到优惠的用户发送一个模版消息")])])],1)],1)],1),t._v(" "),s("el-form",{ref:"form",attrs:{model:t.form}},[s("div",{staticClass:"jfk-fieldset__hd"},[s("div",{staticClass:"jfk-fieldset__title"},[t._v("选择发送内容")])]),t._v(" "),s("div",[s("el-form-item",{attrs:{label:"是否发送模版消息?"}},[s("el-radio-group",{model:{value:t.form.sendmsg,callback:function(e){t.form.sendmsg=e},expression:"form.sendmsg"}},[s("el-radio",{attrs:{label:"是",checked:""}}),t._v(" "),s("el-radio",{attrs:{label:"否"}})],1)],1),t._v(" "),s("el-form-item",{attrs:{label:"模版消息"}},[s("p",[t._v("会员权益到帐通知")])]),t._v(" "),s("el-form-item",{attrs:{label:"模版ID"}},[s("el-input",{staticStyle:{width:"250px"},attrs:{placeholder:""},model:{value:t.form.id,callback:function(e){t.form.id=e},expression:"form.id"}})],1),t._v(" "),s("div",{staticClass:"el-form--inline"},[s("el-form-item",{attrs:{label:"跳转链接"}},[s("el-radio",{attrs:{label:"",checked:""}})],1),t._v(" "),s("el-form-item",{attrs:{label:""}},[s("el-select",{staticStyle:{width:"120px"},attrs:{placeholder:"优惠券列表"},model:{value:t.form.package,callback:function(e){t.form.package=e},expression:"form.package"}},[s("el-option",{attrs:{label:"100优惠券",value:"100"}}),t._v(" "),s("el-option",{attrs:{label:"200优惠券",value:"200"}})],1)],1),t._v(" "),s("el-form-item",{staticStyle:{"margin-left":"20px"},attrs:{label:""}},[s("el-radio",{attrs:{label:"自定义链接",checked:""}})],1),t._v(" "),s("el-form-item",{attrs:{label:""}},[s("el-input",{staticStyle:{width:"250px"},attrs:{placeholder:""},model:{value:t.form.id,callback:function(e){t.form.id=e},expression:"form.id"}})],1),t._v(" "),s("el-form-item",{staticStyle:{"margin-left":"20px"},attrs:{label:""}},[s("el-radio",{attrs:{label:"无跳转",checked:""}})],1)],1)],1),t._v(" "),s("div",{staticClass:"jfk-fieldset__hd"},[s("div",{staticClass:"jfk-fieldset__title"},[t._v("消息内容")])]),t._v(" "),s("el-form-item",{staticClass:"steup-auto-width",attrs:{label:"frist"}},[s("el-input",{attrs:{placeholder:""},model:{value:t.form.frist,callback:function(e){t.form.frist=e},expression:"form.frist"}})],1),t._v(" "),s("el-form-item",{staticClass:"steup-auto-width",attrs:{label:"keyword1"}},[s("el-input",{attrs:{placeholder:""},model:{value:t.form.keyword1,callback:function(e){t.form.keyword1=e},expression:"form.keyword1"}})],1),t._v(" "),s("el-form-item",{staticClass:"steup-auto-width",attrs:{label:"keyword2"}},[s("el-input",{attrs:{placeholder:""},model:{value:t.form.keyword2,callback:function(e){t.form.keyword2=e},expression:"form.keyword2"}})],1),t._v(" "),s("el-form-item",{staticClass:"steup-auto-width",attrs:{label:"keyword3"}},[s("el-input",{attrs:{placeholder:""},model:{value:t.form.keyword3,callback:function(e){t.form.keyword3=e},expression:"form.keyword3"}})],1),t._v(" "),s("el-form-item",{staticClass:"steup-auto-width",attrs:{label:"keyword4"}},[s("el-input",{attrs:{placeholder:""},model:{value:t.form.keyword4,callback:function(e){t.form.keyword4=e},expression:"form.keyword4"}})],1),t._v(" "),s("el-form-item",{staticClass:"steup-auto-width",attrs:{label:"remark"}},[s("el-input",{attrs:{placeholder:""},model:{value:t.form.remark,callback:function(e){t.form.remark=e},expression:"form.remark"}})],1),t._v(" "),s("el-row",{staticClass:"gray-bg"},[s("el-col",{staticStyle:{"padding-right":"35px"},attrs:{span:8}},[s("p",{staticClass:"steup-msg-title"},[t._v("模版消息提示")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("优惠发放模版默认使用该模版，请在微信后台公众号将该模板添加到模版库，并确保模版ID填写正确。")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("模版行业 : 酒店旅游 - 酒店")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("模版编号 : 会员权益到帐通知")])]),t._v(" "),s("el-col",{attrs:{span:10}},[s("p",{staticClass:"steup-msg-title"},[t._v("模版详细内容")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("{frist.DATA}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("会员卡号 : {keyword1.DATA}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("成功到帐 : {keyword2.DATA}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("来源 : {keyword3.DATA}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("到帐时间 : {keyword4.DATA}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("{remark.DATA}")])]),t._v(" "),s("el-col",{attrs:{span:4}},[s("p",{staticClass:"steup-msg-title"},[t._v("模版可用字段")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("{会员卡号}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("{优惠发送内容}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("{发送时间}")]),t._v(" "),s("p",{staticClass:"steup-msg-word"},[t._v("{会员名称}")])])],1),t._v(" "),s("el-row",{staticStyle:{"margin-top":"25px"},attrs:{type:"flex",justify:"center"}},[s("el-button",{staticClass:"jfk-button--middle",attrs:{type:"primary",size:"large"}},[t._v("确认发送优惠")]),t._v(" "),s("el-button",{staticClass:"jfk-button--middle",attrs:{size:"large"}},[t._v("取消发送")])],1)],1)],1)},staticRenderFns:[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"jfk-fieldset__hd"},[s("div",{staticClass:"jfk-fieldset__title"},[t._v("新建优惠券发放任务")])])}]}}});