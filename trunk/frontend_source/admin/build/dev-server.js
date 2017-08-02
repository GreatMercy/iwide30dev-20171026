require('./check-versions')()

var config = require('../config')
if (!process.env.NODE_ENV) {
  process.env.NODE_ENV = JSON.parse(config.dev.env.NODE_ENV)
}

var opn = require('opn')
var path = require('path')
var express = require('express')
var webpack = require('webpack')
var proxyMiddleware = require('http-proxy-middleware')
var webpackConfig = process.env.NODE_ENV === 'testing'
  ? require('./webpack.prod.conf')
  : require('./webpack.dev.conf')
var fs = require('fs')
var glob = require('glob')

// default port where dev server listens for incoming traffic
var port = process.env.PORT || config.dev.port
// automatically open browser, if not set will be false
var autoOpenBrowser = !!config.dev.autoOpenBrowser
// Define HTTP proxies to your custom API backend
// https://github.com/chimurai/http-proxy-middleware
var proxyTable = config.dev.proxyTable

var app = express()
var compiler = webpack(webpackConfig)

var devMiddleware = require('webpack-dev-middleware')(compiler, {
  publicPath: webpackConfig.output.publicPath,
  quiet: true
})

var hotMiddleware = require('webpack-hot-middleware')(compiler, {
  log: () => { }
})
function getPages (globPath) {
  var pages = {}
  glob.sync(globPath).forEach(function (page) {
    let pageArrs = page.split('/')
    let _module = pageArrs[3]
    let _page = pageArrs[4]
    if (!pages[_module]) {
      pages[_module] = []
    }
    if (_page.indexOf('.') === -1) {
      pages[_module].push(_page)
    }
  })
  return pages
}
var pages = getPages('./src/pages/*/*')

// force page reload when html-webpack-plugin template changes
compiler.plugin('compilation', function (compilation) {
  compilation.plugin('html-webpack-plugin-after-emit', function (data, cb) {
    console.log(hotMiddleware)
    hotMiddleware.publish({ action: 'reload' })
    cb()
  })
})

// proxy api requests
Object.keys(proxyTable).forEach(function (context) {
  var options = proxyTable[context]
  if (typeof options === 'string') {
    options = { target: options }
  }
  app.use(proxyMiddleware(options.filter || context, options))
})

// 配置路由
let htmlHead = `<!DOCTYPE html><html><head>
  <meta charset="utf-8">
  <!-- viewport 后面加上 minimal-ui 在safri 体现效果 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <!-- 隐藏状态栏/设置状态栏颜色 -->
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <!-- uc强制竖屏 -->
  <meta name="screen-orientation" content="portrait">
  <!-- UC强制全屏 -->
  <meta name="full-screen" content="yes">
  <!-- UC应用模式 -->
  <meta name="browsermode" content="application">
  <!-- QQ强制竖屏 -->
  <meta name="x5-orientation" content="portrait">
  <!-- QQ强制全屏 -->
  <meta name="x5-fullscreen" content="true">
  <!-- QQ应用模式 -->
  <meta name="x5-page-mode" content="app">
  <title>默认页面title</title>
</head>
<body>`
let indexHtml = [htmlHead, '<dl>']
for (let page in pages) {
  let pageItems = pages[page]
  if (pageItems && pageItems.length) {
    indexHtml.push('<dt>' + page + '</dt>')
    pageItems.forEach(function (_page) {
      let _url = `${page}/${_page}`
      indexHtml.push('<dd><a href="/' + _url + '">' + _page + '</a></dd>')
      app.get('/' + _url, function (req, res, next) {
        let filepath = path.join('./src/pages', _url, '/index.html')
        fs.readFile(filepath, function (err, result) {
          if (err) {
            let p = page + '_' + _page
            let pageId = p.replace(/_(\w)/g, function (a, b) {
              return b.toUpperCase()
            })
            result = `${htmlHead}
              <div id="app">
              </div>
              <div id="scriptArea" data-page-id="${pageId}"></div>
              <script src="/app.js"></script>
            </body>
            </html>`
          }
          res.set('Content-Type', 'text/html')
          res.send(result)
          res.end()
        })
      })
    })
  }
}
app.get('/', function (req, res, next) {
  indexHtml.push('</dl></body></html>')
  res.set('Content-Type', 'text/html')
  res.send(indexHtml.join(''))
  res.end()
})

// handle fallback for HTML5 history API
app.use(require('connect-history-api-fallback')())

// serve webpack bundle output
app.use(devMiddleware)

// enable hot-reload and state-preserving
// compilation error display
app.use(hotMiddleware)

// serve pure static assets
var staticPath = path.posix.join(config.dev.assetsPublicPath, config.dev.assetsSubDirectory)
app.use(staticPath, express.static('./static'))

var uri = 'http://localhost:' + port

var _resolve
var readyPromise = new Promise(resolve => {
  _resolve = resolve
})

console.log('> Starting dev server...')
devMiddleware.waitUntilValid(() => {
  console.log('> Listening at ' + uri + '\n')
  // when env is testing, don't need open it
  if (autoOpenBrowser && process.env.NODE_ENV !== 'testing') {
    opn(uri)
  }
  _resolve()
})

var server = app.listen(port)

module.exports = {
  ready: readyPromise,
  close: () => {
    server.close()
  }
}
