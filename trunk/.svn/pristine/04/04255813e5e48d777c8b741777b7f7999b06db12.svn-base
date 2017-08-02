var copydir = require('copy-dir')
var path = require('path')

var sourceDir = path.join(__dirname, '../dist/user')
var targetDir = path.join(__dirname, '../../../www_front/public/user')
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
