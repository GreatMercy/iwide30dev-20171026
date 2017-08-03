webpackJsonp([18],{231:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var s=a(138),l=a.n(s),r=a(119);t.default={name:"coupon-choice",data:function(){return{form:{name:"",sendtype:"1",package:"",packagenum:2,repeatget:"",targetradio:"",targetcheckbox:""}}},methods:{},computed:l()({},a.i(r.c)(["increment","loading"]))}},302:function(e,t,a){t=e.exports=a(75)(!1),t.push([e.i,".send-word{padding:6px 0;margin-right:10px;display:inline-block;font-size:15px}",""])},330:function(e,t,a){var s=a(302);"string"==typeof s&&(s=[[e.i,s,""]]),s.locals&&(e.exports=s.locals);a(76)("3eb4b490",s,!0)},363:function(e,t,a){a(330);var s=a(94)(a(231),a(386),null,null);e.exports=s.exports},386:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[e._m(0),e._v(" "),a("div",[a("el-row",[a("el-col",{attrs:{span:11}},[a("el-col",{staticClass:"choice-step-num choice-step-active",attrs:{span:4}},[e._v("\n\t\t\t  \t \t01\n\t\t\t  \t")]),e._v(" "),a("el-col",{attrs:{span:20}},[a("p",{staticClass:"choice-step-title"},[e._v("选择优惠券发放内容和目标用户")]),e._v(" "),a("p",{staticClass:"choice-step-word"},[e._v("选择发送的优惠券或礼包，并选择需要发送的用户群体")])])],1),e._v(" "),a("el-col",{staticClass:"jfk-ta-c",attrs:{span:2}},[a("div",{staticClass:"choice-line"})]),e._v(" "),a("el-col",{attrs:{span:11}},[a("el-col",{staticClass:"choice-step-num",attrs:{span:4}},[e._v("\n\t\t\t  \t \t02\n\t\t\t  \t")]),e._v(" "),a("el-col",{attrs:{span:20}},[a("p",{staticClass:"choice-step-title"},[e._v("设置模版消息")]),e._v(" "),a("p",{staticClass:"choice-step-word"},[e._v("设置一个模版消息，给收到优惠的用户发送一个模版消息")])])],1)],1)],1),e._v(" "),a("el-form",{ref:"form",attrs:{model:e.form}},[a("div",{staticClass:"jfk-fieldset__hd"},[a("div",{staticClass:"jfk-fieldset__title"},[e._v("任务信息")])]),e._v(" "),a("div",{staticClass:"choice-rows"},[a("el-form-item",{staticStyle:{margin:"0"},attrs:{label:"请填写任务名称"}},[a("el-input",{staticStyle:{width:"250px"},attrs:{placeholder:"必填，最多15个汉字"},model:{value:e.form.name,callback:function(t){e.form.name=t},expression:"form.name"}})],1)],1),e._v(" "),a("div",{staticClass:"jfk-fieldset__hd"},[a("div",{staticClass:"jfk-fieldset__title"},[e._v("选择发送内容")])]),e._v(" "),a("div",{staticClass:"choice-rows"},[a("el-form-item",{attrs:{label:""}},[a("el-radio-group",{model:{value:e.form.sendtype,callback:function(t){e.form.sendtype=t},expression:"form.sendtype"}},[a("el-radio",{attrs:{label:"1",checked:""}},[e._v("发送优惠券")]),e._v(" "),a("el-radio",{attrs:{label:"2"}},[e._v("发送礼包")])],1)],1),e._v(" "),a("div",{staticClass:"el-form--inline gray-bg"},[a("el-form-item",{attrs:{label:""}},[a("el-select",{staticStyle:{width:"150px"},attrs:{placeholder:"选择会员礼包"},model:{value:e.form.package,callback:function(t){e.form.package=t},expression:"form.package"}},[a("el-option",{attrs:{label:"会员礼包一",value:"one"}}),e._v(" "),a("el-option",{attrs:{label:"会员礼包二",value:"two"}})],1)],1),e._v(" "),a("el-form-item",{directives:[{name:"show",rawName:"v-show",value:"1"===e.form.sendtype,expression:"form.sendtype === '1' "}],attrs:{label:""}},[a("el-input",{staticStyle:{width:"80px","margin-right":"10px"},attrs:{placeholder:""},model:{value:e.form.packagenum,callback:function(t){e.form.packagenum=t},expression:"form.packagenum"}})],1),e._v(" "),a("span",{directives:[{name:"show",rawName:"v-show",value:"2"===e.form.sendtype,expression:"form.sendtype === '2' "}],staticClass:"send-word"},[e._v("礼包默认发送一个")]),e._v(" "),a("el-form-item",{attrs:{label:""}},[a("el-checkbox",{attrs:{label:"重复领取",checked:""},model:{value:e.form.repeatget,callback:function(t){e.form.repeatget=t},expression:"form.repeatget"}})],1)],1),e._v(" "),a("el-row",{staticClass:"choice-tips"},[a("div",[e._v("提示 :")]),e._v(" "),a("div",[a("p",[e._v(" 请确保需要发放的优惠券/礼包，库存充足"),a("br"),e._v(" 勾选重复领取则已领取过该优惠的用户可以再次领取，否则不可以领取。")])])])],1),e._v(" "),a("div",{staticClass:"jfk-fieldset__hd"},[a("div",{staticClass:"jfk-fieldset__title"},[e._v("发送目标用户")])]),e._v(" "),a("div",{staticClass:"choice-rows"},[a("el-form-item",{attrs:{label:""}},[a("el-radio-group",{staticClass:"choice-radio-right",model:{value:e.form.targetradio,callback:function(t){e.form.targetradio=t},expression:"form.targetradio"}},[a("el-radio",{attrs:{label:"会员等级"}}),e._v(" "),a("el-radio",{attrs:{label:"RFM模型"}}),e._v(" "),a("el-radio",{attrs:{label:"导入发放名单"}})],1)],1),e._v(" "),a("div",{staticClass:"el-form--inline gray-bg"},[a("el-form-item",{attrs:{label:""}},[a("el-checkbox-group",{staticClass:"choice-checkbox-right",model:{value:e.form.targetcheckbox,callback:function(t){e.form.targetcheckbox=t},expression:"form.targetcheckbox"}},[a("el-checkbox",{attrs:{label:"全选",name:"targetcheckbox"}}),e._v(" "),a("el-checkbox",{attrs:{label:"微信会员",name:"targetcheckbox"}}),e._v(" "),a("el-checkbox",{attrs:{label:"银卡",name:"targetcheckbox"}}),e._v(" "),a("el-checkbox",{attrs:{label:"金卡",name:"targetcheckbox"}}),e._v(" "),a("el-checkbox",{attrs:{label:"铂金卡",name:"targetcheckbox"}})],1)],1)],1)],1),e._v(" "),a("el-row",{staticStyle:{"margin-top":"25px"},attrs:{type:"flex",justify:"center"}},[a("el-button",{staticClass:"jfk-button--middle",attrs:{type:"primary",size:"large"}},[e._v("下一步")]),e._v(" "),a("el-button",{staticClass:"jfk-button--middle",attrs:{size:"large"}},[e._v("返回")])],1)],1)],1)},staticRenderFns:[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"jfk-fieldset__hd"},[a("div",{staticClass:"jfk-fieldset__title"},[e._v("新建优惠券发放任务")])])}]}}});