let showLoadError = function (err) {
  if (process.env.NODE_ENV === 'development') {
    return console.error(err)
  }
  return console.error(err.message)
}
/* -------------------------- 博饼模块开始 -------------------- */
const pancakeList = (r) => {
  import(/* webpackChunkName: "home" */ './pancake/list/index').then(function (pancakeList) {
    r(pancakeList.default)
  }).catch(function (err) {
    showLoadError(err, 'pancakeList')
  })
}

export default {
  pancakeList
}
