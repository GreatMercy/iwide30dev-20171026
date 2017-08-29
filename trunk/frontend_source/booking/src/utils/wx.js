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
const openLocation = () => {
  // window.wx.openLocation({
  //   latitude: parseFloat(data.latitude), // 纬度，浮点数，范围为90 ~ -90
  //   longitude: parseFloat(data.longitude), // 经度，浮点数，范围为180 ~ -180。
  //   name: data.name, // 位置名
  //   address: data.address, // 地址详情说明
  //   scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最大
  //   infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
  // })
  window.wx.getLocation({
    type: 'wgs84',
    // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
    success: (res) => {
      // 纬度
      let latitude = res.latitude
      // 经度
      let longitude = res.longitude
      alert(latitude, longitude)
      // const map = new BMap.Map("allmap")
      // const myGeo = new BMap.Geocoder()
      // const geolocation = new BMap.Geolocation()
      // const pt = new BMap.Point(res.longitude, res.latitude)
      // myGeo.getLocation(pt,  (rs) => {
      //   const addComp = rs.addressComponents;
      //   const detailInfo = addComp.province + "" + addComp.city + "" + addComp.district + "" + addComp.street + "" + addComp.streetNumber;
      //   const city = addComp.city.substring(0,addComp.city.length - 1);
    }
  })
}
export { wxApiCall, openLocation }
