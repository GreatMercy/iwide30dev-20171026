var copydir = require('copy-dir')
var path = require('path')

var sourceDir = path.join(__dirname, '../dist/hotel/highclass')
var targetDir = path.join(__dirname, '../../../www_front/public/hotel/highclass')
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
