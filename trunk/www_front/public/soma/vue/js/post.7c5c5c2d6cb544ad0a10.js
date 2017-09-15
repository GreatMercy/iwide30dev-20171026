webpackJsonp([6,34],{158:function(s,e,t){"use strict";function i(s){return s&&s.__esModule?s:{default:s}}Object.defineProperty(e,"__esModule",{value:!0});var a=t(8),d=i(a),r=t(426),n=i(r);e.default=function(){new d.default({el:"#app",template:"<App/>",components:{App:n.default}})}},171:function(s,e,t){!function(e,t){s.exports=t()}(0,function(){return function(s){function e(i){if(t[i])return t[i].exports;var a=t[i]={i:i,l:!1,exports:{}};return s[i].call(a.exports,a,a.exports,e),a.l=!0,a.exports}var t={};return e.m=s,e.c=t,e.i=function(s){return s},e.d=function(s,t,i){e.o(s,t)||Object.defineProperty(s,t,{configurable:!1,enumerable:!0,get:i})},e.n=function(s){var t=s&&s.__esModule?function(){return s.default}:function(){return s};return e.d(t,"a",t),t},e.o=function(s,e){return Object.prototype.hasOwnProperty.call(s,e)},e.p="/",e(e.s=167)}({167:function(s,e,t){"use strict";function i(s,e){for(var t=0,i=e.length;t<i;){var a=e[t];if(!n(a,s))return{passed:!1,message:a.message,index:t};t++}return{passed:!0}}Object.defineProperty(e,"__esModule",{value:!0}),e.default=i;var a=function(s){return"string"===s||"url"===s||"hex"===s||"email"===s||"pattern"===s},d=function(s,e){return void 0===s||null===s||!("array"!==e||!Array.isArray(s)||s.length)||!(!a(e)||"string"!=typeof s||s)},r={phone:function(s){return/1\d{10}/.test(s)},integer:function(s){return/^[0-9]+$/.test(s)},required:function(s){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"string";return!d(s,e)},range:function(s){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"string",t=arguments[2],i=arguments[3],a=arguments[4],d=s;return"string"!==e&&"array"!==e||(d=s.length),a?d===a:void 0!==t&&void 0===i?d>=t:void 0===t&&void 0!==i?d<=i:void 0===t||void 0===i||d>=t&&d<=i}},n=function(s,e){return s.required?r.required(e,s.type):s.type&&r[s.type]?r[s.type](e):s.length?r.range(e,s.type,s.min,s.max,s.len):s.validator?s.validator(e,s):void 0}}})})},172:function(s,e,t){"use strict";e.__esModule=!0;var i=t(174),a=function(s){return s&&s.__esModule?s:{default:s}}(i);e.default=function(s,e,t){return e in s?(0,a.default)(s,e,{value:t,enumerable:!0,configurable:!0,writable:!0}):s[e]=t,s}},174:function(s,e,t){s.exports={default:t(175),__esModule:!0}},175:function(s,e,t){t(176);var i=t(3).Object;s.exports=function(s,e,t){return i.defineProperty(s,e,t)}},176:function(s,e,t){var i=t(14);i(i.S+i.F*!t(6),"Object",{defineProperty:t(9).f})},179:function(s,e,t){"use strict";function i(s,e,t){for(var i=s.length,a=Math.min(t||0,i);a<i;){if(e(s[a]))return a;a++}return-1}function a(){var s=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:location.href,i=arguments[3],a=(0,r.default)({t:Date.now()},s);window.history.pushState(a,e,t),window.addEventListener("popstate",function(){setTimeout(function(){i&&i()},100)})}Object.defineProperty(e,"__esModule",{value:!0});var d=t(29),r=function(s){return s&&s.__esModule?s:{default:s}}(d);e.findIndex=i,e.showFullLayer=a},189:function(s,e,t){"use strict";function i(s){return s&&s.__esModule?s:{default:s}}Object.defineProperty(e,"__esModule",{value:!0});var a=t(172),d=i(a),r=t(52),n=i(r),o=t(29),c=i(o),l=t(27),u=t(171),f=i(u),_={province:"",city:"",region:"",contact:"",phone:"",address:""};e.default={name:"jfk-address",components:{"address-select":function(){return t.e(35).then(t.bind(null,325))}},data:function(){var s=this;return{aid:"-1",eaid:"-1",isEditing:!1,loading:!1,actionsheetVisible:!1,addressDataLoaded:!1,addressPicked:{},addressRegionIds:[],rules:{contact:[{required:!0,message:"收件人为空"},{max:10,length:!0,message:"收件人必须在10个字符内"}],phone:[{required:!0,message:"收件电话为空"},{type:"phone",message:"手机号码错误"}],area:[{validator:function(){return s.addressPicked.province},message:"收件地址为空"}],address:[{required:!0,message:"详细地址为空"}]},validResult:{contact:{passed:!1,message:""},phone:{passed:!1,message:""},area:{passed:!1,message:""},address:{passed:!1,message:""}}}},beforeCreate:function(){this.maxHeight=window.innerHeight-45-15+"px"},created:function(){this.aid=this.addressId,this.address.length||(this.isEditing=!0)},computed:{showAdd:function(){return this.addressDataLoaded||(this.loading=!0),!this.address.length||!!this.isEditing},addressPickedDetail:function(){var s=this.addressPicked,e=s.province_name,t=void 0===e?"":e,i=s.city_name,a=void 0===i?"":i,d=s.region_name;return t+a+(void 0===d?"":d)},addressItems:{get:function(){return this.address},set:function(s){this.$emit("update:address",s)}}},watch:{isEditing:function(s){if(s){var e=(0,c.default)({},_),t=this.eaid,i=this.address;if("-1"!==t&&i.length){var a=i.filter(function(s){return s.address_id===t});e=(0,c.default)(e,a[0])}this.addressPicked=e}},addressId:function(s){this.aid=s},showAddressList:function(s){s&&this.addressItems.length&&(this.eaid="-1",this.isEditing=!1)}},methods:{handleEditAddress:function(s){this.isEditing=!0,this.eaid=s},checkForm:function(){var s=this.addressPicked,e=this.rules,t=this,i=!0;for(var a in e){var r=(0,f.default)(s[a],e[a]);t.validResult=(0,c.default)({},t.validResult,(0,d.default)({},a,(0,n.default)({},r,{show:!r.passed}))),r.passed||(i=!1)}return i},handleSaveAddress:function(){if(this.checkForm()){var s=this,e=this.addressPicked,t=this.addressItems,i=e.address_id,a=(0,c.default)({},e),d=this.$jfkToast({isLoading:!0,duration:-1,iconClass:"jfk-loading__snake",zIndex:1e5});(0,l.postExpressSave)(a,{REJECTERRORCONFIG:{serveError:!0}}).then(function(a){if(d.close(),s.eaid="-1",s.isEditing=!1,e.address_id=a.web_data.address_id,i){for(var r=-1,n=t.length,o=0;o<n;){if(t[o].address_id===i){r=o;break}o++}t.splice(r,1,e)}else t.unshift(e);s.$emit("pick-address",a.web_data.address_id)}).catch(function(e){if(1001===e.status&&e.web_data.error){var t=e.web_data.error,i={};for(var a in t)i[a]={message:t[a],passed:!1,show:!0};s.validResult=(0,c.default)({},s.validResult,i)}d.close()})}},handlePickAddress:function(s){this.$emit("pick-address",s)},handleAddAddress:function(){this.eaid="-1",this.isEditing=!0},handleAddressLoaded:function(){this.loading=!1,this.addressDataLoaded=!0},handleAddressPicked:function(s,e){this.actionsheetVisible=!1,this.addressPicked=(0,c.default)({},this.addressPicked,{province:e[0].region_id,province_name:e[0].region_name,city:e[1].region_id,city_name:e[1].region_name,region:e[2]&&e[2].region_id,region_name:e[2]&&e[2].region_name})},handleShowAddressSelect:function(){var s=this.addressPicked;this.addressRegionIds=[s.province,s.city,s.region],this.actionsheetVisible=!0},handleHiddenError:function(s){this.validResult=(0,c.default)({},this.validResult,(0,d.default)({},s,{show:!1}))}},props:{address:{type:Array,required:!0,default:function(){return[]}},addressId:String,showAddressList:Number}}},198:function(s,e,t){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=t(189),a=t.n(i),d=t(207),r=t(26),n=r(a.a,d.a,null,null,null);e.default=n.exports},207:function(s,e,t){"use strict";var i=function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("div",{staticClass:"jfk-address jfk-form font-size--28"},[t("div",{directives:[{name:"show",rawName:"v-show",value:s.showAdd,expression:"showAdd"}],staticClass:"jfk-address__add"},[t("form",{staticClass:"jfk-address-form  jfk-pl-30 jfk-pr-30"},[t("div",{staticClass:"form-item"},[t("label",[t("span",{staticClass:"form-item__label form-item__label--word-3 font-color-extra-light-gray"},[s._v("收件人")]),s._v(" "),t("div",{staticClass:"form-item__body"},[t("input",{directives:[{name:"model",rawName:"v-model",value:s.addressPicked.contact,expression:"addressPicked.contact"}],staticClass:"font-color-white",attrs:{type:"text",placeholder:"请输入收件人"},domProps:{value:s.addressPicked.contact},on:{input:function(e){e.target.composing||(s.addressPicked.contact=e.target.value)}}}),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.contact.show,expression:"validResult.contact.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("contact")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.contact.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])])])]),s._v(" "),t("div",{staticClass:"form-item"},[t("label",[t("span",{staticClass:"form-item__label font-color-extra-light-gray"},[s._v("收件电话")]),s._v(" "),t("div",{staticClass:"form-item__body"},[t("input",{directives:[{name:"model",rawName:"v-model",value:s.addressPicked.phone,expression:"addressPicked.phone"}],staticClass:"font-color-white",attrs:{type:"text",placeholder:"请输入收件人手机号码"},domProps:{value:s.addressPicked.phone},on:{input:function(e){e.target.composing||(s.addressPicked.phone=e.target.value)}}}),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.phone.show,expression:"validResult.phone.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("phone")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.phone.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])])])]),s._v(" "),t("div",{staticClass:"form-item form-item__select"},[t("span",{staticClass:"form-item__label  font-color-extra-light-gray"},[s._v("收件地址")]),s._v(" "),t("div",{staticClass:"form-item__body",on:{click:s.handleShowAddressSelect}},[t("p",{directives:[{name:"show",rawName:"v-show",value:!s.addressPickedDetail,expression:"!addressPickedDetail"}],staticClass:"tip font-color-light-gray"},[s._v("请选择收件区域")]),s._v(" "),t("p",{directives:[{name:"show",rawName:"v-show",value:s.addressPickedDetail,expression:"addressPickedDetail"}],staticClass:"tip font-color-white"},[s._v(s._s(s.addressPickedDetail))]),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.area.show,expression:"validResult.area.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("area")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.area.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])]),s._v(" "),s._m(0)]),s._v(" "),t("div",{staticClass:"form-item"},[t("label",[t("span",{staticClass:"form-item__label font-color-extra-light-gray"},[s._v("详细地址")]),s._v(" "),t("div",{staticClass:"form-item__body"},[t("textarea",{directives:[{name:"model",rawName:"v-model",value:s.addressPicked.address,expression:"addressPicked.address"}],staticClass:"font-color-white",attrs:{rows:"2",placeholder:"如街道、楼层等"},domProps:{value:s.addressPicked.address},on:{input:function(e){e.target.composing||(s.addressPicked.address=e.target.value)}}}),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:s.validResult.address.show,expression:"validResult.address.show"}],staticClass:"form-item__status is-error",on:{click:function(e){s.handleHiddenError("address")}}},[t("i",{staticClass:"form-item__status-icon jfk-font icon-msg_icon_error_norma"}),s._v(" "),t("span",{staticClass:"form-item__status-tip"},[t("i",{staticClass:"form-item__status-cont"},[s._v(s._s(s.validResult.address.message))]),s._v(" "),t("i",{staticClass:"form-item__status-trigger"},[s._v("重新输入")])])])])])])]),s._v(" "),t("div",{staticClass:"jfk-address__add-control"},[t("a",{staticClass:"jfk-button--free jfk-button jfk-button--primary is-special",attrs:{href:"javascript:;"},on:{click:s.handleSaveAddress}},[s._v("保存")])])]),s._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:!s.showAdd,expression:"!showAdd"}],staticClass:"jfk-address__list jfk-pl-30 jfk-pr-30"},[t("ul",{staticClass:"jfk-address__list-box jfk-pt-30",style:{"max-height":s.maxHeight}},s._l(s.addressItems,function(e){return t("li",{key:e.address_id,staticClass:"jfk-address__list-item jfk-pb-30"},[t("div",{staticClass:"jfk-radio jfk-radio--shape-rect color-golden"},[t("label",{staticClass:"jfk-radio__label"},[t("input",{directives:[{name:"model",rawName:"v-model",value:s.aid,expression:"aid"}],attrs:{type:"radio"},domProps:{checked:e.address_id===s.aid,value:e.address_id,checked:s._q(s.aid,e.address_id)},on:{__c:function(t){s.aid=e.address_id}}}),s._v(" "),t("div",{staticClass:"jfk-radio__text",on:{click:function(t){s.handlePickAddress(e.address_id)}}},[t("div",{staticClass:"jfk-address__list-item-cont jfk-flex is-align-middle"},[t("div",{staticClass:"address-item-box"},[t("div",{staticClass:"address-item-cont font-color-white"},[t("span",{staticClass:"contact"},[s._v(s._s(e.contact))]),s._v(" "),t("span",{staticClass:"phone"},[s._v(s._s(e.phone))])]),s._v(" "),t("div",{staticClass:"address-item-cont font-color-extra-light-gray"},[s._v("\n                    "+s._s((e.provice_name||"")+(e.city_name||"")+(e.region_name||"")+(e.address||""))+"\n                  ")])]),s._v(" "),t("div",{staticClass:"address-item-edit jfk-flex is-align-middle is-justify-center",on:{click:function(t){t.preventDefault(),t.stopPropagation(),s.handleEditAddress(e.address_id)}}},[t("i",{staticClass:"edit-icon jfk-font icon-mall_icon_edit color-golden"})])])]),s._v(" "),s._m(1,!0)])])])})),s._v(" "),t("div",{staticClass:"jfk-address__list-control"},[t("a",{staticClass:"jfk-button jfk-button--suspension jfk-button-higher jfk-button--free",attrs:{href:"javascript:;"},on:{click:s.handleAddAddress}},[t("i",{staticClass:"jfk-address__list-icon jfk-d-ib"},[s._v("+")]),t("i",{staticClass:"jfk-d-ib"},[s._v("新增收货地址")])])])]),s._v(" "),t("jfk-popup",{staticClass:"jfk-actionsheet jfk-actionsheet__address",attrs:{closeOnClickModal:!1,position:"bottom"},model:{value:s.actionsheetVisible,callback:function(e){s.actionsheetVisible=e},expression:"actionsheetVisible"}},[t("address-select",{attrs:{ids:s.addressRegionIds},on:{"address-data-loaded":s.handleAddressLoaded,"address-picked":s.handleAddressPicked}})],1)],1)},a=[function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("span",{staticClass:"form-item__foot"},[t("i",{staticClass:"jfk-font icon-user_icon_jump_normal font-color-extra-light-gray"})])},function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("span",{staticClass:"jfk-radio__icon"},[t("i",{staticClass:"jfk-font icon-radio_icon_selected_default jfk-radio__icon-icon"})])}],d={render:i,staticRenderFns:a};e.a=d},370:function(s,e,t){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=t(27),a=t(198),d=function(s){return s&&s.__esModule?s:{default:s}}(a),r=t(179),n=t(28),o=n.default(location.href);e.default={components:{jfkAddress:d.default},computed:{},beforeCreate:function(){this.$pageNamespace(o),this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0})},methods:{deliver:function(){var s=this;if(this.product.arid){this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0});var e={aiid:this.aiid||"",num:this.count||1,arid:this.product.arid,product_id:this.product.product_id};(0,i.posExpressCommit)(e).then(function(e){var t=e.web_data.detail_url;window.location.href=t,s.toast.close()}).catch(function(){s.toast.close()})}},addAddress:function(){var s=this,e=function(){s.addressShow=!1};(0,r.showFullLayer)(null,"",location.href,e),this.addressShow=!0},getAddress:function(s){var e=null;if(this.address&&this.address.length>0)for(var t=0;t<this.address.length;t++)this.address[t].address_id===s&&(e=this.address[t]);return e},setProduct:function(s){null!==s&&(this.product.phone=s.phone,this.product.address=s.province_name+s.city_name+s.region_name+s.address,this.product.user_name=s.contact,this.product.address_show=!0)},handlePickedAddress:function(s){var e=this.getAddress(s);this.setProduct(e),this.product.arid=s,history.back(-1)},selectAddress:function(){var s=this,e=function(){var e=function(){s.addressShow=!1};(0,r.showFullLayer)(null,"",location.href,e),s.addressShow=!0,s.toast.close()};if(this.address&&this.address.length>0)return e(),!1;this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,i.getExpressAddress)().then(function(t){s.address=t.web_data,e()})}},created:function(){var s=this;this.showAddressList=Date.now(),(0,i.getExpressIndex)({oid:o.oid||"",gid:o.gid||""}).then(function(e){s.toast.close();var t=e.web_data;s.max=parseInt(t.count),s.product={count:t.count||0,product_id:t.product.product_id||"",name:t.product.name||"",provider:"由"+t.wechat_name+"提供",address:t.address||"",arid:t.arid||"",user_name:t.contact||"",phone:t.phone||""},void 0===t.wechat_name&&(s.product.provider=""),s.aiid=t.aiid,t&&t.address&&t.arid?(s.product.address_show=!0,s.$store.commit("updateAddressId",s.product.arid)):s.product.address_show=!1}).catch(function(){s.toast.close()})},data:function(){return{count:1,min:1,max:1,aiid:"",product:{},addressLayerVisible:!1,address:[],showAddressList:0,addressShow:!1}}}},426:function(s,e,t){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=t(370),a=t.n(i),d=t(474),r=t(26),n=r(a.a,d.a,null,null,null);e.default=n.exports},474:function(s,e,t){"use strict";var i=function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("div",[s.addressShow?s._e():t("div",{staticClass:"jfk-pages jfk-pages__post"},[t("div",{staticClass:"jfk-pages__theme"}),s._v(" "),s.product.address_show?t("div",{staticClass:"invoice-address jfk-pl-30 jfk-pr-30",on:{click:s.selectAddress}},[t("div",{staticClass:"invoice-address__content"},[t("ul",[t("li",{staticClass:"jfk-flex font-size--24"},[t("div",{staticClass:"invoice-address__title invoice-address__word"},[s._v("收件人")]),s._v(" "),t("div",{staticClass:"invoice-address__item-content font-size--28"},[t("i",{domProps:{textContent:s._s(s.product.user_name)}}),s._v(" "),t("small",{staticClass:"font-size--28",domProps:{textContent:s._s(s.product.phone)}})])]),s._v(" "),t("li",{staticClass:"jfk-flex font-size--24"},[t("div",{staticClass:"invoice-address__title"},[s._v("收件地址")]),s._v(" "),t("div",{staticClass:"invoice-address__item-content font-size--28",domProps:{textContent:s._s(s.product.address)}})])]),s._v(" "),t("span",{staticClass:"jfk-font icon-user_icon_jump_normal font-size--24"}),s._v(" "),t("div",{staticClass:"invoice-address__line"})])]):t("div",{staticClass:"invoice-add-address jfk-pl-30 jfk-pr-30",on:{click:s.addAddress}},[s._m(0)]),s._v(" "),t("div",{staticClass:"post-info jfk-pl-30 jfk-pr-30"},[t("div",{staticClass:"post-info__name"},[t("i",{staticClass:"post-info__name--mask color-golden"}),s._v(" "),t("span",{staticClass:"font-size--38",domProps:{textContent:s._s(s.product.name)}})]),s._v(" "),t("div",{staticClass:"post-info__hotel font-size--24",domProps:{textContent:s._s(s.product.provider)}}),s._v(" "),t("div",{staticClass:"post-info__number font-size--24"},[s._v("共拥有"),t("span",{domProps:{textContent:s._s(s.product.count)}}),s._v("份")])]),s._v(" "),t("div",{staticClass:"jfk-pl-30 jfk-pr-30 post-number-wrap"},[t("div",{staticClass:"post-number is-align-middle jfk-flex"},[t("div",{staticClass:"post-number__title font-size--28"},[s._v("邮寄数量")]),s._v(" "),t("div",{staticClass:"font-size--32 post-number__content jfk-ta-r"},[t("jfk-input-number",{staticClass:"jfk-d-ib",attrs:{min:s.min,max:s.max},model:{value:s.count,callback:function(e){s.count=e},expression:"count"}})],1)])]),s._v(" "),t("div",{staticClass:"post-btn"},[t("button",{staticClass:"jfk-button jfk-button--primary is-plain font-size--30 jfk-button--free",class:{"is-disabled":!s.product.arid},on:{click:s.deliver}},[t("span",[s._v("立即发货")])])]),s._v(" "),s._m(1)],1),s._v(" "),s.addressShow?t("div",{staticClass:"page-address"},[t("div",{staticClass:"jfk-pages__theme"}),s._v(" "),t("jfk-address",{attrs:{address:s.address,addressId:s.product.arid,"show-address-list":s.showAddressList},on:{"update:address":function(e){s.address=e},"pick-address":s.handlePickedAddress}})],1):s._e()])},a=[function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("div",{staticClass:"invoice-add-address__content jfk-flex is-align-middle font-size--28"},[t("i",{staticClass:"jfk-d-ib color-golden"}),t("span",[s._v("新增收货地址")])])},function(){var s=this,e=s.$createElement;return(s._self._c||e)("jfk-support")}],d={render:i,staticRenderFns:a};e.a=d}});