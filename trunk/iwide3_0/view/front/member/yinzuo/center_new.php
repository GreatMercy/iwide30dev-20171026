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
<link href="<?php echo base_url("public/member/phase2/styles/global.css");?>" rel="stylesheet">
<link href="<?php echo base_url("public/member/phase2/styles/mycss.css");?>" rel="stylesheet">
<script src="<?php echo base_url("public/member/phase2/scripts/jquery.js");?>"></script>
<script src="<?php echo base_url("public/member/phase2/scripts/ui_control.js");?>"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<title>会员中心</title>
    <style>
        body,html{background:#f8f8f8}
        .domain_con{
            margin-top: 0.5rem;
            background-color: white;
        }
        .heads{
            color: white;
        }
        .bg_l_g_fec50f_ffa70a {
            background: none;
            background-color: white;
        }
        .grade{
            color: #b19b6b;
        }
        .number_con >p:nth-of-type(1) {
            color: #d54d76 !important;
            font-size: 0.929rem;
        }
        .head_img{
                box-shadow: 0px 1px 5px black;
        }
        .w100{
            width: 100%;
        }
        ib{
            display: inline-block;
        }
        .user_lv{
    position: absolute;
    right: 7.5%;
    bottom: 10%;
    font-size: 0.7rem;
    text-align: right;
        }
        .card_type{
            position: absolute;
            left: 7.5%;
            bottom: 8.2%;
            font-size: 1rem;
            text-align: right
        }
        .user_lv>div{
            line-height: 1.1 !important;
        }
        .user_lv[card="9"]>div, .card_type[card="9"]>div{
            color:#c8b175;
        }
        .user_lv[card="1"]>div, .card_type[card="1"]>div{
            color:#cfcfcf;
        }
        .user_lv[card="2"]>div, .card_type[card="2"]>div{
            color:#a08649;
        }
        .user_lv[card="4"]>div, .card_type[card="4"]>div{
            color:#9d854a;
        }
        .user_lv[card="3"]>div, .card_type[card="3"]>div{
            color:#9da3ad;
        }
    </style>
</head>
<body>
<div class="heads bg_l_g_fec50f_ffa70a">

  <?php if($centerinfo['is_login']=='f' && $centerinfo['member_mode'] ==1){ ?>
<?php if($centerinfo['value']=="login"){ ?>
	<?php if($centerinfo['is_login']=='t' && $centerinfo['member_mode'] ==2 ){ ?>
	<?php if( $inter_id!='a486201893'){?>
		<a class="btn_list  h26" href="<?php echo base_url("index.php/membervip/perfectinfo");?>">修改资料</a>
		<?php }?>
	<?php }else{ ?>
        <div class="btn_list h26">
            <a class="" href="<?php echo base_url("index.php/membervip/login");?>">登录</a> |
            <a class="" href="<?php echo base_url("index.php/membervip/reg");?>">注册</a>
        </div>
	<?php } ?>
<?php } ?>
<?php if($centerinfo['value']=="perfect"){ ?>
		<a class="btn_list h26" href="<?php echo base_url("index.php/membervip/perfectinfo");?>">完善资料</a>
<?php } ?>
    <div class="img_con bd_bottom">
        <a href="<?php echo base_url("index.php/membervip/center/info");?>"><img class="head_img" src="<?php echo $info['headimgurl'];?>"></a>
        <p class="name"><?php if($centerinfo['name']=='微信用户' || $centerinfo['name']=='' ){echo $centerinfo['nickname'];}else{  echo $centerinfo['name'];}?></p>
        <p class="grade"><?php if($centerinfo['value']=="login" && $centerinfo['member_mode'] ==1 ){ echo '微信粉丝';}else{ echo $centerinfo['lvl_name'];}?> <?php if(isset($centerinfo['membership_number'])) echo $centerinfo['membership_number'];?></p>
    </div>
    <?php }?>
    
    <?php if($centerinfo['is_login']=='t' && $centerinfo['member_mode'] ==2 ){ ?>
    <div class="w100 bd_bottom" style="padding:5px 0px;text-align: center;">
        <ib style="width:75%;position: relative;">
        <?php $lvl_pms_code=str_replace(',', '', $centerinfo['lvl_pms_code'])?>
        <?php if (in_array($lvl_pms_code, ['SP1','SP3','SP4','SP5','SP7'])){$lvl_pms_code='SP1';}?>
            <img class="w100" src="<?php echo base_url("public/member/phase2/images/yinzuo").'/'.$lvl_pms_code.'.png';?>">
            <ib class="user_lv" card="<?php echo $lvl_pms_code?>">
                <div>NO.<?php echo $centerinfo['membership_number']?></div>
                <div><?php echo $centerinfo['name']?> </div>
              </ib>
            <ib class="card_type" card="<?php echo $lvl_pms_code?>">
                <div><?php echo $centerinfo['lvl_name']?></div>
            </ib>   
        </ib>
    </div>
    <?php }?>
    <div class="display_flex number_list">
        <a href="<?php echo base_url("index.php/membervip/balance");?>" class="number_con">
            <p><?php if($centerinfo['value']=="login" && $centerinfo['member_mode'] ==1 ){ echo '-';}else{ echo $centerinfo['balance']; } ?></p>
            <p class=""><?php echo $this->_ci_cached_vars['filed_name']['balance_name'];?></p>
        </a>
        <a href="<?php echo base_url("index.php/membervip/bonus?credit_type=1");?>" class="number_con">
            <p><?php if($centerinfo['value']=="login" && $centerinfo['member_mode'] ==1 ){ echo '-';}else{ echo $centerinfo['credit']; } ?></p>
            <p class=""><?php echo $this->_ci_cached_vars['filed_name']['credit_name'];?></p>
        </a>
        <a href="<?php echo base_url("index.php/membervip/card");?>" class="number_con">
            <p><?php echo $centerinfo['card_count'] ?></p>
            <p class=""><?php echo $this->_ci_cached_vars['filed_name']['coupon_name'];?></p>
        </a>
    </div>
</div>
    <div class="domain_con flex flexgrow flexwrap h24 center">

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
		<a class="c_9b9b9b " href="<?php
		 if( $centerinfo['is_login'] == 'f' && $value['is_login'] == 1 &&  ( isset($centerinfo['value']) && $centerinfo['value'] != 'perfect' ) ){
			echo base_url("index.php/membervip/login");}
		 else{ echo $value['link'];} ?>">
		<div class="square bd_bottom bd_right">
			<div class="centerbox flex flexrow flexjustify">
            	<p class="ico_img <?php if(isset($value['icon'])) echo str_replace("ui_",'',$value['icon']); ?>"></p>
				<p><?php echo $value['modelname'] ?></p>
			</div>
		</div>
		</a>
<?php } ?>

    </div>
<?php if(isset($message)) {?>
<script>
$(function(){
	$.MsgBox.Alert('<?php echo $message;?>');
})
</script>
<?php }?>
</body>
</html>