webpackJsonp([9],{140:function(t,e,i){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var n=i(8),o=s(n),r=i(406),a=s(r);e.default=function(){new o.default({el:"#app",template:"<App/>",components:{App:a.default}})}},174:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{wish:{type:String,default:""}}}},175:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i(174),n=i.n(s),o=i(176),r=i(25),a=r(n.a,o.a,null,null,null);e.default=a.exports},176:function(t,e,i){"use strict";var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"gift-theme"},[i("div",{staticClass:"gift-theme-bg"}),t._v(" "),i("div",{staticClass:"gift-theme-logo"}),t._v(" "),i("div",{staticClass:"gift-theme-wish jfk-ta-c jfk-pl-30 jfk-pr-30"},[i("div",{staticClass:"gift-theme-wish__content",domProps:{innerHTML:t._s(t.wish)}})])])},n=[],o={render:s,staticRenderFns:n};e.a=o},184:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i(188),n=function(t){return t&&t.__esModule?t:{default:t}}(s);e.default={name:"giftList",props:{list:{type:Array},status:{type:Number,default:1}},data:function(){return{scroll:null}},created:function(){this.initScroll()},methods:{initScroll:function(){var t=this;this.$nextTick(function(){try{t.scroll=new n.default(t.$refs.list,{bounce:!1})}catch(t){}})}}}},188:function(t,e,i){!function(e,i){t.exports=i()}(0,function(){return function(t){function e(s){if(i[s])return i[s].exports;var n=i[s]={exports:{},id:s,loaded:!1};return t[s].call(n.exports,n,n.exports,e),n.loaded=!0,n.exports}var i={};return e.m=t,e.c=i,e.p="/assets/",e(0)}([function(t,e,i){"use strict";var s=i(1);s.BScroll.Version="0.1.15",t.exports=s.BScroll},function(t,e,i){"use strict";function s(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function n(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function o(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}Object.defineProperty(e,"__esModule",{value:!0}),e.BScroll=void 0;var r=function(){function t(t,e){for(var i=0;i<e.length;i++){var s=e[i];s.enumerable=s.enumerable||!1,s.configurable=!0,"value"in s&&(s.writable=!0),Object.defineProperty(t,s.key,s)}}return function(e,i,s){return i&&t(e.prototype,i),s&&t(e,s),e}}(),a=i(2);e.BScroll=function(t){function e(t,i){s(this,e);var o=n(this,Object.getPrototypeOf(e).call(this));return o.wrapper="string"==typeof t?document.querySelector(t):t,o.scroller=o.wrapper.children[0],o.scrollerStyle=o.scroller.style,o.options={startX:0,startY:0,scrollY:!0,directionLockThreshold:5,momentum:!0,bounce:!0,selectedIndex:0,rotate:25,wheel:!1,snap:!1,snapLoop:!1,snapThreshold:.1,swipeTime:2500,bounceTime:700,adjustTime:400,swipeBounceTime:1200,deceleration:.001,momentumLimitTime:300,momentumLimitDistance:15,resizePolling:60,preventDefault:!0,preventDefaultException:{tagName:/^(INPUT|TEXTAREA|BUTTON|SELECT)$/},HWCompositing:!0,useTransition:!0,useTransform:!0},(0,a.extend)(o.options,i),o.translateZ=o.options.HWCompositing&&a.hasPerspective?" translateZ(0)":"",o.options.useTransition=o.options.useTransition&&a.hasTransition,o.options.useTransform=o.options.useTransform&&a.hasTransform,o.options.eventPassthrough=!0===o.options.eventPassthrough?"vertical":o.options.eventPassthrough,o.options.preventDefault=!o.options.eventPassthrough&&o.options.preventDefault,o.options.scrollX="horizontal"!==o.options.eventPassthrough&&o.options.scrollX,o.options.scrollY="vertical"!==o.options.eventPassthrough&&o.options.scrollY,o.options.freeScroll=o.options.freeScroll&&!o.options.eventPassthrough,o.options.directionLockThreshold=o.options.eventPassthrough?0:o.options.directionLockThreshold,!0===o.options.tap&&(o.options.tap="tap"),o._init(),o.options.snap&&o._initSnap(),o.refresh(),o.options.snap||o.scrollTo(o.options.startX,o.options.startY),o.enable(),o}return o(e,t),r(e,[{key:"_init",value:function(){this.x=0,this.y=0,this.directionX=0,this.directionY=0,this._addEvents()}},{key:"_initSnap",value:function(){var t=this;if(this.currentPage={},this.options.snapLoop){var e=this.scroller.children;e.length>0&&((0,a.prepend)(e[e.length-1].cloneNode(!0),this.scroller),this.scroller.appendChild(e[1].cloneNode(!0)))}"string"==typeof this.options.snap&&(this.options.snap=this.scroller.querySelectorAll(this.options.snap)),this.on("refresh",function(){if(t.pages=[],t.wrapperWidth&&t.wrapperHeight&&t.scrollerWidth&&t.scrollerHeight){var e=t.options.snapStepX||t.wrapperWidth,i=t.options.snapStepY||t.wrapperHeight,s=0,n=void 0,o=void 0,r=void 0,h=0,l=void 0,c=0,u=void 0,p=void 0,d=void 0;if(!0===t.options.snap)for(o=Math.round(e/2),r=Math.round(i/2);s>-t.scrollerWidth;){for(t.pages[h]=[],l=0,n=0;n>-t.scrollerHeight;)t.pages[h][l]={x:Math.max(s,t.maxScrollX),y:Math.max(n,t.maxScrollY),width:e,height:i,cx:s-o,cy:n-r},n-=i,l++;s-=e,h++}else for(p=t.options.snap,l=p.length,u=-1;h<l;h++)d=(0,a.getRect)(p[h]),(0===h||d.left<=(0,a.getRect)(p[h-1]).left)&&(c=0,u++),t.pages[c]||(t.pages[c]=[]),s=Math.max(-d.left,t.maxScrollX),n=Math.max(-d.top,t.maxScrollY),o=s-Math.round(d.width/2),r=n-Math.round(d.height/2),t.pages[c][u]={x:s,y:n,width:d.width,height:d.height,cx:o,cy:r},s>t.maxScrollX&&c++;var f=t.options.snapLoop?1:0;t.goToPage(t.currentPage.pageX||f,t.currentPage.pageY||0,0),t.options.snapThreshold%1==0?(t.snapThresholdX=t.options.snapThreshold,t.snapThresholdY=t.options.snapThreshold):(t.snapThresholdX=Math.round(t.pages[t.currentPage.pageX][t.currentPage.pageY].width*t.options.snapThreshold),t.snapThresholdY=Math.round(t.pages[t.currentPage.pageX][t.currentPage.pageY].height*t.options.snapThreshold))}}),this.on("scrollEnd",function(){t.options.snapLoop&&(0===t.currentPage.pageX&&t.goToPage(t.pages.length-2,t.currentPage.pageY,0),t.currentPage.pageX===t.pages.length-1&&t.goToPage(1,t.currentPage.pageY,0))}),this.on("flick",function(){var e=t.options.snapSpeed||Math.max(Math.max(Math.min(Math.abs(t.x-t.startX),1e3),Math.min(Math.abs(t.y-t.startY),1e3)),300);t.goToPage(t.currentPage.pageX+t.directionX,t.currentPage.pageY+t.directionY,e)})}},{key:"_nearestSnap",value:function(t,e){if(!this.pages.length)return{x:0,y:0,pageX:0,pageY:0};var i=0;if(Math.abs(t-this.absStartX)<this.snapThresholdX&&Math.abs(e-this.absStartY)<this.snapThresholdY)return this.currentPage;t>0?t=0:t<this.maxScrollX&&(t=this.maxScrollX),e>0?e=0:e<this.maxScrollY&&(e=this.maxScrollY);for(var s=this.pages.length;i<s;i++)if(t>=this.pages[i][0].cx){t=this.pages[i][0].x;break}s=this.pages[i].length;for(var n=0;n<s;n++)if(e>=this.pages[0][n].cy){e=this.pages[0][n].y;break}return i===this.currentPage.pageX&&(i+=this.directionX,i<0?i=0:i>=this.pages.length&&(i=this.pages.length-1),t=this.pages[i][0].x),n===this.currentPage.pageY&&(n+=this.directionY,n<0?n=0:n>=this.pages[0].length&&(n=this.pages[0].length-1),e=this.pages[0][n].y),{x:t,y:e,pageX:i,pageY:n}}},{key:"_addEvents",value:function(){var t=a.addEvent;this._handleEvents(t)}},{key:"_removeEvents",value:function(){var t=a.removeEvent;this._handleEvents(t)}},{key:"_handleEvents",value:function(t){var e=this.options.bindToWrapper?this.wrapper:window;t(window,"orientationchange",this),t(window,"resize",this),this.options.click&&t(this.wrapper,"click",this),this.options.disableMouse||(t(this.wrapper,"mousedown",this),t(e,"mousemove",this),t(e,"mousecancel",this),t(e,"mouseup",this)),a.hasTouch&&!this.options.disableTouch&&(t(this.wrapper,"touchstart",this),t(e,"touchmove",this),t(e,"touchcancel",this),t(e,"touchend",this)),t(this.scroller,a.style.transitionEnd,this)}},{key:"_start",value:function(t){var e=a.eventType[t.type];if((1===e||0===t.button)&&!(!this.enabled||this.destroyed||this.initiated&&this.initiated!==e)){if(this.initiated=e,!this.options.preventDefault||a.isBadAndroid||(0,a.preventDefaultException)(t.target,this.options.preventDefaultException)||t.preventDefault(),this.moved=!1,this.distX=0,this.distY=0,this.directionX=0,this.directionY=0,this.directionLocked=0,this._transitionTime(),this.startTime=+new Date,this.options.wheel&&(this.target=t.target),this.options.useTransition&&this.isInTransition){this.isInTransition=!1;var i=this.getComputedPosition();this._translate(i.x,i.y),this.options.wheel?this.target=this.items[Math.round(-i.y/this.itemHeight)]:this.trigger("scrollEnd")}var s=t.touches?t.touches[0]:t;this.startX=this.x,this.startY=this.y,this.absStartX=this.x,this.absStartY=this.y,this.pointX=s.pageX,this.pointY=s.pageY,this.trigger("beforeScrollStart")}}},{key:"_move",value:function(t){if(this.enabled&&!this.destroyed&&a.eventType[t.type]===this.initiated){this.options.preventDefault&&t.preventDefault();var e=t.touches?t.touches[0]:t,i=e.pageX-this.pointX,s=e.pageY-this.pointY;this.pointX=e.pageX,this.pointY=e.pageY,this.distX+=i,this.distY+=s;var n=Math.abs(this.distX),o=Math.abs(this.distY),r=+new Date;if(!(r-this.endTime>this.options.momentumLimitTime&&o<this.options.momentumLimitDistance&&n<this.options.momentumLimitDistance)){if(this.directionLocked||this.options.freeScroll||(n>o+this.options.directionLockThreshold?this.directionLocked="h":o>=n+this.options.directionLockThreshold?this.directionLocked="v":this.directionLocked="n"),"h"===this.directionLocked){if("vertical"===this.options.eventPassthrough)t.preventDefault();else if("horizontal"===this.options.eventPassthrough)return void(this.initiated=!1);s=0}else if("v"===this.directionLocked){if("horizontal"===this.options.eventPassthrough)t.preventDefault();else if("vertical"===this.options.eventPassthrough)return void(this.initiated=!1);i=0}i=this.hasHorizontalScroll?i:0,s=this.hasVerticalScroll?s:0;var h=this.x+i,l=this.y+s;(h>0||h<this.maxScrollX)&&(h=this.options.bounce?this.x+i/3:h>0?0:this.maxScrollX),(l>0||l<this.maxScrollY)&&(l=this.options.bounce?this.y+s/3:l>0?0:this.maxScrollY),this.directionX=i>0?-1:i<0?1:0,this.directionY=s>0?-1:s<0?1:0,this.moved||(this.moved=!0,this.trigger("scrollStart")),this._translate(h,l),r-this.startTime>this.options.momentumLimitTime&&(this.startTime=r,this.startX=this.x,this.startY=this.y,1===this.options.probeType&&this.trigger("scroll",{x:this.x,y:this.y})),this.options.probeType>1&&this.trigger("scroll",{x:this.x,y:this.y});var c=document.documentElement.scrollLeft||window.pageXOffset||document.body.scrollLeft,u=document.documentElement.scrollTop||window.pageYOffset||document.body.scrollTop,p=this.pointX-c,d=this.pointY-u;(p>document.documentElement.clientWidth-this.options.momentumLimitDistance||p<this.options.momentumLimitDistance||d<this.options.momentumLimitDistance||d>document.documentElement.clientHeight-this.options.momentumLimitDistance)&&this._end(t)}}}},{key:"_end",value:function(t){if(this.enabled&&!this.destroyed&&a.eventType[t.type]===this.initiated&&(this.initiated=!1,this.options.preventDefault&&!(0,a.preventDefaultException)(t.target,this.options.preventDefaultException)&&t.preventDefault(),this.trigger("touchend",{x:this.x,y:this.y}),!this.resetPosition(this.options.bounceTime,a.ease.bounce))){this.isInTransition=!1;var e=Math.round(this.x),i=Math.round(this.y);if(!this.moved){if(this.options.wheel){if(this.target&&"wheel-scroll"===this.target.className){var s=Math.abs(Math.round(i/this.itemHeight)),n=Math.round((this.pointY+(0,a.offset)(this.target).top-this.itemHeight/2)/this.itemHeight);this.target=this.items[s+n]}this.scrollToElement(this.target,this.options.adjustTime,!0,!0,a.ease.swipe)}else this.options.tap&&(0,a.tap)(t,this.options.tap),this.options.click&&(0,a.click)(t);return void this.trigger("scrollCancel")}this.scrollTo(e,i),this.endTime=+new Date;var o=this.endTime-this.startTime,r=Math.abs(e-this.startX),h=Math.abs(i-this.startY);if(this._events.flick&&o<this.options.momentumLimitTime&&r<this.options.momentumLimitDistance&&h<this.options.momentumLimitDistance)return void this.trigger("flick");var l=0;if(this.options.momentum&&o<this.options.momentumLimitTime&&(h>this.options.momentumLimitDistance||r>this.options.momentumLimitDistance)){var c=this.hasHorizontalScroll?(0,a.momentum)(this.x,this.startX,o,this.maxScrollX,this.options.bounce?this.wrapperWidth:0,this.options):{destination:e,duration:0},u=this.hasVerticalScroll?(0,a.momentum)(this.y,this.startY,o,this.maxScrollY,this.options.bounce?this.wrapperHeight:0,this.options):{destination:i,duration:0};e=c.destination,i=u.destination,l=Math.max(c.duration,u.duration),this.isInTransition=1}else this.options.wheel&&(i=Math.round(i/this.itemHeight)*this.itemHeight,l=this.options.adjustTime);var p=a.ease.swipe;if(this.options.snap){var d=this._nearestSnap(e,i);this.currentPage=d,l=this.options.snapSpeed||Math.max(Math.max(Math.min(Math.abs(e-d.x),1e3),Math.min(Math.abs(i-d.y),1e3)),300),e=d.x,i=d.y,this.directionX=0,this.directionY=0,p=a.ease.bounce}if(e!==this.x||i!==this.y)return(e>0||e<this.maxScrollX||i>0||i<this.maxScrollY)&&(p=a.ease.swipeBounce),void this.scrollTo(e,i,l,p);this.options.wheel&&(this.selectedIndex=0|Math.abs(this.y/this.itemHeight)),this.trigger("scrollEnd")}}},{key:"_resize",value:function(){var t=this;this.enabled&&(clearTimeout(this.resizeTimeout),this.resizeTimeout=setTimeout(function(){t.refresh()},this.options.resizePolling))}},{key:"_startProbe",value:function(){function t(){var i=e.getComputedPosition();e.trigger("scroll",i),e.isInTransition&&(e.probeTimer=(0,a.requestAnimationFrame)(t))}(0,a.cancelAnimationFrame)(this.probeTimer),this.probeTimer=(0,a.requestAnimationFrame)(t);var e=this}},{key:"_transitionTime",value:function(){var t=this,e=arguments.length<=0||void 0===arguments[0]?0:arguments[0];if(this.scrollerStyle[a.style.transitionDuration]=e+"ms",this.options.wheel&&!a.isBadAndroid)for(var i=0;i<this.items.length;i++)this.items[i].style[a.style.transitionDuration]=e+"ms";!e&&a.isBadAndroid&&(this.scrollerStyle[a.style.transitionDuration]="0.001s",(0,a.requestAnimationFrame)(function(){"0.0001ms"===t.scrollerStyle[a.style.transitionDuration]&&(t.scrollerStyle[a.style.transitionDuration]="0s")}))}},{key:"_transitionTimingFunction",value:function(t){if(this.scrollerStyle[a.style.transitionTimingFunction]=t,this.options.wheel&&!a.isBadAndroid)for(var e=0;e<this.items.length;e++)this.items[e].style[a.style.transitionTimingFunction]=t}},{key:"_transitionEnd",value:function(t){t.target===this.scroller&&this.isInTransition&&(this._transitionTime(),this.resetPosition(this.options.bounceTime,a.ease.bounce)||(this.isInTransition=!1,this.trigger("scrollEnd")))}},{key:"_translate",value:function(t,e){if(this.options.useTransform?this.scrollerStyle[a.style.transform]="translate("+t+"px,"+e+"px)"+this.translateZ:(t=Math.round(t),e=Math.round(e),this.scrollerStyle.left=t+"px",this.scrollerStyle.top=e+"px"),this.options.wheel&&!a.isBadAndroid)for(var i=0;i<this.items.length;i++){var s=this.options.rotate*(e/this.itemHeight+i);this.items[i].style[a.style.transform]="rotateX("+s+"deg)"}this.x=t,this.y=e}},{key:"enable",value:function(){this.enabled=!0}},{key:"disable",value:function(){this.enabled=!1}},{key:"refresh",value:function(){this.wrapper.offsetHeight;this.wrapperWidth=parseInt(this.wrapper.style.width)||this.wrapper.clientWidth,this.wrapperHeight=parseInt(this.wrapper.style.height)||this.wrapper.clientHeight,this.scrollerWidth=parseInt(this.scroller.style.width)||this.scroller.clientWidth,this.scrollerHeight=parseInt(this.scroller.style.height)||this.scroller.clientHeight,this.options.wheel?(this.items=this.scroller.children,this.options.itemHeight=this.itemHeight=this.items.length?this.items[0].clientHeight:0,void 0===this.selectedIndex&&(this.selectedIndex=this.options.selectedIndex),this.options.startY=-this.selectedIndex*this.itemHeight,this.maxScrollX=0,this.maxScrollY=-this.itemHeight*(this.items.length-1)):(this.maxScrollX=this.wrapperWidth-this.scrollerWidth,this.maxScrollY=this.wrapperHeight-this.scrollerHeight),this.hasHorizontalScroll=this.options.scrollX&&this.maxScrollX<0,this.hasVerticalScroll=this.options.scrollY&&this.maxScrollY<0,this.hasHorizontalScroll||(this.maxScrollX=0,this.scrollerWidth=this.wrapperWidth),this.hasVerticalScroll||(this.maxScrollY=0,this.scrollerHeight=this.wrapperHeight),this.endTime=0,this.directionX=0,this.directionY=0,this.wrapperOffset=(0,a.offset)(this.wrapper),this.trigger("refresh"),this.resetPosition()}},{key:"resetPosition",value:function(){var t=arguments.length<=0||void 0===arguments[0]?0:arguments[0],e=arguments.length<=1||void 0===arguments[1]?a.ease.bounce:arguments[1],i=this.x;!this.hasHorizontalScroll||i>0?i=0:i<this.maxScrollX&&(i=this.maxScrollX);var s=this.y;return!this.hasVerticalScroll||s>0?s=0:s<this.maxScrollY&&(s=this.maxScrollY),(i!==this.x||s!==this.y)&&(this.scrollTo(i,s,t,e),!0)}},{key:"wheelTo",value:function(t){this.options.wheel&&(this.y=-t*this.itemHeight,this.scrollTo(0,this.y))}},{key:"scrollBy",value:function(t,e){var i=arguments.length<=2||void 0===arguments[2]?0:arguments[2],s=arguments.length<=3||void 0===arguments[3]?a.ease.bounce:arguments[3];t=this.x+t,e=this.y+e,this.scrollTo(t,e,i,s)}},{key:"scrollTo",value:function(t,e,i){var s=arguments.length<=3||void 0===arguments[3]?a.ease.bounce:arguments[3];this.isInTransition=this.options.useTransition&&i>0&&(t!==this.x||e!==this.y),i&&!this.options.useTransition||(this._transitionTimingFunction(s.style),this._transitionTime(i),this._translate(t,e),i&&3===this.options.probeType&&this._startProbe(),this.options.wheel&&(e>0?this.selectedIndex=0:e<this.maxScrollY?this.selectedIndex=this.items.length-1:this.selectedIndex=0|Math.abs(e/this.itemHeight)))}},{key:"getSelectedIndex",value:function(){return this.options.wheel&&this.selectedIndex}},{key:"getCurrentPage",value:function(){return this.options.snap&&this.currentPage}},{key:"scrollToElement",value:function(t,e,i,s,n){if(t&&(t=t.nodeType?t:this.scroller.querySelector(t),!this.options.wheel||"wheel-item"===t.className)){var o=(0,a.offset)(t);o.left-=this.wrapperOffset.left,o.top-=this.wrapperOffset.top,!0===i&&(i=Math.round(t.offsetWidth/2-this.wrapper.offsetWidth/2)),!0===s&&(s=Math.round(t.offsetHeight/2-this.wrapper.offsetHeight/2)),o.left-=i||0,o.top-=s||0,o.left=o.left>0?0:o.left<this.maxScrollX?this.maxScrollX:o.left,o.top=o.top>0?0:o.top<this.maxScrollY?this.maxScrollY:o.top,this.options.wheel&&(o.top=Math.round(o.top/this.itemHeight)*this.itemHeight),e=void 0===e||null===e||"auto"===e?Math.max(Math.abs(this.x-o.left),Math.abs(this.y-o.top)):e,this.scrollTo(o.left,o.top,e,n)}}},{key:"getComputedPosition",value:function(){var t=window.getComputedStyle(this.scroller,null),e=void 0,i=void 0;return this.options.useTransform?(t=t[a.style.transform].split(")")[0].split(", "),e=+(t[12]||t[4]),i=+(t[13]||t[5])):(e=+t.left.replace(/[^-\d.]/g,""),i=+t.top.replace(/[^-\d.]/g,"")),{x:e,y:i}}},{key:"goToPage",value:function(t,e,i){var s=arguments.length<=3||void 0===arguments[3]?a.ease.bounce:arguments[3];t>=this.pages.length?t=this.pages.length-1:t<0&&(t=0),e>=this.pages[t].length?e=this.pages[t].length-1:e<0&&(e=0);var n=this.pages[t][e].x,o=this.pages[t][e].y;i=void 0===i?this.options.snapSpeed||Math.max(Math.max(Math.min(Math.abs(n-this.x),1e3),Math.min(Math.abs(o-this.y),1e3)),300):i,this.currentPage={x:n,y:o,pageX:t,pageY:e},this.scrollTo(n,o,i,s)}},{key:"next",value:function(t,e){var i=this.currentPage.pageX,s=this.currentPage.pageY;i++,i>=this.pages.length&&this.hasVerticalScroll&&(i=0,s++),this.goToPage(i,s,t,e)}},{key:"prev",value:function(t,e){var i=this.currentPage.pageX,s=this.currentPage.pageY;i--,i<0&&this.hasVerticalScroll&&(i=0,s--),this.goToPage(i,s,t,e)}},{key:"destroy",value:function(){this._removeEvents(),this.destroyed=!0,this.trigger("destroy")}},{key:"handleEvent",value:function(t){switch(t.type){case"touchstart":case"mousedown":this._start(t);break;case"touchmove":case"mousemove":this._move(t);break;case"touchend":case"mouseup":case"touchcancel":case"mousecancel":this._end(t);break;case"orientationchange":case"resize":this._resize();break;case"transitionend":case"webkitTransitionEnd":case"oTransitionEnd":case"MSTransitionEnd":this._transitionEnd(t);break;case"click":!this.enabled||t._constructed||/(SELECT|INPUT|TEXTAREA)/i.test(t.target.tagName)||(t.preventDefault(),t.stopPropagation())}}}]),e}(a.EventEmitter)},function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i(3);Object.keys(s).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return s[t]}})});var n=i(4);Object.keys(n).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return n[t]}})});var o=i(5);Object.keys(o).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return o[t]}})});var r=i(6);Object.keys(r).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return r[t]}})});var a=i(7);Object.keys(a).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return a[t]}})});var h=i(8);Object.keys(h).forEach(function(t){"default"!==t&&"__esModule"!==t&&Object.defineProperty(e,t,{enumerable:!0,get:function(){return h[t]}})})},function(t,e){"use strict";function i(t){return!1!==d&&("standard"===d?t:d+t.charAt(0).toUpperCase()+t.substr(1))}function s(t,e,i,s){t.addEventListener(e,i,{passive:!1,capture:!!s})}function n(t,e,i,s){t.removeEventListener(e,i,!!s)}function o(t){for(var e=0,i=0;t;)e-=t.offsetLeft,i-=t.offsetTop,t=t.offsetParent;return{left:e,top:i}}function r(t){if(t instanceof window.SVGElement){var e=t.getBoundingClientRect();return{top:e.top,left:e.left,width:e.width,height:e.height}}return{top:t.offsetTop,left:t.offsetLeft,width:t.offsetWidth,height:t.offsetHeight}}function a(t,e){for(var i in e)if(e[i].test(t[i]))return!0;return!1}function h(t,e){var i=document.createEvent("Event");i.initEvent(e,!0,!0),i.pageX=t.pageX,i.pageY=t.pageY,t.target.dispatchEvent(i)}function l(t){var e=t.target;if(!/(SELECT|INPUT|TEXTAREA)/i.test(e.tagName)){var i=document.createEvent(window.MouseEvent?"MouseEvents":"Event");i.initEvent("click",!0,!0),i._constructed=!0,e.dispatchEvent(i)}}function c(t,e){e.firstChild?u(t,e.firstChild):e.appendChild(t)}function u(t,e){e.parentNode.insertBefore(t,e)}Object.defineProperty(e,"__esModule",{value:!0}),e.addEvent=s,e.removeEvent=n,e.offset=o,e.getRect=r,e.preventDefaultException=a,e.tap=h,e.click=l,e.prepend=c,e.before=u;var p=document.createElement("div").style,d=function(){var t={webkit:"webkitTransform",Moz:"MozTransform",O:"OTransform",ms:"msTransform",standard:"transform"};for(var e in t)if(void 0!==p[t[e]])return e;return!1}(),f=i("transform");e.hasPerspective=i("perspective")in p,e.hasTouch="ontouchstart"in window,e.hasTransform=!1!==f,e.hasTransition=i("transition")in p,e.style={transform:f,transitionTimingFunction:i("transitionTimingFunction"),transitionDuration:i("transitionDuration"),transitionDelay:i("transitionDelay"),transformOrigin:i("transformOrigin"),transitionEnd:i("transitionEnd")},e.eventType={touchstart:1,touchmove:1,touchend:1,mousedown:2,mousemove:2,mouseup:2}},function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0});e.isBadAndroid=/Android /.test(window.navigator.appVersion)&&!/Chrome\/\d/.test(window.navigator.appVersion)},function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0});e.ease={swipe:{style:"cubic-bezier(0.23, 1, 0.32, 1)",fn:function(t){return 1+--t*t*t*t*t}},swipeBounce:{style:"cubic-bezier(0.25, 0.46, 0.45, 0.94)",fn:function(t){return t*(2-t)}},bounce:{style:"cubic-bezier(0.165, 0.84, 0.44, 1)",fn:function(t){return 1- --t*t*t*t}}}},function(t,e){"use strict";function i(t){if(Array.isArray(t)){for(var e=0,i=Array(t.length);e<t.length;e++)i[e]=t[e];return i}return Array.from(t)}function s(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(e,"__esModule",{value:!0});var n=function(){function t(t,e){var i=[],s=!0,n=!1,o=void 0;try{for(var r,a=t[Symbol.iterator]();!(s=(r=a.next()).done)&&(i.push(r.value),!e||i.length!==e);s=!0);}catch(t){n=!0,o=t}finally{try{!s&&a.return&&a.return()}finally{if(n)throw o}}return i}return function(e,i){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return t(e,i);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),o=function(){function t(t,e){for(var i=0;i<e.length;i++){var s=e[i];s.enumerable=s.enumerable||!1,s.configurable=!0,"value"in s&&(s.writable=!0),Object.defineProperty(t,s.key,s)}}return function(e,i,s){return i&&t(e.prototype,i),s&&t(e,s),e}}();e.EventEmitter=function(){function t(){s(this,t),this._events={}}return o(t,[{key:"on",value:function(t,e){var i=arguments.length<=2||void 0===arguments[2]?this:arguments[2];this._events[t]||(this._events[t]=[]),this._events[t].push([e,i])}},{key:"once",value:function(t,e){function i(){this.off(t,i),n||(n=!0,e.apply(s,arguments))}var s=arguments.length<=2||void 0===arguments[2]?this:arguments[2],n=!1;this.on(t,i)}},{key:"off",value:function(t,e){var i=this._events[t];if(i)for(var s=i.length;s--;)i[s][0]===e&&(i[s][0]=void 0)}},{key:"trigger",value:function(t){var e=this._events[t];if(e)for(var s=e.length,o=[].concat(i(e)),r=0;r<s;r++){var a=o[r],h=n(a,2),l=h[0],c=h[1];l&&l.apply(c,[].slice.call(arguments,1))}}}]),t}()},function(t,e){"use strict";function i(t,e,i,s,n,o){var r=t-e,a=Math.abs(r)/i,h=o.deceleration,l=o.itemHeight,c=o.swipeBounceTime,u=o.bounceTime,p=o.swipeTime,d=o.wheel?4:15,f=t+a/h*(r<0?-1:1);return o.wheel&&l&&(f=Math.round(f/l)*l),f<s?(f=n?s-n/d*a:s,p=c-u):f>0&&(f=n?n/d*a:0,p=c-u),{destination:Math.round(f),duration:p}}Object.defineProperty(e,"__esModule",{value:!0}),e.momentum=i},function(t,e){"use strict";function i(t,e){for(var i in e)t[i]=e[i]}Object.defineProperty(e,"__esModule",{value:!0}),e.extend=i;e.requestAnimationFrame=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||function(t){return window.setTimeout(t,(t.interval||100/60)/2)}}(),e.cancelAnimationFrame=function(){return window.cancelAnimationFrame||window.webkitCancelAnimationFrame||window.mozCancelAnimationFrame||window.oCancelAnimationFrame||function(t){window.clearTimeout(t)}}()}])})},193:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i(184),n=i.n(s),o=i(197),r=i(25),a=r(n.a,o.a,null,null,null);e.default=a.exports},197:function(t,e,i){"use strict";var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[t.list.length>0?i("div",{ref:"list",staticClass:"gift-list-wrap"},[i("ul",{staticClass:"gift-list jfk-pl-30 jfk-pr-30"},t._l(t.list,function(e,s){return i("li",{staticClass:"gift-list-item jfk-flex is-align-middle"},[i("div",{staticClass:"gift-list-item__header"},[e.openid_headimg?i("img",{attrs:{src:e.openid_headimg}}):t._e()]),t._v(" "),i("div",{staticClass:"gift-list-item__info"},[i("p",{staticClass:"font-size--28 gift-list-item__name",domProps:{innerHTML:t._s(e.openid_nickname)}}),t._v(" "),i("p",{staticClass:"font-size--24 gift-list-item__date",domProps:{innerHTML:t._s(e.get_time)}})]),t._v(" "),e.get_qty?i("div",{staticClass:"gift-list-item__number font-size--34 jfk-ta-r",domProps:{innerHTML:t._s("收到"+e.get_qty+"份")}}):t._e()])}))]):i("div",{staticClass:"gift-list__no-data"},[t._m(0),t._v(" "),4===t.status?[i("p",{staticClass:"font-size--28 jfk-ta-c gift-list__text"},[t._v("领取超时")]),t._v(" "),i("p",{staticClass:"font-size--28 jfk-ta-c gift-list__text"},[t._v("礼物已被自动退回")])]:[i("p",{staticClass:"font-size--28 jfk-ta-c gift-list__text"},[t._v("礼物暂无人领取")]),t._v(" "),i("p",{staticClass:"font-size--28 jfk-ta-c gift-list__text"},[t._v("超过24小时将自动退回")])]],2)])},n=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"gift-list__icon jfk-ta-c"},[i("div",{staticClass:"jfk-font icon-user_icon_Polite_nor"})])}],o={render:s,staticRenderFns:n};e.a=o},348:function(t,e,i){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var n=i(175),o=s(n),r=i(193),a=s(r),h=i(26),l=i(27),c=l.default(location.href);e.default={components:{giftList:a.default,giftBg:o.default},data:function(){return{theme:"",giftList:[],wish:"",total:"",received:"",status:"",containerHeight:""}},created:function(){var t=this,e={gid:c.gid||""};this.toast=this.$jfkToast({duration:-1,iconClass:"jfk-loading__snake",isLoading:!0}),(0,h.getPresentsInvalidGiftOrder)(e).then(function(e){var i=e.web_data;t.giftList=i.users,t.theme="gift-theme_"+i.theme_keyword,t.wish=i.message,t.total=parseInt(i.total),t.received=parseInt(i.get_count),t.status=parseInt(i.gift_status),t.toast.close();var s=window.innerHeight;t.giftList.length>0&&s<=480&&(s=500),t.containerHeight={position:"relative",height:s+"px","min-height":s+"px",overflow:"hidden"}}).catch(function(){t.toast.close()})}}},406:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i(348),n=i.n(s),o=i(442),r=i(25),a=r(n.a,o.a,null,null,null);e.default=a.exports},442:function(t,e,i){"use strict";var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"jfk-pages jfk-pages__gift-list",class:t.theme},[t.theme?t._e():i("div",{staticClass:"jfk-pages__theme"},[i("div",{staticClass:"jfk-image__lazy--preload  jfk-image__lazy--3-3 jfk-image__lazy--background-image"})]),t._v(" "),t.theme?i("div",{staticClass:"gift-container",style:t.containerHeight},[t.wish?i("gift-bg",{attrs:{wish:t.wish}}):t._e(),t._v(" "),[i("gift-list",{attrs:{list:t.giftList,status:t.status}})],t._v(" "),t.theme?i("div",{staticClass:"gift-state jfk-ta-c"},[3===t.status?[i("a",{staticClass:"font-size--32 gift-state__finish",attrs:{href:"javascript:void(0)"}},[t._v("手慢了，礼物已被领完")])]:[i("a",{staticClass:"font-size--32 gift-state__finish",attrs:{href:"javascript:void(0)"}},[t._v("领取超时，礼物已被回收")])]],2):t._e()],2):t._e()])},n=[],o={render:s,staticRenderFns:n};e.a=o}});