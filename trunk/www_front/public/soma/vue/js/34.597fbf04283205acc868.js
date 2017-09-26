webpackJsonp([34],{192:function(s,e,t){"use strict";function a(s){return s&&s.__esModule?s:{default:s}}Object.defineProperty(e,"__esModule",{value:!0});var i=t(175),d=a(i),r=t(56),o=a(r),n=t(29),c=a(n),l=t(27),_=t(174),f=a(_),m={province:"",city:"",region:"",contact:"",phone:"",address:""};e.default={name:"jfk-address",components:{"address-select":function(){return t.e(35).then(t.bind(null,328))}},data:function(){var s=this;return{aid:"-1",eaid:"-1",isEditing:!1,loading:!1,actionsheetVisible:!1,addressDataLoaded:!1,addressPicked:{},addressRegionIds:[],rules:{contact:[{required:!0,message:"收件人为空"},{max:10,length:!0,message:"收件人必须在10个字符内"}],phone:[{required:!0,message:"收件电话为空"},{type:"phone",message:"手机号码错误"}],area:[{validator:function(){return s.addressPicked.province},message:"收件地址为空"}],address:[{required:!0,message:"详细地址为空"}]},validResult:{contact:{passed:!1,message:""},phone:{passed:!1,message:""},area:{passed:!1,message:""},address:{passed:!1,message:""}}}},beforeCreate:function(){this.maxHeight=window.innerHeight-45-15+"px"},created:function(){this.aid=this.addressId,this.address.length||(this.isEditing=!0)},computed:{showAdd:function(){return this.addressDataLoaded||(this.loading=!0),!this.address.length||!!this.isEditing},addressPickedDetail:function(){var s=this.addressPicked,e=s.province_name,t=void 0===e?"":e,a=s.city_name,i=void 0===a?"":a,d=s.region_name;return t+i+(void 0===d?"":d)},addressItems:{get:function(){return this.address},set:function(s){this.$emit("update:address",s)}}},watch:{isEditing:function(s){if(s){var e=(0,c.default)({},m),t=this.eaid,a=this.address;if("-1"!==t&&a.length){var i=a.filter(function(s){return s.address_id===t});e=(0,c.default)(e,i[0])}this.addressPicked=e}},addressId:function(s){this.aid=s},showAddressList:function(s){s&&this.addressItems.length&&(this.eaid="-1",this.isEditing=!1)}},methods:{handleEditAddress:function(s){this.isEditing=!0,this.eaid=s},checkForm:function(){var s=this.addressPicked,e=this.rules,t=this,a=!0;for(var i in e){var r=(0,f.default)(s[i],e[i]);t.validResult=(0,c.default)({},t.validResult,(0,d.default)({},i,(0,o.default)({},r,{show:!r.passed}))),r.passed||(a=!1)}return a},handleSaveAddress:function(){if(this.checkForm()){var s=this,e=this.addressPicked,t=this.addressItems,a=e.address_id,i=(0,c.default)({},e),d=this.$jfkToast({isLoading:!0,duration:-1,iconClass:"jfk-loading__snake",zIndex:1e5});(0,l.postExpressSave)(i,{REJECTERRORCONFIG:{serveError:!0}}).then(function(i){if(d.close(),s.eaid="-1",s.isEditing=!1,e.address_id=i.web_data.address_id,a){for(var r=-1,o=t.length,n=0;n<o;){if(t[n].address_id===a){r=n;break}n++}t.splice(r,1,e)}else t.unshift(e);s.$emit("pick-address",i.web_data.address_id)}).catch(function(e){if(1001===e.status&&e.web_data.error){var t=e.web_data.error,a={};for(var i in t)a[i]={message:t[i],passed:!1,show:!0};s.validResult=(0,c.default)({},s.validResult,a)}d.close()})}},handlePickAddress:function(s){this.$emit("pick-address",s)},handleAddAddress:function(){this.eaid="-1",this.isEditing=!0},handleAddressLoaded:function(){this.loading=!1,this.addressDataLoaded=!0},handleAddressPicked:function(s,e){this.actionsheetVisible=!1,this.addressPicked=(0,c.default)({},this.addressPicked,{province:e[0].region_id,province_name:e[0].region_name,city:e[1].region_id,city_name:e[1].region_name,region:e[2]&&e[2].region_id,region_name:e[2]&&e[2].region_name})},handleShowAddressSelect:function(){var s=this.addressPicked;this.addressRegionIds=[s.province,s.city,s.region],this.actionsheetVisible=!0},handleHiddenError:function(s){this.validResult=(0,c.default)({},this.validResult,(0,d.default)({},s,{show:!1}))}},props:{address:{type:Array,required:!0,default:function(){return[]}},addressId:String,showAddressList:Number}}},201:function(s,e,t){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=t(192),i=t.n(a),d=t(210),r=t(26),o=r(i.a,d.a,null,null,null);e.default=o.exports},210:function(s,e,t){"use strict";var a=function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("div",{staticClass:"jfk-address jfk-form font-size--28"},[t("div",{directives:[{name:"show",rawName:"v-show",value:s.showAdd,expression:"showAdd"}],staticClass:"jfk-address__add"},[t("form",{staticClass:"jfk-address-form  jfk-pl-30 jfk-pr-30"},[t("div",{staticClass:"form-item"},[t("label",[t("span",{staticClass:"form-item__label form-item__label--word-3 font-color-extra-light-gray"},[s._v("收件人")]),s._v(" "),t("div",{staticClass:"form-item__body"},[t("input",{directives:[{name:"model",rawName:"v-model",value:s.addressPicked.contact,expression:"addressPicked.contact"}],staticClass:"font-color-white",attrs:{type:"text",placeholder:"请输入收件人"},domProps:{value:s.addressPicked.contact},on:{input:function(e){e.target.composing||(s.addressPicked.contact=e.target.value)}}}),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.contact.show,expression:"validResult.contact.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("contact")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.contact.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])])])]),s._v(" "),t("div",{staticClass:"form-item"},[t("label",[t("span",{staticClass:"form-item__label font-color-extra-light-gray"},[s._v("收件电话")]),s._v(" "),t("div",{staticClass:"form-item__body"},[t("input",{directives:[{name:"model",rawName:"v-model",value:s.addressPicked.phone,expression:"addressPicked.phone"}],staticClass:"font-color-white",attrs:{type:"text",placeholder:"请输入收件人手机号码"},domProps:{value:s.addressPicked.phone},on:{input:function(e){e.target.composing||(s.addressPicked.phone=e.target.value)}}}),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.phone.show,expression:"validResult.phone.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("phone")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.phone.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])])])]),s._v(" "),t("div",{staticClass:"form-item form-item__select"},[t("span",{staticClass:"form-item__label  font-color-extra-light-gray"},[s._v("收件地址")]),s._v(" "),t("div",{staticClass:"form-item__body",on:{click:s.handleShowAddressSelect}},[t("p",{directives:[{name:"show",rawName:"v-show",value:!s.addressPickedDetail,expression:"!addressPickedDetail"}],staticClass:"tip font-color-light-gray"},[s._v("请选择收件区域")]),s._v(" "),t("p",{directives:[{name:"show",rawName:"v-show",value:s.addressPickedDetail,expression:"addressPickedDetail"}],staticClass:"tip font-color-white"},[s._v(s._s(s.addressPickedDetail))]),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.area.show,expression:"validResult.area.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("area")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.area.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])]),s._v(" "),s._m(0)]),s._v(" "),t("div",{staticClass:"form-item"},[t("label",[t("span",{staticClass:"form-item__label font-color-extra-light-gray"},[s._v("详细地址")]),s._v(" "),t("div",{staticClass:"form-item__body"},[t("textarea",{directives:[{name:"model",rawName:"v-model",value:s.addressPicked.address,expression:"addressPicked.address"}],staticClass:"font-color-white",attrs:{rows:"2",placeholder:"如街道、楼层等"},domProps:{value:s.addressPicked.address},on:{input:function(e){e.target.composing||(s.addressPicked.address=e.target.value)}}}),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.address.show,expression:"validResult.address.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("address")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.address.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])])])])]),s._v(" "),t("div",{staticClass:"jfk-address__add-control"},[t("a",{staticClass:"jfk-button--free jfk-button jfk-button--primary is-special",attrs:{href:"javascript:;"},on:{click:s.handleSaveAddress}},[s._v("保存")])])]),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:!s.showAdd,expression:"!showAdd"}],staticClass:"jfk-address__list jfk-pl-30 jfk-pr-30"},[t("ul",{staticClass:"jfk-address__list-box jfk-pt-30",style:{"max-height":s.maxHeight}},s._l(s.addressItems,function(e){return t("li",{key:e.address_id,staticClass:"jfk-address__list-item jfk-pb-30"},[t("div",{staticClass:"jfk-radio jfk-radio--shape-rect color-golden"},[t("label",{staticClass:"jfk-radio__label"},[t("input",{directives:[{name:"model",rawName:"v-model",value:s.aid,expression:"aid"}],attrs:{type:"radio"},domProps:{checked:e.address_id===s.aid,value:e.address_id,checked:s._q(s.aid,e.address_id)},on:{__c:function(t){s.aid=e.address_id}}}),s._v(" "),t("div",{staticClass:"jfk-radio__text",on:{click:function(t){s.handlePickAddress(e.address_id)}}},[t("div",{staticClass:"jfk-address__list-item-cont jfk-flex is-align-middle"},[t("div",{staticClass:"address-item-box"},[t("div",{staticClass:"address-item-cont font-color-white"},[t("span",{staticClass:"contact"},[s._v(s._s(e.contact))]),s._v(" "),t("span",{staticClass:"phone"},[s._v(s._s(e.phone))])]),s._v(" "),t("div",{staticClass:"address-item-cont font-color-extra-light-gray"},[s._v("\n                    "+s._s((e.provice_name||"")+(e.city_name||"")+(e.region_name||"")+(e.address||""))+"\n                  ")])]),s._v(" "),t("div",{staticClass:"address-item-edit jfk-flex is-align-middle is-justify-center",on:{click:function(t){t.preventDefault(),t.stopPropagation(),s.handleEditAddress(e.address_id)}}},[t("i",{staticClass:"edit-icon jfk-font icon-mall_icon_edit color-golden"})])])]),s._v(" "),s._m(1,!0)])])])})),s._v(" "),t("div",{staticClass:"jfk-address__list-control"},[t("a",{staticClass:"jfk-button jfk-button--suspension jfk-button-higher jfk-button--free",attrs:{href:"javascript:;"},on:{click:s.handleAddAddress}},[t("i",{staticClass:"jfk-address__list-icon jfk-font icon-mall_icon_address_add"}),s._v("新增收货地址")])])]),s._v(" "),t("jfk-popup",{staticClass:"jfk-actionsheet jfk-actionsheet__address",attrs:{closeOnClickModal:!1,position:"bottom"},model:{value:s.actionsheetVisible,callback:function(e){s.actionsheetVisible=e},expression:"actionsheetVisible"}},[t("address-select",{attrs:{ids:s.addressRegionIds},on:{"address-data-loaded":s.handleAddressLoaded,"address-picked":s.handleAddressPicked}})],1)],1)},i=[function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("span",{staticClass:"form-item__foot"},[t("i",{staticClass:"jfk-font icon-user_icon_jump_normal font-color-extra-light-gray"})])},function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("span",{staticClass:"jfk-radio__icon"},[t("i",{staticClass:"jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"})])}],d={render:a,staticRenderFns:i};e.a=d}});