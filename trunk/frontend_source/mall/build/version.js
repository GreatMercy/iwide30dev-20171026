var currentDate = new Date()
var month = (currentDate.getMonth() + 1) < 10 ? '0' + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1)
var day = currentDate.getDate() < 10 ? '0' + currentDate.getDate() : currentDate.getDate()
var version = String(currentDate.getFullYear()) + String(month) + String(day)

module.exports = version

