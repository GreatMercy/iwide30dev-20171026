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

<div id="seckill-pay" style="margin-bottom: 60px;">
<?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
<!--<form action="" method="post">-->
<div class="mail_list">
    <div class="justify webkitbox bd_bottom mail_type" <?php if($package['can_mail'] == $packageModel::CAN_T && $package['can_gift'] == $packageModel::CAN_T){}else{ echo 'style="display:none;"'; }?>>
        <span class="mail_tip">使用方式</span>
        <div class="mail_list_type">
		<?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
            <label class="jfk-input__radio"><input type="radio" class="jfk-input__radio-mail" name="mail" checked value="1"><em class="uncheck"></em><em class="checked iconfont color_main">&#xe61e;</em><span>直接邮寄</span></label>
		<?php } ?>
		<?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
			<label class="jfk-input__radio">
                <?php $gift = false; ?>
                <?php if(isset($_REQUEST['gift']) && $_REQUEST['gift'] == 1): ?>
                  <?php $gift = true; ?>
                <?php endif; ?>
                <input type="radio" <?= $gift ? 'checked' : '' ?> class="jfk-input__radio-mail mail_type_gift" name="mail" value="2"/>
                <em class="uncheck"></em><em class="checked iconfont color_main">&#xe61e;</em><span>自提或微信转赠</span><span class="mail_gift_tip"><em>!</em>如何自提</span></label>
        <?php } ?>
		</div>
    </div>
    <div class="gift_process" style="display:<?= $gift ? 'block': 'none'?>">
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
	<?php if(isset($defaultAddress) && !empty($defaultAddress) && $package['can_mail'] == $packageModel::CAN_T){ ?>

    <div class="webkitbox mail_addr_cont color_555 linkblock" data-id="<?php echo $defaultAddress['address_id'];?>">
        <div class="icon">
            <em class="iconfont">&#xe606;</em>
        </div>
        <div class="info">
            <p><span class="name">收货人：<?php echo $defaultAddress['contact'];?></span><span class="phone"><?php echo $defaultAddress['phone'];?></span></p>
            <p>收货地址：<?php echo $defaultAddress['province_name'].$defaultAddress['city_name'].$defaultAddress['region_name'].$defaultAddress['address'];?></p>
        </div>
    </div>
	<?php }elseif($package['can_mail'] == $packageModel::CAN_T){ ?>
	<div class="linkblock webkitbox mail_addr" id="add_mail_address">
        <span class="bg_main mail_addr_icon">+</span><span>新增收货地址</span>
    </div>
	<?php }?>
    </div>
</div>
<?php } ?>

<?php if($package['can_mail'] != $packageModel::CAN_T){ ?>
<div class="header pd-19 bg-white border-bottom support_list">



      <?php if($package['can_refund'] == $packageModel::CAN_T){ ?>
              <div class="item fl f20 c555 box" tips="<?php echo $lang->line('after_buy_apply_refund');?>">
                  <span class="icon"></span>
                  <span><?php echo $lang->line('wechat_refund');?></span>
              </div>
      <?php } ?>

        <?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
            <div class="item fl f20 c555 box" tips="<?php echo $lang->line('after_buy_donated');?>">
                <span class="icon" ></span>
                <span><?php echo $lang->line('gift_a_friend');?></span>
            </div>
        <?php } ?>

          <?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
              <div  class="item fl f20 c555 box" tips="<?php echo $lang->line('goods_can_mail');?>">
                 <span class="icon" ></span>
                  <span><?php echo $lang->line('deliver_to_home');?></span>
              </div>
          <?php } ?>

          <?php if($package['can_pickup'] == $packageModel::CAN_T){ ?>
              <div class="item fl f20 c555 box" tips="<?php echo $lang->line('goods_support_shop_or_self');?>">
                  <span class="icon"></span>
                  <span><?php echo $lang->line('collect_from_hotel');?></span>
              </div>
          <?php } ?>

          <?php if($package['can_invoice'] == $packageModel::CAN_T){ ?>
              <div class="item fl f20 c555 box" tips="<?php echo $lang->line('enter_invoice_header_tip');?>">
                  <span class="icon"></span>
                  <span><?php echo $lang->line('invoice');?></span>
              </div>
          <?php } ?>

          <?php if($package['can_split_use'] == $packageModel::CAN_T){ ?>
              <div class="item fl f20 c555 box" tips="<?php echo $lang->line('can_be_used_splitting');?>">
                  <span class="icon"></span>
                  <span><?php echo $lang->line('multi_usage');?></span>
              </div>
          <?php } ?>

