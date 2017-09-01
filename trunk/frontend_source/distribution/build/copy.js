var copydir = require('copy-dir')
var path = require('path')

var sourceDir = path.join(__dirname, '../dist/soma/vueold')
var targetDir = path.join(__dirname, '../../../www_front/public/soma/vueold')
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
