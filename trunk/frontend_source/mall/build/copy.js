var copydir = require('copy-dir')
var path = require('path')
var subPath = 'vue' + (process.env.npm_config_interid ? '_' + process.env.npm_config_interid : '')
var sourceDir = path.join(__dirname, '../dist/soma', subPath)
var targetDir = path.join(__dirname, '../../../www_front/public/soma', subPath)
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
