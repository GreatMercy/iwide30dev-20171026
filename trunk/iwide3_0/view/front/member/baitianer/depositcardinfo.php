<!doctype html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes" >
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<script src="<?php echo base_url("public/member/public/js/viewport.js");?>"></script>
<script src="<?php echo base_url("public/member/public/js/jquery.js");?>"></script>
<script src="<?php echo base_url("public/member/public/js/ui_control.js");?>"></script>
<script src="<?php echo base_url("public/member/public/js/addcount.js");?>"></script>
<link href="<?php echo base_url("public/member/public/css/global.css");?>" rel="stylesheet">
<link href="<?php echo base_url("public/member/public/css/ui.css");?>" rel="stylesheet">
<link href="<?php echo base_url("public/member/public/css/ui_style.css");?>" rel="stylesheet">
<link href="<?php echo base_url("public/member/public/css/store.css");?>" rel="stylesheet">
<link href="<?php echo base_url("public/member/public/css/addcount.css");?>" rel="stylesheet">
<title>详细信息</title>
<style>
.ui_foot_fixed_btn div.total{ font-size:0.65rem; display:inline-block; margin-top:2%;}
</style>
<body>
<div class="headers"> 
  <div class="headerslide">
  	  <a class="slideson imgshow relative ui_img_auto_cut" href="#">
     	 <img src="<?php echo $card['logo_url'];?>" />
      </a>
  </div>
<!--   <div class="banner">
      <div class="circle overfw_hidden">	
          <span class="disc disc_show"></span>
      </div>
  </div>    -->
</div>
<div class="detail" >
    <div class="goods_rest ui_price"><?php echo $card['money'];?></div>
	<div class="goods_name"><?php echo $card['title'];?></div>
	<div class="goods_dec"><?php echo $card['brand_name'];?></div>
    <div class="how_use" style=" border-top: 1px solid #ccc;">
        <?php echo $card['description'];?>
    </div>
</div>
<form action="<?php echo base_url("index.php/membervip/depositcard/buycard");?>" method="post">
<div style="padding-top:15%">
	<div class="ui_foot_fixed_btn">

        <button class="btn" type="submit">确认购买</button>
    </div>
</div>
      <input type="hidden" name="cardId" value="<?php echo $card['deposit_card_id'];?>" />
</form>
</body>
</html>