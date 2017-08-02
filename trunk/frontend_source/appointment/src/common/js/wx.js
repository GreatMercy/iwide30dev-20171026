import wx from 'weixin-js-sdk'

/**
 * 调用微信的接口
 * */
const wxApiCall = (config, apiName, params) => {
  wx.config({
    debug: false,
    appId: config['appId'],
    timestamp: config['timestamp'],
    nonceStr: config['nonceStr'],
    signature: config['signature'],
    jsApiList: ['checkJsApi', 'onMenuShareTimeline', 'onMenuShareQQ', 'openLocation', 'onMenuShareAppMessage', 'hideMenuItems']
  })
  wx.ready(function () {
    if (apiName === 'share') {
      wxShare(params)
    }

    if (apiName === 'openLocation') {
      openLocation()
    }

    if (apiName === 'hideMenu') {
      hideMenu()
    }
  })
  wx.error(function (res) {
    console.log(res)
  })
}

/**
 * 检测wxApi 是否可以使用
 * @param {string} apiName 需要检测
 * */
const checkApi = (apiName) => {
  wx.checkJsApi({
    jsApiList: [apiName],
    success: function (res) {
      console.log(res)
    }
  })
}

/**
 * 隐藏菜单
 * */
const hideMenu = () => {
  wx.hideMenuItems({
    menuList: ['menuItem:share:appMessage', 'menuItem:share:timeline', 'menuItem:share:qq', 'menuItem:share:weiboApp', 'menuItem:share:facebook', 'menuItem:share:QZone']
  })
}

/**
 * 打开地图
 * */
const openLocation = (data) => {
  wx.openLocation({
    latitude: parseFloat(data.latitude), // 纬度，浮点数，范围为90 ~ -90
    longitude: parseFloat(data.longitude), // 经度，浮点数，范围为180 ~ -180。
    name: data.name, // 位置名
    address: data.address, // 地址详情说明
    scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最大
    infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
  })
}

/**
 * 微信分享
 * @param {object} data.title 分享标题
 * @param {object} data.link  分享的链接
 * @param {object} data.imgUrl 分享的图片
 * @param {object} data.desc 分享的描述
 * @param {object} data.success 用户确认分享后执行的回调函数
 * @param {object} data.cancel 用户取消分享后执行的回调函数
 * */
const wxShare = (data) => {
  wx.onMenuShareTimeline({
    title: data.title,
    link: data.link,
    imgUrl: data.imgUrl,
    type: 'link',
    desc: data.desc,
    success: function () {
    },
    fail: function () {
    }
  })
  wx.onMenuShareAppMessage({
    title: data.title,
    link: data.link,
    imgUrl: data.imgUrl,
    type: 'link',
    desc: data.desc,
    success: function () {
    },
    fail: function () {
    }
  })
}
export { wxShare, checkApi, wxApiCall, openLocation, hideMenu }

