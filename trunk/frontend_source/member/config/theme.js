const browsers = require('../package.json').browsers
const path = require('path')
const config = {
  browsers: browsers,
  out: path.join(__dirname, '../src/assets/css'),
  minimize: false
}

module.exports = config
