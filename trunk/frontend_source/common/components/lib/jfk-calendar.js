!function(t,e){if("object"==typeof exports&&"object"==typeof module)module.exports=e();else if("function"==typeof define&&define.amd)define([],e);else{var n=e();for(var r in n)("object"==typeof exports?exports:t)[r]=n[r]}}(this,function(){return function(t){function e(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,e),o.l=!0,o.exports}var n={};return e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/",e(e.s=60)}([function(t,e){var n=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=n)},function(t,e,n){t.exports=!n(5)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(t,e){var n=t.exports={version:"2.4.0"};"number"==typeof __e&&(__e=n)},function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},,function(t,e){t.exports=function(t){try{return!!t()}catch(t){return!0}}},function(t,e,n){var r=n(8),o=n(26),a=n(21),i=Object.defineProperty;e.f=n(1)?Object.defineProperty:function(t,e,n){if(r(t),e=a(e,!0),r(n),o)try{return i(t,e,n)}catch(t){}if("get"in n||"set"in n)throw TypeError("Accessors not supported!");return"value"in n&&(t[e]=n.value),t}},function(t,e,n){var r=n(27),o=n(15);t.exports=function(t){return r(o(t))}},function(t,e,n){var r=n(3);t.exports=function(t){if(!r(t))throw TypeError(t+" is not an object!");return t}},function(t,e,n){var r=n(6),o=n(13);t.exports=n(1)?function(t,e,n){return r.f(t,e,o(1,n))}:function(t,e,n){return t[e]=n,t}},function(t,e){var n={}.hasOwnProperty;t.exports=function(t,e){return n.call(t,e)}},function(t,e){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},function(t,e,n){var r=n(19);t.exports=function(t,e,n){if(r(t),void 0===e)return t;switch(n){case 1:return function(n){return t.call(e,n)};case 2:return function(n,r){return t.call(e,n,r)};case 3:return function(n,r,o){return t.call(e,n,r,o)}}return function(){return t.apply(e,arguments)}}},function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},,function(t,e){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on  "+t);return t}},function(t,e,n){var r=n(0),o=n(2),a=n(12),i=n(9),u=function(t,e,n){var s,c,f,l=t&u.F,d=t&u.G,h=t&u.S,p=t&u.P,y=t&u.B,v=t&u.W,m=d?o:o[e]||(o[e]={}),g=m.prototype,_=d?r:h?r[e]:(r[e]||{}).prototype;d&&(n=e);for(s in n)(c=!l&&_&&void 0!==_[s])&&s in m||(f=c?_[s]:n[s],m[s]=d&&"function"!=typeof _[s]?n[s]:y&&c?a(f,r):v&&_[s]==f?function(t){var e=function(e,n,r){if(this instanceof t){switch(arguments.length){case 0:return new t;case 1:return new t(e);case 2:return new t(e,n)}return new t(e,n,r)}return t.apply(this,arguments)};return e.prototype=t.prototype,e}(f):p&&"function"==typeof f?a(Function.call,f):f,p&&((m.virtual||(m.virtual={}))[s]=f,t&u.R&&g&&!g[s]&&i(g,s,f)))};u.F=1,u.G=2,u.S=4,u.P=8,u.B=16,u.W=32,u.U=64,u.R=128,t.exports=u},function(t,e,n){var r=n(32),o=n(25);t.exports=Object.keys||function(t){return r(t,o)}},function(t,e){var n=Math.ceil,r=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?r:n)(t)}},function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},function(t,e,n){var r=n(3),o=n(0).document,a=r(o)&&r(o.createElement);t.exports=function(t){return a?o.createElement(t):{}}},function(t,e,n){var r=n(3);t.exports=function(t,e){if(!r(t))return t;var n,o;if(e&&"function"==typeof(n=t.toString)&&!r(o=n.call(t)))return o;if("function"==typeof(n=t.valueOf)&&!r(o=n.call(t)))return o;if(!e&&"function"==typeof(n=t.toString)&&!r(o=n.call(t)))return o;throw TypeError("Can't convert object to primitive value")}},function(t,e){var n=0,r=Math.random();t.exports=function(t){return"Symbol(".concat(void 0===t?"":t,")_",(++n+r).toString(36))}},function(t,e){e.f={}.propertyIsEnumerable},,function(t,e){t.exports="constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",")},function(t,e,n){t.exports=!n(1)&&!n(5)(function(){return 7!=Object.defineProperty(n(20)("div"),"a",{get:function(){return 7}}).a})},function(t,e,n){var r=n(11);t.exports=Object("z").propertyIsEnumerable(0)?Object:function(t){return"String"==r(t)?t.split(""):Object(t)}},function(t,e,n){var r=n(29)("keys"),o=n(22);t.exports=function(t){return r[t]||(r[t]=o(t))}},function(t,e,n){var r=n(0),o=r["__core-js_shared__"]||(r["__core-js_shared__"]={});t.exports=function(t){return o[t]||(o[t]={})}},function(t,e){e.f=Object.getOwnPropertySymbols},,function(t,e,n){var r=n(10),o=n(7),a=n(36)(!1),i=n(28)("IE_PROTO");t.exports=function(t,e){var n,u=o(t),s=0,c=[];for(n in u)n!=i&&r(u,n)&&c.push(n);for(;e.length>s;)r(u,n=e[s++])&&(~a(c,n)||c.push(n));return c}},function(t,e,n){var r=n(18),o=Math.min;t.exports=function(t){return t>0?o(r(t),9007199254740991):0}},function(t,e,n){var r=n(15);t.exports=function(t){return Object(r(t))}},function(t,e,n){t.exports={default:n(40),__esModule:!0}},function(t,e,n){var r=n(7),o=n(33),a=n(39);t.exports=function(t){return function(e,n,i){var u,s=r(e),c=o(s.length),f=a(i,c);if(t&&n!=n){for(;c>f;)if((u=s[f++])!=u)return!0}else for(;c>f;f++)if((t||f in s)&&s[f]===n)return t||f||0;return!t&&-1}}},,,function(t,e,n){var r=n(18),o=Math.max,a=Math.min;t.exports=function(t,e){return t=r(t),t<0?o(t+e,0):a(t,e)}},function(t,e,n){n(44),t.exports=n(2).Object.assign},function(t,e,n){"use strict";var r=n(17),o=n(30),a=n(23),i=n(34),u=n(27),s=Object.assign;t.exports=!s||n(5)(function(){var t={},e={},n=Symbol(),r="abcdefghijklmnopqrst";return t[n]=7,r.split("").forEach(function(t){e[t]=t}),7!=s({},t)[n]||Object.keys(s({},e)).join("")!=r})?function(t,e){for(var n=i(t),s=arguments.length,c=1,f=o.f,l=a.f;s>c;)for(var d,h=u(arguments[c++]),p=f?r(h).concat(f(h)):r(h),y=p.length,v=0;y>v;)l.call(h,d=p[v++])&&(n[d]=h[d]);return n}:s},,,function(t,e,n){var r=n(16);r(r.S+r.F,"Object",{assign:n(41)})},,,function(t,e,n){"use strict";function r(t){return(t<10?"0":"")+t}Object.defineProperty(e,"__esModule",{value:!0}),e.default=r},,,,,,,,,,,,,function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(61),o=function(t){return t&&t.__esModule?t:{default:t}}(r);o.default.install=function(t){t.component(o.default.name,o.default)},e.default=o.default},function(t,e,n){"use strict";function r(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var o=n(35),a=r(o),i=n(75),u=r(i),s=n(76),c=["日","一","二","三","四","五","六"];e.default={name:"jfkCalendar",render:function(t){var e=void 0,n=this.showWeekTitle,r=this.showOtherMonthDates,o=this.weekTitles,a=this.dates,i=this.year,u=this.month,s=this.handleDateClick,c=this.prevMonthDisabled,f=this.nextMonthDisabled,l=this.prevMonth,d=this.nextMonth;n&&(e=t("div",{class:"jfk-calendar__thead font-color-light-silver"},[t("table",{class:"jfk-calendar__weeks"},[t("thead",null,[t("tr",{class:"jfk-calendar__cell"},[o.map(function(e,n){return t("td",{key:"week_"+n,class:"jfk-calendar__row"},[e])})])])])]));for(var h=[],p=a.length/7,y=0;y<p;y++){for(var v=[],m=0;m<7;m++){var g=7*y+m,_=a[g],x=void 0;(r||!r&&0===_.current)&&(x=t("jfk-date",{attrs:{value:_.date,selected:_.selected,text:_.text,content:_.content}},[])),v.push(t("td",{attrs:{title:_.key},on:{click:s(g)},class:{"jfk-calendar__row":!0,"is-today":_.today,"color-golden":_.today||_.selected||void 0!==_.range,"is-disabled":_.disabled,"is-selected":_.selected,"is-range":void 0!==_.range,"is-start":"-1"===_.range,"is-end":"1"===_.range},key:_.key},[x]))}h.push(t("tr",{class:"jfk-calendar__cell",key:"row_"+y},[v]))}return t("div",{class:"jfk-calendar"},[t("div",{class:"jfk-calendar__tools"},[t("a",{on:{click:l},class:{"is-disabled":c,"is-prev":!0,"switch-month":!0,"color-golden":!0}},[" "]),t("div",{class:"title font-color-white"},[i,"年",u,"月"]),t("a",{on:{click:d},class:{"is-disabled":f,"is-next":!0,"switch-month":!0,"color-golden":!0}},[" "])]),t("div",{class:"jfk-calendar__body"},[e,t("div",{class:"jfk-calendar__tbody"},[t("div",{class:"table-box"},[t("table",{class:"jfk-calendar__dates"},[t("tbody",null,[h])])])])])])},data:function(){return{year:0,month:0,select:[],today:""}},created:function(){this.year=this.defaultDate.getFullYear(),this.month=this.defaultDate.getMonth()+1},computed:{defaultDate:function(){return this.defaultValue||this.value&&this.value[0]||new Date},min:function(){return this.minDate?(0,s.formatDate)(this.minDate,s.dateKeyFormat):""},max:function(){return this.maxDate?(0,s.formatDate)(this.maxDate,s.dateKeyFormat):""},items:function(){var t=this.year,e=this.month,n=this.firstDay,r=this.weekMode,o=this.dateCellRender,a=this.dateTextRender,i=(0,s.formatDate)(new Date,s.dateKeyFormat),u=this.weekMode&&6||(0,s.getWeeksInMonth)(t,e,n),c=(0,s.getDatesInPrevMonth)(t,e,n),f=(0,s.getDatesInNextMonth)(t,e,n,r),l=(0,s.getDatesInMonth)(t,e),d=0,h=t,p=t,y=e,v=e,m=l,g=[];c&&(1===y&&(--h,y=13),--y,m=(0,s.getDatesInMonth)(h,y)),f&&(12===v&&(++p,v=0),++v);for(var _=0,x=0;d<u;){for(var D=0;D<7;){var b=0,M=0,k=0,w=0;c?(b=h,M=y,k=m-c+1,w=-1,--c):_<l?(b=t,M=e,k=++_):x<f&&(b=p,M=v,k=++x,w=1);var j=(0,s.formatDate)({y:b,m:M,d:k},s.dateKeyFormat),O="",F="",P="";j===i&&(O="今天",F="1"),a&&(O=a(new Date(b,M-1,k),O,b,M,k)),o&&(P=o(new Date(b,M-1,k),b,M,k)),g.push({year:b,month:M,date:k,current:w,key:j,text:O,content:P,today:F}),D++}d++}return g},weekTitles:function(){var t=this.firstDay;return c.slice(t,7).concat(c.slice(0,t))},prevMonthDisabled:function(){if(this.min){return(0,s.formatDate)({y:this.year,m:this.month,d:1},s.dateKeyFormat)<=this.min}return!1},nextMonthDisabled:function(){if(this.max){return(0,s.formatDate)({y:this.year,m:this.month,d:(0,s.getDatesInMonth)(this.year,this.month)},s.dateKeyFormat)>=this.max}return!1},dates:function(){var t=this.disabledDate,e=this.range,n=this.min,r=this.max,o=this.select;return this.items.map(function(i){var u=i.current,s=i.key,c=i.year,f=i.month,l=i.date,d="",h="",p="";if(e){var y=o[0],v=o[1];y&&(y===s?(d="-1",h="1"):v&&(v===s?(d="1",h="1"):s>y&&s<v&&(d="0")))}else o.indexOf(s)>-1&&(h="1");return u?p="1":(n&&n>s||r&&r<s)&&(p="2"),t&&(p=""+(t(new Date(c,f-1,l),p,c,f,l)||"")),(0,a.default)({},i,{range:d,selected:h,disabled:p})})}},watch:{value:function(t){this.select=t.map(function(t){return(0,s.formatDate)(t,s.dateKeyFormat)})}},methods:{prevMonth:function(){if(!this.prevMonthDisabled){var t=this.month-1;t<1&&(t=12,this.year=this.year-1),this.month=t}},nextMonth:function(){if(!this.nextMonthDisabled){var t=this.month+1;t>12&&(t=1,this.year=this.year+1),this.month=t}},handleDateClick:function(t){var e=this.dates,n=this.range,r=this.select,o=this.format,a=this.multiple,i=e[t],u=i.disabled,c=i.year,f=i.month,l=i.date,d=i.selected,h=i.key,p=this;return u?function(){}:function(){var t=!1;if(n)"1"!==d?2===r.length?p.select=[]:1===r.length?h>r?(p.select.push(h),t=!0):p.select=[h]:p.select.push(h):p.select=[];else if("1"===d)if(1===r.length)p.select=[];else{var e=r.indexOf(h);p.select.splice(e,1)}else a?p.select.push(h):p.select=[h];var i=(0,s.formatDate)({y:c,m:f,d:l},o);if(p.$emit("date-click",i,"1"!==d),a&&p.select.length>0&&(t=!0),t){var u=p.select.sort().map(function(t){var e=t.split("/");return(0,s.formatDate)({y:+e[0],m:+e[1],d:+e[2]},o)});p.$emit("date-pick",u)}}}},components:{JfkDate:u.default},props:{value:{type:Array,default:function(){return[]}},defaultValue:Date,weekMode:Boolean,range:Boolean,multiple:Boolean,minDate:Date,maxDate:Date,minRangeGap:Date,maxRangeGap:Date,switchViewByOtherMonth:Boolean,firstDay:{type:Number,default:0},showWeekTitle:{type:Boolean,default:!0},showOtherMonthDates:Boolean,dateCellRender:Function,disabledDate:Function,dateTextRender:Function,format:{type:String,default:"yyyy-MM-dd"}}}},,,,,,,,,,,,,,function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={functional:!0,render:function(t,e){var n=e.props,r=n.value,o=n.text,a=void 0===o?"":o,i=n.content,u=void 0===i?"":i,s=n.selected,c=void 0;return c=a&&"1"!==s?t("div",{class:"jfk-calendar__text"},[a]):t("div",{class:{"jfk-calendar__value":!0,"color-golden":"1"===s}},[t("i",{class:"date"},[r])]),t("div",{class:"jfk-calendar__date"},[t("div",{class:"jfk-calendar__number  font-color-white"},[t("transition",{attrs:{name:"fade",mode:"out-in"}},[c])]),t("div",{class:"jfk-calendar__content",domProps:{innerHTML:u}},[])])}}},function(t,e,n){"use strict";function r(t,e){return new Date(t,e-1,1)}function o(t){return!((t%4||!(t%100))&&t%400)}function a(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0,o=r(t,e).getDay(),a=0;return~o&&(a=o>n?o-n:o===n?0:6-n+1+o),a}function i(t,e,n,r){return r?6:7*s(t,e,n)-a(t,e,n)-u(t,e)}function u(t,e){return--e,1===e?o(t)?29:28:x[e]}function s(t,e,n){var r=u(t,e)-7+a(t,e,n);return Math.ceil(r/7)+1||0}function c(t,e,n){for(var r=0,a=1;a<e;)r+=2===a?o(t)?29:28:x[e-1],a++;return r+=n}function f(t,e,n){var r=c(t,e,n);return Math.round(r/7)}function l(t){return new Date(t.getTime())}function d(t){var e=l(t);return e.setHours(0,0,0,0),e}function h(t,e){var n=l(t);return n.setDate(t.getDate()+e),n}function p(t,e){var n=l(t);return n.setDate(t.getDate()-e),n}function y(t,e){return d(t)>d(e)}function v(t,e){var n=void 0;return n=12*(t.getFullYear()-e.getFullYear()),n+=t.getMonth(),n-=e.getMonth()}function m(t,e){var n={};return n=t.y?t:{y:t.getFullYear(),m:t.getMonth()+1,d:t.getDate()},e.replace(D,function(t){return t in b?b[t](n):t.slice(t.length-1)})}Object.defineProperty(e,"__esModule",{value:!0}),e.dateKeyFormat=void 0,e.getFirstDateInMonth=r,e.isLeapYear=o,e.getDatesInPrevMonth=a,e.getDatesInNextMonth=i,e.getDatesInMonth=u,e.getWeeksInMonth=s,e.getDatesInYear=c,e.getWeeksInYear=f,e.cloneDate=l,e.cloneAsDate=d,e.addDays=h,e.subtractDays=p,e.isAfterDate=y,e.monthDiff=v,e.formatDate=m;var g=n(47),_=function(t){return t&&t.__esModule?t:{default:t}}(g),x=[31,0,31,30,31,30,31,31,30,31,30,31],D=/d{1,4}|M{1,4}|yy(?:yy)?/g,b={yy:function(t){return t.y.substr(2)},yyyy:function(t){return t.y},M:function(t){return t.m},MM:function(t){return(0,_.default)(t.m)},d:function(t){return t.d},dd:function(t){return(0,_.default)(t.d)}};e.dateKeyFormat="yyyy/MM/dd"}])});