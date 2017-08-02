// 根据长与宽计算出原始长方形的长与宽，并给出已经旋转的角度
module.exports = function (w, h) {
  if (!w || !h) {
    throw Error('计算斜角需要长与宽的值')
  }
  w = parseFloat(w)
  h = parseFloat(h)
  let radian = Math.atan(h / w)
  let angle1 = Math.ceil(radian * 180 / Math.PI)
  let height = Math.ceil(h / Math.sin(radian))
  let width =  Math.ceil(w * Math.sin(radian))
  return `${width}, ${height}, ${angle1}`
}