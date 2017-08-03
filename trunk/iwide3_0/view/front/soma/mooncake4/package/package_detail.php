<?php
// 是否显示¥符号
$show_y_flag = true;
if($package['type'] == $packageModel::PRODUCT_TYPE_POINT)
{
    $show_y_flag = false;
}
?>
<body>
<link href="<?php echo base_url('public/soma/v1/v1.css'). config_item('css_debug');?>" rel="stylesheet">
<script src="<?php echo base_url('public/soma/scripts/imgscroll.js');?>"></script>
<script src="<?php echo base_url('public/soma/scripts/jquery.touchwipe.min.js');?>"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $wx_config["appId"]?>',
        timestamp: <?php echo $wx_config["timestamp"]?>,
        nonceStr: '<?php echo $wx_config["nonceStr"]?>',
        signature: '<?php echo $wx_config["signature"]?>',
        jsApiList: [<?php echo $js_api_list; ?>,'getLocation','openLocation']
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

        <?php if($inter_id != 'a455510007'): //速8需要隐藏 ?>

        <?php if( !empty($package['latitude']) && !empty($package['longitude'])): ?>
        document.querySelector('#openLocation').onclick = function () {
            wx.openLocation({
                latitude:<?php echo $package['latitude'];?>,
                longitude:<?php echo $package['longitude'];?>,
                name: '<?php echo $package['hotel_name'];?>',
                address: '<?php echo $package['hotel_address'];?>',
                scale: 14,
                infoUrl: 'http://weixin.qq.com'
            });
        };
        <?php endif; ?>

        <?php endif; ?>

    });
