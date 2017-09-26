var version = require('./version')
var copydir = require('copy-dir')
var path = require('path')
// var subPath = 'vue' + (process.env.npm_config_interid ? '_' + process.env.npm_config_interid : '')
var subPath = process.env.npm_config_interid ? 'vue/soma_' + process.env.npm_config_interid : 'vue/soma_com'
var sourceDir = path.join(__dirname, '../dist/soma', subPath + '/' + version)
console.log(sourceDir)
var targetDir = path.join(__dirname, '../../../www_front/public/soma', subPath + '/' + version)
console.log(targetDir)
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})

