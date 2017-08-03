;(function(window) {

var svgSprite = '<svg>' +
  ''+
    '<symbol id="icon-sousuo" viewBox="0 0 1000 1000">'+
      ''+
      '<path d="M864.5282 808.5048l-251.3122-236.0699c37.3832-41.6028 61.5808-95.5942 65.4794-155.7374 9.2241-142.2945-98.6553-265.1252-240.9558-274.349-142.3005-9.2237-265.1364 98.6511-274.3605 240.9456s98.6553 265.1252 240.9558 274.349c67.559 4.379 130.7189-17.649 179.4279-57.2092l252.9851 237.6419c4.8269 4.5349 9.9727 1.0603 15.0864-4.383l9.2601-9.8573C866.2091 818.3921 869.3551 813.0398 864.5282 808.5048zM406.5334 623.7371c-123.5744-8.0106-217.2568-114.6762-209.2469-238.2455s114.6811-217.2477 238.2555-209.2381c123.5744 8.0106 217.2568 114.6762 209.2469 238.2455S530.1069 631.7477 406.5334 623.7371z"  ></path>'+
      ''+
    '</symbol>'+
  ''+
    '<symbol id="icon-xiangshang" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M836.337411 417.786245 538.658661 60.396555c-6.126534-7.355525-16.151865-7.355525-22.277376 0l-297.67875 357.38969c-6.125511 7.354502-3.306302 13.372565 6.265704 13.372565l174.638459 0 0 493.685889c0 9.573029 7.832386 17.404392 17.404392 17.404392l221.017766 0c9.573029 0 17.404392-7.832386 17.404392-17.404392L655.433248 431.15881l174.638459 0C839.643714 431.15881 842.462922 425.14177 836.337411 417.786245z"  ></path>'+
      ''+
    '</symbol>'+
  ''+
    '<symbol id="icon-xiangxia" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M640.253524 751.223407c0 9.612938-5.184069 17.404392-11.579733 17.404392L395.495054 768.627798c-6.395664 0-11.579733-7.791453-11.579733-17.404392L383.915321 81.520665c0-9.611915 5.184069-17.404392 11.579733-17.404392l233.177714 0c6.395664 0 11.579733 7.792477 11.579733 17.404392L640.252501 751.223407z"  ></path>'+
      ''+
      '<path d="M814.467311 574.36642c9.572006 0 12.391215 6.018064 6.263657 13.371542L522.982634 945.130721c-6.127558 7.354502-16.152888 7.354502-22.280446 0L202.953853 587.738985c-6.127558-7.354502-3.308349-13.371542 6.263657-13.371542L814.467311 574.367443z"  ></path>'+
      ''+
    '</symbol>'+
  ''+
    '<symbol id="icon-bijia" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M502.8576 92.4448C371.0304 92.4448 182.672 160.4672 128 160.4672l0 460.6272c6.7232 56.4544 54.128 225.2064 374.8576 303.6288 320.6624-78.4224 367.5136-247.1744 374.1056-303.6288L876.9632 160.4672C823.0464 160.4672 634.6432 92.4448 502.8576 92.4448L502.8576 92.4448zM831.5072 607.44c-5.7984 49.6-46.9696 197.8624-328.6912 266.7712-281.7952-68.9088-323.4624-217.1712-329.3568-266.7712L173.4592 202.7264c48.032 0 213.5424-59.7696 329.3568-59.7696 115.792 0 281.3088 59.7696 328.6912 59.7696L831.5072 607.44 831.5072 607.44z"  ></path>'+
      ''+
      '<path d="M306.624 698.8512 306.624 278.8512l60 0 0 114.3744 103.1264 0 0 41.2512L366.624 434.4768l0 189.376c30-7.5008 63.7504-19.9808 101.2512-37.5008l0 45.0016C417.8656 658.832 364.1056 681.3312 306.624 698.8512zM567.2512 693.2256c-46.2592 1.232-68.7584-21.8848-67.5008-69.376L499.7504 273.2256l60 0 0 129.376c41.2512-4.9824 71.8656-26.8672 91.8752-65.6256l60 0c-25.0176 62.5184-75.6448 96.8832-151.8752 103.1264l0 181.8752c0 22.4992 11.2512 33.7504 33.7504 33.7504l35.6256 0c22.4992 0 33.7504-10.6048 33.7504-31.8752l0-24.3744 46.8736 0 0 31.8752c0 41.2512-22.4992 61.8752-67.5008 61.8752L567.2512 693.2288z"  ></path>'+
      ''+
    '</symbol>'+
  ''+
    '<symbol id="icon-mima" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M522.368 10.3936c-144.1536 0-252.9024 114.6624-252.9024 266.752l0 93.7472-8.192 0c-75.776 0-137.4464 63.3088-137.4464 141.0816l0 360.5248c0 77.7728 61.6704 141.1072 137.4464 141.1072l524.3392 0c75.776 0 137.4464-63.3344 137.4464-141.1072L923.0592 511.9744c0-77.7728-61.6704-141.0816-137.4464-141.0816l-4.5056 0c-1.2032-0.4352-2.4576-0.5632-3.712-0.768l0-93.0048C777.4464 125.0816 667.8016 10.3936 522.368 10.3936L522.368 10.3936zM522.368 52.224c123.52 0 213.248 94.592 213.248 224.9472l0 92.3648L311.3216 369.536l0-92.3648C311.3216 146.816 400.0768 52.224 522.368 52.224L522.368 52.224zM881.28 511.9744l0 360.5248c0 54.7328-42.9312 99.2768-95.616 99.2768L261.2992 971.776c-52.736 0-95.616-44.544-95.616-99.2768L165.6832 511.9744c0-54.7072 42.88-99.2512 95.616-99.2512l50.0224 0 0-1.3824 424.2688 0 0 1.3824 50.048 0C838.3488 412.7488 881.28 457.2672 881.28 511.9744L881.28 511.9744zM881.28 511.9744"  ></path>'+
      ''+
      '<path d="M518.8608 568.0384c-33.5104 0-60.672 28.0064-60.672 62.5664 0 23.1168 12.2368 43.3408 30.336 54.1696l0 102.1952c0 17.2544 13.568 31.3088 30.336 31.3088 16.7424 0 30.336-14.0544 30.336-31.3088L549.1968 684.8c18.0992-10.8288 30.3104-31.0272 30.3104-54.1696C579.456 596.0704 552.32 568.0384 518.8608 568.0384L518.8608 568.0384zM518.8608 568.0384"  ></path>'+
      ''+
    '</symbol>'+
  ''+
    '<symbol id="icon-zhanghao" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M1001.211307 1024l-56.88647 0c0-188.611719-120.668325-354.001176-300.280306-411.611471l-63.498856-20.334219 58.669728-31.748521c86.663067-46.918004 140.52725-137.196567 140.52725-235.640384 0-147.669352-120.113211-267.778935-267.751724-267.778935-147.642141 0-267.74991 120.109583-267.74991 267.778935 0 98.443816 53.858741 188.747777 140.554462 235.640384l58.693311 31.719495-63.529695 20.363245c-179.611982 57.610295-300.278492 222.999752-300.278492 411.611471l-56.888284 0c0-194.333383 113.223269-366.886711 286.890453-445.415365C233.127858 517.611004 187.350922 424.611294 187.350922 324.667219c0-179.029656 145.637563-324.667219 324.638194-324.667219 179.002445 0 324.640008 145.637563 324.640008 324.667219 0 99.915049-45.749725 192.914759-122.337295 253.917416C888.018878 657.084263 1001.211307 829.666617 1001.211307 1024z"  ></path>'+
      ''+
    '</symbol>'+
  ''+
'</svg>'
var script = function() {
    var scripts = document.getElementsByTagName('script')
    return scripts[scripts.length - 1]
  }()
var shouldInjectCss = script.getAttribute("data-injectcss")

/**
 * document ready
 */
var ready = function(fn){
  if(document.addEventListener){
      document.addEventListener("DOMContentLoaded",function(){
          document.removeEventListener("DOMContentLoaded",arguments.callee,false)
          fn()
      },false)
  }else if(document.attachEvent){
     IEContentLoaded (window, fn)
  }

  function IEContentLoaded (w, fn) {
      var d = w.document, done = false,
      // only fire once
      init = function () {
          if (!done) {
              done = true
              fn()
          }
      }
      // polling for no errors
      ;(function () {
          try {
              // throws errors until after ondocumentready
              d.documentElement.doScroll('left')
          } catch (e) {
              setTimeout(arguments.callee, 50)
              return
          }
          // no errors, fire

          init()
      })()
      // trying to always fire before onload
      d.onreadystatechange = function() {
          if (d.readyState == 'complete') {
              d.onreadystatechange = null
              init()
          }
      }
  }
}

/**
 * Insert el before target
 *
 * @param {Element} el
 * @param {Element} target
 */

var before = function (el, target) {
  target.parentNode.insertBefore(el, target)
}

/**
 * Prepend el to target
 *
 * @param {Element} el
 * @param {Element} target
 */

var prepend = function (el, target) {
  if (target.firstChild) {
    before(el, target.firstChild)
  } else {
    target.appendChild(el)
  }
}

function appendSvg(){
  var div,svg

  div = document.createElement('div')
  div.innerHTML = svgSprite
  svg = div.getElementsByTagName('svg')[0]
  if (svg) {
    svg.setAttribute('aria-hidden', 'true')
    svg.style.position = 'absolute'
    svg.style.width = 0
    svg.style.height = 0
    svg.style.overflow = 'hidden'
    prepend(svg,document.body)
  }
}

if(shouldInjectCss && !window.__iconfont__svg__cssinject__){
  window.__iconfont__svg__cssinject__ = true
  try{
    document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>");
  }catch(e){
    console && console.log(e)
  }
}

ready(appendSvg)


})(window)