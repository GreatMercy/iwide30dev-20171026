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
<?php include 'wxheader.php' ?>
<script src="<?php echo base_url("public/member/public/js/jquery.js");?>"></script>
<script src="<?php echo base_url("public/member/scripts/ui_control.js");?>"></script>
<script src="<?php echo base_url("public/member/scripts/alert.js");?>"></script>
<link href="<?php echo base_url("public/member/styles/global.css");?>" rel="stylesheet">
<link href="<?php echo base_url("public/member/public/css/mycss.css");?>" rel="stylesheet">
<title>豪礼大放送</title>
</head>
<style>
body,html{ background:#ffc242}
.gain_btn,a.gain_btn{ background:url(<?=base_url("public/member/images/btn01.png");?>) no-repeat; background-size:auto 100%; background-position:center center; color:#fff; padding:10px 0 15px 0}
</style>
<body>
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
<div class="pageloading"></div>

<div><img src="<?php echo base_url("public/member/images/bg01.jpg");?>"></div>
<?php if(isset($card_info['logo_url'])):?>
<div class="center">
	<div style="width:70px; display:inline-block;"><div class="squareimg" style="overflow:hidden; border-radius:50%"><img src="<?php echo $card_info['logo_url'];?>"></div></div>
</div>
<?php endif;?>
<?php if(!empty($card_info)):?>
    <?php if(!empty($card_info['is_package']) && $card_info['is_package']=='f'):?>
        <div class="pad10 center color_fff">
            <div>尊贵的会员，您获得了一张券</div>
            <div class="h26">点击领取享受更多优惠</div>
        </div>
        
        <div class="pad10 center">
            <?php if(!empty($card_info['frequency']) && $card_info['frequency']>$gain_count):?>
                <div class="gain_btn gain_card">立即领取</div>
                <div class="gain_btn look_card" style="display:none;" href="<?php echo site_url("membervip/card");?>">立即查看</div>
            <?php else:?>
                <div class="gain_btn look_card" href="<?php echo site_url("membervip/card");?>">立即查看</div>
            <?php endif;?>
        </div>
        <div class="newCardBox">
            <div class="bg_alpha pad10">
                <div class="martop bg_alpha pad10 newCard">
                    <?php if($card_info['count_num'] > 1):?>
                    <div class="CardCount h20"><p>1张</p><span><!--三角形--></span></div>
                    <?php endif;?>
                    <div class="color_red h30 box1">
                        <?php if($card_info['card_type']==1):?>
                            <?php echo $card_info['reduce_cost']; ?>
                        <?php elseif($card_info['card_type']==2):?>
                            <?php echo $card_info['discount']; ?><span class="h22">折</span>
                        <?php elseif($card_info['card_type']==3):?>
                            兑
                        <?php elseif($card_info['card_type']==4):?>
                            <span class="h22 y"></span><?php echo $card_info['money']; ?>
                        <?php else:?>
                            券
                        <?php endif;?>
                    </div>
                    <img src="<?=base_url("public/member");?>/images/bg02.png" />
                    <div class="box2">
                        <div class="color_red"><?php echo $card_info['title']; ?></div>
                        <div class="color_555 h24">有效期至<?=$card_info['expiretime']?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif (!empty($card_info['is_package']) && $card_info['is_package']=='t'):?>
    <div class="pad10 center color_fff">
        <div>尊贵的会员，您获得了<?=!empty($card_info['name'])?'"'.$card_info['name'].'"':'';?>大礼包</div>
        <?php if(!empty($card_info['frequency']) && $card_info['frequency']>$gain_count):?>
        <div class="h26">点击领取享受更多优惠</div>
        <?php endif;?>
    </div>
    <div class="pad10 center">
        <?php if(!empty($card_info['frequency']) && $card_info['frequency']>$gain_count):?>
            <div class="gain_btn gain_package" href="javascript:void(0);">立即领取</div>
            <div class="gain_btn look_card" style="display:none;" href="<?php echo site_url("membervip/card");?>">立即查看</div>
        <?php else:?>
            <div class="gain_btn look_card" href="<?php echo site_url("membervip/card");?>">立即查看</div>
        <?php endif;?>
    </div>
    <div class="newCardBox">
        <div class="bg_alpha pad10">
            <div class="flexbox center pad10">
                <?php if(!empty($card_info['lvl_name'])):?>
                <div class="item">
                    <div class="img"><div class="squareimg"><img src="<?=base_url("public/member");?>/images/icon01.png" /></div></div>
                    <div class="color_red h26"><?=$card_info['lvl_name'];?></div>
                </div>
                <?php endif;?>
                <?php if(!empty($card_info['deposit'])):?>
                <div class="item">
                    <div class="img"><div class="squareimg"><img src="<?=base_url("public/member");?>/images/icon02.png" /></div></div>
                    <div class="color_red h26"><?=$card_info['deposit'];?>元</div>
                </div>
                <?php endif;?>
                <?php if(!empty($card_info['credit'])):?>
                <div class="item">
                    <div class="img"><div class="squareimg"><img src="<?=base_url("public/member");?>/images/icon03.png" /></div></div>
                    <div class="color_red h26"><?=$card_info['credit'];?><?php echo $this->_ci_cached_vars['filed_name']['credit_name'];?></div>
                </div>
                <?php endif;?>
            </div>
            <?php if(!empty($card_info['card'])):?>
			<?php foreach ($card_info['card'] as $kc => $vo):?>
            <div class="martop bg_alpha pad10 newCard">
                <?php if($vo['number'] > 1):?>
                <div class="CardCount h20"><p><?=$vo['number']?>张</p><span><!--三角形--></span></div>
                <?php endif;?>
                <div class="color_red h30 box1">
				<?php if($vo['card_type']==1):?>
                    <span class="h22 y"></span><?=$vo['reduce_cost'];?>
                <?php elseif($vo['card_type']==2):?>
                    <?=$vo['discount'];?><span class="h22">折</span>
                <?php elseif($vo['card_type']==3):?>
                    兑
                <?php elseif($vo['card_type']==4):?>
                    <span class="h22 y"></span><?php echo $vo['money']; ?>
                <?php else:?>
                	券
                <?php endif;?>
                </div>
                <img src="<?=base_url("public/member");?>/images/bg02.png" />
                <div class="box2">
                    <div class="color_red"><?php echo $vo['title']; ?></div>
                    <div class="color_555 h24">有效期至<?=$vo['expiretime']?></div>
                </div>
            </div>
            <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
    <?php endif;?>
<?php endif;?>
<script>
    var card_rule_id = "<?=$card_rule_id?>";
    var package_id = "<?=!empty($card_info['package_id'])?$card_info['package_id']:0;?>";
    var frequency = "<?=!empty($card_info['frequency'])?$card_info['frequency']:0;?>";
    var ajaxload = false;

    //领取礼包
    $(document).ready(function () {
        $(".gain_package").click(function (e) {
            e.preventDefault();
            if(ajaxload)return;
            pageloading();
            var surl = "<?=base_url('index.php/membervip/card/getpackage');?>";
            var datas = {"package_id":package_id,"card_rule_id":card_rule_id,"frequency":frequency};
            var obj = $(this),obj_next = $(this).next();
            $.post(surl,datas,function (data) {
                removeload();
                ajaxload=false;
                if(typeof(data.err) != "undefined") {
                    if(data.err=='0'){
                        $.MsgBox.Alert('领取成功');
                        obj.hide();
                        obj_next.show();
                    }else{
                        $.MsgBox.Alert(data.msg);
                    }
                }else{
                    $.MsgBox.Alert("系统繁忙！");
                }
            },'json');
            return false;
        });

        //领取优惠券
        $(".gain_card").click(function (e) {
            e.preventDefault();
            if(ajaxload)return;
            pageloading();
            var surl = "<?=base_url('index.php/membervip/card/addcard');?>";
            var datas = {"card_rule_id":card_rule_id};
            var obj = $(this),obj_next = $(this).next();
            $.post(surl,datas,function(Result){
                removeload();
                ajaxload=false;
                if(Result['err']>0){
                    $.MsgBox.Alert(Result['msg']);
                }else{
                    $.MsgBox.Alert('领取成功');
                    obj.hide();
                    obj_next.show();
                }
            }, "json");
        });
    });
</script>
</body>
</html>