</div>
<?php } ?>

<form onsubmit="return _submit()">
  <!--
    <div class="order_list bd_bottom martop">
        <a href="<?php echo Soma_const_url::inst()->get_package_detail(array('pid'=>$package['product_id'],'id'=>$inter_id));?>" class="item bg_fff">
            <div class="item_left">
                <div class="img"><img src="<?php echo $package['face_img'];?>" /></div>
                <p class="txtclip"><?php echo $package['name'];?></p>
                <p class="txtclip"><?php echo $package['hotel_name'];?></p>
                <p class="txtclip color_main">秒杀价:<?php if($show_y_flag): ?><span class="y"><?php else: ?><span><?php endif; ?><?php echo $killsec['killsec_price'];?></span></p>
            </div>
        </a>
    </div>
    -->

      <a class="goods-detail box"  href="<?php echo Soma_const_url::inst()->get_package_detail(array('pid'=>$package['product_id'],'id'=>$inter_id));?>">
          <div class="goods-img">
              <img src="<?php echo $package['face_img'];?>" />
          </div>
          <div class="goods-info flex1">
              <p class="f26 c555 goods-name"><?php echo $package['name'];?></p>
              <p class="f24 c888">秒杀价：<?php if($show_y_flag): ?><span class="y"><?php else: ?><span><?php endif; ?><?php echo $killsec['killsec_price'];?></p>
          </div>
      </a>


<?php 
$buy_limit= intval($killsec['killsec_permax'])<1? 1: intval($killsec['killsec_permax']);
if(isset($cache_hash['max_stock']) && $cache_hash['max_stock'] != $buy_limit ) $buy_limit =  $cache_hash['max_stock'];
$buy_default= 1; //默认买几个？
?>

<!--
<ul class="list_style_2 bd martop" id="select_num">

    <li class="arrow webkitbox justify">
        <span>
        <?php echo $lang->line('purchase_quantity');?>
        <tt class="btn_main btn_small"> <?php echo str_replace('[0]', $buy_limit, $lang->line('limit_num'));?></tt>
        </span>
        <input class="color_888" type="tel" value="<?php echo $buy_default; ?>" id="buy_num" readonly>
    </li>

    <li class="justify webkitbox">
        <span><?php echo $lang->line('purchase_validity');?></span>
        <span><span id="timeLeft"><?php echo $lang->line('remain');?></span></span>
    </li>

</ul> -->

<div class="number bg-white box pr">
      <div class="title f26 c555"><?php echo $lang->line('purchase_quantity');?></div>

      <div class="limit pr">
          <span class="bgff9900 f20"><?php echo str_replace('[0]', $buy_limit, $lang->line('limit_num'));?></span>
      </div>
      
      <!--
      <div class="num_control bd webkitbox" style="float:right">
              <div class="down_num bd_left">-</div>
              <div class="result_num bd_left"><input id="selece_num" value="<?php echo $buy_default; ?>" type="tel" min="1" max="<?php echo $buy_limit; ?>"></div>
              <div class="up_num bd_lr">+</div>
      </div> -->

      <div class="flex1">
          <div class="number-input">
              <div class="reduce pr fl pr"></div>
              <div class="fl f24 number-mask" style="height:24px;width: 52px;">
                   <input type="number" class="fl f24" value="<?php echo $buy_default; ?>"  id="buy_num" max="<?php echo $buy_limit; ?>">
              </div>
              <div class="increase fl pr"></div>
          </div>
      </div>
