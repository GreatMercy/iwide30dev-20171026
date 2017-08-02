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
    <link rel="stylesheet" href="<?php echo base_url("public/member/highclass/css/mycss.css")?>" type="text/css">
    <script src="<?php echo base_url("public/member/highclass/js/jquery.js")?>"></script>
    <script src="<?php echo base_url("public/member/highclass/js/myjs.js")?>"></script>
    <title>我的余额</title>
</head>
<body>
<div class="gradient_bg">
    <section class="padding_0_15">
        <head>
            <div class="iconfont center padding_top_48 main_color1"><font class="iconfont margin_right_7 font_13">&#xe643;</font><em class="iconfonts font_30"><?php echo $total_deposit;?></em></div>
            <div class="flex between centers font_12 margin_top_42">
                <div class="width_86 center relative border_1_808080 line_height_20 height_20 radius_3 margin_right_38 border_b2945e main_color1">马上充值</div>
                <div class="width_86 center relative border_1_808080 line_height_20 height_20 radius_3 color1 border_fff"><a href="<?php echo base_url("index.php/membervip/resetpassword/resetbindpwd")?>">设置支付密码</a></div>
            </div>
        </head>
        <section>
            <div class="flex font_16 centers margin_top_42 bd_bottom padding_bottom_35 recharge color2">
                <div class="flex_1 center relative <?php if($credit_type==1){ echo 'active';} ?>">
                    <a href="<?php echo base_url("index.php/membervip/balance?credit_type=1")?>">充值记录</a>
                    <span class="shadow_b"></span>
                </div>
                <div class="flex_1 center relative <?php if($credit_type==2){ echo 'active';} ?>">
                    <a class="bd_left" href="<?php echo base_url("index.php/membervip/balance?credit_type=2")?>">消费记录</a>
                    <span class="shadow_b"></span>
                </div>
            </div>
            <section class="containers_list">
                <?php if ( empty($bonuslist)){ ?>
                    <div class="center color_D3D3D3 h24" style="padding:30px;">暂无记录</div>
                <?php }else{?>
                    <?php foreach ($bonuslist as $key => $value){ ?>
                        <section>
                            <div class="flex between padding_30 bd_bottom">
                                <div>
                                    <p class="font_16 width_210 txtclip"><?php echo $value['note']?></p>
                                    <p class="font_12 margin_top_22 color3">
                                        <em><?php echo $value['last_update_time']?></em>
                                    </p>
                                </div>
                                <div class="iconfonts main_color1">
                                    <?php if($value['log_type']==1){ ?>+<?php }else{ ?>-<?php } ?>
                                    ¥<em class="iconfonts font_17 "><?php echo $value['amount']?></em>
                                </div>
                            </div>
                        </section>
                    <?php }?>
                <?php }?>
            </section>
        </section>
    </section>
</div>
</body>
</html>