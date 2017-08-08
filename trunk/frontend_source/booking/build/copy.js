var copydir = require('copy-dir')
var path = require('path')

var sourceDir = path.join(__dirname, '../dist/soma/vue')
var targetDir = path.join(__dirname, '../../../www_front/public/soma/vue')
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
