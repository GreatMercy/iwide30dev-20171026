module.exports = function (px, dpr = 2, base = 16) {
  if (!px) {
    throw Error('px2rem需要传px参数')
  }
  px = parseFloat(eval(px))
  return (px / base / dpr)  + 'rem'
}