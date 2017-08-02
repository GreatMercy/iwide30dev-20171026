webpackJsonp([6],{224:function(e,t,o){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=o(101),r=o.n(a),l=o(99),i=o(83),s=o(118),n=o(92),m=/^[1-9]\d*$/,c=/^\d+$/;t.default={data:function(){var e=this,t=function(t,o,a){return"athour"!==e.form.type||e.form.bookTimeMod?a():a(new Error(t.message))},a=function(t,o,a){if("athour"===e.form.type){if(!e.form.bookTimeStart)return a(new Error("请输入最早到店时间"));if(e.form.bookTimeEnd&&e.form.bookTimeStart>=e.form.bookTimeEnd)return a(new Error("最早到店时间应该小于最迟到店时间"))}return a()},r=function(t,o,a){if("athour"===e.form.type){if(!e.form.bookTimeEnd)return a(new Error("请输入最迟到店时间"));if(e.form.bookTimeStart&&e.form.bookTimeStart>=e.form.bookTimeEnd)return a(new Error("最迟到店时间应该大于最早到店时间"))}return a()},l=function(e,t,o){return""===t||m.test(t)?o():o(new Error(e.message))};return{policyRules:{bookTimeMod:[{validator:t,message:"时租价必须选择时间间隔",trigger:"change"}],bookTimeStart:[{validator:a,trigger:"blur"}],bookTimeEnd:[{validator:r,trigger:"blur"}],preD:[{trigger:"blur",message:"提前预定天数为非负整数",validator:function(e,t,o){return""===t||c.test(t)?o():o(new Error(e.message))}}],mxn:[{trigger:"blur",message:"单次最大间数为正整数",validator:l}],minDay:[{trigger:"blur",message:"最小可定天数为正整数",validator:l},{trigger:"blur",validator:function(t,o,a){return o&&e.form.mxd&&e.$refs.policyForm.validateField("mxd"),a()}}],mxd:[{trigger:"blur",message:"最大可定天数为正整数",validator:l},{trigger:"blur",message:"最大可定天数必须不小于最小可定天数",validator:function(t,o,a){return o&&+e.form.minDay>+o?a(new Error(t.message)):a()}}],sDateS:[{trigger:"change",validator:function(t,o,a){return o&&e.form.sDateE&&e.$refs.policyForm.validateField("sDateE"),a()}}],sDateE:[{trigger:"change",message:"最迟入住日期必须不小于最早入住日期",validator:function(t,o,a){return o&&e.form.sDateS>o?a(new Error(t.message)):a()}}],eDateS:[{trigger:"change",validator:function(t,o,a){return o&&e.form.eDateE&&e.$refs.policyForm.validateField("eDateE"),a()}}],eDateE:[{trigger:"change",message:"最迟离店日期必须不小于最早离店日期",validator:function(t,o,a){return o&&e.form.eDateS>o?a(new Error(t.message)):a()}}],couponNum:[{trigger:"blur",validator:function(t,o,a){if(0===e.form.couponNoUse){if(""===o)return a(new Error("请输入用卷的使用张数"));if(!m.test(o))return a(new Error("用卷的使用张数必须为正整数"))}return a()}}],wxPayFavour:[{trigger:"blur",message:"微信支付立减必须为最多两位小数的正数",validator:function(t,a,r){return e.hasWxPayInPayways&&a&&!o.i(n.a)(a)?r(new Error(t.message)):r()}}],sort:[{trigger:"blur",message:"排序必须为正整数",validator:l}],status:[{trigger:"change",message:"必须选择一个状态",required:!0}]}}},methods:r()({},o.i(l.d)("form",[i.n]),o.i(l.d)([i.p]),{handlePrevStep:function(){this[i.p]({increment:!1})},handleNextStep:function(){var e=this;this.$refs.policyForm.validate(function(t){t&&e[i.p]({increment:!0})})},sDateSChange:function(e){this.form.sDateS1=e},sDateEChange:function(e){this.form.sDateE1=e},eDateSChange:function(e){this.form.eDateS1=e},eDateEChange:function(e){this.form.eDateE1=e}}),computed:r()({},o.i(l.a)("config",["confPayWays","confBookTimeMod","confCouponNumType","confCodeStatus","confCouponTypes"]),o.i(l.a)(["form"]),o.i(l.e)("form",["hasWxPayInPayways"])),beforeRouteEnter:function(e,t,o){if(!t.name)return o({path:s.a[0].path});o(function(e){var t={},o={};e.form.payWays.forEach(function(a){e.form.delayTime[a]||(t[a]="18",o[a]="12")}),e[i.n]({bookpolicy_condition:{delay_time:t,retain_time:o}})})}}},227:function(e,t,o){t=e.exports=o(76)(!1),t.push([e.i,".policy-coupon-num-type[data-v-2c9571f4]{width:145px}.policy-coupon-num-type-box[data-v-2c9571f4]{max-width:210px;margin-left:15px}",""])},232:function(e,t,o){var a=o(227);"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);o(77)("ba02f8aa",a,!0)},240:function(e,t,o){o(232);var a=o(112)(o(224),o(243),"data-v-2c9571f4",null);e.exports=a.exports},243:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,o=e._self._c||t;return o("div",{staticClass:"jfk-pages__modules jfk-pages__modules-policy"},[o("el-form",{ref:"policyForm",attrs:{rules:e.policyRules,model:e.form,"label-width":"150px"}},[o("div",{staticClass:"jfk-fieldset"},[o("div",{staticClass:"jfk-fieldset__hd"},[o("div",{staticClass:"jfk-fieldset__title"},[e._v("\n          预定政策\n        ")])]),e._v(" "),o("el-row",[o("el-col",{attrs:{lg:12,md:24}},[o("el-row",{attrs:{type:"flex",align:"middle"}},[o("div",{staticClass:"policy-time-label"},[e._v("保留时间")]),e._v(" "),o("div",{staticClass:"policy-time-content"},e._l(e.form.payWays,function(t){return o("el-form-item",{key:t,attrs:{label:e.confPayWays[t].pay_name+" 入住日期","label-width":"250px"}},[o("el-time-select",{attrs:{editable:!1,"picker-options":{start:"00:00",end:"23:00",step:"01:00"},placeholder:"入住时间"},model:{value:e.form.delayTime[t],callback:function(o){var a=e.form.delayTime,r=t;Array.isArray(a)?a.splice(r,1,o):e.form.delayTime[t]=o},expression:"form.delayTime[item]"}})],1)}))])],1),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-row",{attrs:{type:"flex",align:"middle"}},[o("div",{staticClass:"policy-time-label"},[e._v("退房时间")]),e._v(" "),o("div",{staticClass:"policy-time-content"},e._l(e.form.payWays,function(t){return o("el-form-item",{key:t,attrs:{label:e.confPayWays[t].pay_name+" 离店日期","label-width":"250px"}},[o("el-time-select",{attrs:{editable:!1,"picker-options":{start:"00:00",end:"23:00",step:"01:00"},placeholder:"退房时间"},model:{value:e.form.retainTime[t],callback:function(o){var a=e.form.retainTime,r=t;Array.isArray(a)?a.splice(r,1,o):e.form.retainTime[t]=o},expression:"form.retainTime[item]"}})],1)}))])],1)],1)],1),e._v(" "),o("div",{staticClass:"jfk-fieldset"},[o("div",{staticClass:"jfk-fieldset__hd"},[o("div",{staticClass:"jfk-fieldset__title"},[e._v("\n          高级预订政策\n        ")])]),e._v(" "),o("el-row",[o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"提前预定天数",prop:"preD"}},[o("el-input",{staticClass:"jfk-input__fixed-width--110",model:{value:e.form.preD,callback:function(t){e.form.preD="string"==typeof t?t.trim():t},expression:"form.preD"}},[o("template",{slot:"append"},[e._v("天")])],2)],1)],1),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"单次最大间数",prop:"mxn"}},[o("el-input",{staticClass:"jfk-input__fixed-width--110",model:{value:e.form.mxn,callback:function(t){e.form.mxn="string"==typeof t?t.trim():t},expression:"form.mxn"}},[o("template",{slot:"append"},[e._v("间")])],2)],1)],1),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"可定天数"}},[o("el-col",{attrs:{span:11}},[o("el-form-item",{attrs:{prop:"minDay"}},[o("el-input",{staticClass:"jfk-input__diy-icon",attrs:{placeholder:"最小可定天数"},model:{value:e.form.minDay,callback:function(t){e.form.minDay=t},expression:"form.minDay"}},[o("template",{slot:"prepend"},[o("i",{staticClass:"jfkfont icon-ipt_icon_gte_default"})])],2)],1)],1),e._v(" "),o("el-col",{attrs:{span:11,offset:1}},[o("el-form-item",{attrs:{prop:"mxd"}},[o("el-input",{staticClass:"jfk-input__diy-icon",attrs:{placeholder:"最大可定天数"},model:{value:e.form.mxd,callback:function(t){e.form.mxd=t},expression:"form.mxd"}},[o("template",{slot:"prepend"},[o("i",{staticClass:"jfkfont icon-ipt_icon_lte_default"})])],2)],1)],1)],1)],1),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"入住日期"}},[o("el-col",{attrs:{span:11}},[o("el-form-item",{attrs:{prop:"sDateS"}},[o("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[o("div",{staticClass:"el-input-group__prepend"},[o("i",{staticClass:"jfkfont icon-ipt_icon_gte_default"})]),e._v(" "),o("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最早入住日期"},on:{change:e.sDateSChange},model:{value:e.form.sDateS,callback:function(t){e.form.sDateS=t},expression:"form.sDateS"}})],1)])],1),e._v(" "),o("el-col",{attrs:{span:11,offset:1}},[o("el-form-item",{attrs:{prop:"sDateE"}},[o("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[o("div",{staticClass:"el-input-group__prepend"},[o("i",{staticClass:"jfkfont icon-ipt_icon_lte_default"})]),e._v(" "),o("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最迟入住日期"},on:{change:e.sDateEChange},model:{value:e.form.sDateE,callback:function(t){e.form.sDateE=t},expression:"form.sDateE"}})],1)])],1)],1)],1),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"离店日期"}},[o("el-col",{attrs:{span:11}},[o("el-form-item",{attrs:{prop:"eDateS"}},[o("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[o("div",{staticClass:"el-input-group__prepend"},[o("i",{staticClass:"jfkfont icon-ipt_icon_gte_default"})]),e._v(" "),o("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最早离店日期"},on:{change:e.eDateSChange},model:{value:e.form.eDateS,callback:function(t){e.form.eDateS=t},expression:"form.eDateS"}})],1)])],1),e._v(" "),o("el-col",{attrs:{span:11,offset:1}},[o("el-form-item",{attrs:{prop:"eDateE"}},[o("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[o("div",{staticClass:"el-input-group__prepend"},[o("i",{staticClass:"jfkfont icon-ipt_icon_lte_default"})]),e._v(" "),o("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最迟离店日期"},on:{change:e.eDateEChange},model:{value:e.form.eDateE,callback:function(t){e.form.eDateE=t},expression:"form.eDateE"}})],1)])],1)],1)],1),e._v(" "),o("el-col",{directives:[{name:"show",rawName:"v-show",value:e.hasWxPayInPayways,expression:"hasWxPayInPayways"}],attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"微信支付立减",prop:"wxPayFavour"}},[o("el-input",{staticClass:"jfk-input__fixed-width--110",model:{value:e.form.wxPayFavour,callback:function(t){e.form.wxPayFavour=e._n(t)},expression:"form.wxPayFavour"}},[o("template",{slot:"append"},[e._v("元")])],2)],1)],1),e._v(" "),o("el-col",{directives:[{name:"show",rawName:"v-show",value:"athour"===e.form.type,expression:"form.type === 'athour'"}],attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"到店时间段",required:""}},[o("el-form-item",{staticClass:"jfk-d-ib",attrs:{prop:"bookTimeStart"}},[o("el-time-select",{attrs:{placeholder:"起始时间","picker-options":{start:"00:00",step:"01:00",end:"23:00"}},model:{value:e.form.bookTimeStart,callback:function(t){e.form.bookTimeStart=t},expression:"form.bookTimeStart"}})],1),e._v(" "),o("span",[e._v("-")]),e._v(" "),o("el-form-item",{staticClass:"jfk-d-ib",attrs:{prop:"bookTimeEnd"}},[o("el-time-select",{attrs:{placeholder:"结束时间","picker-options":{start:"00:00",step:"01:00",end:"23:00",minTime:e.form.bookTimeStart}},model:{value:e.form.bookTimeEnd,callback:function(t){e.form.bookTimeEnd=t},expression:"form.bookTimeEnd"}})],1)],1)],1),e._v(" "),o("el-col",{directives:[{name:"show",rawName:"v-show",value:"athour"===e.form.type,expression:"form.type === 'athour'"}],attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"时间间隔",prop:"bookTimeMod",required:""}},[o("el-select",{model:{value:e.form.bookTimeMod,callback:function(t){e.form.bookTimeMod=t},expression:"form.bookTimeMod"}},e._l(e.confBookTimeMod,function(e,t){return o("el-option",{key:t,attrs:{label:e,value:t}})}))],1)],1)],1)],1),e._v(" "),o("div",{staticClass:"jfk-fieldset"},[o("div",{staticClass:"jfk-fieldset__hd"},[o("div",{staticClass:"jfk-fieldset__title"},[e._v("\n          营销规则\n        ")])]),e._v(" "),o("el-row",[o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"用卷规则"}},[o("el-radio",{attrs:{label:1},model:{value:e.form.couponNoUse,callback:function(t){e.form.couponNoUse=t},expression:"form.couponNoUse"}},[e._v("不可用")]),e._v(" "),o("el-radio",{attrs:{label:0},model:{value:e.form.couponNoUse,callback:function(t){e.form.couponNoUse=t},expression:"form.couponNoUse"}},[e._v("可用")]),e._v(" "),o("el-form-item",{directives:[{name:"show",rawName:"v-show",value:0===e.form.couponNoUse,expression:"form.couponNoUse === 0"}],staticClass:"jfk-d-ib policy-coupon-num-type-box",attrs:{prop:"couponNum"}},[o("el-input",{attrs:{placeholder:"请输入使用张数"},model:{value:e.form.couponNum,callback:function(t){e.form.couponNum=t},expression:"form.couponNum"}},[o("el-select",{staticClass:"policy-coupon-num-type",attrs:{placeholder:"请选择"},slot:"prepend",model:{value:e.form.couponNumType,callback:function(t){e.form.couponNumType=e._n(t)},expression:"form.couponNumType"}},e._l(e.confCouponNumType,function(e,t){return o("el-option",{key:t,attrs:{label:"按"+e+"使用张数",value:t}})}))],1)],1)],1)],1),e._v(" "),Object.keys(e.confCouponTypes).length?o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"券关联"}},[o("el-select",{model:{value:e.form.couprel,callback:function(t){e.form.couprel=t},expression:"form.couprel"}},e._l(e.confCouponTypes,function(e,t){return o("el-option",{key:t,attrs:{label:e.title,value:t}})}))],1)],1):e._e(),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"积分兑换"}},[o("el-radio",{attrs:{label:1},model:{value:e.form.bonusNoPart,callback:function(t){e.form.bonusNoPart=t},expression:"form.bonusNoPart"}},[e._v("不可用")]),e._v(" "),o("el-radio",{attrs:{label:0},model:{value:e.form.bonusNoPart,callback:function(t){e.form.bonusNoPart=t},expression:"form.bonusNoPart"}},[e._v("可用")])],1)],1),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"积分与卷"}},[o("el-radio",{attrs:{label:1},model:{value:e.form.bonusPoc,callback:function(t){e.form.bonusPoc=t},expression:"form.bonusPoc"}},[e._v("不可同用")]),e._v(" "),o("el-radio",{attrs:{label:0},model:{value:e.form.bonusPoc,callback:function(t){e.form.bonusPoc=t},expression:"form.bonusPoc"}},[e._v("可同用")])],1)],1),e._v(" "),0!==e.form.isPms?o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"使用pms卷"}},[o("el-radio",{attrs:{label:0},model:{value:e.form.couponIsPms,callback:function(t){e.form.couponIsPms=t},expression:"form.couponIsPms"}},[e._v("不使用")]),e._v(" "),o("el-radio",{attrs:{label:1},model:{value:e.form.couponIsPms,callback:function(t){e.form.couponIsPms=t},expression:"form.couponIsPms"}},[e._v("使用")])],1)],1):e._e(),e._v(" "),0!==e.form.isPms?o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"pms代码"}},[o("el-col",{attrs:{span:8}},[o("el-input",{model:{value:e.form.externalCode,callback:function(t){e.form.externalCode=t},expression:"form.externalCode"}})],1)],1)],1):e._e(),e._v(" "),"0"===e.form.isPackages?o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"仅用于套餐预订"}},[o("el-radio",{attrs:{label:0},model:{value:e.form.packageOnly,callback:function(t){e.form.packageOnly=t},expression:"form.packageOnly"}},[e._v("否")]),e._v(" "),o("el-radio",{attrs:{label:1},model:{value:e.form.packageOnly,callback:function(t){e.form.packageOnly=t},expression:"form.packageOnly"}},[e._v("是")])],1)],1):e._e()],1)],1),e._v(" "),o("div",{staticClass:"jfk-fieldset"},[o("div",{staticClass:"jfk-fieldset__hd"},[o("div",{staticClass:"jfk-fieldset__title"},[e._v("\n          其他\n        ")])]),e._v(" "),o("el-row",[o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"排序",prop:"sort"}},[o("el-input",{staticClass:"jfk-input__fixed-width--110",model:{value:e.form.sort,callback:function(t){e.form.sort=t},expression:"form.sort"}})],1)],1),e._v(" "),o("el-col",{attrs:{lg:12,md:24}},[o("el-form-item",{attrs:{label:"状态",prop:"status"}},[o("el-radio-group",{model:{value:e.form.status,callback:function(t){e.form.status=t},expression:"form.status"}},e._l(e.confCodeStatus,function(t,a){return o("el-radio",{key:a,attrs:{label:a}},[e._v("\n                "+e._s(t)+"\n              ")])}))],1)],1)],1)],1),e._v(" "),o("el-row",{attrs:{type:"flex",justify:"center"}},[o("el-button",{staticClass:"jfk-button--middle",attrs:{size:"large"},nativeOn:{click:function(t){t.preventDefault(),e.handlePrevStep(t)}}},[e._v("上一步")]),e._v(" "),o("el-button",{staticClass:"jfk-button--middle",attrs:{type:"primary",size:"large"},nativeOn:{click:function(t){t.preventDefault(),e.handleNextStep(t)}}},[e._v("下一步")])],1)],1)],1)},staticRenderFns:[]}}});