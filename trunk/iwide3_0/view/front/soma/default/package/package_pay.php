<?php
    // 是否显示¥符号
    $show_y_flag = true;
    if($package['type'] == $packageModel::PRODUCT_TYPE_POINT)
    {
        $show_y_flag = false;
    }
?>
<style>
    .jfk-input__radio {line-height: 1;}
    .jfk-input__radio input[type="radio"] ~ .uncheck {display:inline-block;border: solid 1px #555; border-radius: 50%; width: 16px; height: 16px;margin-right: 2px;vertical-align: middle;}
    .jfk-input__radio input[type="radio"] ~ .checked{display: none;}
    .jfk-input__radio input[type="radio"]:checked ~ .checked{display: inline-block;}
    .jfk-input__radio input[type="radio"]:checked ~ .uncheck {display: none;}
    .jfk-input__radio em + span{display:inline-block;vertical-align: middle;padding-left: 4px;}
    .jfk-input__radio + .jfk-input__radio {margin-left: 3%;}
    .mail_list {background: #fff;padding: 8px;margin-bottom: 8px;}
    .mail_list .mail_list_type{text-align: left;}
    .mail_list .webkitbox:first-child{padding-top: 0;}
    .mail_list .mail_type{padding-bottom: 8px;}
    .mail_list .mail_addr{padding-top: 8px;}
    .mail_list .mail_addr_area{padding-top: 8px;}
    .mail_list .gift_process{display: none;}
    .mail_list .process_list{display:-webkit-box;display:flex;width: 96%;margin: 11px auto;}
    .mail_list .process_item{-webkit-box-flex: 1;flex-grow: 1;text-align: center;color: #888;font-size: 12px;position: relative;}
    .mail_list .process_item:not(:last-child) .process_cont{padding-right: 35%;}
    .mail_list .process_item:not(:last-child) .process_cont:before{content: '';position: absolute;width: 25%;height: 1px;-webkit-transform: scale(1, 0.5);transform: scale(1, 0.5);background-color: #c3c3c3; right: 5%; top: 50%;}
    .mail_list .process_item:not(:last-child) .process_cont:after{content: '';position: absolute; width: 10px; height: 10px; border: solid 1px #c3c3c3;border-left: 0 none; border-top: 0 none;-webkit-transform: scale(0.5) rotate(-45deg);transform: scale(0.5) rotate(-45deg);right: 4%;top: 50%;margin-top: -5px;}
    .mail_list .process_item .icon{display: inline-block; width: 18px; height: 18px;}
    .mail_list .process_item .icon img{display: block;width: 100%;height: 100%;}
    .mail_list .mail_addr_cont .icon{display: inline-block;width: 18px;}
    .mail_list .mail_addr_cont .info{padding-left: 10px;padding-right: 10px;}
    .mail_list .mail_addr_cont .info p{line-height: 1.5}
    .mail_list .mail_addr_cont .info .phone{float: right;}
    .mail_list .mail_tip{width: 80px;display: inline-block;}
    .mail_list .mail_gift_tip{color: #999; vertical-align: middle;margin-left: 2%;font-size: 13px;display: none;}
    .mail_list .mail_type_gift:checked ~ .mail_gift_tip{display: inline-block;}
    .mail_list .mail_gift_tip em{display: inline-block; width: 14px; height: 14px; border: solid 1px #999; border-radius: 50%; line-height: 14px;font-size: 12px; text-align: center; vertical-align: 1px; margin-right: 2px;}
    .mail_addr_control .mail_addr_icon, .mail_addr .mail_addr_icon{width: 16px; height: 16px; display:inline-block;border-radius: 50%; text-align: center; line-height: 14px;margin-right:12px;vertical-align: 2px}
    .mail_add {display: block;}
    .mail_add_list{display: none;-webkit-box-sizing: border-box;box-sizing: border-box;height: 100%;padding-bottom: 32px;position: relative;}
    .mail_add_list_content{height: 100%;overflow-y: auto;overflow-x: hidden;}
    .mail_add_list_content .mail_add_list_item:first-child{margin-top: 0;}
    .mail_add_list_item{padding-right: 50px;position: relative;}
    .mail_add_list_item p + p{padding-top: 8px;}
    .mail_add_list_control{position: absolute;top: 15px;bottom: 15px;width: 45px;text-align: center; right: 0; border-left: solid 1px #e4e4e4;font-size: 12px;display: -webkit-box;display: -webkit-flex;display: flex;-webkit-box-align: center;-webkit-align-items: center;align-items: center;-webkit-align-content: center;align-content: center;    -webkit-box-pack: center;-webkit-justify-content: center;justify-content: center}
    .mail_add_list_control .modify{padding: 7px;}
    .mail_add_list_item .phone{float: right;}
    .jfk-dialog__address {position: fixed;top: 0;right: 0;width: 100%; height: 100%;z-index: 1000;display: none; overflow: auto}
    .jfk-dialog__address .jfk-dialog__box{height: 100%;}
    .jfk-dialog__address .mail_addr_control{position: absolute; bottom: 0; width: 100%; z-index: 1; background: #fff;text-align: center; padding: 8px 0;}
    .jfk-dialog__address .mail_addr_control i{font-style: normal;}
    .jfk-dialog__address .mail_addr_control .btn_main{padding: 7px 40px;}
    .jfk-dialog__address .mail_add_form .input_item{
        box-sizing: border-box;
        padding-left: 85px;
        display: block;
    }
    .jfk-dialog__address .mail_add_form .input_item .label{position: absolute;top: 9px;left: 10px;}
    .jfk-dialog__address .mail_add_form .input_item .cont{width: 100%;display: block;}
    .jfk-dialog__address .mail_add_form .input_item:after{left: 10px;}
    .jfk-dialog__address .mail_add_form .input_item_area{
        width: 100%;
    }
    .jfk-dialog__address .mail_add_form .input_item_area .area_placeholder {display: block;width: 100%;overflow: hidden;text-overflow: ellipsis; word-break: break-all; word-wrap:nowrap;}
    .jfk-dialog__address .bd_left:before{width:1px;height: 100%;top: 0;bottom: 0;-webkit-transform: scale(.5, 1);transform: scale(.5,1);}
    .jfk-dialog__address .pull_loading{background-color: #fff;}
    @media only screen and (max-width: 320px) {
        .mail_list .mail_tip{width: 65px;}
        .jfk-input__radio + .jfk-input__radio{margin-left: 0;}
        .mail_list .mail_gift_tip{font-size: 12px;}
        .mail_list .mail_gift_tip em{width: 13px;height: 13px;line-height: 13px;vertical-align: 0;}
    }
</style>
<body>
<div class="pageloading"><p class="isload"><?php echo $lang->line('loading');?></p></div>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $wx_config["appId"]?>',
        timestamp: <?php echo $wx_config["timestamp"]?>,
        nonceStr: '<?php echo $wx_config["nonceStr"]?>',
        signature: '<?php echo $wx_config["signature"]?>',
        jsApiList: [<?php echo $js_api_list; ?>]
    });
    wx.ready(function(){
        <?php if( $js_menu_hide ): ?>wx.hideMenuItems({ menuList: [<?php echo $js_menu_hide; ?>] });<?php endif; ?>

        <?php if( $js_menu_show ): ?>wx.showMenuItems({ menuList: [<?php echo $js_menu_show; ?>] });<?php endif; ?>

        <?php if( $js_share_config ): ?>
        wx.onMenuShareTimeline({
            title: '<?php echo $js_share_config["title"]?>',
            link: '<?php echo $js_share_config["link"]?>',
            imgUrl: '<?php echo $js_share_config["imgUrl"]?>',
            success: function () {},
            cancel: function () {}
        });
        wx.onMenuShareAppMessage({
            title: '<?php echo $js_share_config["title"]?>',
            desc: '<?php echo $js_share_config["desc"]?>',
            link: '<?php echo $js_share_config["link"]?>',
            imgUrl: '<?php echo $js_share_config["imgUrl"]?>',
            //type: '', //music|video|link(default)
            //dataUrl: '', //use in music|video
            success: function () {},
            cancel: function () {}
        });
        <?php endif; ?>
    });
</script>

<?php $gift = false; ?>

<?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
<!--<form action="" method="post">-->
<div class="mail_list">
    <div class="justify webkitbox bd_bottom mail_type"  <?php if($package['can_mail'] == $packageModel::CAN_T && $package['can_gift'] == $packageModel::CAN_T){}else{ echo 'style="display:none;"'; }?>>
        <span class="mail_tip">使用方式</span>
        <div class="mail_list_type">
		<?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
            <label class="jfk-input__radio"><input type="radio" class="jfk-input__radio-mail" name="mail" checked value="1"><em class="uncheck"></em><em class="checked iconfont color_main">&#xe61e;</em><span>直接邮寄</span></label>
		<?php } ?>
		<?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
			<label class="jfk-input__radio">
                <?php if(isset($_REQUEST['gift']) && $_REQUEST['gift'] == 1): ?>
                  <?php $gift = true; ?>
                <?php endif; ?>
                <input type="radio" <?= $gift ? 'checked' : '' ?> class="jfk-input__radio-mail mail_type_gift" name="mail" value="2"/>
                <em class="uncheck"></em><em class="checked iconfont color_main">&#xe61e;</em><span>赠送他人</span><span class="mail_gift_tip"><em>!</em>如何赠送</span></label>
        <?php } ?>
		</div>
    </div>
    <div class="gift_process" style="display:<?= ($gift || ($package['can_gift'] == $packageModel::CAN_T && $package['can_mail'] != $packageModel::CAN_T) ) ? 'block': 'none';?>">
       <ul class="process_list">
           <li class="process_item">
               <div class="process_cont">
                   <span class="icon"><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAQAAABLCVATAAACmUlEQVRIx7WWT08TYRDGJ5ACQvyX0OLBGKkXLyLRhB4MN/gO1oMxaSlQLlyoX8DD7+LRGIKaGCs08TN4MUIIoZAYY5suUTwRk+qBRprWpOOhS313u7ssJL5z2tknz+68M/PMiPgcRpkjT5EqDRpUKZJnjlEJf+glyTot1MNarJOkNwzNFCUUpUaBWRLE6KefGAlmKVBDUUpMBZMMsIyiWKQZ8kQMkcZCUZYZ8KOJsoVS5zF9gZ/rI0cdZYuoN00ZZY/xUPc4joVS7qJikE2UIiOhUzJCEWWTQad7BcXy/FV/qigWyoozU8oRt+WUhzGO0E4G6eELSk5EhBJKnfnQVDmUkl1XJFH2iIiIsMgLlPehiSJYKMn2w0eUtPGyQi1U7bbRKZT1dk+1ODTLjxWUOyJMsuxrT7nRKdFDWsSFeZSC4xsPURZEyPLLx5oonzv4Asq8kEeZcRBdR3kTGM4FDtDO0wxKXthFSbiA3/l2ws18MogSKDtCFWXYBcujXAkkKhlEwyg/hQbqblIyKK/xP3la1IwmVhreRDc9Rc20Pyy6iTxCE+EH+8QD7LKBtUPzuGwR3tFikrs+FnNgEyi7wlt3+kVEWAgMbN+BtdPfVZAiIvTziIyvTTqwdkHG3S1ySikZtFvEbtpUF+ASz1ly+S7yjCf0eDatLSNWW0YMQBZFuebw3UdR7jlkpPJPRnopHQubAbnFAR+c9FzlK0XOG54lQ9g6Ujt2Bqn9jTJtul6dWfxf/p9x1BmQVrgAGfMZkCIixNhGqZNzZ7BL8Nsje9vZKibknL1EVEh3/fIxIkXlhCXChk5TtteaNTJMECVChCgTZFiz15qyI1OBi9aGz6KlbPAg/LBqj6ksq+xQpUmTKjuskvVf/f4C+zZi6HbCZZ8AAAAASUVORK5CYII='/></span>
                   <p>购买商品</p>
               </div>
           </li>
           <li class="process_item">
               <div class="process_cont">
                   <span class="icon"><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAQAAABLCVATAAACdUlEQVRIx7WWT0sbQRjGx0rUKt5MFNqLHltIPRmR4kk/QOkpvRrjHwq2h6Zf4Uf7CUTaU6qhX0Eo9E9EgolQaBNcT55TK0oNEcnTg+s2m93RVejMad559pmd988zrzGWwSiL5ClTp0mTOmXyLDJqog+6SVOkhUJmiyJpuqPQzFBFiBMKLJAiQS+9JEixQIEThKgyczVJH6sI4ZBhIBQxQAYHIVbps9HEKSEavKbnyuN6yNFAlIiH09QQ+4xH8uM4DqIWoKKfbUSZ4cghGaaM2Kbfb15DOKG/aqeK4yDW/JESpzwyNxwkOUVeBLnDT0TOB/lEmfuBD+9R5IvPkkNU3bwijdgn5gN8Rxzw0Gd7wAHih88Ww0GkLxbfEJmOs0eoIA6Z9iyPOUTsMtKBnEMUL2qqxXEw/RhkE9HgqTHG8IQGYpPBkBQ9psWYYQlRsCReHnHOc5Y5R+TDE5UCYsmQR8xbotLFG69c39JlQc0j8oZdRCqwOUXWnSWEKHnrqQA2hagY6oihwObvUBER4iiAHUL8MjRR8O6s8NGbQm2rlRBfiqaFyAcUukYNRNNytRsRuVcLd/ak59wsQm2ryVBn7xo+hIWfoxs42w1/aELywursl7aEHAsvkag+ot8tEbdo525NdFm0row4fhmJSkSMvX8y0k21U9h84M98te69ahM2T2qTt5DaP4jZdtP7W4v/u//zHHkPpBPtgiQtD6QxxpBgB9EgZ4+gG6mLJ3uHhA1y120i9sgEfvkSMcfeNU2EC52l5rY1G2SZIE6MGHEmyLLhtjU1X6SubLS2LI2W2OJZpEarrfVbZp0Kdc44o06FdZbtrd9frgxCVVLpmAcAAAAASUVORK5CYII='/></span>
                   <p>完成支付</p>
               </div>
           </li>
           <li class="process_item">
                <div class="process_cont">
                   <span class="icon"><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAQAAABLCVATAAACRUlEQVRIx7WWz04aURSHb2pQga3gWnduKN3IC+gjmEiXin+3tvQVvlcw2q6o8h5VY4zoTojj0iVNjEQJJvLrgiuFmXtHaNK5q5lz5pt755zzO8cYz8Uc21So0aRDhyY1KmwzZ0a/mKDIKV3kWF1OKTIxCmaJOkK0qLJFgSxTTJGlwBZVWghRZykeMs0+QgSUSDs90pQIEGKfaR8mwwWizTcmYz83SZk24oKMG9NA3JEf6T/mCRCNCIoU54gasyOHZJYa4pzU8OMDRODcqh+VIUAcDEdKPPPR88IKKx5LjmfUjyAfuEGUPc57CLHnsZYRdZtXFBF3JLyYV7o+FAkCRLF3c4IoOd2+IF5tRvtQ64jTXk11eXSln8WsIcSaD0WaR7rMG3YQVYfDQg9jDELGWNSCw7OK2DFUEBsOc5JDVo15AxnDKockHZ4biIrhGlGIzRcL8toLiCtDEzETMeV9ID6FP8sM4rehg8JFyhP3XtA9rUgRi44bJB68oIfwQd9ArqONB7JHc/zsEOgXJ7GgAuLa8DMa/mFQyBYF2fA7EnJMkE3I+WiJjAMiZUvEFu16OAXjlrNorYwEgzLyDuhxSEZu/8rIBHW/sL0jt18HhK0vtbmxMTmeEMuDj378s/h//z/tqN8gg9EOSM7TII0xhiyXiDZldyMYiFSvZV+S9bkk7RBxSymy5TePdW7fGSKs6zINO9Ycs8kiGRIkyLDIJsd2rGkMRSp20DrzDFrijM8jDVoDo98uR1zR5IUXmlxxxK5/9PsDxYc2S+IuTo8AAAAASUVORK5CYII='/></span>
                   <p>转发好友</p>
               </div>
           </li>
           <li class="process_item">
               <div class="process_cont">
                   <span class="icon"><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAQAAABLCVATAAACh0lEQVRIx7WWv2tTURTHbxteUtNJbVIFEVrUMRbRZnRpJze3iFvSH6k6GnUQB5cPVEcLJf5YYhvwH3BTwYRSmhQcTMgrIjgJ6dJiQmJ5xyG3adL3o68F71veve/ez7v3nnO+5yjl0hhjnhwl6rRoUadEjnnGlP9GgAQFLMThsSiQIOAHM0UFQdglzxxxooQIESXOHHl2EYQKU96QIZYRBJMUw44zhklhIgjLDLlhIqwjNHlE0PN3QTI0EdaJOGOqCFtM+LrHCUyEqg1FmDWEEqO+TTJKCWGNcP9wFsF03Ko7KoKJkO23lNDgqjpmI0YD6VqQQb4jZI4BSPNKv2UQKtqvSCBsYfiEhHiHxVPdMzAREp3OV4SUT8w5iljc7xlJIhQ6MWWx4+x+Nsw1fiE8PuSiO1iMK9IIeV+Y2zQQlmzjeYS0Iocw4wPzgD2EL/a7ZAYhp9hEiB+JeY4g/Oa8w7c4QllRRxjp+3CDe339AV5oEbnl+JMRhG1FC+kNUp7QRsgeHIGXGvPaNYiFlh2U1ss+c6brcp1jnfYG2Y/2TC+tcZmb7OneXdf700dzuGyW9OJtfui3Twy4guIIm4r3dvMzSO6QUl/3sKg2v6NDEuRjD+iDp2tohxx3DhEtdYLwlysemLAOER20SYcpZ/nWkXnP/ewHrZYR00lGuMBPWlz0wBjUDmQkQMVN2LjEoud+HvYIW1dqYyeQ2j8I071Db08s/m/+TzrqJkjT3wGJuSRIpZQiygZCk4x3IsDQKXuDqNuUU7qIqJGybXl/RpLaEUWEnjpNVZc1q8wySQQDgwiTzLKqy5pqn6U8C62iS6ElFLnjq9DqKf0WWKFMnTZt6pRZYcG99PsHhmIa/3I//wAAAAAASUVORK5CYII='/></span>
                   <p>赠送成功</p>
               </div>
           </li>
       </ul>
    </div>
    <div class="mail_addr_area" style="display:<?= $gift ? 'none': 'block'?>">

    <input type="hidden" name="addressID" value="<?php echo isset($defaultAddress) && !empty($defaultAddress) ? $defaultAddress['address_id'] : 0;?>"/>
	<?php if(isset($defaultAddress) && !empty($defaultAddress) && $package['can_mail'] == $packageModel::CAN_T ){ ?>

    <div class="webkitbox mail_addr_cont color_555 linkblock" data-id="<?php echo $defaultAddress['address_id'];?>">
        <div class="icon">
            <em class="iconfont">&#xe606;</em>
        </div>
        <div class="info">
            <p><span class="name">收货人：<?php echo $defaultAddress['contact'];?></span><span class="phone"><?php echo $defaultAddress['phone'];?></span></p>
            <p>收货地址：<?php echo $defaultAddress['province_name'].$defaultAddress['city_name'].$defaultAddress['region_name'].$defaultAddress['address'];?></p>
        </div>
    </div>
	<?php }elseif($package['can_mail'] == $packageModel::CAN_T ){ ?>
	<div class="linkblock webkitbox mail_addr" id="add_mail_address">
        <span class="bg_main mail_addr_icon">+</span><span>新增收货地址</span>
    </div>
	<?php }?>
    </div>
</div>
<?php } ?>

<?php if($package['can_mail'] != $packageModel::CAN_T){ ?>
<div class="whiteblock bd_bottom support_list" style="margin-top:0">

    <!--
    <?php if($package['can_refund'] == $packageModel::CAN_T && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE){ ?>
        <span tips="购买后，您可以在订单中心直接申请退款，并原路退回"><em class="iconfont color_main">&#xe61e;</em><tt>微信退款</tt></span>
    <?php } ?>
    -->

    <?php if($package['can_refund'] != $packageModel::CAN_REFUND_STATUS_FAIL && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE && $package['type'] != $packageModel::PRODUCT_TYPE_POINT): ?>
        <span tips="<?php echo $lang->line('after_buy_apply_refund'); ?>"><em class="iconfont color_main">&#xe61e;</em>
            <tt>
                <?php if($package['can_refund'] == $packageModel::CAN_REFUND_STATUS_SEVEN): ?>

                    <?php echo $lang->line('7_refund_day'); ?><?php else: ?><?php echo $lang->line('refund_any_time'); ?>

                <?php endif; ?>
            </tt>
        </span>
    <?php endif; ?>


    <?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('after_buy_donated'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('gift_a_friend'); ?></tt></span>
    <?php } ?>

    <?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('goods_can_mail'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('deliver_to_home'); ?></tt></span>
    <?php } ?>
    <?php if($package['can_pickup'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('goods_support_shop_or_self'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('collect_from_hotel'); ?></tt></span>
    <?php } ?>
    <?php if($package['can_invoice'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('purchase_can_invoice'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('invoice'); ?></tt></span>
    <?php } ?>
    <?php if($package['can_split_use'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('can_be_used_splitting'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('multi_usage'); ?></tt></span>
    <?php } ?>
</div>
<?php } ?>

<div class="order_list bd_bottom martop">
    <a href="<?php echo Soma_const_url::inst()->get_package_detail(array('pid'=>$package['product_id'],'id'=>$inter_id));?>" class="item color_555 bg_fff">
        <div class="item_left">
            <div class="img"><img src="<?php echo $package['face_img'];?>" /></div>
            <p class="txtclip"><?php echo $package['name'];?></p>
            <?php if($inter_id != 'a455510007'){ //速8需要隐藏 ?>
                <p class="txtclip"><?php echo $package['hotel_name'];?></p>
            <?php } ?>
            <p class="txtclip h30 color_main">
                <?php
                    if (empty($scope_product_link)) {
                        echo $lang->line('single_purchase_price');
                    } else {
                        echo $lang->line('exclusive_price');
                    }
                ?>:

                <?php if($show_y_flag): ?>
                <span class="y">
                <?php else: ?><span>
                <?php endif; ?>
                <?php echo $package['price_package'];?></span>
            </p>
        </div>
    </a>
</div>

<?php
$buy_limit= $salesOrderModel::STOCK_LIMIT;
if( !isset($buy_default)) $buy_default= 1; //默认买几个？
?>
<!-------------------------------------------------- 立即购买 ------------------------------------>
<ul class="list_style_2 bd martop" id="select_num">
    <li class="arrow justify webkitbox">
        <span>
            <?php echo $lang->line('purchase_quantity'); ?>
            <?php if(isset($psp_setting[0])): ?>
                <tt class="color_888 h24 result">
                <?php echo isset( $psp_setting[0]['spec_name'] ) ? $lang->line('slected').'：'.implode(',', $psp_setting[0]['spec_name']) : '';?>
                </tt>
            <?php endif; ?>
            <?php if(!empty($scope_product_link) && $scope_product_link['limit_num'] > 0): ?>
                <tt class="btn_main btn_small">
                    限购<?php echo $scope_product_link['limit_num'] - $scope_product_link['used_num']; ?>份
                </tt>
            <?php endif; ?>
        </span>
        <span class="color_888" id="buy_num"><?php echo $buy_default ?></span>
    </li>
</ul>
<div class="ui_pull area_pull" style="display:none" onClick="toclose();">
    <div class="relative _w" style="height:100%;">
        <div class="area_box bg_fff absolute _w">
            <div class="webkitbox justify pad10" style="margin-top:0">
                <span><?php echo $lang->line('purchase_quantity'); ?></span>
                <span>
                    <div class="num_control bd webkitbox" style="float:right">
                        <div class="down_num bd_left">-</div>
                        <div class="result_num bd_left"><input id="selece_num" value="<?php echo $buy_default ?>" type="tel" min="1" max="<?php echo $buy_limit; ?>"></div>
                        <div class="up_num bd_lr">+</div>
                    </div>
                </span>
            </div>
            <div class="sure_btn btn_main _w pad10"><?php echo $lang->line('confirm');?></div>
        </div>
    </div>
</div>

<?php if($package['type'] != $packageModel::PRODUCT_TYPE_POINT): ?>
    <ul class="list_style_1 bd martop">
        <li id="choose_coupon" class="justify webkitbox">
            <?php if( isset($coupons) && count($coupons)>0 ){ ?>
                <span><?php echo $lang->line('use_coupon'); ?>
                    <tt class="after_float">
                        <?php
                            echo str_replace('[0]', count($coupons), $lang->line('coupon_num'));
                        ?>
                    </tt>
                </span>
                <span class="color_main" id="couponName"><?php echo $lang->line('select_coupon');?></span>
            <?php }else{?>
                <span><?php echo $lang->line('use_coupon');?></span>
                <span><?php echo $lang->line('no_coupons');?></span>
            <?php } ?>
        </li>

        <li id="ActivityReduce" style="display:none" class="justify webkitbox">
            <span><?php echo $lang->line('special_offer');?><tt class="after_float" id="ActivityName"></tt></span>
            <span class="color_main txtright" id="ActivityTips"></span>
        </li>
    </ul>
<?php endif; ?>


<ul class="list_style_1 bd martop" style="display:none;" id="userReduceObj" type="" quote=""  reduce_cost>
    <li class="user_check_box justify webkitbox" >
        <span><?php echo $lang->line('use');?><?php if($langDir == 'english') { echo ' '; } ?><tt id="userReduceTips"><?php echo $lang->line('point');?></tt></span>
        <span>
            <input class="hide" type="radio"  name=""  />
            <div class="checkbox" ><div></div></div>
        </span>
    </li>
    <?php if($show_balance_passwd == Soma_base::STATUS_TRUE): ?>
        <li class="justify webkitbox" id="passwordText">
            <span><?php echo $lang->line('payment_password');?></span>
            <input class="" type="password" placeholder="<?php echo $lang->line('enter_payment_password');?>" id="userPassword">
        </li>
    <?php endif; ?>
</ul>
<ul class="list_style_1 bd  martop">
    <li class="justify webkitbox">
        <span><?php echo $lang->line('contacts');?></span>
        <input type="text" id="name" name='name' placeholder="<?php echo $lang->line('enter_a_contact');?>" maxlength="20" value="<?php echo $customer_info['name']; ?>">
    </li>
    <li class="justify webkitbox">
        <span><?php echo $lang->line('contacts_phone_number');?></span>
        <input type="tel" id="phone" name="phone" placeholder="<?php echo $lang->line('enter_phone_number');?>" maxlength="11" value="<?php echo $customer_info['mobile']; ?>">
    </li>
</ul>
<input type="hidden" name="orderId" style="display:none"/>
<!--------------------------------------------------  end ------------------------------------- -->

<?php if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE): ?>
    <!--- 修改 -->
    <div class="pay bg_fff bd martop block">
        <div class="pay_means bd_bottom"><?php echo $lang->line('payment_method');?></div>
        <div class="pay_way list_style_1">
            <div class="balancepay item justify webkitbox">
                <span><?php echo $lang->line('stored_balance');?>(<?php echo isset($balance) ? $balance : 0; ?>)</span>
                <span><input class="hide" checked type="radio"  name="pay_way" />
                <div class="radio"><div></div></div></span>
            </div>
        </div>
    </div>
    <?php if($show_balance_passwd == Soma_base::STATUS_TRUE): ?>
    <ul class="list_style_1 bd  martop">
        <li class="justify webkitbox">
            <span><?php echo $lang->line('store_password');?></span>
            <input type="password" id="bpay_passwd" name="bpay_passwd" placeholder="<?php echo $lang->line('enter_password_first');?>" >
        </li>
    </ul>
    <?php endif; ?>
<?php elseif($package['type'] == $packageModel::PRODUCT_TYPE_POINT): ?>
    <!--- 修改 -->
    <div class="pay bg_fff bd martop block">
        <div class="pay_means bd_bottom"><?php echo $lang->line('payment_method');?></div>
        <div class="pay_way list_style_1">
            <div class="balancepay item justify webkitbox">
                <span><?php echo $lang->line('point_balance');?>(<?php echo isset($point) ? $point : 0; ?>)</span>
                <span><input class="hide" checked type="radio"  name="pay_way" />
                <div class="radio"><div></div></div></span>
            </div>
        </div>
    </div>
    <?php if(false && $show_balance_passwd == Soma_base::STATUS_TRUE): ?>
    <ul class="list_style_1 bd  martop">
        <li class="justify webkitbox">
            <span><?php echo $lang->line('point_password');?></span>
            <input type="password" id="bpay_passwd" name="bpay_passwd" placeholder="<?php echo $lang->line('enter_password_first');?>" >
        </li>
    </ul>
    <?php endif; ?>
<?php else: ?>
    <div class="pay bg_fff bd martop block">
        <div class="pay_means bd_bottom"><?php echo $lang->line('payment_method');?></div>
        <div class="pay_way list_style_1">
            <div class="item wxpay justify webkitbox">
                <span><?php echo $lang->line('wechat_pay');?></span>
                <span><input class="hide" checked type="radio"  name="pay_way" />
                <div class="radio"><div></div></div></span>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if( $packageModel::PRODUCT_TYPE_PRIVILEGES_VOUCHER == $package['type'] )://特权券?>
<div class="bg_fff bd martop block">
    <div class="bd_bottom"><?php echo $lang->line('choose_method');?></div>
    <div class="send_way list_style_1">
            <div class="item justify webkitbox">
                <span><?php echo $lang->line('send_yourself');?></span>
                <span><input class="hide" checked type="radio"  name="send_way" value="1" />
                <div class="radio"><div></div></div></span>
            </div>
        <?php if($package['can_gift'] == $packageModel::CAN_T): ?>
        <div class="item justify webkitbox">
            <span><?php echo $lang->line('send_friends');?></span>
            <span><input class="hide" type="radio"  name="send_way" value="2" />
            <div class="radio"><div></div></div></span>
        </div>
        <?php endif;?>
    </div>
</div>
<?php endif; ?>

<!--div class="color_888 martop pad3" id="how_sent">温馨提示:如果您是第一次购买或有疑惑,请<span class="color_main">点击此处</span></div-->
<div class="foot_fixed">
    <div class="bg_fff foot_fixed_list bd_top">
        <div class="pad10" style="text-align:left;line-height:1;padding:5px 0 5px 10px;">
            <?php echo $lang->line('total_amount');?>：

            <?php if($show_y_flag): ?>

            <span class="y color_main" id="grandTotal">

            <?php else: ?>

            <span class="color_main" id="grandTotal">

            <?php endif; ?>

            <?php echo $package['price_package'];?>
            </span><br>

            <span class="h24" id="totalReduceCost">
                （<?php echo $lang->line('discounted');?><?php if($show_y_flag): ?><tt class="y"><?php else: ?><tt><?php endif; ?>0</tt>）
            </span>
        </div>
        <?php if( $is_expire ): ?>
            <button class="h30 bg_main pad10 bg_C3C3C3" type="button"><?php $lang->line('expired');?></button>
        <?php else: ?>
            <button class="h30 bg_main pad10" type="button" onClick="_submit()"><?php echo $lang->line('buy_now');?></button>
        <?php endif; ?>
    </div>
</div>
<!--</form>-->

<!-- 弹层 -->

<div class="ui_pull how_sent_pull" style="display:none">
    <div class="how_sent bg_fff scroll" style="max-height:70%">
        <div class="bg_main bdradius" style="width:2rem; height:0.5rem;margin:auto;"></div>
        <div class="h30" style="padding:0.5rem 0;"><?php echo $lang->line('tips');?></div>
        <div style="text-align:justify; line-height:1.5">
            <p class="color_main"><?php echo $lang->line('buy_tip');?></p>
            <p><?php echo $lang->line('buy_tip_one');?></p>
            <p><img src="<?php echo base_url('public/soma/images/step1.jpg');?>"></p>
            <p><?php echo $lang->line('buy_tip_two');?></p>
            <p><img src="<?php echo base_url('public/soma/images/step2.jpg');?>"></p>
            <p><?php echo $lang->line('buy_tip_three');?> </p>
            <p><img src="<?php echo base_url('public/soma/images/step3.jpg');?>"></p>
            <p><?php echo $lang->line('buy_tip_four');?></p>
            <p><img src="<?php echo base_url('public/soma/images/step4.jpg');?>"></p>
        </div>
    </div>
    <div class="pull_close color_fff h36"><em class="iconfont">&#xe612;</em></div>
</div>

<div class="ui_pull coupon_pull scroll" style="display:none">
	<div class="pad3 toptab">
    	<div class="webkitbox tab_coupon center color_main">
        	<div class="bg_main" card_type="<?php echo $discountModel::TYPE_COUPON_DJ; //代金券?>"><?php echo $lang->line('coupons');?></div>
        	<div card_type="<?php echo $discountModel::TYPE_COUPON_DH; //兑换券?>"><?php echo $lang->line('voucher');?></div>
        	<div card_type="<?php echo $discountModel::TYPE_COUPON_ZK; //折扣券?>"><?php echo $lang->line('discount_coupons');?></div>
        </div>
    </div>
    <div style="padding-top:45px;"></div>
    <div class="pad3 bg_fff bd_bottom" id="RemindText" style="display: none">
        <p class="h30"><?php echo $lang->line('tips');?>：</p>
        <!-- <p>由于微信支付限制（支付金额>0元），扣减后的订单总金额最小不能小于<b class="color_main">0.01</b>元。</p> -->
        <!-- <p>选择优惠券，并提交订单后，若支付失败或未支付，该券将不能再次使用</p> -->
        <p><?php echo $lang->line('coupon_fail_can_not_use');?></p>
    </div>
    <div class="coupon_select">

        <?php /*优惠券模板*/ ?>
        <!--商城代金券-->
        <div class="coupon_item template<?php echo $discountModel::TYPE_COUPON_DJ; //代金券?>" mcid="" style="display: none">
            <input type="checkbox" name="coupon" style="display:none">
            <div class="b_radius"><div></div></div>
            <div class="coupon">
            <?php if($show_y_flag): ?>
                <p class="y against coupon_price"></p>
            <?php else: ?>
                <p class="against coupon_price"></p>
            <?php endif; ?>
                <p class="ticket couponTitle f_s_11"></p>
                <p class="color_888 couponSubTitle"></p>
                <div class="coupon_foot webkitbox bd_top f_s_9" style="clear:both">
                    <p class="against expireDate"></p>
                    <p class="against txt_r scopeType"></p>
                </div>
            </div>
        </div>

        <!--商城折扣劵-->
        <div class="coupon_item template<?php echo $discountModel::TYPE_COUPON_ZK; //折扣券?>" mcid=""  style="display: none">
            <input type="radio" name="coupon" style="display:none">
            <div class="b_radius"><div></div></div>
            <div class="coupon">
                <p class="zhe against coupon_price"></p>
                <p class="ticket couponTitle f_s_11"></p>
                <p class="color_888 couponSubTitle"></p>
                <div class="coupon_foot webkitbox bd_top f_s_9" style="clear:both">
                    <p class="against expireDate"></p>
                    <p class="against txt_r scopeType"></p>
                </div>
            </div>
        </div>

        <!--商城兑换劵-->
        <div class="coupon_item template<?php echo $discountModel::TYPE_COUPON_DH; //兑换劵?>" mcid=""  style="display: none">
            <input type="checkbox" name="coupon" style="display:none">
            <div class="b_radius"><div></div></div>
            <div class="coupon">
                <p class="against coupon_price"></p>
                <p class="ticket couponTitle f_s_11"></p>
                <p class="color_888 couponSubTitle"></p>
                <div class="coupon_foot webkitbox bd_top f_s_9" style="clear:both">
                    <p class="against expireDate"></p>
                    <p class="against txt_r scopeType"></p>
                </div>
            </div>
        </div>
        <form action="<?php echo current_url(); ?>" method="post" id="apply_coupon">
        </form>
    </div>
    <div class="ui_none" style="display: none"><div> <?php echo $lang->line('no_corresponding_coupon');?></div></div>

    <div class="foot_fixed bg_main pad3 center" onclick="choose_end();">
        <div><?php echo $lang->line('confirm'); ?></div>
    </div>
    <div style="padding-top:48px;"></div>
</div>
<div style="margin-bottom:20%;"></div>
<div class="jfk-dialog jfk-dialog__address bg_F3F4F8">
    <div class="jfk-dialog__box">
        <div class="pull_loading"><p class="isload">正在加载</p></div>
        <div class="mail_add">
            <form class="mail_add_form">
                <input name="address_id" value="0" type="hidden" />
                <input type="hidden" name="province"/>
                <input type="hidden" name="city"/>
                <input type="hidden" name="region"/>
                <input type="hidden" name="province_name"/>
                <input type="hidden" name="city_name"/>
                <input type="hidden" name="region_name"/>
                <ul class="list_style_2">
                    <li class="input_item bd_bottom">
                        <span class="label">收件人</span>
                        <span class="cont">
                            <input type="text" placeholder="请填写收件人姓名" name="contact"/>
                        </span>
                    </li>
                    <li class="input_item bd_bottom">
                        <span class="label">收件电话</span>
                        <span class="cont"><input type="tel" placeholder="请输入手机号"  name="phone" /></span>
                    </li>
                    <li class="input_item input_item_area arrow bd_bottom" id="select_area">
                        <span class="label">收件区域</span>
                        <label class="cont">
                            <span class="area_placeholder">请选择收件区域</span>
                            <input type="text" readonly id="area" name="area" />
                        </label>
                    </li>
                    <li class="input_item">
                        <span class="label">详细地址</span>
                        <span class="cont"><input type="text" placeholder="如街道，楼层等"  name="address" /></span>
                    </li>
                </ul>
            </form>
            <div class="mail_addr_control">
                <a class="btn_main control" data-type="save" href="javascript:;">保存</a>
            </div>
        </div>
        <div class="mail_add_list">
            <ul class="mail_add_list_content">
            </ul>
            <div class="mail_addr_control">
                <span class="control" data-type="add"><i class="bg_main mail_addr_icon">+</i><i>新增收货地址</i></span>
            </div>
        </div>
    </div>
</div>
<script>

var singlePrice =  parseFloat('<?php echo $package['price_package'] ?>').toFixed(2);
var originalTotal = parseFloat('<?php echo $package['price_package']*$buy_default ?>').toFixed(2);
var couponPrice = 0;
var totalReduce = 0; <?php /*总优惠价*/ ?>
var userBalance = 0; <?php /*用户储值总价*/ ?>
var userReduce = 0; <?php /*用户储值或者积分扣减*/ ?>
var assetScale = 1; <?php /*(积分储值)兑换金额比例*/?>
var activityReduce = 0; <?php /*活动满减*/ ?>
var autoPick = false; <?php //true为进入自动选券?>
var couponItemText; <?php //优惠券初始文字?>
var mCid=[];
var can_use_coupon ;

var payUrl = '<?php echo Soma_const_url::inst()->go_to_pay( array('id'=> $this->inter_id, 'bType'=>$bType ) );//订单生产请求地址?>';
var wftPayUrl = '<?php echo Soma_const_url::inst()->wft_go_to_pay( array('id'=> $this->inter_id, 'bType'=>$bType ) );//订单生产请求地址?>';
var getDiscountUrl = '<?php echo Soma_const_url::inst()->get_url('soma/package/discount_rule_ajax'); //获取所有优惠信息?>';
var couponListUrl = '<?php echo Soma_const_url::inst()->get_url('soma/package/coupon_list_ajax'); //优惠券列表请求地址?>';

$('.tab_coupon *').click(function(){
	var _this =$(this);
	var card_type=_this.attr('card_type');
	if($('#apply_coupon .choose').length>0){
		$.MsgBox.Confirm('<?php echo $lang->line('use_one_discount_type');?>',function(){
			_this.addClass('bg_main').siblings().removeClass('bg_main');
			getCouponList(card_type,false);
		},null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
	}else{
		_this.addClass('bg_main').siblings().removeClass('bg_main');
		getCouponList(card_type,false);
	}
})

$('#how_sent').click(function(){
    toshow($('.how_sent_pull'));
})
$('.how_sent_pull .pull_close').click(toclose);

$('.pay_way .item').click(function(){
    $(this).addClass('choose').siblings().removeClass('choose');
    $('input',this).get(0).checked=true;
});

$('.check_box').click(function(){
    $(this).toggleClass('choose');
    $('input',this).get(0).checked= $(this).hasClass('choose');
});

//用户储值或者积分扣减
$('.user_check_box').click(function(){
    var userCheck = $('.user_check_box').find('input[type=radio]').get(0).checked;

    //与优惠券有冲突
    if( $('#userReduceObj').attr('can_use_coupon') == <?php echo Soma_base::STATUS_FALSE;?>){
        $('#choose_coupon').html(couponItemText);
        couponPrice = 0;
    }

    if(userCheck){
        $(this).addClass('choose');
        userReduce = parseFloat($('#userReduceObj').attr('reduce_cost'));
        grandTotalCalcShow();
    }else{
        $(this).removeClass('choose');
        userReduce = 0;
        grandTotalCalcShow();
    }
});


var _submit = function(){
        if( $('#name').val()=='' ){
            $.MsgBox.Confirm('<?php echo $lang->line('enter_a_contact');?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');return false;
        }
        if( $('#phone').val()=='' ){
            $.MsgBox.Confirm('<?php echo $lang->line('enter_phone_number');?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');return false;
        }
        if( !reg_phone.test($('#phone').val()) ){
            $.MsgBox.Confirm('<?php echo $lang->line('phone_number_wrong');?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');return false;
        }
        // 邮寄地址
        if (userAddressArr !== null && $('[name="mail"]').filter(':checked').val() === '1') {
            var _addressId = $('[name="addressID"]').val()
            if ( _addressId == 0){
                $.MsgBox.Confirm('请选择收货地址');
                return false;
            }
            var _data = userAddressCache[_addressId]
            if (!_data.contact) {
                $.MsgBox.Confirm('请填写收件人姓名');
                return false;
            }
            if (!_data.phone) {
                $.MsgBox.Confirm('请填写收件人电话');
                return false;
            }
            if (!/^1\d{10}$/.test(_data.phone)) {
                $.MsgBox.Confirm('请正确填写收件人电话');
                return false;
            }
            if (!_data.province || !_data.city || !_data.address) {
                $.MsgBox.Confirm('请填写收货地址');
                return false;
            }

        }

        var assetType = $('#userReduceObj').attr('type') ;
        var assetQuote = $('#userReduceObj').attr('quote');
        var password = $('#userPassword').val();
        var bpay_passwd = $('#bpay_passwd').val();


        if( ! $('.user_check_box').hasClass('choose')){
            assetType = '';
            assetQuote = '';
        }

        if(assetType == <?php echo $salesRuleModel::RULE_TYPE_BALENCE;?> ){
            if($('.user_check_box').find('input[type=radio]').get(0).checked){
				if(can_use_coupon == <?php echo Soma_base::STATUS_FALSE;?>)mCid=[];
				//console.log($('#mcid').val())
                if(password ==''){
                    $.MsgBox.Confirm('<?php echo $lang->line('enter_payment_password');?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');return false;
                }

            }
        }

        <?php if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE): ?>
    		if($('.balancepay').length){
    			if($('.balancepay input').get(0).checked&& $('#grandTotal').html()*1><?php echo isset($balance) ? $balance : 0; ?>){
    				$.MsgBox.Confirm('<?php echo $lang->line('balance_note_enough_tip');?>',function(){
    					window.location.href="<?php echo $balance_url;?>";//充值链接
    					// alert('未对接充值接口');
    				},null,'<?php echo $lang->line('recharge_now');?>','<?php echo $lang->line('cancel');?>');
    				return false;
    			}
    		}
            if(bpay_passwd ==''){
                $.MsgBox.Confirm('<?php echo $lang->line('enter_payment_password');?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
                return false;
            }
        <?php endif; ?>

        <?php if($package['type'] == $packageModel::PRODUCT_TYPE_POINT): ?>
        if($('.balancepay').length){
            if($('.balancepay input').get(0).checked&& $('#grandTotal').html()*1><?php echo isset($point) ? $point : 0; ?>){
                $.MsgBox.Confirm('<?php echo $lang->line('credit_not_enough_tip');?>',function(){
					window.location.href="<?php echo Soma_const_url::inst()->get_pacakge_home_page(array('id'=>$inter_id)); ?>"
                },null,'<?php echo $lang->line('go_online_shop');?>', '<?php echo $lang->line('cancel');?>' );
                return false;
            }
        }
        <?php endif; ?>

        // 设置使用方式，默认为-1，即无使用方式
        var u_type = "-1";
        <?php if( $packageModel::PRODUCT_TYPE_PRIVILEGES_VOUCHER == $package['type'] )://特权券?>
            u_type = $('input[name="send_way"]:checked').val();
        <?php endif; ?>

        //show loading

        pageloading('<?php echo $lang->line('generate_order');?>',0.2);

        var pQty = $('#buy_num').html();
        if(isNaN(pQty)){
            $.MsgBox.Confirm('<?php echo $lang->line('number_incorrect');?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
            return false;
        }
        var ajaxData = {
            business: 'package',
            settlement: 'default',
            hotel_id: '<?php echo $package['hotel_id'];?>',
            qty : {<?php echo $_GET['pid'];?>:parseInt(pQty)},
            name : $('#name').val(),
            phone : $('#phone').val(),
            orderId : $('#orderId').val(),
            inid : 0,
            mcid: mCid,//优惠券批量使用，这里需要改成多个mcid 1
            saler: '<?php echo isset($saler_self)? $saler_self: $saler; ?>',
            fans_saler: '<?php echo isset($fans_saler_self)? $fans_saler_self: $fans_saler; ?>',
            fans: '<?php echo $fans; ?>',
            product_id: <?php echo $_GET['pid'];?>,
            quote_type: assetType,
            quote: assetQuote, //assetQuote, //originalTotal- couponPrice- activityReduce,
            password: password,
            bpay_passwd: bpay_passwd,
            u_type: u_type,
            psp_setting:{<?php echo $_GET['pid'];?>:<?php echo isset($psp_setting[0]) ? $psp_setting[0]['setting_id'] : -1;?>},
            scope_product_link_id: '<?php echo empty($scope_product_link)? 0 : $scope_product_link["id"]; ?>'
        }
        if (userAddressArr !== null && $('[name="mail"]').filter(':checked').val() === '1') {
            ajaxData.address_id = $addressId.val()
        }
        $.ajax({
			async: true,
            type: 'POST',
			timeout : 10000,
            url: '<?php echo Soma_const_url::inst()->get_prepay_order_ajax(array('bType'=>$bType));?>',
            data: ajaxData,
        success: function(data,text_status,re){
            //close loading
           //  console.log(text_status);
           //  console.log(re.status);
            if(re.status == 200) {
                if(data.status == 1){
                    // alert('s');
                    if(data.step =='wxpay'){
                        location.href = payUrl+'&order_id='+data.data.orderId;
                    }else if(data.step == 'wft_pay'){
                        location.href = wftPayUrl+'&order_id='+data.data.orderId;
                    }else{
                        var redirectUrl = '';
                        if( data. bType && data.bType != '' && data.success_url ){
                            redirectUrl = data.success_url;
                        } else {
                            redirectUrl = '<?php echo  Soma_const_url::inst()->get_payment_package_success(array('id'=>$inter_id,'bType'=>$bType));?>'+ "&order_id=" + data.data.orderId;
                        }
                        location.href = redirectUrl;
                    }
                }else if(data.status == 2){
                    $('.pageloading').remove();
                    //失败
                    $.MsgBox.Confirm(data.message,null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
                    return false;
                }
                else if (data.status == 3) {
                    $('.pageloading').remove();
                    $.MsgBox.loading(data.message, function(){
                        var timer = $(this).timer;
                        clearTimeout(timer);
                        $(this).timer = setTimeout(function(){
                            clearTimeout(timer);
                            location.href = data.success_url
                        }, 20000)
                    })
                }
            }
            if(re.status == 302||re.status == 307) {
				window.location.reload();
			}
        } ,
        error: function(e) {
			//失败
            $('.pageloading').remove();
			$.MsgBox.Confirm('<?php echo $lang->line('order_overtime_try_again_tip');?>',function(){
				//if(e.status == 302||e.status == 307) {
					window.location.reload();
				//}
			},function(){
					window.location.reload();
			},'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
			return false;
        },
        timeout: function(e) {
            $('.pageloading').remove();
                    //失败
			$.MsgBox.Confirm('<?php echo $lang->line('order_overtime_try_again_tip');?>',function(){
				//if(e.status == 302||e.status == 307) {
					window.location.reload();
				//}
			},function(){
					window.location.reload();
			}, '<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
        },
	　　complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
	　　　　if(status=='timeout'){//超时,status还有success,error等值的情况
				$('.pageloading').remove();
				$.MsgBox.Confirm('<?php echo $lang->line('order_overtime_try_again_tip');?>',function(){
					//if(e.status == 302||e.status == 307) {
						window.location.reload();
					//}
				},function(){
						window.location.reload();
				},'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
	　　　　}
	　　},
        dataType: 'json'
        });
}

$('#choose_coupon').click(function(){
	if($(this).hasClass('disable')){
        $.MsgBox.Confirm('<?php echo $lang->line('can_not_use_coupon_tip');?>', null, null, '<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
		return;
	}
	var card_type=$('.tab_coupon .bg_main').attr('card_type');
    getCouponList(card_type,true);
})

//获取可用优惠券
function getCouponList(card_type,showpull){
    pageloading('<?php echo $lang->line('please_wait_tip');?>',0.2);
    var couponListUrl = '<?php echo Soma_const_url::inst()->get_url('soma/package/coupon_list_ajax'); ?>';
    $.ajax({
        type: 'POST',
        url: couponListUrl,
        data: {
            '<?php echo $_GET['pid'];?>':parseInt($('#buy_num').html()),
			card_type:card_type
        },
        success: function(data){
            removeload();
            if(data.status == <?php echo Soma_base::STATUS_FALSE;?>){
                $.MsgBox.Confirm(data.message,null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
            }else{
                fillCouponContent(data.data);
                if(showpull)toshow($('.coupon_pull'));
            }
        } ,
        dataType: 'json'
    });

}

//优惠券填充
function fillCouponContent(data){
	var disableCard = [];
	var _j = 0;
    $('#apply_coupon').html('');
    if(data.length <= 0){ //没有优惠券
        $('#RemindText').hide();
        $('.coupon_select').hide();
        $('.ui_none').show();
    }else{
        $('.ui_none').hide();
        $('#RemindText').show();
        $('.coupon_select').show();
        //循环输出
        for(var i = 0;i < data.length; i++) {
            coupon = data[i];
            if(coupon.card_type == <?php echo $discountModel::TYPE_COUPON_DH; //兑换券?>){  //
                CouponObj = $('.coupon_select>.template<?php echo $discountModel::TYPE_COUPON_DH; //兑换券?>').clone();
                $(CouponObj).find('.couponTitle').html(coupon.title);
                $(CouponObj).find('.coupon_price').html('<?php echo $lang->line('exchange');?>');
                $(CouponObj).attr('cost',coupon.reduce_cost);

            }else if(coupon.card_type == <?php echo $discountModel::TYPE_COUPON_ZK; //折扣券?>){ //type2
                CouponObj = $('.coupon_select>.template<?php echo $discountModel::TYPE_COUPON_ZK; //折扣券?>').clone();
                $(CouponObj).find('.couponTitle').html(coupon.title);
                $(CouponObj).find('.coupon_price').html(coupon.discount);
                $(CouponObj).attr('cost',coupon.discount);

            }else{
                CouponObj = $('.coupon_select>.template<?php echo $discountModel::TYPE_COUPON_DJ; //代金券?>').clone();
                $(CouponObj).find('.couponTitle').html(coupon.title);
                $(CouponObj).find('.coupon_price').html(coupon.reduce_cost);
                $(CouponObj).attr('cost',coupon.reduce_cost);

            }

            <?php /*使用门槛*/?>
            if( parseFloat(coupon.least_cost) >= 0){
                var str = '<?php echo $lang->line('full_use');?>'
                str = str.replace('[0]', coupon.least_cost);
    //                $(CouponObj).find('.couponSubTitle').html('满'+coupon.least_cost+'元使用');
                $(CouponObj).find('.couponSubTitle').html(str);
            }else{
                $(CouponObj).find('.couponSubTitle').html(coupon.sub_title);
            }

            $(CouponObj).removeAttr('style');
            $(CouponObj).attr('cardType',coupon.card_type);
            $(CouponObj).attr('mcid',coupon.member_card_id);
            $(CouponObj).attr('cardid',coupon.card_id);

            <?php /*主标题*/ ?>
            $(CouponObj).attr('name',coupon.title);

            <?php /*有效期*/?>
            $(CouponObj).find('.expireDate').html( coupon.expire_time );

            <?php /*适用商品*/?>
            $(CouponObj).find('.scopeType').html(coupon.scopeType);

            if(!coupon.usable){
				if(disableCard.indexOf(coupon.card_id)<0)
					disableCard[_j++]=coupon.card_id;
                $(CouponObj).addClass('coupon_disable');
            }
            $('#apply_coupon').append(CouponObj);

        }
		$('#apply_coupon .coupon_item').click(function(){
			if ( $(this).hasClass('coupon_disable')) return;
			var couponType = $('.tab_coupon .bg_main').attr('card_type');
			if( couponType == <?php echo $discountModel::TYPE_COUPON_ZK; //折扣券?>){
				$(this).addClass('choose').siblings().removeClass('choose');
			}else{
				var buynum = parseInt($('#buy_num').html());
				if ( $(this).hasClass('choose')){
					$(this).removeClass('choose');
					$('input',this).get(0).checked=false;
				}else{
					$(this).addClass('choose')
					$('input',this).get(0).checked=true;
				}
				if ( $('#apply_coupon .choose').length >=buynum){
					$('#apply_coupon .coupon_item').addClass('coupon_disable');
					$('#apply_coupon .choose').removeClass('coupon_disable');
					return;
				}
				if($('#apply_coupon .choose').length>0){
					var tmpid=$('#apply_coupon .choose').eq(0).attr('cardid');
					$('#apply_coupon .coupon_item').addClass('coupon_disable');
					$('#apply_coupon .coupon_item[cardid="'+tmpid+'"]').removeClass('coupon_disable');
				}
				else{
					$('#apply_coupon .coupon_item').removeClass('coupon_disable');
					for(var _i = 0;_i<disableCard.length;_i++){
						$('.coupon_item[cardid="'+disableCard[_i]+'"]').addClass('coupon_disable');
					}
				}
			}
		});
    }
}

/**
 * 优惠活动
 */
function activityReduceSet(actName,actTips,actReduceAmount){
    $('#ActivityReduce').show();
    $('#ActivityName').html(actName);
    $('#ActivityTips').html(actTips);
    activityReduce = parseFloat(actReduceAmount);
}

function getLvlInfo(){
    $.ajax({
        type: 'POST',
        url: '<?php echo Soma_const_url::inst()->get_url('*/package/get_lvl_info_ajax', array('id'=> $inter_id) ); ?>',
        data: {},
        success: function(data){
            if(data.status == <?php echo Soma_base::STATUS_FALSE;?>){
    			$.MsgBox.Confirm(data.message,null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
            }
        },
        dataType: 'json'
    });
}

/*获取所有可用优惠*/
function getReduceInfo(){

    <?php if($package['type'] == $packageModel::PRODUCT_TYPE_POINT): ?>
    return;
    <?php endif; ?>

    resetAllReduceCost();
    pageloading('<?php echo $lang->line('please_wait_tip');?>', 0.2);
    $.ajax({
        type: 'POST',
        url: getDiscountUrl,
        data: {
            pid: '<?php echo $_GET['pid'];?>',
            qty: $('#buy_num').html(),
            stl:'default',
            sid: '<?php echo isset($_GET['psp_sid'])?$_GET['psp_sid']:-1; ?>'
        },
        success: function(data){
            console.log(data);
            removeload();

			can_use_coupon = data.data.asset.cal_rule.can_use_coupon; //储值积分
			// 根据配置项判断积分储值能否使用优惠券 2016年9月20日19:10:53  fengzhongcheng
            if( can_use_coupon !=undefined){
                if( can_use_coupon ==<?php echo Soma_base::STATUS_FALSE;?>){
                    $('#choose_coupon').addClass('disable');
                }else{
                    $('#choose_coupon').removeClass('disable');
                }
            }

			var tmp_can_use_coupon = data.data.activity.auto_rule.can_use_coupon;  //活动

            if( tmp_can_use_coupon !=undefined){
				if( tmp_can_use_coupon ==<?php echo Soma_base::STATUS_FALSE;?>){
                    console.log('use coupon disable');
					$('#choose_coupon').addClass('disable');
				}else{
					$('#choose_coupon').removeClass('disable');
				}
			}

            if(data.status == <?php echo Soma_base::STATUS_TRUE;?>){
                var discountData = data.data;

                if(discountData.activity.status == <?php echo Soma_base::STATUS_TRUE;?>){
                    var activity = discountData.activity.auto_rule;
                    activityReduceSet(activity.name,"<?php echo $lang->line('discounted'); ?>" +'¥'+ parseFloat(activity.reduce_cost).toFixed(2),activity.reduce_cost);
                    activityReduce = activity.reduce_cost;
                }else{
                    activityReduce = 0;
                    $('#ActivityReduce').hide();
                }

                <?php //积分储值 ?>

                if(data.data.asset.cal_rule.can_use != undefined
                    && data.data.asset.cal_rule.can_use == <?php echo Soma_base::STATUS_FALSE; ?>) {
                    // 不可用储值积分优惠
                    $('#userReduceObj').show();

                    $('#userReduceTips').html(data.data.asset.cal_rule.label + ': <?php echo $lang->line('lack_of_balance');?>');
                    $('#passwordText').hide();
                    // $('#userReduceObj').addClass('disable');
                    $('#userReduceObj .checkbox').hide();
                    // console.log(data.data.asset.cal_rule);return;
                } else {
                    if(discountData.asset.status == <?php echo Soma_base::STATUS_TRUE;?>){
                        var asset = discountData.asset.cal_rule;
                        assetScale = asset.scale;
                        $('#userReduceObj').attr('type',asset.rule_type);
                        $('#userReduceObj').attr('reduce_cost',asset.reduce_cost);
                        $('#userReduceObj').attr('quote',asset.quote);
                        $('#userReduceObj').attr('can_use_coupon',asset.can_use_coupon);
                        $('#userReduceObj').show();

    					//默认使用积分//
    					$('.user_check_box input').get(0).checked=true;
    					$('.user_check_box').trigger('click');

                        if(asset.rule_type == <?php echo $salesRuleModel::RULE_TYPE_POINT;?>){
                            $('#choose_coupon').addClass('disable');
                            var reduce_cost = parseFloat(asset.reduce_cost).toFixed(2)

                            var str = '<?php echo $lang->line('point_change');?>';
                            // str = str.replace(/N/g, asset.quote);
                            // str = str.replace(/M/g, reduce_cost);
                            str = str.replace('[0]', asset.quote);
                            str = str.replace('[1]', reduce_cost);
    //                            $('#userReduceTips').html('积分 '+ asset.quote + '抵' + reduce_cost);
                            $('#userReduceTips').html(str);
                            userBalance = asset.reduce_cost;
                            $('#passwordText').hide();
                        }else if(asset.rule_type == <?php echo $salesRuleModel::RULE_TYPE_BALENCE;?>){
                            $('#choose_coupon').addClass('disable');
                            $('#userReduceTips').html('<?php echo $lang->line('stored_value');?>¥'+ asset.quote );
                            userBalance = asset.quote;
                            <?php if($show_balance_passwd == Soma_base::STATUS_TRUE): ?>
                            $('#passwordText').show();
                            <?php endif; ?>
                        }

    //                    userReduce = asset.reduce_cost;
                    }else{
                        $('#userReduceObj').attr('type','');
                        $('#userReduceObj').attr('quote','');
                        $('#userReduceObj').attr('reduce_cost',0);
                        $('#userReduceObj').hide();
                        $('#passwordText').hide();
    //                    userReduce = asset.reduce_cost;
                    }
                }

                var status_val = <?php echo Soma_base::STATUS_FALSE;?>;
                if(discountData.asset.status==status_val && discountData.activity.status== status_val){
                    console.log('remove disable anyway!');
                    $('#choose_coupon').removeClass('disable');//选择的有活动或优惠不能和优惠券共存，隐藏了，但是不选择活动或优惠，优惠券就不显示了
                }

                grandTotalCalcShow();

            }else{ //没有返回值
                $.MsgBox.Confirm(data.message,null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
                $('#userReduceObj').hide();
                $('#ActivityReduce').hide();
            }
        } ,
        dataType: 'json'
    });
}

//reset所有优惠信息
function resetAllReduceCost(){
    couponPrice = 0;  //优惠券金额
    activityReduce = 0;
    totalReduce = 0;  //总优惠重置0
    userReduce = 0;     //积分储值重置
    mCid=[];
    $('#choose_coupon').html(couponItemText);
    $('.user_check_box').removeClass('choose');
    $('#userReduceObj').attr('type','');
    $('#userReduceObj').attr('quote','');
    $('#userReduceObj').attr('can_use_coupon',"");
    grandTotalCalcShow();
}

$(function(){
    $('#select_num').click(function(){
        toshow($('.area_pull'));
        $('.area_box').stop().animate({'bottom':0});
    });
    $('.area_box').click(function(e){e.stopPropagation();});
    $('.sure_btn').click(function(){
		var buy_num = parseInt($('#selece_num').val());
		if(isNaN(buy_num)){
			$.MsgBox.Confirm('<?php echo $lang->line('purchase_must_be_nnnumeric');?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
			return false;
		}
		if( buy_num > <?php echo $buy_limit; ?> ){
			$.MsgBox.Confirm('<?php echo str_replace('[0]', $buy_limit, $lang->line('quantity_limit_tip') ); ?>',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
			return false;
		}
        originalTotal = buy_num* singlePrice;
        $('#buy_num').html(buy_num);
        getReduceInfo();
		<?php if($package['type'] == $packageModel::PRODUCT_TYPE_POINT): ?>
		grandTotalCalcShow();
		<?php endif; ?>
        toclose();
    })
    $('.addCardId').click(function(){
        alert($(this).attr('card_id'));
    });

});

/**总价显示*/
function showCalcTotalHtml(price){
    var total = 0;
    if( price <= 0){
        total = 0;
    }else{
        total = price;
    }
    $('#grandTotal').html(total.toFixed(2));
	reduce = originalTotal - total;
	if(reduce > 0){
		$('#totalReduceCost').show();
		$('#totalReduceCost tt').html( reduce.toFixed(2) );
	}else{
		$('#totalReduceCost').hide();
	}
}


/**
 * 总价计算
 */
function grandTotalCalcShow(){
    var grandTotal = originalTotal - couponPrice - userReduce - activityReduce;
    showCalcTotalHtml(grandTotal);
}

//选择完优惠券
function choose_end(){
	couponPrice=0;
	mCid=[];
	$('#apply_coupon .choose').each(function(index, element) {
		var obj = $(this);
		$('#couponName').html(obj.attr('name'));
		mCid[index]=obj.attr('mcid');
		var couponType = $('.tab_coupon .bg_main').attr('card_type');
		var reduceCost = obj.attr('cost');
	   // var tmp_can_use_coupon = $("#userReduceObj").attr('can_use_coupon');
		if(couponType == <?php echo $discountModel::TYPE_COUPON_DH; //兑换券?>){
			couponPrice += singlePrice*1;
		}else if(couponType == <?php echo $discountModel::TYPE_COUPON_ZK; //折扣券?>){
			var reduceCost = obj.attr('cost');
			couponPrice = originalTotal *  (1 - reduceCost / 10);
		}else if(couponType == <?php echo $discountModel::TYPE_COUPON_DJ; //代金券?>){
			couponPrice += reduceCost*1;
		}
		//检测是否与储值积分冲突
		if(can_use_coupon == <?php echo Soma_base::STATUS_TRUE;?>){
			var userCalcPrice = userBalance - couponPrice;
			if(userCalcPrice < 0) {
				userCalcPrice = 0
			}
            var label = $('#userReduceTips').html();
            if(label.substring(0, 2) == '<?php echo $show_name;  ?>') {
                // 储值
    			$('#userReduceObj').attr('reduce_cost',userCalcPrice);
    			$('#userReduceObj').attr('quote',userBalance);
    			$('#userReduceTips').html('<?php echo $show_name;  ?>¥'+  userCalcPrice);
            } else {
                // 积分
                var point = Math.ceil(userCalcPrice/assetScale);
                userCalcPrice = point * assetScale;
                userCalcPrice = userCalcPrice.toFixed(2);
                $('#userReduceObj').attr('reduce_cost',userCalcPrice);
                $('#userReduceObj').attr('quote', point);
//                $('#userReduceTips').html('积分 '+  point + '抵' + userCalcPrice);
                var str = '<?php echo $lang->line('point_change');?>';
                text.replace('[0]', point);
                text.replace('[1]', userCalcPrice);
                $('#userReduceTips').html(str);
            }
		} else {
			userReduce = 0;
			$('.user_check_box').find('input').get(0).checked = false;
		}
    });
    toclose();
	if(mCid.length>1) $('#couponName').html(mCid.length+'张'+$('.tab_coupon .bg_main').html());
	if(mCid.length<=0) $('#couponName').html('<?php echo $lang->line('select_coupon');?>');
    grandTotalCalcShow();

}

$(function(){
    couponItemText = $('#choose_coupon').html();
    getReduceInfo();
    //getLvlInfo();  //会员接口狂抛异常，暂时无法检测
});
</script>
<!-- add by fsy0718 at 2017/06/23 邮寄 -->
<script src="<?php echo base_url('public/soma/calendar/mobiscroll.core.js');?>"></script>
<script src="<?php echo base_url('public/soma/calendar/mobiscroll.widget.js');?>"></script>
<script src="<?php echo base_url('public/soma/calendar/mobiscroll.scroller.js');?>"></script>
<script src="<?php echo base_url('public/soma/calendar/mobiscroll.listbase.city.js');?>"></script>
<script src="<?php echo base_url('public/soma/calendar/mobiscroll.list.js');?>"></script>
<script src="<?php echo base_url('public/soma/calendar/mobiscroll.widget.ios.js');?>"></script>
<script src="<?php echo base_url('public/soma/calendar/mobiscroll.i18n.zh.js');?>"></script>
<link href="<?php echo base_url('public/soma/calendar/mobiscroll.animation.css');?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('public/soma/calendar/mobiscroll.widget.css');?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('public/soma/calendar/mobiscroll.widget.ios.css');?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('public/soma/calendar/mobiscroll.scroller.css');?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('public/soma/calendar/mobiscroll.scroller.ios.css');?>" rel="stylesheet" type="text/css">
<script>
var $addAddressBtn = $('#add_mail_address')
var $addressId = $('input[name="addressID"]')
var $dialogAddr = $('.jfk-dialog__address')
var $addrFormArea = $dialogAddr.find('.mail_add')
var $addrForm = $addrFormArea.find('.mail_add_form')
var $addrList = $dialogAddr.find('.mail_add_list')
var $addrListCont = $addrList.find('.mail_add_list_content')
var $giftProcess = $('.gift_process')
var $mailAddrArea = $('.mail_addr_area')
var $dialogAddrArea = $('#areaShow')
var $dialogName = $dialogAddr.find('input[name="contact"]')
var $dialogTel = $dialogAddr.find('input[name="phone"]')
var $dialogAddress = $dialogAddr.find('input[name="address"]')
var $dialogArea = $dialogAddr.find('input[name="area"]')
var $dialogAreaPlaceholder = $dialogAddr.find('.area_placeholder')
var $dialogProvince = $dialogAddr.find('input[name="province"]')
var $dialogAddressId = $dialogAddr.find('input[name="address_id"]')
var $dialogCity = $dialogAddr.find('input[name="city"]')
var $dialogRegion = $dialogAddr.find('input[name="region"]')
var $dialogProvinceName = $dialogAddr.find('input[name="province_name"]')
var $dialogCityName = $dialogAddr.find('input[name="city_name"]')
var $dialogRegionName = $dialogAddr.find('input[name="region_name"]')
var $dialogAddrLoading = $dialogAddr.find('.pull_loading')
var isFristShowAddressLayer = true
var hasLoadCities = false
var loadCityUrl = '/index.php/soma/express/tree'
var loadUserAddrUrl = '/index.php/soma/express/my'
var updateUserAddrUrl = '/index.php/soma/express/save'
var deleteUserAddrUrl = 'index.php/soma/express/destroy'

var userAddressArr = <?php echo (isset($userAddress)) ? $userAddress:" " ;?>;
var userAddressCache = {};
var changeAddressCache = {};
if (userAddressArr) {
    $.each(userAddressArr, function (idx, addr) {
        userAddressCache[addr.address_id] = addr
    })
}
var loadCityData = function () {
    $.get(loadCityUrl, function(data){
        hasLoadCities = true
        $dialogAddrLoading.hide();
        if (data.status === 1) {
            $('#area').mobiscroll().treelist({
                theme: 'ios',//样式
                lang: 'zh',//语言
                display: 'bottom',//指定显示模式
                labels: ['省份', '城市', '地区'],
                wheelArray: data.data[0].children,
                rows:5,//滚动区域内的行数
                showInput: false,
                onClose: function (val, action, inst) {
                    if (action === 'set') {
                        var $inst = $('.mbsc-ios')
                        var text = []
                        var values = val.split(' ')
                        $.each(values, function (key, v) {
                            var _t = $inst.find('.dw-li[data-val="' + v + '"]').text()
                            text.push(_t);
                            if (key === 0) {
                                $dialogProvince.val(v)
                                $dialogProvinceName.val(_t)
                            }
                            if (key === 1) {
                                $dialogCity.val(v)
                                $dialogCityName.val(_t)
                            }
                            if (key === 2) {
                                $dialogRegion.val(v)
                                $dialogCityName.val(_t)
                            }
                        })
                        if (values.length === 2) {
                            $dialogRegion.val('')
                            $dialogRegionName.val('')
                        }
                        $dialogAreaPlaceholder.text(text.join(' '));
                    }
                    return true
                }
            })
        }
    })
}
var getUserAddrHtml = function (addr) {
    return '<li data-id="'+addr.address_id+'" class="mail_add_list_item whiteblock martop"><p><span class="name">收货人：'+addr.contact+'</span><span class="phone">'+addr.phone+'</span></p><p>收货地址：'+addr.province_name + addr.city_name + (addr.region_name || '') + addr.address +'</p><div class="mail_add_list_control color_main"><span class="modify" data-id="'+addr.address_id+'">修改</span></div></li>'
}

var loadUserAddress = function (addrs) {
    var addrHtmls = []
    $.each(addrs, function (idx, addr) {
        addrHtmls.push(getUserAddrHtml(addr))
    })
    $addrListCont.html(addrHtmls.join(''))
}

$addAddressBtn.click(function(){
    if (isFristShowAddressLayer) {
        loadCityData();
        isFristShowAddressLayer = false
    }
    toshow($dialogAddr)
})
// 选择地址
$addrListCont.on('click', '.mail_add_list_item', function () {
    var aid = $(this).data('id')
    showChooseAddress(aid)
})
$addrListCont.on('click', '.modify', function (e) {
    e.stopPropagation()
    var aid = $(this).data('id');
    var addressObj = userAddressCache[aid];
    if (!hasLoadCities) {
        $dialogAddrLoading.show()
        loadCityData();
    }
    $dialogAddressId.val(addressObj.address_id)
    $dialogProvince.val(addressObj.province)
    $dialogProvinceName.val(addressObj.province_name)
    $dialogCity.val(addressObj.city)
    $dialogCityName.val(addressObj.city_name)
    $dialogRegion.val(addressObj.region || '')
    $dialogRegionName.val(addressObj.region_name || '')
    $dialogName.val(addressObj.contact)
    $dialogTel.val(addressObj.phone)
    if (Number(addressObj.province) && Number(addressObj.city)) {
        $dialogArea.val(addressObj.province + ' ' + addressObj.city + (addressObj.region ? ' ' + addressObj.region : ''))
        $dialogAreaPlaceholder.text((addressObj.province_name + ' ' + addressObj.city_name + (addressObj.region ? ' ' + addressObj.region_name : '')) || '请选择收货区域')
    }else {
        $dialogArea.val('')
        $dialogAreaPlaceholder.text('请选择收货区域')
    }
    $dialogAddress.val(addressObj.address)
    $addrFormArea.show();
    $addrList.hide();
})
$mailAddrArea.on('click', '.mail_addr_cont', function () {
    $addrFormArea.hide();
    $addrList.show();
    if (isFristShowAddressLayer) {
        loadUserAddress(userAddressArr);
        $dialogAddrLoading.hide()
        isFristShowAddressLayer = false
    } else {
        $.each(changeAddressCache, function (aid, status) {
            var addressObj = userAddressCache[aid]
            var html = getUserAddrHtml(addressObj)
            if (status === 2) {
                $addrListCont.append(html)
            } else if(status === 1) {
                $addrListCont.find('.mail_add_list_item[data-id="' + aid + '"]').replaceWith(html)
            }
            delete changeAddressCache[aid]
        })
    }
    toshow($dialogAddr)
})
var $mailAddrType = $('.jfk-input__radio-mail')
$mailAddrType.on('change', function(){
    var val = $(this).val();
    if(val == 2){
        $giftProcess.show();
        $mailAddrArea.hide();
    }else {
        $giftProcess.hide();
        $mailAddrArea.show();
    }

})
// 如果赠送提示
$('.mail_gift_tip').on('click', function(){
    $.MsgBox.Alert('支付成功后，将礼包链接发送给微信好友，您的好友收礼即可领取礼物消费')
})
// 地址弹框上的事件

var formItems = {
    contact: '收件人',
    phone: '收件电话',
    'area': '收件区域',
    'address': '详细地址'
}
var mobileReg = /^1(\d{10})$/
var blackList = {
    area: 1,
    province_name: 1,
    city_name: 1,
    region_name: 1
}
var checkAddrForm = function() {
    var data = $addrForm.serializeArray();
    var addressId = data[0].value
    var errorItems = [];
    var errorItems2 = [];
    var result = {
        status: 1
    }
    var source = {}
    var service = {}
    var cache = userAddressCache[addressId]
    var i = 0
    $.each(data, function(index, item){
        if (item.value === '') {
            formItems[item.name] && errorItems.push(formItems[item.name])
        } else if (item.name === 'phone' && !mobileReg.test(item.value)) {
            errorItems2.push(',请输入正确的收件电话')
        } else {
            if (cache && (item.name === 'area' || item.value === cache[item.name])) {
                i++;
            }
            if (!blackList[item.name]) {
                service[item.name] = item.value
            }
            source[item.name] = item.value
        }
    })
    if (errorItems.length || errorItems2.length) {
        $.MsgBox.Alert('请输入' + errorItems.join('、') + errorItems2.join(''))
        result.status = 0
    } else {
        if (i === data.length) { // 说明未变动数据
            result.status = 2
        }
        result.source = source;
        result.service = service
    }
    return result;
}
var saveUserAddr = function (data, callback) {
    $.post(updateUserAddrUrl, data, function (res) {
        if (callback) {
            callback(res)
        }
    })
}
var showChooseAddress = function (addressId) {
    toclose($dialogAddr)
    $addressId.val(addressId)
    var addressObj = userAddressCache[addressId]
    var html = '<div class="webkitbox mail_addr_cont color_555 linkblock" data-id="'+addressObj.address_id+'"><div class="icon"><em class="iconfont">&#xe606;</em></div><div class="info"><p><span class="name">收货人：' + addressObj.contact + '</span><span class="phone">' + addressObj.phone + '</span></p><p>收货地址：' + addressObj.province_name + addressObj.city_name + (addressObj.region_name || '') + addressObj.address + '</p></div></div>'
    var $mailAddrCont = $mailAddrArea.find('.mail_addr_cont')
    if ($mailAddrCont.length) {
        $mailAddrCont.replaceWith(html)
    } else {
        $mailAddrArea.append(html)
    }
}
$dialogAddr.on('click', '.mail_addr_control .control', function(){
    var $that = $(this);
    var type = $that.data('type');
    if(type === 'add'){
        if (!hasLoadCities) {
            loadCityData();
        } else {
            $dialogAddressId.val('')
            $dialogProvince.val('')
            $dialogProvinceName.val('')
            $dialogCity.val('')
            $dialogCityName.val('')
            $dialogRegion.val('')
            $dialogRegionName.val('')
            $dialogName.val('')
            $dialogTel.val('')
            $dialogArea.val('')
            $dialogAreaPlaceholder.text('请选择收件区域')
            $dialogAddress.val('')
        }
        $addrFormArea.show();
        $addrList.hide();
    }else {
        var result = checkAddrForm()
        if (result.status === 1){
            $dialogAddrLoading.show();
            saveUserAddr($.param(result.service), function (res){
                $dialogAddrLoading.hide();
                if (res.status === 1) {
                    var isNewAddress = result.source.address_id == 0
                    var addressId =  isNewAddress ? res.data.address_id : result.source.address_id
                    userAddressCache[addressId] = result.source
                    changeAddressCache[addressId] = isNewAddress ? 2 : 1;
                    showChooseAddress(addressId)
                    $addAddressBtn.length &&  $addAddressBtn.remove()
                } else {
                    $.MsgBox.Alert(res.message)
                }
            })
        } else if (result.status === 2) { //未变更数据
            showChooseAddress(result.source.address_id)
        }
    }
})
</script>

</body>
</html>