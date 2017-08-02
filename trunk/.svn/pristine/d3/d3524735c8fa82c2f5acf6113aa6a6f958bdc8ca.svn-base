<!DOCTYPE html>
<html lang="en">
<head>
<script src="<?php echo base_url("public/member/highclass/js/rem.js")?>"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="ML-Config" content="fullscreen=yes,preventMove=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui">
<!-- 全局控制 -->
<link rel="stylesheet" href="<?php echo base_url("public/member/highclass/css/global.css")?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url("public/member/highclass/css/mycss.css")?> " type="text/css">
    <script src="<?php echo base_url("public/member/highclass/js/jquery.js")?>"></script>
    <script src="<?php echo base_url("public/member/highclass/js/myjs.js")?>"></script>
<title>会员中心</title>
    <style>.none{display:none}</style>
</head>
<body>
<div class="bg_img">
	<section class="padding_0_15">
		<header>
            <?php if($centerinfo['value']=="login"){ ?>
            <?php if($centerinfo['is_login']=='t'  && $centerinfo['member_mode'] ==2){ ?>
			<div class="banner padding_top_15">
				<div class="relative radius_5 overflow">
		            <div class="banner_img"><img src="<?php echo base_url("public/member/highclass/images/nologin_box.png")?>" alt=""></div>
                    <div class="banner_txt absolute l_t_0 flex between font_15">
		                <span class="block center flex_1">加入XXX，领取¥200大礼包</span>
		                <a class="block" href="<?php echo base_url("index.php/membervip/login");?>"><span class="iconfont main_color1 font_17 margin_right_15">&#xe607;&#xe610;/&#xe61a;&#xe605;<em class="iconfont font_16">&#xe61c;</em></span></a>
		            </div>
	            </div>
	        </div>
                <?php }?>
            <?php }?>
			<div id="member_info" class="flex between padding_60 font_12 bd_bottom <?php echo $centerinfo['is_login']=='f' ? 'none':'';?>">
				<div class="margin_right_30 relative padding_left_35">
					<div class="line_left absolute"><img src="<?php echo base_url("public/member/highclass/images/line_03.png")?>" alt=""></div>
					<div>
						<div class="head_img"><img alt="" src="<?php echo $info['headimgurl'];?>"></div>
						<div class="iconfont margin_top_8 center relative"><em class="iconfont font_21 bold absolute spot color_338b43">&#xe7b0;</em>微信粉丝</div>
					</div>
				</div>
				<div class="flex_1">
					<a class="block flex between">
						<div>
							<p class="font_19"><?php echo $centerinfo['name'];?></p>
							<p><?php echo $centerinfo['membership_number'];?></p>
						</div>
						<div><em class="iconfont font_15 bold">&#xe61c;</em></div>
					</a>
					<a class="block margin_top_20">查看会员权益<em class="iconfont margin_left_8 font_17">&#xe61e;</em></a>
				</div>
			</div>

			<div class="flex between padding_60 bd_bottom padding_0_14">
				<a id='wechat_login' class="block margin_right_20 center flex_1 padding_15 relative border_1"><em class="iconfont font_19 margin_right_8">&#xe64f;</em>微信登陆</a>
				<a id="login" class="block center flex_1 padding_16 color_fff bg_b2945e" href="<?php echo base_url("index.php/membervip/login");?>">会员登陆/注册</a>
			</div>
		</header>
		<section class="flex around padding_35 font_12">
			<div class="flex_1 center">
                <a href="<?php echo base_url("index.php/membervip/bonus?credit_type=1");?>">
                    <p><em class="iconfont margin_right_8 txt_show1">&#xe622;</em>积分<em class="iconfont margin_left_4 font_17">&#xe61e;</em></p>
                    <p><fotn class="font_19"><?php echo $centerinfo['is_login']=='t'? $centerinfo['credit']:'--'?></fotn></p>
                </a>
			</div>
			<div class="line_center"><img alt="" src="<?php echo base_url("public/member/highclass/images/line_01.png")?>" /></div>
			<div class="flex_1 center">
                <a href="<?php echo base_url("index.php/membervip/balance?credit_type=1");?>">
                    <p><em class="iconfont margin_right_8 txt_show1">&#xe62e;</em>储值<em class="iconfont margin_left_4 font_17">&#xe61e;</em></p>
                    <p><fotn class="font_19"><?php echo $centerinfo['is_login']=='t'? '¥'.$centerinfo['balance']:'--'?></fotn></p>
                </a>
			</div>
			<div class="line_center"><img alt="" src="<?php echo base_url("public/member/highclass/images/line_01.png")?>" /></div>
			<div class="flex_1 center">
				<p><em class="iconfont margin_right_8 txt_show1">&#xe61f;</em>优惠券<em class="iconfont margin_left_4 font_17">&#xe61e;</em></p>
				<p><fotn class="font_19"><?php echo $centerinfo['is_login']=='t'? $centerinfo['card_count']:'--'?></fotn></p>
			</div>
		</section>
		<section class="flex ">
			<a class="block flex_1 center bg_202020 radius_3 padding_32">
				<em class="iconfont margin_left_8 txt_show2">&#xe62b;</em>
				<span class="iconfont">商城订单</span>
				<em class="iconfont margin_left_8 font_17">&#xe61e;</em>
			</a>
			<a class="block flex_1 center bg_202020 radius_3 padding_32 margin_left_15">
				<em class="iconfont margin_left_8 txt_show2">&#xe62d;</em>
				<span class="iconfont">订房订单</span>
				<em class="iconfont margin_left_8 font_17">&#xe61e;</em>
			</a>
		</section>
		<section class="flex wrap margin_top_35 padding_bottom_77 font_12">
            <?php
            foreach ($menu as  $group_key => $group){
                if(!empty($group)){
                    foreach($group as $menu_key => $menu_link){
                        if(!empty($menu_link)){
                            $menuShow[] = $menu_link;
                        }
                    }
                }
            }
            ?>
            <?php foreach ($menuShow as $key => $value) { ?>
                <a class="block width_25 " href="<?php
                if( $centerinfo['is_login'] == 'f' && $value['is_login'] == 1 &&  ( isset($centerinfo['value']) && $centerinfo['value'] != 'perfect' ) ){
                    echo base_url("index.php/membervip/login");}
                else{ echo $value['link'];} ?>">
                    <div class="flex column center padding_20">
                        <p><em class="iconfont font_21 color_fff"><?php if(isset($value['icon'])) echo str_replace("ui_",'',$value['icon']); ?></em></p>
                        <div class="margin_top_18"><?php echo $value['modelname'] ?></div>
                    </div>
                </a>
            <?php } ?>

		</section>
	</section>
</div>
<script type="text/javascript">
    $(function() {
    	var cache = [];
	    try{
			cache = JSON.parse(window.localStorage['login_cache']);
		}catch(e){
			console.log(e);
			cache = [];
		}
        $("#wechat_login").click(function () {
        		cache = true;
        		window.localStorage['login_cache']=cache;
                $("#member_info").show();
            }
        );
        $("#login").click(function () {
        		cache = false;
        		window.localStorage['login_cache']=cache;
                $("#member_info").hide();
            }
        );
		if(cache){
			$("#member_info").show();
		}
    });
</script>
</body>
</html>