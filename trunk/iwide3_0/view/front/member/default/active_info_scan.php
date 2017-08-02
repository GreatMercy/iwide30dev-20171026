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
<link rel="stylesheet" href="<?php echo base_url('public/member/super8/css/activate_card.css'); ?>">

<title>速8酒店 - 激活会员卡</title>
<script>
wx.config({
	debug:false,
	appId:'<?php echo $signpackage["appId"];?>',
	timestamp:<?php echo $signpackage["timestamp"];?>,
	nonceStr:'<?php echo $signpackage["nonceStr"];?>',
	signature:'<?php echo $signpackage["signature"];?>',
	jsApiList: [
		'hideOptionMenu'
	]
});
wx.ready(function () {
	wx.hideOptionMenu();
});
</script>
</head>
<body>
<div class="wrap-outer">
	<div class="wrap">
		<img src="<?php echo base_url('public/member/super8/images/logo-115.png'); ?>" class="logo">
		<h1 class="page-name">激活会员卡</h1>
		<div class="form-wrap" id="form-div">
			<div class="input-box"><input type="text" class="i-t-normal" name="customer"  value="<?php echo $name?>"  readonly="readonly"  placeholder="请输入您的真实姓名"></div>
			<div class="input-box"><input type="tel" maxlength="11" name="telephone"   value="<?php echo $tel?>"  readonly="readonly"  class="i-t-normal" placeholder="请输入您的手机号码"></div>
			<div class="input-box"><input type="hidden"  name="cardNo"   value="<?php echo $cardNo?>"  readonly="readonly"  class="i-t-normal"  ></div>
		</div>
		<div class="btn-wrap">
			<a href="javascript:;" class="btn" id="btn-submit">提交</a>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">

	$('#btn-submit').on('click',function(){
		
		$.ajax({
			url:'<?php echo site_url("member/account/band_scan_card_save"); ?>',
			type:'POST',
			dataType:'json',
			data:$('#form-div input[name="cardNo"]'),
			beforeSend:function(){
				pageloading('资料提交中...',0.2);
			},
			complete:function(){
				$('.pageloading').remove();
			},
			success:function(res){
				if(res.redirect){
					location.href=res.redirect;
				}
				if(res.errmsg){
					$.MsgBox.Alert(res.errmsg);
				}
			}
		});
	});




</script>
</html>