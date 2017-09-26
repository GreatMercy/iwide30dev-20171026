/**
 * wx为全局对象
 */
const wxApiCall = (config, apiName, params) => {
  window.wx.ready(function () {
    if (apiName === 'openLocation') {
      openLocation()
    }
  })
}
/**
 * 打开地图
 * */
const openLocation = (data) => {
  window.wx.openLocation({
    latitude: parseFloat(data.latitude), // 纬度，浮点数，范围为90 ~ -90
    longitude: parseFloat(data.longitude), // 经度，浮点数，范围为180 ~ -180。
    name: data.name, // 位置名
    address: data.address, // 地址详情说明
    scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最大
    infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
  })
}
export { wxApiCall, openLocation }