</div>

 <!-- 下单时间 -->
    <div class="order-time mt-16 bg-white box">
        <div class="title f26 c555"><?php echo $lang->line('purchase_validity');?></div>
        <div class="title ta-r cff9900 f22 flex1" id="timeLeft"><?php echo $lang->line('remain');?></div>
    </div>
 <!-- 下单时间 -->


 <div class="ui_pull area_pull" style="display:none">
    <div class="relative _w" style="height:100%;">
        <div class="area_box bg_fff absolute _w">
            <div class="webkitbox justify pad10" style="margin-top:0">
                <span><?php echo $lang->line('purchase_quantity');?></span>
                <span>
                    <div class="num_control bd webkitbox" style="float:right">
                        <div class="down_num bd_left">-</div>
                        <div class="result_num bd_left"><input id="selece_num" value="<?php echo $buy_default; ?>" type="tel" min="1" max="<?php echo $buy_limit; ?>"></div>
                        <div class="up_num bd_lr">+</div>
                    </div>
                </span>
            </div>
            <div class="sure_btn btn_main _w pad12"><?php echo $lang->line('confirm');?></div>
        </div>
    </div>
</div>


<!-- 填写订单 -->
<ul class="mt-16 bg-white">
    <li class="box border-bottom">
        <div class="title f26 c555">联<span class="em">系</span>人</div>
        <input type="text" class="f24 flex1" placeholder="<?php echo $lang->line('enter_a_contact');?>" value="<?php echo $customer_info['name']; ?>" id="name">
    </li>

    <li class="box">
        <div class="title f26 c555">手机号码</div>
        <input type="tel" class="f24 flex1" placeholder="<?php echo $lang->line('enter_phone_number');?>" maxlength="11" value="<?php echo $customer_info['mobile']; ?>" id="phone">
    </li>
</ul>
<!-- 填写订单 -->


<!--
<ul class="list_style_1 bd  martop">
    <li class="justify webkitbox">
        <span><?php echo $lang->line('contacts');?></span>
        <input type="text" id="name" name='name' placeholder="<?php echo $lang->line('enter_a_contact');?>" maxlength="20" value="<?php echo $customer_info['name']; ?>">
    </li>
    <li class="justify webkitbox">
        <span><?php echo $lang->line('contacts_phone_number');?></span>
        <input type="tel" id="phone" name="phone" placeholder="<?php echo $lang->line('enter_phone_number');?>" maxlength="11" value="<?php echo $customer_info['mobile']; ?>">
    </li>
</ul> -->

<input type="hidden" name="orderId">
<?php if($package['type'] != $packageModel::PRODUCT_TYPE_BALANCE): ?>

  <!-- <div class="pay bg_fff bd martop block">
      <div class="pay_means bd_bottom"><?php echo $lang->line('payment_method');?></div>
      <div class="pay_way list_style_1">
          <div class="item wxpay justify webkitbox">
              <span><?php echo $lang->line('wechat_pay');?></span>
              <span><input class="hide" checked type="radio"  name="pay_way" />
              <div class="radio"><div></div></div></span>
          </div>
      </div>
  </div> -->

  <ul class="mt-16 pay-way bg-white">
      <li class="box border-bottom">
          <div class="title f26 c555"><?php echo $lang->line('payment_method');?></div>
      </li>
      <li class="box">
          <div class="title f26 c555"><?php echo $lang->line('wechat_pay');?></div>
          <input class="hide" checked type="radio"  name="pay_way" />
          <div class="flex1 pr choice active">
              <span class="pa"></span>
          </div>
      </li>
   </ul>


<?php else: ?>

<!--- 修改 -->

<!-- <div class="pay bg_fff bd martop block">
    <div class="pay_means bd_bottom"><?php echo $lang->line('payment_method');?></div>
    <div class="pay_way list_style_1">
        <div class="balancepay item justify webkitbox">
            <span><?php echo $lang->line('stored_balance');?>(<?php echo isset($balance) ? $balance : 0; ?>)</span>
            <span><input class="hide" checked type="radio"  name="pay_way" />
            <div class="radio"><div></div></div></span>
        </div>
    </div>
</div> -->

 <ul class="mt-16 pay-way bg-white">
      <li class="box border-bottom">
          <div class="title f26 c555"><?php echo $lang->line('payment_method');?></div>
      </li>
      <li class="box">
          <div class="title f26 c555"><?php echo $lang->line('stored_balance');?>(<?php echo isset($balance) ? $balance : 0; ?>)</div>
          <input class="hide" checked type="radio"  name="pay_way" />
          <div class="flex1 pr choice active">
              <span class="pa"></span>
          </div>
      </li>
 </ul>


