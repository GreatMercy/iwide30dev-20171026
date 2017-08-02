webpackJsonp([23],{228:function(e,o,t){"use strict";function a(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(o,"__esModule",{value:!0});var l=t(120),i=a(l),r=t(198),s=a(r),n=t(139),m=a(n),c=t(204),d=a(c),f=t(199),u=t(202),h=function(e,o,t,a){var l=e.form.limitRoomChecked[o];if(a)l&&(t?(e.$delete(e.form.limitRoomChecked[o].rooms,t),0===(0,d.default)(l.rooms).length&&e.$delete(e.form.limitRoomChecked,o)):e.$delete(e.form.limitRoomChecked,o));else{var r=l?{hotelId:o,rooms:(0,m.default)({},l.rooms,(0,s.default)({},t,o))}:{hotelId:o,rooms:(0,s.default)({},t,o)};e.form.limitRoomChecked=(0,i.default)({},e.form.limitRoomChecked,(0,s.default)({},o,r))}};o.default={name:"price-info",data:function(){var e=this,o=function(e,o,t){!e.required||o&&"-1"!==o?t():t(new Error(e.message))};return{limitRoomKeyword:"",showUnlockCodeArea:!1,noticeNumber:0,noticeMaxNumber:200,limitRoom:{dialog:!1,keyword:"",page:1,size:10,count:0,loading:!0,first:!0,currentPageHasAllChecked:!1,roomsProps:{children:"rooms",label:"name"},currentPageHotelIds:[],refreshCheckedRoomTable:!0,defaultChecked:[],shouldCheckAllRooms:!1},payWayIndeterminate:!1,payWayCheckAll:!1,limitWeeksIndeterminate:!1,limitWeeksCheckAll:!1,isPackageDisable:!1,rules:{type:[{required:!0,message:"请选择价格类型",trigger:"blur"}],unlockCode:[{required:!1,message:"请输入协议价",trigger:"blur"}],priceName:[{required:!0,message:"请输入价格代码名称",trigger:"blur"},{message:"价格代码必须为2-8个字符",trigger:"blur",min:2,max:8,length:!0}],des:[{required:!0,message:"请输入价格代码描述",trigger:"blur"}],limitWeeks:[{required:!0,message:"请选择可用日期",trigger:"change",type:"array"}],relatedCalValue:[{message:"请输入数值",trigger:"blur",type:"number"}],allRooms:[{required:!0,message:"请选择适用范围",trigger:"change"},{validator:function(o,t,a){return"0"===t&&e.limitRoom.shouldCheckAllRooms&&0===e.limitRoomCheckedCount?a(new Error(o.message)):a()},message:"请添加部分门店与房型",trigger:"change"}],memberLevel:[{required:!1,validator:o,message:"价格类型为会员时，会员等级必填",trigger:"change"}],payWays:[{required:!0,message:"至少选择一种支付方式",trigger:"change",type:"array"}],goodInfoSaleWay:[{validator:function(o,t,a){if("1"===e.form.isPackages){if(0===t)return a(new Error("请选择一种销售方式"));if(1===t&&!e.form.goodInfoCountWay)return a(new Error("请选择一种包价方式"))}return a()},trigger:"change"}],goodInfoSaleNotice:[{validator:function(o,t,a){if("1"===e.form.isPackages&&1===e.form.goodInfoSaleWay){if(!t)return a(new Error("请输入订购须知"));if(e.noticeNumber>e.noticeMaxNumber)return a(new Error("订购须知最多"+e.noticeMaxNumber+"字"))}return a()},trigger:"change"}],sDateS:[{trigger:"change",validator:function(o,t,a){return t&&e.form.sDateE&&e.$refs.infoForm.validateField("sDateE"),a()}}],sDateE:[{trigger:"change",message:"最迟入住日期必须不小于最早入住日期",validator:function(o,t,a){return t&&e.form.sDateS>t?a(new Error(o.message)):a()}}],eDateS:[{trigger:"change",validator:function(o,t,a){return t&&e.form.eDateE&&e.$refs.infoForm.validateField("eDateE"),a()}}],eDateE:[{trigger:"change",message:"最迟离店日期必须不小于最早离店日期",validator:function(o,t,a){return t&&e.form.eDateS>t?a(new Error(o.message)):a()}}]}}},methods:(0,m.default)({},(0,f.mapMutations)([u.UPDATE_PRICE_STEP]),(0,f.mapActions)("rooms",[u.INIT_HOTEL_ROOMS_ACTION,u.UPDATE_HOTEL_ROOMS_ACTION]),(0,f.mapActions)("form",[u.GET_HOTEL_ROOM_BY_CODE_ACTION]),{handleLimitWeeksCheckAll:function(e){this.form.limitWeeks=e.target.checked?(0,d.default)(this.confWeeks):[],this.limitWeeksIndeterminate=!1},handleLimitWeeksChange:function(e){var o=e.length,t=(0,d.default)(this.confWeeks).length;this.limitWeeksCheckAll=o===t,this.limitWeeksIndeterminate=o>0&&o<t},handlePayWaysCheckAll:function(e){this.form.payWays=e.target.checked?(0,d.default)(this.confPayWays):[],this.payWayIndeterminate=!1},handlePayWayChange:function(e){var o=e.length,t=(0,d.default)(this.confPayWays).length;this.payWayCheckAll=o===t,this.payWayIndeterminate=o>0&&o<t},handleAddLimitRoom:function(){this.limitRoom.dialog=!0},handleSearchLimitRoom:function(){this.limitRoom.keyword=this.$refs.limitRoomKeywordInput.currentValue,this.hotelRoomIds[this.limitRoom.keyword||"__default__"]||this[u.UPDATE_HOTEL_ROOMS_ACTION]({page:1,size:this.limitRoom.size,keyword:this.limitRoom.keyword||""})},handleLimitRoomCurrentChange:function(e){var o=this.limitRoom.size*(e-1),t=this.hotelRoomIds[this.limitRoom.keyword||"__default__"];t&&t.hotelIds[o]||this[u.UPDATE_HOTEL_ROOMS_ACTION]({page:e,size:this.limitRoom.size,keyword:this.limitRoom.keyword||""}),this.limitRoom.currentPageHasAllChecked=!1,this.limitRoom.page=e},handleRomoveLimitHotel:function(e){h(this,e,void 0,!0)},handleRemoveLimitRoom:function(e,o){h(this,e,o,!0)},handleOpenLimitRoomDialog:function(){this.limitRoom.first&&(this[u.INIT_HOTEL_ROOMS_ACTION]({page:1,size:this.limitRoom.size}),this.limitRoom.first=!1),this.limitRoom.refreshCheckedRoomTable=!1;var e=[];for(var o in this.form.limitRoomChecked){var t=(0,d.default)(this.form.limitRoomChecked[o].rooms);e=e.concat(t)}this.limitRoom.defaultChecked=e},handleCloseLimitRoomDialog:function(){this.limitRoom.dialog=!1,this.limitRoom.refreshCheckedRoomTable=!0,this.$refs.infoForm.validateField("allRooms")},handleNextStep:function(){var e=this;this.$refs.infoForm.validate(function(o){if(o)return e[u.UPDATE_PRICE_STEP]({increment:!0})})},handleCheckAllLimitRoomByPage:function(){this.$refs.limitRoomTree.setCheckedKeys(this.limitRoom.currentPageHasAllChecked?this.limitRoom.currentPageHotelIds:[])},handleLimitRoomCheckChange:function(e,o){if(e.room_id)return h(this,e.hotel_id,e.room_id,!o)},handlegoodInfoSaleWayChange:function(){this.$refs.infoForm.validateField("goodInfoSaleWay")},handleChangeAllRooms:function(){this.limitRoom.shouldCheckAllRooms=!0},handleGoodNoticePaste:function(){var e=this;setTimeout(function(){e.$refs.infoForm.validateField("goodInfoSaleNotice")},0)},sDateSChange:function(e){this.form.sDateS1=e},sDateEChange:function(e){this.form.sDateE1=e},eDateSChange:function(e){this.form.eDateS1=e},eDateEChange:function(e){this.form.eDateE1=e}}),computed:(0,m.default)({showRelatedCalArea:function(){return"member"!==this.codeType&&"0"!==this.form.relatedCode}},(0,f.mapGetters)("form",["limitWeeksHasAllChecked","limitRoomCheckedCount"]),(0,f.mapGetters)("config",["hasConfMemberLevel","hasConfPayWays"]),(0,f.mapState)(["form"]),(0,f.mapState)("form",{codeType:"type",limitRoomType:"allRooms",goodInfoSaleNotice:"goodInfoSaleNotice",payWays:"payWays"}),(0,f.mapState)("config",["confCodeType","confCodeCalWay","confBfFields","confPriceCodes","confCodeStatus","confMemberLevels","confPayWays","confWeeks","confPackagePaymentSupport"]),(0,f.mapState)("rooms",{hotelRoomItems:"hotelRoomItems",hotelRoomIds:"hotelRoomIds",roomLoading:"loading"}),{hotels:function(){var e=[];this.limitRoom.currentPageHotelIds=[];var o=this.hotelRoomIds[this.limitRoom.keyword||"__default__"];if(o&&o.hotelIds.length){this.limitRoom.count=o.count;for(var t=(this.limitRoom.page-1)*this.limitRoom.size,a=this.limitRoom.page*this.limitRoom.size;t<a;){var l=o.hotelIds[t];if(l){var i=this.hotelRoomItems[l];this.limitRoom.currentPageHotelIds.push(i.nid),e.push(i)}t++}}return e},hotelsChecked:function(){if(this.limitRoom.refreshCheckedRoomTable){var e=[],o=this.form.limitRoomChecked;for(var t in o)e.push(o[t]);return e}},packagePaymentSupportText:function(){var e=[];for(var o in this.confPackagePaymentSupport)e.push(this.confPackagePaymentSupport[o]);return e.join("、")}}),watch:{codeType:function(e){var o="protrol"===e,t="member"===e;this.showUnlockCodeArea=o,this.rules.unlockCode[0].required=o,this.rules.memberLevel[0].required=t},limitRoomType:function(e){this.form.priceCode&&!this.limitRoom.getCheckedRooms&&"0"===e&&(this.limitRoom.getCheckedRooms=!0,this[u.GET_HOTEL_ROOM_BY_CODE_ACTION]({pcode:this.form.priceCode}))},goodInfoSaleNotice:function(e){var o=e.replace(/\s*\r\n|\s*\n/gm,"");this.noticeNumber=o.length},payWays:function(e){var o=this,t=e.some(function(e){return o.confPackagePaymentSupport[e]});t||(o.form.isPackages="0"),o.isPackageDisable=!t}}}},322:function(e,o,t){o=e.exports=t(75)(!1),o.push([e.i,".jfk-dialog__hotelRooms .el-dialog__body{padding-bottom:10px}",""])},323:function(e,o,t){o=e.exports=t(75)(!1),o.push([e.i,".goodInfo_sale_way[data-v-59189f34]{width:90px}.checkbox-indeterminate+.el-checkbox-group.jfk-d-ib[data-v-59189f34]{margin-left:0}.checkall-input-box[data-v-59189f34]{margin-top:5px;margin-bottom:15px}.el-tag[data-v-59189f34]{margin:5px 0}.el-tag+.el-tag[data-v-59189f34]{margin-left:10px}.el-checkbox+.el-checkbox[data-v-59189f34]{margin-left:0}.el-checkbox[data-v-59189f34]{margin-right:15px}.saleNotice-item[data-v-59189f34]{position:relative}.notice-tip[data-v-59189f34]{position:absolute;bottom:-16px;right:5px;font-size:12px;line-height:1}",""])},353:function(e,o,t){var a=t(322);"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);t(76)("43faae91",a,!0)},354:function(e,o,t){var a=t(323);"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);t(76)("6606603e",a,!0)},374:function(e,o,t){t(354),t(353);var a=t(140)(t(228),t(415),"data-v-59189f34",null);e.exports=a.exports},415:function(e,o){e.exports={render:function(){var e=this,o=e.$createElement,t=e._self._c||o;return t("div",{staticClass:"jfk-pages__modules jfk-pages__modules-baseinfo jfk-tofle"},[t("el-form",{ref:"infoForm",attrs:{rules:e.rules,model:e.form,"label-width":"120px"}},[t("div",{staticClass:"jfk-fieldset"},[t("div",{staticClass:"jfk-fieldset__hd"},[t("div",{staticClass:"jfk-fieldset__title"},[e._v("基础设置")])]),e._v(" "),t("el-row",[t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"价格类型",prop:"type"}},[Object.keys(e.confCodeType).length<6?[t("el-radio-group",{model:{value:e.form.type,callback:function(o){e.form.type=o},expression:"form.type"}},e._l(e.confCodeType,function(o,a){return t("el-radio",{key:a,attrs:{label:a}},[e._v("\n                  "+e._s(o)+"\n                ")])}))]:[t("el-select",{attrs:{placeholder:"请选择价格类型"},model:{value:e.form.type,callback:function(o){e.form.type=o},expression:"form.type"}},e._l(e.confCodeType,function(e,o){return t("el-option",{key:o,attrs:{value:o,label:e}})}))]],2)],1),e._v(" "),t("el-col",{directives:[{name:"show",rawName:"v-show",value:e.showUnlockCodeArea,expression:"showUnlockCodeArea"}],attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{required:"",label:"协议代码",prop:"unlockCode"}},[t("el-input",{model:{value:e.form.unlockCode,callback:function(o){e.form.unlockCode=o},expression:"form.unlockCode"}})],1)],1),e._v(" "),t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"价格代码名称",prop:"priceName"}},[t("el-input",{attrs:{maxlength:8,minlength:2,placeholder:"2至8个文字"},model:{value:e.form.priceName,callback:function(o){e.form.priceName="string"==typeof o?o.trim():o},expression:"form.priceName"}})],1)],1),e._v(" "),t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"价格代码描述",prop:"des"}},[t("el-input",{attrs:{maxlength:50,minlength:2,placeholder:"50以内个文字"},model:{value:e.form.des,callback:function(o){e.form.des="string"==typeof o?o.trim():o},expression:"form.des"}})],1)],1),e._v(" "),t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"可用日期",prop:"limitWeeks"}},[t("el-checkbox",{staticClass:"checkbox-indeterminate",attrs:{indeterminate:e.limitWeeksIndeterminate},on:{change:e.handleLimitWeeksCheckAll},model:{value:e.limitWeeksCheckAll,callback:function(o){e.limitWeeksCheckAll=o},expression:"limitWeeksCheckAll"}},[e._v("\n              全选\n            ")]),e._v(" "),t("el-checkbox-group",{staticClass:"jfk-d-ib",on:{change:e.handleLimitWeeksChange},model:{value:e.form.limitWeeks,callback:function(o){e.form.limitWeeks=o},expression:"form.limitWeeks"}},e._l(e.confWeeks,function(o,a){return t("el-checkbox",{key:a,attrs:{min:1,label:a}},[e._v("\n                "+e._s(o)+"\n              ")])}))],1)],1),e._v(" "),t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"入住日期"}},[t("el-col",{attrs:{span:11}},[t("el-form-item",{attrs:{prop:"sDateS"}},[t("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[t("div",{staticClass:"el-input-group__prepend"},[t("i",{staticClass:"jfkfont icon-ipt_icon_gte_default"})]),e._v(" "),t("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最早入住日期"},on:{change:e.sDateSChange},model:{value:e.form.sDateS,callback:function(o){e.form.sDateS=o},expression:"form.sDateS"}})],1)])],1),e._v(" "),t("el-col",{attrs:{span:11,offset:1}},[t("el-form-item",{attrs:{prop:"sDateE"}},[t("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[t("div",{staticClass:"el-input-group__prepend"},[t("i",{staticClass:"jfkfont icon-ipt_icon_lte_default"})]),e._v(" "),t("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最迟入住日期"},on:{change:e.sDateEChange},model:{value:e.form.sDateE,callback:function(o){e.form.sDateE=o},expression:"form.sDateE"}})],1)])],1)],1)],1),e._v(" "),t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"离店日期"}},[t("el-col",{attrs:{span:11}},[t("el-form-item",{attrs:{prop:"eDateS"}},[t("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[t("div",{staticClass:"el-input-group__prepend"},[t("i",{staticClass:"jfkfont icon-ipt_icon_gte_default"})]),e._v(" "),t("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最早离店日期"},on:{change:e.eDateSChange},model:{value:e.form.eDateS,callback:function(o){e.form.eDateS=o},expression:"form.eDateS"}})],1)])],1),e._v(" "),t("el-col",{attrs:{span:11,offset:1}},[t("el-form-item",{attrs:{prop:"eDateE"}},[t("div",{staticClass:"el-input el-input-group el-input-group--prepend jfk-input__diy-icon"},[t("div",{staticClass:"el-input-group__prepend"},[t("i",{staticClass:"jfkfont icon-ipt_icon_lte_default"})]),e._v(" "),t("el-date-picker",{staticClass:"jfk-datepicker--width-auto",attrs:{type:"date",editable:!1,placeholder:"最迟离店日期"},on:{change:e.eDateEChange},model:{value:e.form.eDateE,callback:function(o){e.form.eDateE=o},expression:"form.eDateE"}})],1)])],1)],1)],1),e._v(" "),t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"早餐"}},[t("el-select",{model:{value:e.form.breakfastNums,callback:function(o){e.form.breakfastNums=o},expression:"form.breakfastNums"}},e._l(e.confBfFields,function(e,o){return t("el-option",{key:o,attrs:{value:o,label:e}})}))],1)],1)],1)],1),e._v(" "),t("div",{staticClass:"jfk-fieldset"},[t("div",{staticClass:"jfk-fieldset__hd"},[t("div",{staticClass:"jfk-fieldset__title"},[e._v("价格策略")])]),e._v(" "),t("el-row",[t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"关联价格代码"}},[t("el-select",{attrs:{filterable:""},model:{value:e.form.relatedCode,callback:function(o){e.form.relatedCode=o},expression:"form.relatedCode"}},e._l(e.confPriceCodes,function(e,o){return t("el-option",{key:o,attrs:{value:o,label:e.price_name}})}))],1)],1),e._v(" "),t("el-col",{directives:[{name:"show",rawName:"v-show",value:e.showRelatedCalArea,expression:"showRelatedCalArea"}],attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"计算公式"}},[t("el-radio-group",{model:{value:e.form.relatedCalWay,callback:function(o){e.form.relatedCalWay=o},expression:"form.relatedCalWay"}},e._l(e.confCodeCalWay,function(o,a){return t("el-radio",{key:a,attrs:{label:a}},[e._v("\n                "+e._s(o)+"\n              ")])}))],1)],1),e._v(" "),t("el-col",{directives:[{name:"show",rawName:"v-show",value:e.showRelatedCalArea,expression:"showRelatedCalArea"}],attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"计算值",prop:"relatedCalValue"}},[t("el-input",{staticClass:"jfk-input__fixed-width--110",model:{value:e.form.relatedCalValue,callback:function(o){e.form.relatedCalValue=e._n(o)},expression:"form.relatedCalValue"}})],1)],1)],1)],1),e._v(" "),t("div",{staticClass:"jfk-fieldset"},[t("div",{staticClass:"jfk-fieldset__hd"},[t("div",{staticClass:"jfk-fieldset__title"},[e._v("适用范围")])]),e._v(" "),t("el-row",[t("el-col",{attrs:{lg:24,md:24}},[t("el-form-item",{attrs:{label:"酒店房型",prop:"allRooms"}},[t("el-radio-group",{nativeOn:{change:function(o){e.handleChangeAllRooms(o)}},model:{value:e.form.allRooms,callback:function(o){e.form.allRooms=o},expression:"form.allRooms"}},[t("el-radio",{attrs:{label:"1"}},[e._v("全部门店和房型")]),e._v(" "),t("el-radio",{attrs:{label:"0"}},[e._v("部分门店和房型")])],1),e._v(" "),t("el-button",{style:{padding:"4px 12px","margin-left":"5px"},attrs:{type:"primary",disabled:"1"===e.form.allRooms,size:"mini"},on:{click:e.handleAddLimitRoom}},[e._v(e._s(e.limitRoomCheckedCount>0?"修改":"添加"))])],1),e._v(" "),t("div",{staticStyle:{"margin-left":"42px"}},["0"===e.form.allRooms&&e.limitRoomCheckedCount>0?[t("el-table",{staticClass:"jfk-table--no-border",staticStyle:{width:"100%"},attrs:{data:e.hotelsChecked,"max-height":"350"}},[t("el-table-column",{attrs:{label:"酒店"},scopedSlots:e._u([{key:"default",fn:function(o){return[t("el-tag",{key:"hotel_"+o.row.hotelId,attrs:{closable:"",type:"primary"},on:{close:function(t){e.handleRomoveLimitHotel(o.row.hotelId)}}},[e._v("\n                      "+e._s(e.hotelRoomItems[o.row.hotelId].name)+"\n                    ")])]}}])}),e._v(" "),t("el-table-column",{attrs:{label:"房型"},scopedSlots:e._u([{key:"default",fn:function(o){return e._l(o.row.rooms,function(o,a){return t("el-tag",{key:a,attrs:{closable:"",type:"primary"},on:{close:function(t){e.handleRemoveLimitRoom(o,a)}}},[e._v("\n                      "+e._s(e.hotelRoomItems[o].room_ids[a].name)+"\n                    ")])})}}])})],1)]:e._e()],2)],1)],1)],1),e._v(" "),e.hasConfMemberLevel||e.hasConfPayWays?t("div",{staticClass:"jfk-fieldset"},[t("div",{staticClass:"jfk-fieldset__hd"},[t("div",{staticClass:"jfk-fieldset__title"},[e._v("适用条件")])]),e._v(" "),t("el-row",[e.hasConfMemberLevel?t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"会员等级",prop:"memberLevel"}},[t("el-radio-group",{model:{value:e.form.memberLevel,callback:function(o){e.form.memberLevel=o},expression:"form.memberLevel"}},e._l(e.confMemberLevels,function(o,a){return t("el-radio",{key:a,attrs:{label:a}},[e._v("\n                "+e._s(o)+"\n              ")])}))],1)],1):e._e(),e._v(" "),t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"预付标记",prop:"prePay"}},[t("el-radio-group",{model:{value:e.form.prePay,callback:function(o){e.form.prePay=o},expression:"form.prePay"}},[t("el-radio",{attrs:{label:1}},[e._v("显示")]),e._v(" "),t("el-radio",{attrs:{label:0}},[e._v("不显示")])],1)],1)],1),e._v(" "),e.hasConfPayWays?t("el-col",{attrs:{lg:12,md:24}},[t("el-form-item",{attrs:{label:"支付方式",prop:"payWays"}},[t("el-checkbox",{staticClass:"checkbox-indeterminate",attrs:{indeterminate:e.payWayIndeterminate},on:{change:e.handlePayWaysCheckAll},model:{value:e.payWayCheckAll,callback:function(o){e.payWayCheckAll=o},expression:"payWayCheckAll"}},[e._v("\n              全选\n            ")]),e._v(" "),t("el-checkbox-group",{staticClass:"jfk-d-ib",on:{change:e.handlePayWayChange},model:{value:e.form.payWays,callback:function(o){e.form.payWays=o},expression:"form.payWays"}},e._l(e.confPayWays,function(o,a){return t("el-checkbox",{key:a,attrs:{min:1,label:a}},[e._v("\n                "+e._s(o.pay_name)+"\n              ")])}))],1)],1):e._e()],1)],1):e._e(),e._v(" "),t("div",{staticClass:"jfk-fieldset"},[t("div",{staticClass:"jfk-fieldset__hd"},[t("div",{staticClass:"jfk-fieldset__title"},[e._v("套餐属性")])]),e._v(" "),t("el-row",[t("el-col",[t("el-form-item",{attrs:{label:"开启套餐属性"}},[t("el-switch",{attrs:{disabled:e.isPackageDisable,"on-text":"开启","off-text":"关闭","on-value":"1","off-value":"0"},model:{value:e.form.isPackages,callback:function(o){e.form.isPackages=o},expression:"form.isPackages"}}),e._v(" "),t("span",{directives:[{name:"show",rawName:"v-show",value:e.isPackageDisable,expression:"isPackageDisable"}],staticClass:"jfk-color--warning"},[e._v("支付方式包含"+e._s(e.packagePaymentSupportText)+"才能开启套餐属性")])],1)],1)],1),e._v(" "),t("el-row",[t("el-col",[t("el-form-item",{directives:[{name:"show",rawName:"v-show",value:"1"===e.form.isPackages,expression:"form.isPackages === '1'"}],attrs:{required:"",label:"销售方式",prop:"goodInfoSaleWay"}},[t("el-radio",{staticClass:"goodInfo_sale_way",attrs:{label:1},on:{input:e.handlegoodInfoSaleWayChange},model:{value:e.form.goodInfoSaleWay,callback:function(o){e.form.goodInfoSaleWay=o},expression:"form.goodInfoSaleWay"}},[e._v("包价")]),e._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:1===e.form.goodInfoSaleWay,expression:"form.goodInfoSaleWay === 1"}],staticClass:"jfk-d-ib"},[t("el-radio",{attrs:{label:1},on:{input:e.handlegoodInfoSaleWayChange},model:{value:e.form.goodInfoCountWay,callback:function(o){e.form.goodInfoCountWay=o},expression:"form.goodInfoCountWay"}},[e._v("按房晚赠送")]),e._v(" "),t("el-radio",{attrs:{label:2},on:{input:e.handlegoodInfoSaleWayChange},model:{value:e.form.goodInfoCountWay,callback:function(o){e.form.goodInfoCountWay=o},expression:"form.goodInfoCountWay"}},[e._v("按订单赠送")])],1),e._v(" "),t("div",[t("el-radio",{staticClass:"goodInfo_sale_way",attrs:{label:2},on:{input:e.handlegoodInfoSaleWayChange},model:{value:e.form.goodInfoSaleWay,callback:function(o){e.form.goodInfoSaleWay=o},expression:"form.goodInfoSaleWay"}},[e._v("自由组合")])],1)],1),e._v(" "),t("el-form-item",{directives:[{name:"show",rawName:"v-show",value:"1"===e.form.isPackages&&1===e.form.goodInfoSaleWay,expression:"form.isPackages === '1' && form.goodInfoSaleWay === 1"}],staticClass:"saleNotice-item",attrs:{required:"",label:"订购须知",prop:"goodInfoSaleNotice"}},[t("el-input",{attrs:{type:"textarea",autosize:{minRows:2,maxRows:6}},nativeOn:{paste:function(o){e.handleGoodNoticePaste(o)}},model:{value:e.form.goodInfoSaleNotice,callback:function(o){e.form.goodInfoSaleNotice=o},expression:"form.goodInfoSaleNotice"}}),e._v(" "),t("span",{staticClass:"notice-tip jfk-color--base-gray"},[e._v(e._s(e.noticeNumber)+"个字，最多"+e._s(e.noticeMaxNumber)+"个字")])],1)],1)],1)],1),e._v(" "),t("el-row",{attrs:{type:"flex",justify:"center"}},[t("el-button",{staticClass:"jfk-button--large",attrs:{type:"primary",size:"large"},nativeOn:{click:function(o){o.preventDefault(),e.handleNextStep(o)}}},[e._v("下一步")])],1)],1),e._v(" "),t("el-dialog",{staticClass:"jfk-dialog__title--center jfk-dialog__hotelRooms",attrs:{title:"添加酒店和房型",visible:e.limitRoom.dialog,"lock-scroll":"",size:"small"},on:{"update:visible":function(o){e.limitRoom.dialog=o},close:e.handleCloseLimitRoomDialog,open:e.handleOpenLimitRoomDialog}},[t("el-row",{staticClass:"hotelRoom_control"},[t("el-col",{staticClass:"checkall-input-box",attrs:{span:12}},[t("el-checkbox",{on:{change:e.handleCheckAllLimitRoomByPage},model:{value:e.limitRoom.currentPageHasAllChecked,callback:function(o){e.limitRoom.currentPageHasAllChecked=o},expression:"limitRoom.currentPageHasAllChecked"}},[e._v("全选当前页")])],1),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-input",{ref:"limitRoomKeywordInput",attrs:{size:"small",placeholder:"请输入门店名称"}},[t("el-button",{attrs:{icon:"search"},on:{click:e.handleSearchLimitRoom},slot:"append"})],1)],1)],1),e._v(" "),t("div",{directives:[{name:"loading",rawName:"v-loading",value:e.roomLoading,expression:"roomLoading"}],staticClass:"hotelRoom-box"},[t("el-tree",{ref:"limitRoomTree",attrs:{data:e.hotels,"show-checkbox":"","node-key":"nid","hightlight-current":"","default-checked-keys":e.limitRoom.defaultChecked,props:e.limitRoom.roomsProps},on:{"check-change":e.handleLimitRoomCheckChange}}),e._v(" "),t("div",{staticClass:"jfk-ta-r"},[t("el-pagination",{directives:[{name:"show",rawName:"v-show",value:e.limitRoom.count>e.limitRoom.size,expression:"limitRoom.count > limitRoom.size"}],staticClass:"jfk-d-ib jfk-mt-20",attrs:{"current-page":e.limitRoom.page,"page-size":e.limitRoom.size,layout:"prev, pager, next, jumper",total:e.limitRoom.count},on:{"current-change":e.handleLimitRoomCurrentChange,"update:currentPage":function(o){e.limitRoom.page=o}}})],1)],1),e._v(" "),t("el-row",{staticClass:"hotelRoom__footer",slot:"footer"},[t("el-col",{staticClass:"jfk-ta-l jfk-fz-12 jfk-color--base-gray",attrs:{span:12}},[e._v("已选"),t("span",{staticClass:"jfk-color--base-silver"},[e._v(" "+e._s(e.limitRoomCheckedCount)+" ")]),e._v("家,共"+e._s(e.hotelRoomIds.__default__.count)+"家")]),e._v(" "),t("el-col",{attrs:{span:12}},[t("el-button",{attrs:{type:"primary"},on:{click:e.handleCloseLimitRoomDialog}},[e._v("完成")])],1)],1)],1)],1)},staticRenderFns:[]}}});