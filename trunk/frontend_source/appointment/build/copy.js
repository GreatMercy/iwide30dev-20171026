var copydir = require('copy-dir')
var path = require('path')

var sourceDir = path.join(__dirname, '../dist/ticket/revision')
var targetDir = path.join(__dirname, '../../../www_front/public/ticket/revision')
console.log(sourceDir)
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
