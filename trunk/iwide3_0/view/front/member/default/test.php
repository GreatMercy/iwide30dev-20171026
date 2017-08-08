<!doctype html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" >
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">

<meta name="viewport" content="width=device-width, user-scalable=no" />
<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="<?php echo base_url("public/member/public/js/viewport.js");?>"></script>
<script src="<?php echo base_url("public/member/public/js/jquery.js");?>"></script>
<script src="<?php echo base_url("public/member/public/js/ui_control.js");?>"></script>

<link href="<?php echo base_url('public/soma/styles/global.css');?>" rel="stylesheet">

<link href="<?php echo base_url("public/member/public/css/global.css");?>" rel="stylesheet">
<link href="<?php echo base_url("public/member/public/css/ui.css");?>" rel="stylesheet">
<script src="<?php echo base_url('public/soma/scripts/ui_control.js');?>"></script>
<script src="<?php echo base_url('public/soma/scripts/alert.js');?>"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<link rel="stylesheet" href="<?php echo base_url('public/member/super8/css/activate_card.css'); ?>">

<title></title>

<script>
wx.config({
	debug:false,
	appId:'<?php echo $signPackage["appId"];?>',
	timestamp:<?php echo $signPackage["timestamp"];?>,
	nonceStr:'<?php echo $signPackage["nonceStr"];?>',
	signature:'<?php echo $signPackage["signature"];?>',
	jsApiList: [
		'hideOptionMenu',
        'chooseImage',
        'uploadImage'
	]
});

</script>
</head>
<body>
<div onclick="chooseImage()" src="" value="">选择图片</div>
</body>
<script type="text/javascript">
    function chooseImage(obj){
        // 选择张片
        wx.chooseImage({
            count: 3, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function(res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                $(obj).attr('src', localIds);
                // 上传照片
                wx.uploadImage({
                    localId: '' + localIds,
                    isShowProgressTips: 1,
                    success: function(res) {
                        serverId = res.serverId;
                        $(obj).next().val(serverId); // 把上传成功后获取的值附上
                    }
                });
            }
        });
    }


</script>
</html>