<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=320,initial-scale=1,user-scalable=0">
<title>会员登录</title>
<link rel="stylesheet" href="<?php echo base_url("public/member/styles/global.css");?>"/>
<link rel="stylesheet" href="<?php echo base_url("public/member/junting/styles/junting.css");?>"/>

<script src="<?php echo base_url("public/member/scripts/jquery.js");?>"></script>
<script src="<?php echo base_url("public/member/scripts/ui_control.js");?>"></script>
<script src="<?php echo base_url("public/member/scripts/alert.js");?>"></script>
</head>
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
<body>
<div style="padding:50px 10px 25px 10px;" class="center">
	<img style="width:auto; height:70px" src="icon/logo.png">
    <p class="pad3">您已是会员，请登录</p>
</div>
<form id="pinfo" action="<?php echo base_url("index.php/member/account/save");?>" method="post">
<div  class="list_style_1 bd_bottom">
  <?php foreach ($fields as $key => $info){ ?>
    <?php if ($info['must']==1){ ?>
         <?php  if($inter_id=='a449675133' && $info['name']=='登录账号'){ ?>
              <div class="input_item">
                  <div><?php echo $info['name'];?></div>
                  <div><input name="<?php echo $key; ?>" type="text" placeholder="请输入会员号／手机／Email" /></div>
              </div>
          <?php }else{ ?>
              <div class="input_item">
                <div><?php echo $info['name'];?></div>
                <div><input name="<?php echo $key; ?>" type="text" placeholder="请输入<?php echo $info['name'] ?>" /></div>
              </div>
        <?php }  ?>
    <?php } ?>
  <?php } ?>
  <?php if(isset($fields['telephone']) && ($fields['telephone']['must']==1 && $fields['telephone']['check']==1)) {?>
	<div class="input_item justify">
    	<div>验证码</div>
        <div><input placeholder="请输入验证码" name="sms" type="tel"></div>
        <div><span id="sms"  class="btn_main xs bdradius h22">获取验证码</span></div>
    </div>
  <?php } ?>
	<div class="input_item ">
    	<div>密码</div>
        <div><input placeholder="请输入密码" type="password"></div>
    </div>
</div>
<div class="txt_r pad3 h22">
	<a href="<?php echo base_url("index.php/member/account/resetpassword");?>">忘记密码？</a>
</div>
<div class="pad3">
	<button class="bg_main pad12 bdradius" style="width:100%"  id="sub">登录</button>
</div>
</form>
<div class="pad3"><?php if(isset($tishiMsg)) echo $tishiMsg; ?></div>
</body>
<script>
$(document).ready(function(){
   $("#sub").click(function(){
       if($("input[name='account']").val().length==0) {
           alert("请填写登录帐号!");
           return false;
       }
       if($("input[name='password']").val().length==0) {
           alert("请输入密码!");
           return false;
       }
       $("#pinfo").submit();

   });
});
</script>
</html>