</script>
    <!--通知面板-->
    <div id="goodsDetail">
        <?php if(!empty($effective_rule) && !empty($saler_info) && !in_array($this->inter_id, $idistributInterId)): ?>
            <?php
            $fanName = '亲爱的用户：';
            if($saler_info['saler_type'] == 'FANS'){
                if(!empty($saler_info_by_id['name'])){
                    $fanName = '亲爱的'.$saler_info_by_id['name'].'：';
                }
            }
            else{
                $fanName = '亲爱的'.$saler_info['saler_name'].'：';
            }
            ?>
        <div class="tips box">
            <div class="tips-left"></div>
            <div class="tips-right flex1 f24">
                <?= $fanName ?>
            分享本产品，您的好友购买成功后，您将获得
            <?php if($effective_rule['reward_type'] == Reward_rule_model::REWARD_TYPE_PERCENT): ?>
                订单<?php endif; ?><span class="haoma"><?php echo $effective_rule['reward_rate']; ?></span>
            <?php if($effective_rule['reward_type'] == Reward_rule_model::REWARD_TYPE_PERCENT): ?>
                <span class="percent">%</span><?php else: ?>元<?php endif; ?>红包奖励，<?php if($saler_info['saler_type'] == 'FANS'): ?>
                隔天发至您的微信钱包<?php else: ?>由酒店发放<?php endif; ?>
            </div>
        </div>
        <?php endif; ?>


    <!--轮播图-->
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php if(!empty($gallery)): ?>
                    <?php foreach($gallery as $k => $v){?>
                        <?php if($v['gry_url']): ?>
                            <div class="swiper-slide">
                                <a><img src="<?php echo $v['gry_url'];?>" /></a>
                            </div>
                        <?php endif;?>
                    <?php }?>
                <?php else: ?>
                    <a>
                        <img src="<?php echo base_url('public/soma/images/default.jpg'); ?>" />
                    </a>
                <?php endif; ?>
            </div>

            <div class="swiper-pagination"></div>

        </div>
    </div>

    <!--商品详情-->
    <div class="detail">

        <!--秒杀-->
        <?php if(isset($killsec) && !empty($killsec)):?>
            <?php if($killsec['killsec_time'] < date('Y-m-d H:i:s', time())){ ?>
                <?php
                   $restTime = strtotime($killsec['end_time']) * 1000;
                ?>
                <!--距离结束还有-->
                <div class="countdown box">
                    <div class="countdown-title f24"><?= $lang->line('end_of_distance') ?></div>
                    <div class="countdown-content f28" countdown="<?= $restTime ?>" id="countdown"></div>
                </div>
            <?php } else{ ?>
                <div class="countdown box">
                    <!--距离开始还有-->
                    <div class="countdown-title f24"><?= $lang->line('start_of_distance') ?></div>
                    <div class="countdown-content f28" countdown="<?= $killsec['killsec_countdown'] ?>" id="countdown"></div>
                </div>
            <?php } ?>
        <?php endif;?>

        <div class="title f34">
            <?php echo $package['name'];?>
        </div>

        <div class="number box f24">
            <div class="sub-title"> <?php echo $lang->line('sold'); ?></div>
            <div><?php echo $package['sales_cnt']; ?></div>&nbsp;&nbsp;
            <!--秒杀-->
            <?php if(isset($killsec) && !empty($killsec)):?>
                <div class="sub-title"><?= $lang->line('remaining_quota') ?></div>
                <div><span id="currentNumber"></span>/<span class="f20" id="total"></span></div>
                <div class="progress flex1">
                    <div id="progress"></div>
                </div>
            <?php endif;?>
        </div>

        <div class="price-wrap">
            <div class="price">
                <span class="symbol f28">¥</span>
                <span class="f46">
                    <?php if(isset($killsec) && !empty($killsec)):?>
                          <?php echo $killsec['killsec_price'];?>
                        <?php else:?>
                       <?php echo $package['price_package'];?>
                    <?php endif; ?>
                </span>
                <span class="original f24">¥ <?php echo $package['price_market'];?></span>
            </div>
        </div>


        <!--选择商品款式-->
        <?php if($spec_product) : ?>
            <?php if(isset($isTicket ) && !$isTicket):?>
                <?php
                $spec_compose = isset( $psp_summary['spec_compose'] ) ? json_decode($psp_summary['spec_compose'], true) : '';
                $spec_type = isset( $spec_compose['spec_type'] ) ? implode(' ',  $spec_compose['spec_type'] ) : '';
                ?>
                <div class="selected box" id="selectSpec" <?php if(!$spec_product): ?> style="display:none" <?php endif; ?>>
                    <div class="f28" id="selected"><span><?php echo $lang->line('choose') . ' ' . $spec_type; ?></span><!--大三元经典款月饼礼盒套餐一--></div>
                    <div class="flex1"></div>
                </div>
            <?php else:?>
                <input type="hidden" name="gift" value="<?php echo Soma_const_url::inst()->get_url('*/*/ticket_select_time',array('id'=>$inter_id,'pid'=>$_GET['pid'],'tkid'=>$ticketId)); ?>" />
                <a href="<?php echo Soma_const_url::inst()->get_url('*/*/ticket_select_time',array('id'=>$inter_id,'pid'=>$_GET['pid'],'tkid'=>$ticketId)); ?>">
                    <div class="selected box" <?php if(!$spec_product): ?> style="display:none" <?php endif; ?>>
                        <div class="f28" id="selected"><span>请选择门票时间：</span><!--大三元经典款月饼礼盒套餐一--></div>
                    </div>
                </a>
            <?php endif;?>
        <?php endif;?>


        <!--服务标签-->
        <div class="service box">

            <?php $hasOne = false; ?>

            <?php if($package['can_refund'] != $packageModel::CAN_REFUND_STATUS_FAIL && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE && $package['type'] != $packageModel::PRODUCT_TYPE_POINT): ?>
                <div class="item flex1">
                    <p class="icon icon2"></p>
                    <p class="text f24 ta-c">
                        <?php if($package['can_refund'] == $packageModel::CAN_REFUND_STATUS_SEVEN): ?>
                            <?php echo $lang->line('7_refund_day');?>
                        <?php else: ?>
                            <?php echo $lang->line('refund_any_time');?>
                        <?php endif; ?>
                    </p>
                </div>
                <?php $hasOne = true; ?>
            <?php endif; ?>

            <?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
                <div class="item flex1">
                    <p class="icon icon4"></p>
                    <p class="text f24 ta-c"><?php echo $lang->line('gift_a_friend'); ?></p>
                </div>
                <?php $hasOne = true; ?>
            <?php } ?>

            <?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
                <div class="item flex1">
                    <p class="icon icon3"></p>
                    <p class="text f24 ta-c"><?php echo $lang->line('deliver_to_home'); ?></p>
                </div>
                <?php $hasOne = true; ?>
            <?php } ?>

            <?php if($package['can_pickup'] == $packageModel::CAN_T){ ?>
                <div class="item flex1">
                    <p class="icon icon5"></p>
                    <p class="text f24 ta-c"><?php echo $lang->line('collect_from_hotel'); ?></p>
                </div>
                <?php $hasOne = true; ?>
            <?php } ?>

            <?php if($package['can_invoice'] == $packageModel::CAN_T){ ?>
                <div class="item flex1">
                    <p class="icon icon6"></p>
                    <p class="text f24 ta-c"><?php echo $lang->line('invoice'); ?></p>
                </div>
                <?php $hasOne = true; ?>
            <?php } ?>

            <?php if($package['can_split_use'] == $packageModel::CAN_T){ ?>
                <div class="item flex1">
                    <p class="icon icon1"></p>
                    <p class="text f24 ta-c"><?php echo $lang->line('multi_usage'); ?></p>
                </div>
                <?php $hasOne = true; ?>
            <?php } ?>

            <?php if($hasOne): ?>
                <div class="item flex1 more" id="more">
                    <p class="icon"></p>
                    <p class="text f24 ta-c"></p>
                </div>
            <?php endif;?>

        </div>

    </div>

    <!--切换面板-->
    <div class="tabs clearfix" id="tabs">
        <a href="javascript:void(0)" class="fl pr f32 ta-c active">
            <?php echo $lang->line('details');?>
        </a>
        <a href="javascript:void(0)" class="fl pr f32 ta-c">
            <?php echo $lang->line('terms_and_conditions');?>
        </a>
    </div>
    <div class="pic-content" style="display: block;">
        <?php echo $package['img_detail'];?>
    </div>
    <div class="pic-content">
        <?php echo $package['order_notice']; ?>
    </div>

    <!--初始化-->
    <script>
        var canBuy = true, startFlag = false;
        <?php if(isset($isTicket) && !$isTicket):?>
        canBuy = false;
        <?php endif;?>
    </script>

    <!--购买按钮-->
    <footer>
        <div class="clearfix">
            <div class="cell fl box">
                <a href="<?php echo Soma_const_url::inst()->get_url('*/*/index',array('id'=>$inter_id,'openid'=>$this->openid)); ?>" class="flex1">
                    <p class="icon homepage"></p>
                    <p class="ta-c f20 text"><?php echo $lang->line('home'); ?></p>
                </a>
                <a href="<?php echo Soma_const_url::inst()->get_url('*/order/my_order_list',array('id'=>$inter_id)); ?>" class="flex1">
                    <p class="icon order"></p>
                    <p class="ta-c f20 text"><?php echo $lang->line('order'); ?></p>
                </a>
                <?php if($package['can_gift'] == $packageModel::CAN_T): ?>
                    <a href="javascript:;" class="flex1 mail_gift_tip">
                        <p class="icon gift"></p>
                        <p class="ta-c f20 text"><?php echo $lang->line('gift'); ?></p>
                    </a>
                <?php endif;?>
            </div>


            <?php if($is_expire): ?>
                <a href="javascript:void(0)" class="fl ta-c f32 btn"><?php echo $lang->line('expired'); ?></a>
            <?php elseif(!isset($killsec) || empty($killsec)) : ?>
                <?php if(isset($isTicket) && !$isTicket): ?>
                    <?php
                    $buyTitle = null;
                    if(isset($package['scopes']) && isset($package['scopes'][0])) {
                        $buyTitle = $package['scopes'][0]['price'];
                    }
                    else{
                        $buyTitle = $package['price_package'];
                    }

                    if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE) {
                        $buyTitle .= $lang->line('soted_value_buy');
                    } elseif($package['type'] == $packageModel::PRODUCT_TYPE_POINT) {
                        $buyTitle .= $lang->line('point_buy');
                    } else {
                        if(isset($package['scopes']) && isset($package['scopes'][0]) ) {
                            $buyTitle .= $lang->line('exclusive_buy');
                        } else {
                            $buyTitle .= $lang->line('buy_now');
                        }
                    }
                    ?>
                    <input type="hidden" name="select_type" value="<?php echo Soma_const_url::inst ()->get_package_pay(array('pid'=>$_GET['pid'],'id'=>$inter_id,'bType'=>$bType));?>" />
                    <a href="javascript:void(0)" class="fl ta-c f32 btn" id="buy"><?php echo $buyTitle; ?></a>
                <?php else:?>
                    <?php
                    $buyTitle = null;
                    if(isset($package['scopes']) && isset($package['scopes'][0]) ) {
                        //$buyTitle = $package['scopes'][0]['price'];
                    } else {
                        //$buyTitle = $package['price_package'];
                    }
                    if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE) {
                        $buyTitle .= $lang->line('soted_value_buy');
                    } elseif($package['type'] == $packageModel::PRODUCT_TYPE_POINT) {
                        $buyTitle .= $lang->line('point_buy');
                    } else {
                        if(isset($package['scopes']) && isset($package['scopes'][0]) ) {
                            $buyTitle .= $lang->line('exclusive_buy');
                        } else {
                            $buyTitle .= $lang->line('buy_now');
                        }
                    }
                    ?>
                    <a href="<?php echo Soma_const_url::inst()->get_url('*/*/ticket_select_time', array('id'=>$inter_id,'pid'=>$_GET['pid'],'tkid'=>$ticketId,'bType'=>$bType)); ?>" class="fl ta-c f32 btn"><?php echo $buyTitle; ?></a>
                    <input type="hidden" name="gift" value="<?php echo Soma_const_url::inst()->get_url('*/*/ticket_select_time', array('id'=>$inter_id,'pid'=>$_GET['pid'],'tkid'=>$ticketId,'bType'=>$bType)); ?>" />
                <?php endif; ?>
            <?php endif; ?>

            <?php if(isset($finish_killsec) && $finish_killsec): ?>
                <a href="javascript:void(0)" class="fl ta-c f32 btn"><?php echo $lang->line('sold_out');?></a>
            <?php elseif(isset($killsec) && !empty($killsec)): ?>
            <input type="hidden" name="select_type" value="<?php echo Soma_const_url::inst ()->get_package_pay(array('pid'=>$_GET['pid'],'id'=>$inter_id,'bType'=>$bType));?>" />
            <?php if($killsec['killsec_time'] < date('Y-m-d H:i:s', time())){ ?>
                <a id="killsec_btn" href="javascript:void(0)" class="fl ta-c f32 btn"><?php echo $lang->line('flash_sale_in_progress'); ?></a>
                <script>
                    startFlag = true;
                </script>
            <?php }
            else{ ?>
                <a id="killsec_btn" class="fl ta-c f32 btn">
                    <?php if($show_y_flag):?>¥<?php endif; ?><?php echo $killsec['killsec_price'];?>
                    <?php
                    if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE) {
                        echo $lang->line('soted_value_buy');
                    }
                    elseif($package['type'] == $packageModel::PRODUCT_TYPE_POINT) {
                        echo $lang->line('point_buy');
                    }
                    else {
                        echo $lang->line('flash_sale_buy');
                    }
                    ?>
                </a>
            <?php } ?>
            <?php elseif(!empty($groupons) && !$is_expire): ?>
            <?php foreach($groupons as $k=>$v): ?>
                <input type="hidden" name="gift" value="<?php echo Soma_const_url::inst ()->get_groupon_first_pay(array('act_id'=>$v['act_id'],'id'=>$inter_id,'bType'=>$bType));?>" />
                <a href="<?php echo Soma_const_url::inst ()->get_groupon_first_pay(array('act_id'=>$v['act_id'],'id'=>$inter_id,'bType'=>$bType));?>"
                   class="h24 bg_main bdradius txtclip"  style="border: 1px solid transparent">
                    <?php if($show_y_flag):?>¥<?php endif; ?>
                    <?php echo $v['group_price'];?> | <?php echo $v['group_count'] . ' ' . $lang->line('person_group');?>
                </a>
            <?php break; endforeach; ?>
            <?php elseif( isset($auto_rule[0]) ): ?>
                <input type="hidden" name="gift" value="<?php echo Soma_const_url::inst()->get_package_pay(array('pid'=>$_GET['pid'], 'id'=>$inter_id, 'rid'=>$auto_rule[0]['rule_id'], 'bType'=>$bType )); ?>" />
                <a class="h24 bg_main bdradius txtclip" style="border: 1px solid transparent" href="<?php echo Soma_const_url::inst()->get_package_pay(array('pid'=>$_GET['pid'], 'id'=>$inter_id, 'rid'=>$auto_rule[0]['rule_id'], 'bType'=>$bType )); ?>">
                    <?php echo $lang->line('group_purchase'); ?>
                </a>
            <?php endif; ?>

            <?php if(isset($package['scopes']) && isset($package['scopes'][0]) ) : ?>
                <div class="zhuanshujia">
                    <?php echo str_replace('[0]', $package['social']['name'], $lang->line('exclusive_tip')); ?>
                </div>
            <?php endif; ?>

        </div>
    </footer>

    <!--商品款式-->
    <?php if($spec_product): ?>
        <?php
        $low_price = $psp_setting[$package['product_id']][0]['spec_price'];
        $high_setting = end($psp_setting[$package['product_id']]);
        $high_price = $high_setting['spec_price'];
        ?>
        <div class="popup" id="specPopup">
            <a href="javascript:void(0)" class="buy-now f32" id="buyNow" disabled="true">立即支付</a>
            <div class="popup-wrap pr">
                <div class="popup-header">
                    <a href="javascript:void(0)" class="fr"></a>
                </div>

                <div class="popup-content">
                    <div class="spec-wrap">

                        <div class="goods-detail">
                            <div class="box">
                                <div class="img"><img src="<?php if( $package['face_img'] )echo $package['face_img'];else echo base_url('public/soma/images/default2.jpg');?>" /></div>
                                <div class="info flex1">
                                    <p class="name f30"><?php echo $package['name'];?></p>
                                    <p class="price">
                                        <span class="f24">￥<?= $low_price; ?> ～ </span><span class="f24">￥<?= $high_price; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="spec-box"></div>
                    </div>
                </div>

            </div>
        </div>
    <?php endif;?>

    <!--服务说明-->
    <div class="popup" id="servicePopup">
        <div class="popup-wrap pr">
            <div class="popup-header">
                <a href="javascript:void(0)" class="fr"></a>
            </div>

            <div class="popup-content">
                <div class="service-title ta-c"><?php echo $lang->line('service_note');?></div>
                <ul class="service-list">

                    <?php if($package['can_refund'] != $packageModel::CAN_REFUND_STATUS_FAIL && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE && $package['type'] != $packageModel::PRODUCT_TYPE_POINT): ?>
                        <li class="box">
                            <div class="icon icon2"></div>
                            <div class="service-content flex1">
                                <p class="f28 title">
                                    <?php if($package['can_refund'] == $packageModel::CAN_REFUND_STATUS_SEVEN): ?>
                                        <?php echo $lang->line('7_refund_day');?>
                                    <?php else: ?>
                                        <?php echo $lang->line('refund_any_time');?>
                                    <?php endif; ?>
                                </p>
                                <p class="f28 service-item">
                                    <?php if($package['can_refund'] == $packageModel::CAN_REFUND_STATUS_SEVEN): ?>
                                        <?php echo $lang->line('7_refund_day');?>
                                    <?php else: ?>
                                        <?php echo $lang->line('refund_any_time');?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
                        <li class="box">
                            <div class="icon icon4"></div>
                            <div class="service-content flex1">
                                <p class="f28 title"><?php echo $lang->line('gift_a_friend'); ?></p>
                                <p class="f28 service-item"><?php echo $lang->line('after_buy_donated'); ?></p>
                            </div>
                        </li>
                    <?php } ?>

                    <?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
                        <li class="box">
                            <div class="icon icon3"></div>
                            <div class="service-content flex1">
                                <p class="f28 title"><?php echo $lang->line('deliver_to_home'); ?></p>
                                <p class="f28 service-item"><?php echo $lang->line('goods_can_mail'); ?></p>
                            </div>
                        </li>
                    <?php } ?>

                    <?php if($package['can_pickup'] == $packageModel::CAN_T){ ?>
                        <li class="box">
                            <div class="icon icon5"></div>
                            <div class="service-content flex1">
                                <p class="f28 title"><?php echo $lang->line('collect_from_hotel'); ?></p>
                                <p class="f28 service-item"><?php echo $lang->line('goods_support_shop_or_self'); ?></p>
                            </div>
                        </li>
                    <?php } ?>

                    <?php if($package['can_invoice'] == $packageModel::CAN_T){ ?>
                        <li class="box">
                            <div class="icon icon6"></div>
                            <div class="service-content flex1">
                                <p class="f28 title"><?php echo $lang->line('invoice'); ?></p>
                                <p class="f28 service-item"><?php echo $lang->line('purchase_can_invoice'); ?></p>
                            </div>
                        </li>
                    <?php } ?>

                    <?php if($package['can_split_use'] == $packageModel::CAN_T){ ?>
                        <li class="box">
                            <div class="icon icon1"></div>
                            <div class="service-content flex1">
                                <p class="f28 title"><?php echo $lang->line('multi_usage'); ?></p>
                                <p class="f28 service-item"><?php echo $lang->line('can_be_used_splitting'); ?></p>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>

    <!--弹窗-->
    <div class="kill-layer" style="display: none" id="subscribe">
        <div class="container">
            <p class="content f24" id="subscribeMsg">您已订阅成功，我们将在活动开始前10分钟内通知您</p>
            <div class="btn-group">
                <a href="javascript:void(0)" class="btn f24 fl">取消</a>
                <a href="javascript:void(0)" class="btn f24 active fr">好的</a>
            </div>
        </div>
    </div>
    <div class="kill-layer" style="display: none" id="qrcode">
        <div class="container">
            <p class="content f24" id="qrcodeMsg">您已订阅成功，长按二维码关注，确保能及时获得提醒</p>
            <div class="qrcode-container">
                <div class="qrcode">
                    <img src="" alt="">
                </div>
            </div>
            <p class="cff9900 f24 tips">长按关注，及时获得模版提醒</p>
        </div>
    </div>

   </div>
</body>

<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/fastclick.js');?>"></script>
<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/moment.js');?>"></script>
<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/public.js');?>"></script>
<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/detail.js');?>"></script>

<script>

    //库存进度条
    <?php if(isset($killsec) &&  !empty($killsec)):?>
    function fill_progress(){
        $.post('<?php echo Soma_const_url::inst()->get_url('*/killsec/find_killsec_stock_ajax', ['id'=>$inter_id]); ?>', {act_id:'<?php echo $killsec['act_id']; ?>'}, function(json)
        {
            if(json.status == 1 ){
                $('#currentNumber').html(json.stock);
                $('#total').html(json.total);
            }
        }, 'json');
    }
    fill_progress();
    window.setInterval(fill_progress, <?php echo $stock_reflesh_rate; ?>);
    <?php endif;?>

    //商品款式
    var scopes = <?php
                        if(isset($package['scopes'])) {
                            echo json_encode($package['scopes']);
                        } else {
                            echo json_encode(array());
                        }
                 ?>;
    var gift = false;

    //送礼、款式、支付
    <?php if(true): ?>

        //门票
        <?php if(isset($isTicket) && $isTicket):?>
            $('.mail_gift_tip').on('click', function(){
                //门票
                var href = $('input[name="gift"]:last-child').val();
                gift = true;
                if(href){
                    if(gift){
                        href += '&gift=1';
                    }
                }
                window.location.href = href;
            });
        <?php endif;?>

        <?php if(isset($isTicket) && !$isTicket):?>
        //款式
        $('#selectSpec').on('click', function(){
            gift = false;
            kindSelect();
        });
        //支付
        $('#buy').on('click', function(){
            if(!canBuy){
                gift = false;
                getSpec();
                kindSelect();
            }
        });
        //送礼
        $('.mail_gift_tip').on('click', function(){
            if(!canBuy){
                gift = true;
                getSpec();
                kindSelect();
            }
        });
        <?php endif;?>
    <?php endif;?>


    //选择商品款式
    function kindSelect(){
        $.ajax({
            type: 'GET',
            url: '<?php echo Soma_const_url::inst()->get_url("*/*/ajax_product_spec"); ?>',
            data:{
                id:'<?php echo $this->inter_id; ?>',
                pid:<?php echo $package['product_id']; ?>,
                openid:'<?php echo $this->openid; ?>',
            },
            beforeSend: pageloading(),
            dataType:'JSON',
            error: function(){
                $.MsgBox.Confirm('<?php echo $lang->line('network_problem_refreah');?>',null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
            },
            success: function(data){
                if(data.status == 1){
                    if(!jQuery.isEmptyObject(data.data.data) && data.data.spec_type != undefined){
                        specdata = data.data;
                        var html = '';
                        for(var i = 0; i < specdata.spec_type.length; i++){
                            html += '<div class="spec-title f24">' + "<?php echo $lang->line('goods');?>" + specdata.spec_type[i] + '</div>';
                            html += '<ul class="clearfix spec-list">';
                            for(var j = 0; j < specdata.spec_name[i].length; j++){
                                html += '<li class="item fl f30 kind-btn" value="' + specdata.spec_name_id[i][j] + '">' + specdata.spec_name[i][j] + '</li>';
                            }
                            html += '</ul>';
                        }

                        $('.spec-box').html(html);

                        //选中
                        clickNow();
                        function clickNow(){
                            var stock = '-',price = '-',specid = '', _url='', setting_id='', text = "<?= $lang->line('buy_now') ?>";
                            $('.kind-btn').off().on('click', function () {
                                $(this).addClass('active').siblings('.kind-btn').removeClass('active');
                                stock = '-', price = '-', specid = '', _url='', setting_id='';
                                $('.kind-btn').each(function() {
                                    if($(this).hasClass('active')){
                                        specid += $(this).attr('value');
                                    }
                                });

                                for(var i = 0; i < specdata.spec_id.length; i++){
                                    if(specid == specdata.spec_id[i].toString()){
                                        setting_id = specdata.setting_id[i];
                                    }
                                }

                                if(specdata.data[setting_id] != undefined){
                                    _url = $('input[name="select_type"]').val() + '&psp_sid='+specdata.data[setting_id].setting_id+'&bType='+'<?php echo $bType;?>';
                                    stock = Number(specdata.data[setting_id].stock);
                                    price = Number(specdata.data[setting_id].specprice);
                                    for(var i=0; i<scopes.length; i++) {
                                        if (scopes[i].setting_id && scopes[i].setting_id == setting_id) {
                                            price = scopes[i].price;
                                        }
                                    }

                                    //已选
                                    var result = '';
                                    for(var d = 0; d<specdata.data[setting_id].spec_name.length; d++){
                                        result += '"' + specdata.data[setting_id].spec_name[d] + '"';
                                    }

                                    //库存不足
                                    if(stock <= 0){
                                        text = '<?php echo $lang->line('inventory_shortage');?>';
                                        $('#buy').attr('disabled');
                                        canBuy = false;
                                    }
                                    else{
                                        text = "<?php echo $lang->line('buy_now'); ?>";
                                        $('#selected').html("").html("<span>" + "<?php echo $lang->line('selected').'：';?>" + "</span>" + result);
                                        $('a#buyNow').attr('href', _url);
                                        $('a#buy').attr('href', _url);
                                        //送礼
                                        var attach = '&gift=1';
                                        if(gift){
                                            $('a#buy').attr('href', _url + attach);
											$('a#buyNow').attr('href', _url + attach);
                                        }
                                        $('a.mail_gift_tip').attr('href', _url + attach);
                                        canBuy = true;
                                    }
                                }

                                //显示
                                $('p.price').html('<span class="f24">￥' + price + '</span>');
                                $('div.price .f46').html('￥' + price);
                                $('#buy').html(text);
                            });
                        }

                    }
                    else{
                        var _href =  $('input[name="select_type"]').val();
                        var attach = '&gift=1';
                        if(gift){
                           _href = _href + attach;
                        }

                        window.location.href =_href;
                    }
                }
                else {
                    $.MsgBox.Confirm('<?php echo $lang->line('try_again');?>', null, null, '<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
                }
            },
            complete: function(data){
                removeload();
            }
        });
    }

    //显示二维码
    function qrcode (img, msg) {
        if (msg) {
            $('#qrcodeMsg').html(msg)
        }
        if (img) {
            $('#qrcode').find('img').attr('src', img);
        }

        $('#qrcode').show().off().on('click', function() {
            $('#qrcode').hide();
        })

        $('#qrcode').find('.qrcode').off().on('click', function(ev){
            ev.stopPropagation();
        });
    }


    //秒杀
    <?php if(isset($killsec) && !empty($killsec)){ ?>
    var subscribe_lock = false;
    var killsec = <?php echo json_encode($killsec); ?>;
    var canSubscribe = <?php echo Soma_base::STATUS_TRUE; ?>;
    $('#killsec_btn').off().on('click', function(){
        get_in_line(1);
    });
    $('.mail_gift_tip').off().on('click', function(){
        get_in_line(2);
    });
    function get_in_line(kind){
        if(!startFlag){
            var tmptime = new Date('<?php echo date('Y/m/d H:i:s', strtotime($killsec['killsec_time']));?>');
            var tmpnow = new Date();
            if (tmptime.getTime() - tmpnow.getTime() < 10 * 60 * 1000 ){ // 小于10分钟
                $.MsgBox.Alert( '秒杀即将开始，手快有，手慢无');
            }
            else{

                if (killsec.is_subscribe == canSubscribe) {
                    if( subscribe_lock == true){
                        $.MsgBox.Confirm( '<?php echo $lang->line('subscribe_success');?>' ,null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
                    }
                    else {
                        $.MsgBox.Confirm('<?php echo $lang->line('subscribe_and_reminder');?>', function(){
                            pageloading('<?php echo $lang->line('settting_for_you');?>', 0.2);
                            $.ajax({
                                url:'<?php echo Soma_const_url::inst()->get_url('*/killsec/subscribe_killsec_notice_ajax', array('id'=>$inter_id )); ?>',
                                type: 'POST',
                                dataType:'JSON',
                                data:{
                                    act_id :'<?php echo $killsec['act_id']; ?>',
                                },
                                success:function(json){
                                    $('.pageloading').remove();
                                    subscribe_lock= true;
                                    if( json.status == 1 ){
                                        if(json.data && json.data !='') {
                                            qrcode(json.data);
                                        }else{
                                            $.MsgBox.Confirm( json.message ,null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
                                        }
                                    } else if( json.status == 2 ){
                                        $.MsgBox.Confirm( json.message ,null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
                                    }
                                }
                            });
                        },function(){
                        },'<?php echo $lang->line('subscribe_now');?>', '<?php echo $lang->line('say_later');?>');
                    }
                }
                else {
                    $.MsgBox.Confirm( '<?php echo $lang->line('flash_sale_prepare');?>',null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
                }

            }
            return false;
        }

        pageloading('<?php echo $lang->line('line_up_wait');?>',0.2);

        var api = '<?php echo Soma_const_url::inst()->get_url('*/killsec/rob_ajax', array('id'=>$inter_id )); ?>';
        $.ajax({
            async: true,
            url: api,
            type: 'POST',
            dataType:'JSON',
            data:{
                act_id : killsec.act_id,
                inid : killsec.instance.instance_id,
            },
            success:function(json){
                if( json.status == 1 ){
                    var token= json.data.token;
                    var instance_id= json.data.instance_id;
                    if(kind == 1){
                        window.location.href='<?php echo Soma_const_url::inst()->get_url('*/killsec/package_pay', array('id'=>$inter_id, 'pid'=>$_GET['pid'], 'act_id'=>$killsec['act_id'], 'bType'=>$bType )); ?>&instance_id='+ instance_id+ '&token='+ token;
                    }
                    else{
                        window.location.href='<?php echo Soma_const_url::inst()->get_url('*/killsec/package_pay', array('id'=>$inter_id, 'pid'=>$_GET['pid'], 'act_id'=>$killsec['act_id'], 'bType'=>$bType, 'gift'=>1 )); ?>&instance_id='+ instance_id+ '&token='+ token;
                    }
                }
                else if( json.status == 2 ){
                    if(killsec.instance=='' || killsec.instance.instance_id ==''){
                        location.reload();
                    }else{
                        $.MsgBox.Confirm( json.message,null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
                    }
                }
            },
            error: function() {
                $.MsgBox.Confirm('<?php echo $lang->line('so_crowded');?>',winreload,winreload);
                return false;
            },
            complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                removeload();
                if(status=='timeout'){//超时,status还有success,error等值的情况
                    $.MsgBox.Confirm('<?php echo $lang->line('so_crowded');?>',winreload,winreload);
                }
            },
            timeout: function() {
                $.MsgBox.Confirm('<?php echo $lang->line('so_crowded');?>',winreload,winreload);
            }
        })
    }
    <?php } ?>

    //倒计时
    var timer = null;
    var timeLeft = 0;
    function countDown () {

        var countdown = parseInt($('#countdown').attr('countdown'));
        timeLeft = countdown - moment().valueOf();

        clearTimeout(timer);
        if (timeLeft === 0) {
            clearTimeout(timer);
            // 倒计时为0 时候执行的操作
            return false;
        }
        var days = parseInt(timeLeft / 1000 / 60 / 60 / 24, 10);
        var hours = parseInt(timeLeft / 1000 / 60 / 60 % 24, 10);
        var minutes = parseInt(timeLeft / 1000 / 60 % 60, 10);
        var seconds = parseInt(timeLeft / 1000 % 60, 10);
        timeLeft = timeLeft - 1000;
        var startDay = '';
        var startHour = '';
        var startMin = '';
        var startSec = '';

        if (days <= 0) {
            startDay = '';
        } else {
            var showDay = days > 9 ? minutes : '0' + days;
            startDay = showDay + '天';
            // hours += parseInt(startDay) * 24;
        }

        if (hours <= 0) {
            startHour = startHour;
        } else {
            var showHour = hours > 9 ? hours : '0' + hours;
            startHour = showHour + ': ';
        }

        if (minutes <= 0) {
            startMin = '00: ';
        } else {
            var showMin = minutes > 9 ? minutes : '0' + minutes;
            startMin = showMin + ': ';
        }

        if (seconds <= 0) {
            startSec = '00';
        } else {
            var showSec = seconds > 9 ? seconds : '0' + seconds;
            startSec = showSec;
        }
        $('#countdown').html(startDay + startHour + startMin + startSec);

        if(showDay == undefined && showHour == undefined && showMin == '00' && startSec == '00'){
            //秒杀开始
            <?php if(isset($killsec) && !empty($killsec)):?>
                $('.countdown-title').html("<?= $lang->line('end_of_distance') ?>");
                $('#countdown').attr('countdown', "<?= strtotime($killsec['end_time']) * 1000 ?>")
                $('#killsec_btn').html("<?php echo $lang->line('flash_sale_in_progress');?>");
                startFlag = true;
            <?php endif;?>
        }

        setTimeout(countDown, 1000);
    }
    countDown ();

</script>

</html>