
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
	wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      'openLocation',
	  'onMenuShareTimeline',
	  'onMenuShareAppMessage'
    ]
  });
wx.ready(function(){
wx.onMenuShareTimeline({
    title: '<?php echo $share['title'];?>', // 分享标题
    link: '<?php echo $share['link'];?>', // 分享链接
    imgUrl: '', // 分享图标
    success: function () { 
        // 用户确认分享后执行的回调函数
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
    }
});
wx.checkJsApi({
    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
    success: function(res) {
        console.log(res);
        // 以键值对的形式返回，可用的api值true，不可用为false
        // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
    }
});
wx.onMenuShareAppMessage({
    title: '<?php echo $share['title'];?>', // 分享标题
    desc: '<?php echo $share['desc'];?>', // 分享描述
    link: '<?php echo $share['link'];?>', // 分享链接
    imgUrl: '', // 分享图标
    //type: '', // 分享类型,music、video或link，不填默认为link
    //dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        // 用户确认分享后执行的回调函数
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
    }
});
});
function tonavigate(lati,longi,hname,addr) {
	wx.openLocation({
		latitude: lati,
		longitude: longi,
		name: hname,
		address: addr,
		scale: 15,
		infoUrl: ''
	});
}
	</script>
</head>