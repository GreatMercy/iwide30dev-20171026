<body>
<script src="<?php echo base_url('public/soma/scripts/jquery.touchwipe.min.js'); ?>"></script>
<div class="pageloading"><p class="isload"></p></div>
<script>
    var package_obj = {
        'appId': '<?php echo $wx_config["appId"]?>',
        'timestamp': <?php echo $wx_config["timestamp"]?>,
        'nonceStr': '<?php echo $wx_config["nonceStr"]?>',
        'signature': '<?php echo $wx_config["signature"]?>'
    }
    /*下列字符不能删除，用作替换之用*/
    //[<sign_update_code>]
    wx.config({
        debug: false,
        appId: package_obj.appId,
        timestamp: package_obj.timestamp,
        nonceStr: package_obj.nonceStr,
        signature: package_obj.signature,
        jsApiList: [<?php echo $js_api_list; ?>, 'getLocation']
    });
    wx.ready(function () {

        <?php if( $js_menu_hide ): ?>wx.hideMenuItems({menuList: [<?php echo $js_menu_hide; ?>]});
        <?php endif; ?>

        <?php if( $js_menu_show ): ?>wx.showMenuItems({menuList: [<?php echo $js_menu_show; ?>]});
        <?php endif; ?>

        <?php if( $js_share_config ): ?>
        wx.onMenuShareTimeline({
            title: '<?php echo $js_share_config["title"]?>',
            link: '<?php echo $js_share_config["link"]?>',
            imgUrl: '<?php echo $js_share_config["imgUrl"]?>',
            success: function () {
            },
            cancel: function () {
            }
        });
        wx.onMenuShareAppMessage({
            title: '<?php echo $js_share_config["title"]?>',
            desc: '<?php echo $js_share_config["desc"]?>',
            link: '<?php echo $js_share_config["link"]?>',
            imgUrl: '<?php echo $js_share_config["imgUrl"]?>',
            //type: '', //music|video|link(default)
            //dataUrl: '', //use in music|video
            success: function () {
            },
            cancel: function () {
            }
        });
        <?php endif; ?>
    });

</script>

<style>
    <?php if(!empty($theme) && !empty($theme['index_bg'])):?>

    #index.bg {
      background-image: url(<?php echo $theme['index_bg'];  ?>);
    }
    <?php endif;?>


</style>

<div class="bg pr" id="index">

    <a class="header pa" id="distribution">
        <img src="<?php echo $fan['headimgurl']; ?>" alt=""/>
    </a>

    <div class="kill-time" id="killTime">
        <div class="time" style="margin-top:-18px;">
            <span class="f24 time-unit number-title">距开始:</span>
            <span class="time-number">1</span>
            <span class="f24 time-unit">天</span>
            <span class="time-number">09</span>
            <span class="f24 time-unit">时</span>
            <span class="time-number">24</span>
            <span class="f24 time-unit">分</span>
            <span class="time-number">56</span>
            <span class="f24 time-unit">秒</span>
        </div>
    </div>
    <!-- </div>  -->

    <div class="pr img-wrap">
        <div class="kill-goods pr kill-sign" id="sign">
            <div class="img-container pr">
                <div class="swiper-container  pr">
                    <div class="swiper-wrapper">
                        <?php if ($products): ?>
                            <?php
                            foreach ($products as $k => $v):
                                $price_market = $v['price_market'];
                                $price_package = $v['price_package'];
                                $iskillsec = 'false';
                                $countdown = 0;
                                $countdownend = 0;
                                if (isset($v['killsec'])) {
                                    $price_package = $v['killsec']['killsec_price'];
                                    $iskillsec = 'true';
                                    $countdown = $v['killsec']['killsec_countdown'];
                                    $countdownend = strtotime($v['killsec']['end_time']) * 1000;
                                }
                                elseif (isset($v['groupon'])) {
                                    $price_package = $v['groupon']['group_price'];
                                }
                                elseif (isset($v['auto_rule'])) {
                                    //$price_package = $v['killsec']['killsec_price'];
                                }

                                //碧桂园
                                if(in_array($this->inter_id, ['a421641095'])){
                                    if($v['keyword']){
                                        $v['name'] = $v['keyword'];
                                    }
                                }

                                ?>
                                <div class="swiper-slide" name="<?php echo $v['name'];?>"
                                     discount="<?php echo $price_package;?>"
                                     original="<?php echo $price_market;?>"
                                     iskillsec="<?php echo $iskillsec;?>"
                                     countdown="<?php echo $countdown;?>"
                                     countdownend="<?php echo $countdownend;?>"
                                     href="<?php echo Soma_const_url::inst()->get_url('soma/package/package_detail/', array('id' => $this->inter_id, 'bsn' => 'package', 'pid' => $v['product_id'], 'tkid' => $ticketId, 'catid' => $catId));?>">
                                    <img src="<?php echo $v['face_img'];?>">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="arrow pa left-arrow"></div>
        <div class="arrow pa right-arrow"></div>
    </div>


    <div class="ta-c name-wrap">
        <div class="shop-name pr" id="name">
        </div>
    </div>

    <div class="price-wrap ta-c">
        <div class="price">
            <span class="symbol">￥</span>
            <span class="discount" id="discount">145</span>
            <span class="original" id="original">￥347</span>
        </div>
    </div>


    <div class="popup">
        <div class="popup-wrap pr">
            <div class="popup-header"><a href="javascript:void(0)" class="fr"></a></div>
            <div class="popup-content">
                <div class="distribution">
                    <div class="distribution-header"><img src="<?php echo $fan['headimgurl']; ?>"></div>
                    <?php if (empty($staff)): ?>
                        <div class="distribution-name ta-c f32"><?php echo $fan['nickname']; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($staff)): ?>
                        <div class="distribution-name ta-c f32"><?php echo $staff['saler_name']; ?></div>
                        <div class="distribution-id ta-c f30">分销ID:<?php echo $staff['saler_id']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="kill-index">
    <div class="button-wrap ta-c kill">
        <a href="" class="button" id="href"></a>

        <p class="f24" id="all-mooncake">查看全部月饼<span class="arrow"></span></p>
    </div>
</div>

</body>

<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/moment.js?123'); ?>"></script>
<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/fastclick.js?123'); ?>"></script>
<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/public.js?123'); ?>"></script>
<script src="<?php echo get_cdn_url('public/soma/mooncake4/js/index_new.js?123'); ?>"></script>

<script type="text/javascript">
    allMooncake();
    function allMooncake() {
        $('#all-mooncake').off().on('click', function () {
            window.location.href = "<?php echo Soma_const_url::inst()->get_url('soma/package/mooncake4_index', array('id' => $this->inter_id, 'tkid' => $ticketId, 'catid' => $catId))?>"
        });
    }
</script>

</html>