<?php if($show_balance_passwd == Soma_base::STATUS_TRUE): ?>
<ul class="list_style_1 bd  martop">
    <li class="justify webkitbox">
        <span>
            <?php echo $lang->line('store_password');?>
        </span>
        <input type="text" id="bpay_passwd" name="bpay_passwd" placeholder="<?php echo $lang->line('enter_password_first');?>" >
    </li>
</ul>
<?php endif; ?>
<?php endif; ?>
    <!--div class="color_888 martop pad3" id="how_sent">温馨提示：如果您是第一次购买或有疑惑，请<span class="color_main">点击此处</span></div-->
    <div class="foot_fixed">
        <div class="bg_fff foot_fixed_list bd_top">
            <div class="pad10" style="text-align:left">
                <?php echo $lang->line('real_pay');?>：
                <span class="<?php if($show_y_flag): ?>y<?php endif; ?> color_main" id="grandTotal">
                    <?php echo $killsec['killsec_price']*$buy_default;?>
                </span>
            </div>
            <?php if( $is_expire ): ?>
            	<button class="h30 bg_main pad10 bg_C3C3C3" type="button"><?php echo $lang->line('expired');?></button>
            <?php else: ?>
                <button class="h30 bg_main pad10" type="button" onClick="_submit()"><?php echo $lang->line('buy_now');?></button>
            <?php endif; ?>
        </div>
    </div>
</form>

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

<div class="ui_pull" id="layout_tips" onclick="$(this).remove()">
    <div class="pullbox bg_fff">
        <div class="pulltitle h30"><?php echo $lang->line('get_qualification');?></div>
        <div style="text-align:justify"><?php echo $lang->line('pay_in_five_minute_tip');?></div>
        <div class="webkitbox center">
        	<div><div class="btn_main"><?php echo $lang->line('confirm')?></div></div>
        </div>
    </div>
</div>

<!-- <div style="padding-top:20%"></div> -->

  </div>
