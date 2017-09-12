var path = require('path')
var utils = require('./utils')
var config = require('../config')
var vueLoaderConfig = require('./vue-loader.conf')

function resolve (dir) {
  return path.join(__dirname, '..', dir)
}

module.exports = {
  entry: {
    'jfk-ui': './src/index.js',
    'killsec-time': './src/utils/killsec-time.js',
    'jfk-banner': './src/packages/jfk-banner/index.js',
    'format-urlparams': './src/utils/format-urlparams.js',
    'string-length-to-two': './src/utils/string-length-to-two.js',
    'jfk-infinite-scroll': './src/packages/jfk-infinite-scroll/index.js',
    'jfk-loadmore': './src/packages/jfk-loadmore/index.js',
    'jfk-message-box': './src/packages/jfk-message-box/index.js',
    'jfk-support': './src/packages/jfk-support/index.js',
    'jfk-text-split': './src/packages/jfk-text-split/index.js',
    'jfk-toast': './src/packages/jfk-toast/index.js',
    'jfk-recommendation': './src/packages/jfk-recommendation/index.js',
    'jfk-calendar': './src/packages/jfk-calendar/index.js',
    'jfk-notification': './src/packages/jfk-notification/index.js',
    'jfk-picker': './src/packages/jfk-picker/index.js',
    'jfk-share': './src/packages/jfk-share/index.js',
    'jfk-sticky': './src/packages/jfk-sticky/index.js',
    'jfk-rater': './src/packages/jfk-rater/index.js',
    'validator': './src/utils/validator.js',
    'arithmetic': './src/utils/arithmetic.js'
  },
  output: {
    path: config.build.assetsRoot,
    filename: '[name].js',
    publicPath: process.env.NODE_ENV === 'production'
      ? config.build.assetsPublicPath
      : config.dev.assetsPublicPath
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '@': resolve('src')
    }
  },
  module: {
    rules: [
      {
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        enforce: 'pre',
        include: [resolve('src'), resolve('test')],
        options: {
          formatter: require('eslint-friendly-formatter')
        }
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: vueLoaderConfig
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        include: [resolve('src'), resolve('test')]
      },
      {
        test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000,
          name: utils.assetsPath('img/[name].[hash:7].[ext]')
        }
      },
      {
        test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000,
          name: utils.assetsPath('media/[name].[hash:7].[ext]')
        }
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000,
          name: utils.assetsPath('fonts/[name].[hash:7].[ext]')
        }
      }
    ]
  }
}
