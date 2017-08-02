var copydir = require('copy-dir')
var path = require('path')

var sourceDir = path.join(__dirname, '../dist/admin')
var targetDir = path.join(__dirname, '../../../www_admin/public/admin')
copydir(sourceDir, targetDir, function (err) {
  console.log(err || 'copy completed')
})
