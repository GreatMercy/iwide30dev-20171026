!function(e,t){if("object"==typeof exports&&"object"==typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var r=t();for(var n in r)("object"==typeof exports?exports:e)[n]=r[n]}}(this,function(){return function(e){function t(n){if(r[n])return r[n].exports;var o=r[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var r={};return t.m=e,t.c=r,t.i=function(e){return e},t.d=function(e,r,n){t.o(e,r)||Object.defineProperty(e,r,{configurable:!1,enumerable:!0,get:n})},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="/",t(t.s=167)}({167:function(e,t,r){"use strict";function n(e,t){for(var r=0,n=t.length;r<n;){var o=t[r];if(!a(o,e))return{passed:!1,message:o.message,index:r};r++}return{passed:!0}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=n;var o=function(e){return"string"===e||"url"===e||"hex"===e||"email"===e||"pattern"===e},i=function(e,t){return void 0===e||null===e||(!("array"!==t||!Array.isArray(e)||e.length)||!(!o(t)||"string"!=typeof e||e))},u={phone:function(e){return/1\d{10}/.test(e)},integer:function(e){return/^[0-9]+$/.test(e)},required:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"string";return!i(e,t)},range:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"string",r=arguments[2],n=arguments[3],o=arguments[4],i=e;return"string"!==t&&"array"!==t||(i=e.length),o?i===o:void 0!==r&&void 0===n?i>=r:void 0===r&&void 0!==n?i<=n:void 0===r||void 0===n||i>=r&&i<=n}},a=function(e,t){return e.required?u.required(t,e.type):e.type&&u[e.type]?u[e.type](t):e.length?u.range(t,e.type,e.min,e.max,e.len):e.validator?e.validator(t,e):void 0}}})});