<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" >
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta name="ML-Config" content="fullscreen=yes,preventMove=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=320.1,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">
    <script src="<?php echo base_url('public/soma/scripts/jquery.js');?>"></script>
    <script src="<?php echo base_url('public/soma/scripts/ui_control.js');?>"></script>
    <script src="<?php echo base_url('public/soma/scripts/imgscroll.js');?>"></script>
    <script src="<?php echo base_url('public/soma/scripts/jquery.touchwipe.min.js');?>"></script>
    <!-- 
    <script src="<?php echo base_url('public/soma/scripts/lazyload.js');?>"></script>
     -->
    <link href="<?php echo base_url('public/soma/styles/global.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('public/soma/styles/command.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('public/soma/styles/theme.css');?>" rel="stylesheet">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="<?php echo base_url('public/member/scripts/alert.js');?>"></script>
    <title><?php echo $title ?></title>
</head>
    <script>
    //$(function(){
	//	$("img.lazy").lazyload();  //惰性加载
	//});
    </script>
    <?php if($type == 1){ ?>
<body d="扫码页面">
<!-- 
<div class="page_loading"><p class="isload">正在加载</p></div>
 -->
<script>
wx.config({
    debug: false,
    appId:'<?php echo $signpackage["appId"];?>',
    timestamp:<?php echo $signpackage["timestamp"];?>,
    nonceStr:'<?php echo $signpackage["nonceStr"];?>',
    signature:'<?php echo $signpackage["signature"];?>',
    jsApiList: [
    'scanQRCode',
    'closeWindow',
    ]
});
wx.ready(function(){
	<?php if( $js_menu_show ): ?>wx.showMenuItems({ menuList: [<?php echo $js_menu_show; ?>] });<?php endif; ?>
	
	<?php if( $js_menu_hide ): ?>wx.hideMenuItems({ menuList: [<?php echo $js_menu_hide; ?>] });<?php endif; ?>
});
</script>
<div id="logo_div" class="center" style="padding-top:100px;">
	<p class="pad3 mcolor" style="font-size:60px;"><em class="iconfont">&#xe61a;</em></p>
	<p class="h3 fcolor pad3"><?php echo $message; ?></p>
    <p class="fcolor" style="padding-top:50px">小提示：右上角收藏本页面，以后打开即可核销</p>
</div>
<script>
function call_qrcode(){
	wx.scanQRCode({
		needResult: 1,
		scanType: ["qrCode","barCode"],
		success: function (res) {
			var result = res.resultStr;
            pageloading('核销中，请稍后……');
			$.post('<?php echo $callback; ?>', {'code':result}, function(res){
                removeload();
				$.MsgBox.Alert( res['msg'] );
			}, 'json');
		}
	});
	$("title").html("扫码核销");
}
$('#logo_div').click(function(){ call_qrcode(); });
</script>
</body>
</html>
<?php }else{ ?>

<body d="失败">
<!-- 
<div class="page_loading"><p class="isload">正在加载</p></div>
 -->
<div class="center pad3" style="padding-top:100px;">
	<p class="pad3 fcolor" style="font-size:60px;"><em class="iconfont">&#xe612;</em></p>
	<p class="h3 fcolor pad3"><?php echo $message; ?></p>
    <p class="fcolor" style="padding-top:50px"><tt>5</tt>秒后关闭</p>
</div>
<script>
window.onload=function(){
	window.setTimeout(function(){
		wx.closeWindow();
	},5000);
}
</script>
</body>
</html>
<?php } ?>