(function(window){var svgSprite="<svg>"+""+'<symbol id="icon-duigou" viewBox="0 0 1024 1024">'+""+'<path d="M387.67103 826.608574c-12.995703 0-25.889078-4.809433-35.814929-14.4283L54.080544 521.670031c-19.749375-19.340062-19.749375-50.550215 0-69.890277s51.880484-19.340062 71.629859 0l261.960627 255.616269 510.618567-498.236834c19.749375-19.340062 51.880484-19.340062 71.629859 0 19.749375 19.237734 19.749375 50.550215 0 69.890276L423.48596 812.282602c-9.925852 9.41421-22.819227 14.325972-35.81493 14.325972z" fill="" ></path>'+""+"</symbol>"+""+'<symbol id="icon-home_icon_Jump_norma" viewBox="0 0 1024 1024">'+""+'<path d="M293.6533333333333 416l224 224 224-224z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-mall_icon_pay_focus" viewBox="0 0 1024 1024">'+""+'<path d="M553.6 307.2v384h-89.6v-384h89.6z m3.2-288v195.2h-89.6V19.2h89.6z m0 793.6v195.2h-89.6v-195.2h89.6z m-35.2-259.2h-195.2v-89.6h195.2v89.6z m-326.4 3.2H0v-89.6h195.2v89.6z m828.8-3.2h-195.2v-89.6H1024v89.6z m-297.6 64v217.6h-89.6v-217.6h89.6z m128 89.6h-217.6v-89.6h217.6v89.6z m169.6-89.6v387.2H636.8v-89.6H928v-297.6h96zM0 19.2h387.2v387.2H297.6V112H0V19.2z m387.2 387.2H0V19.2h89.6v291.2h297.6v96zM0 617.6h387.2v387.2H297.6v-291.2H0v-96z m387.2 387.2H0V617.6h89.6v291.2h297.6v96zM636.8 19.2H1024v387.2h-89.6V112h-297.6V19.2zM1024 406.4H636.8V19.2h89.6v291.2H1024v96z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-icon_close" viewBox="0 0 1024 1024">'+""+'<path d="M92.8 931.2c-19.2-19.2-19.2-48 0-67.2l768-768c19.2-19.2 48-19.2 67.2 0 19.2 19.2 19.2 48 0 67.2l-768 768c-16 19.2-48 19.2-67.2 0z m838.4 0c-19.2 19.2-48 19.2-67.2 0L92.8 160c-19.2-19.2-19.2-48 0-67.2 19.2-19.2 48-19.2 67.2 0l768 768c22.4 19.2 22.4 51.2 3.2 70.4z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-mall_icon_reward" viewBox="0 0 1024 1024">'+""+'<path d="M841.6 233.6l-252.8-147.2c-32-19.2-54.4-25.6-76.8-25.6s-44.8 9.6-76.8 25.6L182.4 233.6c-60.8 35.2-76.8 60.8-76.8 131.2v294.4c0 70.4 12.8 96 76.8 131.2l252.8 147.2c32 19.2 54.4 25.6 76.8 25.6s44.8-9.6 76.8-25.6l252.8-147.2c60.8-35.2 76.8-60.8 76.8-131.2v-294.4c0-70.4-16-96-76.8-131.2z m38.4 422.4c0 32 0 51.2-6.4 64-6.4 12.8-22.4 25.6-48 41.6L576 905.6c-32 16-48 22.4-64 22.4s-32-6.4-60.8-22.4l-249.6-144c-28.8-16-41.6-28.8-48-41.6s-9.6-32-9.6-64v-288c0-32 3.2-51.2 9.6-64 6.4-12.8 22.4-25.6 48-41.6l249.6-144C480 102.4 496 96 512 96s32 6.4 60.8 22.4l249.6 144c28.8 16 41.6 28.8 48 41.6 6.4 12.8 9.6 32 9.6 64v288z"  ></path>'+""+'<path d="M665.6 550.4h-131.2v-57.6h124.8c12.8 0 22.4-6.4 22.4-19.2s-12.8-19.2-22.4-19.2h-105.6l89.6-112s9.6-19.2-6.4-28.8c-16-9.6-28.8 3.2-35.2 9.6l-92.8 112-89.6-115.2c-6.4-9.6-19.2-12.8-28.8-6.4-9.6 6.4-12.8 19.2-9.6 28.8l86.4 118.4h-108.8c-12.8 0-22.4 9.6-22.4 16 0 12.8 9.6 19.2 22.4 19.2h124.8v57.6h-124.8c-12.8 0-22.4 9.6-22.4 19.2s9.6 19.2 22.4 19.2h124.8v108.8c0 9.6 12.8 22.4 25.6 22.4 16 0 22.4-12.8 22.4-22.4v-108.8h131.2c12.8 0 22.4-9.6 22.4-19.2 3.2-16-9.6-22.4-19.2-22.4z"  ></path>'+""+"</symbol>"+""+"</svg>";var script=function(){var scripts=document.getElementsByTagName("script");return scripts[scripts.length-1]}();var shouldInjectCss=script.getAttribute("data-injectcss");var ready=function(fn){if(document.addEventListener){if(~["complete","loaded","interactive"].indexOf(document.readyState)){setTimeout(fn,0)}else{var loadFn=function(){document.removeEventListener("DOMContentLoaded",loadFn,false);fn()};document.addEventListener("DOMContentLoaded",loadFn,false)}}else if(document.attachEvent){IEContentLoaded(window,fn)}function IEContentLoaded(w,fn){var d=w.document,done=false,init=function(){if(!done){done=true;fn()}};var polling=function(){try{d.documentElement.doScroll("left")}catch(e){setTimeout(polling,50);return}init()};polling();d.onreadystatechange=function(){if(d.readyState=="complete"){d.onreadystatechange=null;init()}}}};var before=function(el,target){target.parentNode.insertBefore(el,target)};var prepend=function(el,target){if(target.firstChild){before(el,target.firstChild)}else{target.appendChild(el)}};function appendSvg(){var div,svg;div=document.createElement("div");div.innerHTML=svgSprite;svgSprite=null;svg=div.getElementsByTagName("svg")[0];if(svg){svg.setAttribute("aria-hidden","true");svg.style.position="absolute";svg.style.width=0;svg.style.height=0;svg.style.overflow="hidden";prepend(svg,document.body)}}if(shouldInjectCss&&!window.__iconfont__svg__cssinject__){window.__iconfont__svg__cssinject__=true;try{document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>")}catch(e){console&&console.log(e)}}ready(appendSvg)})(window)