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
    <script src="<?php echo base_url("public/member/phase2/scripts/jquery.js"); ?>"></script>
    <script src="<?php echo base_url("public/member/phase2/scripts/ui_control.js"); ?>"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <title><?php  echo (isset($page_title)) ? $page_title : '我的卡券';?></title>
    <script>
        wx.config({
            debug: false,
            appId: '<?php if (isset($signpackage["appId"])) echo $signpackage["appId"];?>',
            timestamp: '<?php if (isset($signpackage["timestamp"])) echo $signpackage["timestamp"];?>',
            nonceStr: '<?php if (isset($signpackage["nonceStr"])) echo $signpackage["nonceStr"];?>',
            signature: '<?php if (isset($signpackage["signature"])) echo $signpackage["signature"];?>',
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
<!--tab-->
<div class="display_flex head_title bg_fff">
    <div id="usableTitle" class="active">可使用</div>
    <div id="unusedTitle">已使用</div>
    <div id="expiredTitle">已过期</div>
</div>
<!--tab end-->
<!--card list-->
<div class="coupon_list" id="usable">
    <?php if(!empty($usableCardLists)){ foreach ($usableCardLists as $v) { ?>
    <?php if(!isset($v['is_pms_card'])){ ?>
    <a href="<?php echo base_url("index.php/membervip/card/cardinfo?member_card_id=".$v['member_card_id'].'&id='.$inter_id)?>">
        <?php }else{ ?>
        <a href="<?php echo base_url("index.php/membervip/card/pcardinfo?member_card_id=".$v['member_card_id'].'&id='.$inter_id)?>">
            <?php } ?>
        <div class="
            <?php
        $color = ''; //字体颜色类
        if (!isset($v['is_pms_card'])) {
            if (isset($v['card_type'])) {
                switch ($v['card_type']) {
                    case 1:
                        // 抵用券样式
                        echo 'coupon_1';
                        $color = 'c_266695';
                        break;
                    case 2:
                        // 折扣券样式
                        echo 'coupon_2';
                        $color = 'c_c67215';
                        break;
                    case 3:
                        // 兑换券样式
                        echo 'coupon_4';
                        $color = 'c_583c69';
                        break;
                    case 4:
                        // 储值卡样式
                        echo 'coupon_5';
                        $color = 'c_196f3b';
                        break;
                    default:
                        //错误卡卷样式
                }
            }
        } else {
            // 官方卡卷样式
            echo '';
        } ?> coupon_mk c_fff">
            <div class="f_r hotel_price">
                <!--卡卷金额 -->
                <font class="<?php echo $color;?> f_38">
                    <?php
                    if (isset($v['card_type'])) {
                        switch ($v['card_type']) {
                            case 1:
                                // 抵用券样式
                                echo $v['reduce_cost'] . '</font>' . '元';
                                break;
                            case 2:
                                // 折扣券样式
                                echo $v['discount'] . '</font>' . '折';
                                break;
                            case 3:
                                // 兑换券样式
//                                echo $v['exchange'];
                                echo '</font>';
                                break;
                            case 4:
                                // 储值卡样式
                                echo $v['money'] . '</font>' . '元';
                                break;
                            default:
                                //错误卡卷样式
                        }
                    }
                    ?>
            </div>
            <div class="hotel_name">
                <?php if (isset($v['logo_url'])) { ?>
                    <img class="coupon_img" src="<?php echo $v['logo_url']; ?>"/>
                <?php } ?>
                <?php echo isset($v['brand_name']) ? $v['brand_name'] : ''; ?>
            </div>
            <div class="hotel_txt">
                <p><?php echo isset($v['title']) ? $v['title'] : ''; ?></p>
                <p class="h24 c_505f6f"><?php echo isset($v['sub_title']) ? $v['sub_title'] : ''; ?></p>
            </div>
            <?php if (isset($v['can_give_friend']) && $v['can_give_friend'] == 't') { ?>
<!--                <span class="give_btn give_btn_bg1" href="javascript:void(0);">转赠</span>-->
            <?php } ?>
            <div class="coupon_time">
                <font class="f_r">
                    <?php
//                    if (isset($v['can_give_friend'])) {
//                        if ($v['can_give_friend'] == 't') {
//                            echo '可转赠';
//                        } else {
//                            echo '不可转赠';
//                        }
//                    }
                    ?>
                </font>
                <?php echo isset($v['expire_time']) ? '有效期 ' . date('Y.m.d', $v['use_time_start']) . ' - ' . date('Y.m.d', $v['expire_time']) : ''; ?>
            </div>
        </div>
            </a>
    <?php } } else { ?>
    <div class="center color_888 h24" style="padding:30px;">没有可使用的卡券</div>
    <?php } ?>
</div>
<div class="coupon_list" id="unused" style="display: none;">
    <?php if(!empty($unusedCardLists)){ foreach ($unusedCardLists as $v) { ?>
        <div class="coupon_3 coupon_mk c_fff">
            <div class="f_r hotel_price">
                <font class="f_38"> <?php
                    if (isset($v['card_type'])) {
                        switch ($v['card_type']) {
                            case 1:
                                // 抵用券样式
                                echo $v['reduce_cost'] . '</font>' . '元';
                                break;
                            case 2:
                                // 折扣券样式
                                echo $v['discount'] . '</font>' . '折';
                                break;
                            case 3:
                                // 兑换券样式
//                                echo $v['exchange'];
                                echo '</font>';
                                break;
                            case 4:
                                // 储值卡样式
                                echo $v['money'] . '</font>' . '元';
                                break;
                            default:
                                //错误卡卷样式
                        }
                    }
                    ?>
            </div>
            <div class="hotel_name">
                <?php if (isset($v['logo_url'])) { ?>
                    <img class="coupon_img" src="<?php echo $v['logo_url']; ?>"/>
                <?php } ?>
                <?php echo isset($v['brand_name']) ? $v['brand_name'] : ''; ?>
            </div>
            <div class="hotel_txt">
                <p><?php echo isset($v['title']) ? $v['title'] : ''; ?></p>
                <p class="h24 c_505f6f"><?php echo isset($v['sub_title']) ? $v['sub_title'] : ''; ?></p>
            </div>
            <div class="coupon_time">
                <?php echo isset($v['expire_time']) ? '有效期 ' . date('Y.m.d', $v['use_time_start']) . ' - ' . date('Y.m.d', $v['expire_time']) : ''; ?>
            </div>
            <img class="pay_ico" src="<?php echo base_url("public/member/phase2/images/pay_ico1.png"); ?>"/>
        </div>
    <?php }  } else { ?>
    <div class="center color_888 h24" style="padding:30px;">没有已使用的卡券</div>
    <?php } ?>
</div>
<div class="coupon_list" id="expired" style="display: none;">
    <?php if(!empty($expiredCardLists)){ foreach ($expiredCardLists as $v) { ?>
        <div class="coupon_3 coupon_mk c_fff">
            <div class="f_r hotel_price">
                <font class="f_38"> <?php
                    if (isset($v['card_type'])) {
                        switch ($v['card_type']) {
                            case 1:
                                // 抵用券样式
                                echo $v['reduce_cost'] . '</font>' . '元';
                                break;
                            case 2:
                                // 折扣券样式
                                echo $v['discount'] . '</font>' . '折';
                                break;
                            case 3:
                                // 兑换券样式
//                                echo $v['exchange'];
                                echo '</font>';
                                break;
                            case 4:
                                // 储值卡样式
                                echo $v['money'] . '</font>' . '元';
                                break;
                            default:
                                //错误卡卷样式
                        }
                    }
                    ?>
            </div>
            <div class="hotel_name">
                <?php if (isset($v['logo_url'])) { ?>
                    <img class="coupon_img" src="<?php echo $v['logo_url']; ?>"/>
                <?php } ?>
                <?php echo isset($v['brand_name']) ? $v['brand_name'] : ''; ?>
            </div>
            <div class="hotel_txt">
                <p><?php echo isset($v['title']) ? $v['title'] : ''; ?></p>
                <p class="h24 c_505f6f"><?php echo isset($v['sub_title']) ? $v['sub_title'] : ''; ?></p>
            </div>
            <div class="coupon_time">
                <?php echo isset($v['expire_time']) ? '有效期 ' . date('Y.m.d', $v['use_time_start']) . ' - ' . date('Y.m.d', $v['expire_time']) : ''; ?>
            </div>
            <img class="pay_ico" src="<?php echo base_url("public/member/phase2/images/pay_ico3.png"); ?>"/>
        </div>
    <?php }  } else { ?>
    <div class="center color_888 h24" style="padding:30px;">没有已过期的卡券</div>
    <?php } ?>
</div>
<!--card list end-->
<div class="coupon_list" style="display: none;">
    <div class="coupon_1 coupon_mk c_fff">
        <div class="f_r hotel_price"><font class="c_266695 f_38">200</font>元</div>
        <div class="hotel_name">
            <img class="coupon_img" src="<?php echo base_url("public/member/phase2/images/name.png"); ?>"/>金房卡大酒店
        </div>
        <div class="hotel_txt">
            <p>高级大床房抵价券</p>
            <p class="h24 c_505f6f">指定酒店可用</p>
        </div>
        <a class="give_btn give_btn_bg1" href="">转赠</a>
        <div class="coupon_time">
            <font class="f_r">可赠好友</font>
            有效期 2016.01.01-2016.12.31
        </div>
    </div>
    <div class="coupon_2 coupon_mk c_fff">
        <div class="f_r hotel_price"><font class="c_c67215 f_38">200</font>元</div>
        <div class="hotel_name">
            <img class="coupon_img" src="<?php echo base_url("public/member/phase2/images/name.png"); ?>"/>金房卡大酒店
        </div>
        <div class="hotel_txt">
            <p>高级大床房抵价券</p>
            <p class="h24 c_505f6f">指定酒店可用</p>
        </div>
        <a class="give_btn give_btn_bg1" href="">转赠</a>
        <div class="coupon_time">
            <font class="f_r">可赠好友</font>
            有效期 2016.01.01-2016.12.31
        </div>
    </div>
    <div class="coupon_3 coupon_mk c_fff">
        <div class="f_r hotel_price"><font class="f_38">200</font>元</div>
        <div class="hotel_name">
            <img class="coupon_img" src="<?php echo base_url("public/member/phase2/images/name.png"); ?>"/>金房卡大酒店
        </div>
        <div class="hotel_txt">
            <p>高级大床房抵价券</p>
            <p class="h24 ">指定酒店可用</p>
        </div>
        <a class="give_btn give_btn_bg2" href="javascript:;">转赠</a>
        <div class="coupon_time">
            <font class="f_r">可赠好友</font>
            有效期 2016.01.01-2016.12.31
        </div>
        <img class="pay_ico" src="<?php echo base_url("public/member/phase2/images/pay_ico1.png"); ?>"/>
    </div>
    <div class="coupon_3 coupon_mk c_fff">
        <div class="f_r hotel_price"><font class="f_38">200</font>元</div>
        <div class="hotel_name">
            <img class="coupon_img" src="<?php echo base_url("public/member/phase2/images/name.png"); ?>"/>金房卡大酒店
        </div>
        <div class="hotel_txt">
            <p>高级大床房抵价券</p>
            <p class="h24 ">指定酒店可用</p>
        </div>
        <a class="give_btn give_btn_bg2" href="javascript:;">转赠</a>
        <div class="coupon_time">
            <font class="f_r">可赠好友</font>
            有效期 2016.01.01-2016.12.31
        </div>
        <img class="pay_ico" src="<?php echo base_url("public/member/phase2/images/pay_ico2.png"); ?>"/>
    </div>
    <div class="coupon_3 coupon_mk c_fff">
        <div class="f_r hotel_price"><font class="f_38">200</font>元</div>
        <div class="hotel_name">
            <img class="coupon_img" src="<?php echo base_url("public/member/phase2/images/name.png"); ?>"/>金房卡大酒店
        </div>
        <div class="hotel_txt">
            <p>高级大床房抵价券</p>
            <p class="h24 ">指定酒店可用</p>
        </div>
        <a class="give_btn give_btn_bg2" href="javascript:;">转赠</a>
        <div class="coupon_time">
            <font class="f_r">可赠好友</font>
            有效期 2016.01.01-2016.12.31
        </div>
        <img class="pay_ico" src="<?php echo base_url("public/member/phase2/images/pay_ico3.png"); ?>"/>
    </div>
</div>
<script>
    $(function () {
        // 点击tab切换可使用
        $('#usableTitle').on('click', function () {

            $('#usable').show();
            $('#unused').hide();
            $('#expired').hide();
            $('#unusedTitle').attr('class', '');
            $('#expiredTitle').attr('class', '');
            $(this).attr('class', 'active');
        });
        // 点击tab切换不可使用
        $('#unusedTitle').on('click', function () {

            $('#unused').show();
            $('#usable').hide();
            $('#expired').hide();
            $('#usableTitle').attr('class', '');
            $('#expiredTitle').attr('class', '');
            $(this).attr('class', 'active');
        });
        // 点击tab切换过期
        $('#expiredTitle').on('click', function () {
            $('#expired').show();
            $('#usable').hide();
            $('#unused').hide();
            $('#usableTitle').attr('class', '');
            $('#unusedTitle').attr('class', '');
            $(this).attr('class', 'active');
        });

    })
</script>
<!--
<?php if ($cardlist) { ?>
<?php foreach ($cardlist as $card) { ?>
		<?php if (!isset($card['is_pms_card'])) { ?>
			<a href="<?php echo base_url("index.php/membervip/card/cardinfo?member_card_id=" . $card['member_card_id'] . '&id=' . $inter_id) ?>">
		<?php } else { ?>
			<a href="<?php echo base_url("index.php/membervip/card/pcardinfo?member_card_id=" . $card['member_card_id'] . '&id=' . $inter_id) ?>">
		<?php } ?>
			<?php if (($card['use_time_start'] + 7200) >= time()) { ?>
			   <div class="sign bgc_73e">新到</div>
			<?php } ?>
			<?php if (isset($card['expire_time']) && ($card['expire_time'] + 43200) <= time()) { ?>
				<div class="sign bgc_f64">快过期</div>
			<?php } ?>
			<div class="b_rig">
				<div class="l_h_1 r_title"><?php echo $card['title']; ?></div>
				<div class="arrow"></div>
				<div><?php echo $card['brand_name']; ?></div>
			</div>
			<div class="logo_txt color_ff7">
				<?php if (!isset($card['is_pms_card'])) { ?>
					<?php if ($card['card_type'] == 1) { ?>
						抵用券
					<?php } elseif ($card['card_type'] == 2) { ?>
						折扣券
					<?php } elseif ($card['card_type'] == 3) { ?>
						兑换券
					<?php } elseif ($card['card_type'] == 4) { ?>
						储值卡
					<?php } else { ?>
						错误卡券
					<?php } ?>
				<?php } else { ?>
					官方券
				<?php } ?>
			</div>
			<div class="price color_ff7">
				
					<?php if ($card['card_type'] == 1) { ?>
						¥<font><?php echo $card['reduce_cost']; ?></font>
					<?php } elseif ($card['card_type'] == 2) { ?>
						<font><?php echo $card['discount']; ?></font> 折
					<?php } elseif ($card['card_type'] == 3) { ?>
						
					<?php } elseif ($card['card_type'] == 4) { ?>
						¥<font><?php echo $card['money']; ?></font>
					<?php } elseif ($card['card_type'] == 5) { ?>
						<font>1</font> 张
					<?php } else { ?>
						物品抵扣券
					<?php } ?>
				
			</div>
			<div class="ra_inline"></div>
		</a>
		<div class="f_date" >
			<?php if (!isset($card['is_pms_card'])) { ?>
				<?php if ($card['can_give_friend'] == 't') { ?>
					<a href="<?php echo base_url("index.php/membervip/card/givecard?member_card_id=" . $card['member_card_id'] . '&id=' . $inter_id) ?>" class="weui_btn weui_btn_mini weui_btn_primary" style="float:left;">赠送好友</a>
				<?php } ?>
				<?php echo date('Y.m.d', $card['use_time_start']); ?>
				<?php if (isset($card['expire_time']) && !empty($card['expire_time'])) { ?>
					-
					<?php echo date('Y.m.d', $card['expire_time']); ?>
					<?php if (($card['expire_time'] + 43200) < time()) { ?>
						<font class="color_f64">（仅剩1天）</font>
						<?php } ?>
				<?php } ?>
			<?php } else { ?>
				<?php echo date('Y.m.d', $card['use_time_start']); ?>
				<?php if (isset($card['expire_time']) && !empty($card['expire_time'])) { ?>
				-
				<?php echo date('Y.m.d', $card['expire_time']); ?>
				<?php if (($card['expire_time'] + 43200) < time()) { ?>
					<font class="color_f64">（仅剩1天）</font>
				<?php } ?>
			<?php } ?>
			<?php } ?>
			<?php if (isset($card['pms_card_sno_show']) && $card['pms_card_sno_show'] == true) { ?>
			<br/>
			<?php echo $card['pms_card_sno']; ?>
			<?php } ?>
		</div>
	</div>
</div>
<?php } ?>
<?php } else { ?>暂无卡券
<?php } ?>
-->
</body>
</html>
