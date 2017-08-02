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
    <title>我的积分</title>
</head>
<body>
<div class="gradient_bg">
    <section class="padding_0_15">
        <head>
            <div class="center padding_top_48 main_color1">
                <em class="iconfonts font_30"><?php echo $total_credit;?></em>
                <p class="color3 font_12 margin_top_15">账户积分</p>
            </div>
        </head>
        <section>
            <div class="flex font_16 centers margin_top_42 bd_bottom padding_bottom_35 recharge color2">
                <div class="flex_1 center relative <?php echo $credit_type == 1 ? 'active' : '';?>">
                    <a href="<?php echo base_url("index.php/membervip/bonus?credit_type=1")?>">获取记录</a>
                    <span class="shadow_b"></span>
                </div>
                <div class="flex_1 center relative <?php echo $credit_type == 2 ? 'active' : '';?>">
                    <a href="<?php echo base_url("index.php/membervip/bonus?credit_type=2")?>" class="bd_left">消费记录</a>
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