</div>

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
$(function(){
    $('#how_sent').click(function(){
        toshow($('.how_sent_pull'));
    })
    $('.how_sent_pull').click(toclose)

    $('.pay_way .item').click(function(){
        $(this).addClass('choose').siblings().removeClass('choose');
        $('input',this).get(0).checked=true;
    })

    $('#select_num').click(function(){
        toshow($('.area_pull'));
        $('.area_box').stop().animate({'bottom':0});
    });
    $('.area_box').click(function(e){e.stopPropagation();});
    $('.sure_btn').click(function(){
		var buy_num = parseInt($('#selece_num').val());
        $('#buy_num').val(buy_num);
        var tmp = buy_num*<?php echo $killsec['killsec_price'];?>;
        $('#grandTotal').html(tmp.toFixed(2));
        toclose();
    })
});
  
    $('.increase').on('click', function() {
        var select_num = $('#buy_num');
        var max = parseInt(select_num.attr('max'));
        var number = parseInt($('#buy_num').val());
        number = number + 1 ;
        if (number >= max) {
          number = max;
        }
        var tmp = number*<?php echo $killsec['killsec_price'];?>;
        $('#grandTotal').html(tmp.toFixed(2));
        select_num.val(number)
    });

    $('.reduce').on('click', function(){
        var select_num = $('#buy_num');
        var number = parseInt($('#buy_num').val());
        number = number - 1 ;
        if (number <= 1) {
          number = 1;
        }
        var tmp = number*<?php echo $killsec['killsec_price'];?>;
        $('#grandTotal').html(tmp.toFixed(2));
        select_num.val(number)
    });

    var _submit = function(){
        if( $('#name').val()=='' ){
            $.MsgBox.Confirm('<?php echo $lang->line('enter_a_contact');?>',null,null, '<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');return false;
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

        var payUrl = '<?php echo Soma_const_url::inst()->go_to_pay( array('id'=> $this->inter_id) ); ?>';
        var wftPayUrl = '<?php echo Soma_const_url::inst()->wft_go_to_pay( array('id'=> $this->inter_id ) );//订单生产请求地址?>';

        var bpay_passwd = $('#bpay_passwd').val();
        var pQty = parseInt($('#buy_num').val());
        if(isNaN(pQty)){
            $.MsgBox.Confirm('<?php echo $lang->line('number_incorrect');?>!',null,null,'<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
            return false;
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
        <?php endif; ?>

        pageloading('<?php echo $lang->line('generate_order');?>',0.2);
		
		var ajaxData = {
            business: 'package',
            settlement: 'killsec',
            hotel_id: '<?php echo $package['hotel_id'];?>',
            qty : {<?php echo $_GET['pid'];?>:parseInt(pQty)},
            name : $('#name').val(),
            phone : $('#phone').val(),
            orderId : $('#orderId').val(),
            mcid: $('#mcid').val(),
            saler: '<?php echo isset($saler_self)? $saler_self: $saler; ?>',
            fans_saler: '<?php echo isset($fans_saler_self)? $fans_saler_self: $fans_saler; ?>',
            fans: '<?php echo $fans; ?>',
            product_id : <?php echo $killsec['product_id']; ?>,
            act_id  : <?php echo $killsec['act_id']; ?>,
            token : '<?php echo $_GET['token']; ?>',
            bpay_passwd: bpay_passwd,
            inid : '<?php echo $_GET['instance_id']; ?>'
        }
        if (userAddressArr !== null && $('[name="mail"]').filter(':checked').val() === '1') {
            ajaxData.address_id = $addressId.val()
        }
		
        $.ajax({
			async: true,
            type: 'POST',
			timeout : 10000,
            url: '<?php echo Soma_const_url::inst()->get_prepay_order_ajax();?>',
            data: ajaxData,
            success: function (data) {
                if (data.status == 1) {
                   if(data.step =='wxpay'){
                        location.href = payUrl+'&order_id='+data.data.orderId;
                    }else if(data.step == 'wft_pay'){
                        location.href = wftPayUrl+'&order_id='+data.data.orderId;
                    }else{
                        location.href = '<?php echo  Soma_const_url::inst()->get_payment_package_success(array('id'=>$inter_id));?>'+ "&order_id=" + data.data.orderId;
                    }
                } else if (data.status == 2) {
                    $('.pageloading').remove();
                    //失败
                    $.MsgBox.Confirm(data.message,null,null, '<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
                    return false;
                }
            },
			error: function() {
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
		　　complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
		　　　　if(status=='timeout'){//超时,status还有success,error等值的情况
					$('.pageloading').remove();
					$.MsgBox.Confirm('<?php echo $lang->line('order_overtime_try_again_tip');?>',function(){
						//if(e.status == 302||e.status == 307) {
							window.location.reload();
						//}		
					},function(){
							window.location.reload();
					}, '<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
		　　　　}
		　　},
			timeout: function() {
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
            dataType: 'json'
        });
        return false;
    }

    var oTime = '<?php echo date('Y/m/d H:i:s',strtotime($cache_hash['create_at'])); ?>';
    var startFlag = false;
    /*秒杀倒计时*/
    function countdownTime(Time){
        var endTime=new Date(Time);
        var nowTime=new Date();
        var s_time=endTime-nowTime + 300000;
        var end_date=parseInt((s_time/1000)/86400);
        var end_hour=parseInt((s_time/1000)%86400/3600);
        var end_minute=parseInt((s_time/1000)%3600/60);
        var end_second=parseInt((s_time/1000)%60);
        return {
            j_date : end_date,
            j_hour : end_hour,
            j_minute : end_minute,
            j_second : end_second,
            j_rest  : s_time
        }
    }
    calcStrObj = countdownTime(oTime);
//    $('#timeLeft').html()
    var calcObj = $('#timeLeft');
    calcObj.time=setInterval(function(){
        if(calcStrObj.j_rest <= 0 ){
            $('#timeLeft').html('<?php echo $lang->line('time_out');?>');
            clearInterval(calcObj.time);
            return false;
        }
        calcStrObj = countdownTime(oTime);
        $('#timeLeft').html('<?php echo $lang->line('remain');?>  ' + calcStrObj.j_minute + ' <?php echo $lang->line('min'); ?> ' + calcStrObj.j_second +' <?php echo $lang->line('sec'); ?>');
    },1000)
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
    $.MsgBox.Alert('购买成功后，您将获得12位券码，提供给商家即可自提商品')
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