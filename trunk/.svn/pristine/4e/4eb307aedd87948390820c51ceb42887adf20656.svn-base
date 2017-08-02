const path = require('path')
const webpack = require('webpack')

module.exports = {
  entry: {
    vendor: ['vue/dist/vue.esm.js', 'vue-router', 'axios', 'vuex', 'promise-polyfill']
  },
  output: {
    path: path.join(__dirname, '../static/js'),
    filename: '[name].dll.[chunkhash].js',
    library: '[name]_library'
  },
  plugins: [
    new webpack.DllPlugin({
      path: path.join(__dirname, '../static/js', '[name]-manifest.json'),
      name: '[name]_library',
      context: __dirname
    })
  ]
}
