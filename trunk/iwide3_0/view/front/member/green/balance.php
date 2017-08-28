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
    <link href="<?php echo base_url("public/member/phase2/styles/global.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/member/phase2/styles/mycss.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/member/phase2/styles/green.css");?>" rel="stylesheet">
    <script src="<?php echo base_url("public/member/phase2/scripts/jquery.js"); ?>"></script>
    <script src="<?php echo base_url("public/member/phase2/scripts/ui_control.js"); ?>"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <title>账户<?php echo $this->_ci_cached_vars['filed_name']['balance_name'];?></title>
</head>
<body>
<style>body, html {
        background: #fff;
    }</style>
<div class="balance bg_l_g_fec50f_ffa70a color_fff">
    <p>账户<?php echo $this->_ci_cached_vars['filed_name']['balance_name'];?></p>
    <p><?php echo $total_deposit;?></p>
</div>
<div class="display_flex bd_bottom record">
    <a class="<?php if($credit_type==1){ echo 'active';} ?>" href="<?php echo base_url("index.php/membervip/balance?credit_type=1")?>">充值记录</a>
    <a class="bd_left <?php if($credit_type==2){ echo 'active';} ?>" href="<?php echo base_url("index.php/membervip/balance?credit_type=2")?>">消费记录</a>
</div>
<?php if ( empty($bonuslist)){ ?>
<div class="center color_D3D3D3 h24" style="padding:30px;">暂无记录</div>
<?php }else{?>
<div class="containers p_b_17">
    <div class="balance_box">
        <div class="time_month bd_bottom" style="display: none">2016年11月</div>
        <div class="balance_con_list list_style_1 bg_fff bd_bottom">
            <?php foreach ($bonuslist as $key => $value){ ?>
            <div class="balance_con">
                <div class="f_r balance_number">
                    <p><?php if($value['log_type']==1){echo "+";}else{ echo "-"; } ?><?php echo $value['amount']?></p>
<!--                    <p>ads1234567890</p>-->
                </div>
                <div class="b_con_txt">
                    <p class="name_ellipsis"><?php echo $value['note']?></p>
                    <p><?php echo $value['last_update_time']?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="balance_box" style="display: none">
        <div class="time_month">2016年11月</div>
        <div class="balance_con_list bg_fff">
            <div class="balance_con border_bottom_9b9b9b">
                <div class="f_r balance_number">
                    <p>-388</p>
                    <p>ads1234567890</p>
                </div>
                <div class="b_con_txt">
                    <p class="name_ellipsis">金房卡大酒店岗店店店店店店店店顶店-行政大床房</p>
                    <p>2016.09.01 16:06:00</p>
                </div>
            </div>
            <div class="balance_con border_bottom_9b9b9b">
                <div class="f_r balance_number">
                    <p>-388</p>
                    <p>ads1234567890</p>
                </div>
                <div class="b_con_txt">
                    <p class="name_ellipsis">金房卡大酒店岗顶店-行政大床房</p>
                    <p>2016.09.01 16:06:00</p>
                </div>
            </div>
            <div class="balance_con border_bottom_9b9b9b">
                <div class="f_r balance_number">
                    <p>-388</p>
                    <p>ads1234567890</p>
                </div>
                <div class="b_con_txt">
                    <p class="name_ellipsis">金房卡大酒店岗顶店-行政大床房</p>
                    <p>2016.09.01 16:06:00</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>
<div class="floor" style="display: none;">
    <a class="f_btn bg_ff9900" href="recharge_2.html">充值</a>
</div>
</body>
</html>
