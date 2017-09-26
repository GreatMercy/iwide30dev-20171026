var copydir = require('copy-dir')
var path = require('path')
var subPath = (process.env.npm_config_interid ? '_' + process.env.npm_config_interid : '')
var sourceDir = path.join(__dirname, '../dist/wx', subPath)
var targetDir = path.join(__dirname, '../../../www_front/public/wx', subPath)
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
