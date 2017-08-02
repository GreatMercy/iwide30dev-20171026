// see http://vuejs-templates.github.io/webpack for documentation.
var path = require('path')
var cdnSrc = path.resolve(__dirname, '../../cdn.json')
var cdnConf = require(cdnSrc)

module.exports = {
  build: {
    env: require('./prod.env'),
    index: path.resolve(__dirname, '../dist/index.html'),
    assetsRoot: path.resolve(__dirname, '../dist'),
    assetsSubDirectory: 'ticket/revision',
    assetsPublicPath: (process.env.npm_config_cdn ? `${cdnConf.protocol}//${cdnConf.domain}` : '') + '/public/',
    productionSourceMap: false,
    // Gzip off by default as many popular static hosts such as
    // Surge or Netlify already gzip all static assets for you.
    // Before setting to `true`, make sure to:
    // npm install --save-dev compression-webpack-plugin
    productionGzip: false,
    productionGzipExtensions: ['js', 'css'],
    // Run the build command with an extra argument to
    // View the bundle analyzer report after build finishes:
    // `npm run build --report`
    // Set to `true` or `false` to always turn it on or off
    bundleAnalyzerReport: process.env.npm_config_report
  },
  dev: {
    env: require('./dev.env'),
    port: 8080,
    autoOpenBrowser: true,
    assetsSubDirectory: 'static',
    assetsPublicPath: '/',
    proxyTable: {
      // '/index.php/ticket/ticketApi': {
      //  target: 'http://ihotels.iwide.cn/',
      //  changeOrigin: true,
      //  pathRewrite: {
      //    '/index.php/ticket/ticketApi': 'http://ihotels.iwide.cn/index.php/ticket/ticketApi/'
      //  }
      // }
      // '/index.php/ticket/ticketApi': {
      //  target: 'http://192.168.31.134/',
      //  changeOrigin: true,
      //  pathRewrite: {
      //    '/index.php/ticket/ticketApi': 'http://192.168.31.134/index.php/ticket/ticketApi/'
      //  }
      // }
      '/index.php/ticket/ticketApi': {
        target: 'http://credit.iwide.cn/',
        changeOrigin: true,
        pathRewrite: {
          '/index.php/ticket/ticketApi': 'http://credit.iwide.cn/index.php/ticket/ticketApi/'
        }
      }
    },
    // CSS Sourcemaps off by default because relative paths are "buggy"
    // with this option, according to the CSS-Loader README
    // (https://github.com/webpack/css-loader#sourcemaps)
    // In our experience, they generally work as expected,
    // just be aware of this issue when enabling this option.
    cssSourceMap: false
  }
}
