<?php
    // 是否显示¥符号
    $show_y_flag = true;
    if($record_detail['type'] == MY_Model_Soma::PRODUCT_TYPE_POINT)
    {
        $show_y_flag = false;
    }
?>
<body>
<div class="pageloading"><p class="isload"><?php echo $lang->line('loading'); ?></p></div>
<!-- 以上为header.php -->

<div class="pad10 center h22"><em class="iconfont">&#Xe627;</em><?php echo $lang->line('view_order_snapshot'); ?></div>
<ul class="bd list_style_1">
    <li class="input_item webkitbox justify">
        <span class="color_888"><?php echo $lang->line('order_number'); ?></span>
        <span><?php echo $record_detail['order_id'];?></span>
        <span><?php echo $record_detail['order_time'];?></span>
    </li>
</ul>

<div class="order_list bd martop">
    <div class="item bg_fff">
        <div class="item_left">
            <a href="<?php echo Soma_const_url::inst()->get_url('*/package/package_detail', 
array( 'id'=>$inter_id, 'pid'=> $record_detail['product_id'] ) )?>">
                <div class="img"><img src="<?php echo $record_detail['face_img'];?>" /></div>
                <p class="txtclip h30"><?php echo $record_detail['name'];?></p>
                <p class="txtclip color_888"><?php echo $record_detail['hotel_name'];?></p>
                <p class="txtclip color_main"><?php if($show_y_flag): ?><span class="y"><?php else: ?><span><?php endif; ?><?php echo $record_detail['price_package'];?>x<?php echo $record_detail['qty'];?></span></p>
            </a>
        </div>
    </div>
</div>
<div class="whiteblock bd support_list">

    <?php if($record_detail['can_refund'] == Soma_base::STATUS_TRUE && $refund){ ?>
        <span tips="<?php echo $lang->line('after_buy_apply_refund'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('wechat_refund'); ?></tt></span>
    <?php } ?>

    <?php if($record_detail['can_gift'] == Soma_base::STATUS_TRUE){ ?>
        <span tips="<?php echo $lang->line('after_buy_donated'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('gift_a_friend'); ?></tt></span>
    <?php } ?>

    <?php if($record_detail['can_mail'] == Soma_base::STATUS_TRUE){ ?>
        <span tips="<?php echo $lang->line('goods_can_mail'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('deliver_to_home'); ?></tt></span>
    <?php } ?>

    <?php if($record_detail['can_pickup'] == Soma_base::STATUS_TRUE){ ?>
        <span tips="<?php echo $lang->line('goods_support_shop_or_self'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('collect_from_hotel'); ?></tt></span>
    <?php } ?>
    <?php if($record_detail['can_invoice'] == Soma_base::STATUS_TRUE){ ?>
        <span tips="<?php echo $lang->line('purchase_can_invoice'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('invoice'); ?></tt></span>
    <?php } ?>
    <?php if($record_detail['can_split_use'] == Soma_base::STATUS_TRUE){ ?>
        <span tips="<?php echo $lang->line('can_be_used_splitting'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('multi_usage'); ?></tt></span>
    <?php } ?>
</div>

<div class="whiteblock bd">
	<span><em class="iconfont color_main">&#xe60F;</em> <tt> <?php echo $lang->line('cut_off_time'); ?><?php echo isset($record_detail['expiration_date']) && !empty($record_detail['expiration_date']) ? $record_detail['expiration_date']:'';?></tt></span>
</div>

<?php if(isset($record_detail['order_notice'])  && !empty($record_detail['order_notice']) ){?>
<div class="bg_fff block martop h24">
	<p class="bd_bottom">
    	<span class="color_555"><?php echo $lang->line('notice'); ?></span>
    	<span class="h22"></span>
    </p>
    <p  class="color_999 f_s_12">
        <?php echo $record_detail['order_notice']; ?>
    </p>
</div>
<?php } ?>
<div class="bg_fff bd martop block h24 color_555" id="showdetail">
	<p class="bd_bottom"><?php echo $lang->line('details'); ?></p>
    <div class="h24 fillcontent"><?php echo $record_detail['img_detail'];?></div>
</div>

</body>

</html>
