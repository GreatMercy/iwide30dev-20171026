<?php 
    // 是否显示¥符号
    $show_y_flag = true;
    if($package['type'] == $packageModel::PRODUCT_TYPE_POINT)
    {
        $show_y_flag = false;
    }
    if( !isset( $bType ) )
    {
        $bType = '';
    }
?>
<style>
   #killsec_btn{
        position: relative;
        line-height: 33px;
    }
    #killsec_btn .mask{
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        display: none;
        background: #999;
        color: #fff;
    }
    #killsec_btn .text{
        display: block;
        margin-top: -5px;
    }
    #killsec_btn.disabled .mask{
        display: block;
    }
    .Ldn{
        display: none
    }

    .distribution-tip{
        position: fixed;
        background: rgba(0,0,0,0.6);
        bottom: 60px;
        text-align: center;
        font-size: 14px;
        border-radius: 4px;
        width: 80%;
        height: 30px;
        color: #fff;
        z-index: 99999;
        left: 50%;
        margin-left: -40%;
        line-height: 30px;
    }
</style>
<body>

<link href="<?php echo base_url('public/soma/v1/v1.css'). config_item('css_debug');?>" rel="stylesheet">

<style type="text/css">

    .xgcs{
        position: absolute;
        top: 0px;
        right: 0px;
        font-size: 12px;
        width: 110px;
        background-color: rgba(0,0,0,0.7);
        height: 24px;
        text-align: center;
        line-height: 24px;
        border-radius: 3px 0px 0px 3px;
        color: white;
    }
    .zhuanshujia{
        position: absolute;
        bottom: 110%;
        color: white;
        background-color: rgba(0,0,0,0.7);
        border-radius: 3px;
        width: 80%;
        left: 10%;
        text-align: center;
        padding: 3px 0px;
    }
    .zhuanshujia::after {
        content: "";
        position: absolute;
        width: 8px;
        height: 4px;
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAAICAYAAAAbQcSUAAAApElE…FNvbxIAnG4zthtGkVqcifo4tT0tA72FNLHFGO4H1c3pXvHAEhsTJjybgAAAAASUVORK5CYII=');
        background-size: 100% 100%;
        top: 99%;
        right: 10%;
    }
    @font-face{
      font-family: 'icon';
      src : url('<?php echo base_url('public/soma/v1/font/iconfont.ttf');?>') format('truetype'),
            url('<?php echo base_url('public/soma/v1/font/iconfont.woff');?>') format('woff');
    }
    .fsfl{
        background-color: #27282d;
        color: white;
        font-size: 12px;
        padding: 12px;
        transform-origin: top;
        -webkit-transform-origin: top;
        -webkit-animation: .5s move ease-in-out;
        animation: .5s move ease-in-out;
        transition: all .5s;
        -webkit-transition: all .5s;
        overflow: hidden;
    }
    .fsfl>div>.haoma{
        color: #ff9900;
        font-size: 20px;
        margin-left: 5px;
    }
    .fsfl>div{
        position: relative;
        padding-left: 25px;
        line-height: 1.3;
        /*-webkit-animation: .5s showout ease-in-out;
        animation: .5s showout ease-in-out;
        transform-origin: top;
        -webkit-transform-origin: top;*/
    }
    .percent{
        font-family: Helvetica Neue,sans-serif;
        content: "%";
        font-size: 12px;
        color: #ff9900;
        margin-right: 5px;
    }
    .fsfl>div::before{
            font-family: icon;
    content: "\e039";
    position: absolute;
    left: 0px;
    color:#ff9900;
    }
    .move6::before{
        margin-top: 8px;
    }
    @keyframes showout{
        0%{
            height: 0px
        }
        100%{
            height: 50px;
        }
    }
    @-webkit-keyframes showout{
        0%{
            height: 0px;
        }
        100%{
            height: 50px;
        }
    }
    @keyframes move{
        0%{
            margin-top: -60px;
        }
        100%{
            margin-top: 0px;
        }
    }
    @-webkit-keyframes move{
        0%{
            margin-top: -60px;
        }
        100%{
            margin-top: 0px;
        }
    }
    .none{
        display: none;
    }
    .staff-wrap{
        z-index: 999999999999;
    }
    .staff-tips{
        text-align: center;
        line-height: 1.5;
        margin-bottom: 20px;
        font-size: 15px;
    }
</style>
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

<?php if(in_array($this->inter_id, $idistributInterId) && !empty($saler_info_by_id['name'])): ?>
<div class="distribution-tip">这是来自于<?php echo $saler_info_by_id['name']; ?>的馅饼侠招募令</div>
<?php endif; ?>

<?php if($package['goods_type'] == Product_package_model::SPEC_TYPE_ROOM): ?>
    <?php if($this->input->get('saler', true) && !empty($saler_info_by_id['hotel_name'])
        && !empty($saler_info_by_id['name'])): ?>
        <div class="fsfl none">
            <div>房劵升级酒店<?php echo $saler_info_by_id['hotel_name']; ?>，销售员<?php echo $saler_info_by_id['name']; ?><span class="haoma"></span></div>
        </div>
    <?php else: ?>
        <div class="kill-layer staff-wrap">
            <div class="container">
                <p class="f24 staff-tips">提示</p>
                <p class="content f24 staff-tips">请重新扫描员工二维码</p>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div id="seckill-detail">
<div class="wrap">
 <div class="pageloading"><p class="isload"><?php echo $lang->line('loading');?></p></div>

<?php if($package['goods_type'] != Product_package_model::SPEC_TYPE_ROOM): ?>
    <?php if(!empty($effective_rule) && !empty($saler_info) && !in_array($this->inter_id, $idistributInterId)): ?>
    <div class="fsfl none">
        <div><?php if($saler_info['saler_type'] == 'FANS'): ?>粉丝福利：<?php else: ?>员工福利：<?php endif; ?>分享本产品，您的好友购买成功后，您将获得<?php if($effective_rule['reward_type'] == Reward_rule_model::REWARD_TYPE_PERCENT): ?>订单<?php endif; ?><span class="haoma"><?php echo $effective_rule['reward_rate']; ?></span><?php if($effective_rule['reward_type'] == Reward_rule_model::REWARD_TYPE_PERCENT): ?><span class="percent">%</span><?php else: ?>元<?php endif; ?>红包奖励，<?php if($saler_info['saler_type'] == 'FANS'): ?>隔天发至您的微信钱包<?php else: ?>由酒店发放<?php endif; ?></div>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php if(in_array($this->inter_id, $idistributInterId) && (empty($saler_info) || $saler_info['saler_type'] != 'STAFF')): ?>
<div class="make-money">
  <a href="<?php echo $act_url; ?>"></a>
  <div class="make-money-close"></div>
</div>
<?php endif; ?>

 <header class="headers banner">
    <div class="headerslide">
        <?php if( $gallery ): ?>
            <?php foreach($gallery as $k=>$v){?>
                <a class="slideson ui_img_auto_cut">
                    <img src="<?php echo $v['gry_url'];?>" />
                </a>
            <?php }?>
        <?php else: ?>
            <a class="slideson ui_img_auto_cut">
                <img src="<?php echo base_url('public/soma/images/default.jpg'); ?>" />
            </a>
        <?php endif; ?>
    </div>
    <?php if(isset($package['scopes']) && isset($package['scopes'][0]) && $package['scopes'][0]['limit_num'] > 0 ) : ?>
    <div class="xgcs"><?php echo str_replace('[0]', $package['scopes'][0]['limit_num'] - $package['scopes'][0]['used_num'], $lang->line('exclusive_limit')); ?></div>
    <?php endif; ?>
</header>

<!--
<div class="whiteblock webkitbox justify" style="margin-top:0">
	<div><?php echo $package['name'];?></div>
    <div class="color_888" style="min-width:6rem"><?php if($package['show_sales_cnt'] == Soma_base::STATUS_TRUE): ?>
        <?php echo $lang->line('sold') . ' ' . $package['sales_cnt']; ?>
    <?php endif; ?></div>
</div>
-->

 <!-- 商品信息 -->
  <div class="info pd-19 bg-white  box">
      <div class="info_left f24 c333">
          <?php echo $package['name'];?>
      </div>
      <div class="info_right f20 ta-r flex1 c98">
            <?php if($package['show_sales_cnt'] == Soma_base::STATUS_TRUE): ?>
                <?php
                    echo $lang->line('sold') . ' ';
                    if ($package['product_id'] === '150812') {
                        echo (5000 - $package['sales_cnt'] / $package['use_cnt']);
                    } else {
                        echo $package['sales_cnt'];
                    }
                ?>
            <?php endif; ?>
      </div>
  </div>
 <!-- 商品信息 -->

<?php
    // 无属性
    $no_attr_flag = true;
    if($package['can_refund'] != $packageModel::CAN_REFUND_STATUS_FAIL && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE && $package['type'] != $packageModel::PRODUCT_TYPE_POINT) {
        $no_attr_flag = false;
    }

    if($package['can_gift'] == $packageModel::CAN_T) {
        $no_attr_flag = false;
    }

    if($package['can_mail'] == $packageModel::CAN_T) {
        $no_attr_flag = false;
    }

    if($package['can_pickup'] == $packageModel::CAN_T) {
        $no_attr_flag = false;
    }

    if($package['can_invoice'] == $packageModel::CAN_T) {
        $no_attr_flag = false;
    }

    if($package['can_split_use'] == $packageModel::CAN_T) {
        $no_attr_flag = false;
    }
?>


<!-- <div class="post bg-white mt-16  support_list <?php if($no_attr_flag): ?>Ldn<?php endif; ?>"> -->
    <!--
    <?php if($package['can_refund'] == $packageModel::CAN_T && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE){ ?>
        <span tips="购买后，您可以在订单中心直接申请退款，并原路退回"><em class="iconfont color_main">&#xe61e;</em><tt>微信退款</tt></span>
    <?php } ?>
    -->

    <!--<?php if($package['can_refund'] != $packageModel::CAN_REFUND_STATUS_FAIL && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE && $package['type'] != $packageModel::PRODUCT_TYPE_POINT): ?>
        <span tips="<?php echo $lang->line('after_buy_apply_refund');?>"><em class="iconfont color_main">&#xe61e;</em>
            <tt>
                <?php if($package['can_refund'] == $packageModel::CAN_REFUND_STATUS_SEVEN): ?>
                    <?php echo $lang->line('7_refund_day');?>
                <?php else: ?>
                    <?php echo $lang->line('refund_any_time');?>
                <?php endif; ?>
            </tt>
        </span>
    <?php endif; ?>

    <?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('after_buy_donated'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('gift_a_friend'); ?></tt></span>
    <?php } ?>

    <?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('goods_can_mail');?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('deliver_to_home'); ?></tt></span>
    <?php } ?>

    <?php if($package['can_pickup'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('goods_support_shop_or_self');?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('collect_from_hotel');?></tt></span>
    <?php } ?>
    <?php if($package['can_invoice'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('purchase_can_invoice');?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('invoice');?></tt></span>
    <?php } ?>
    <?php if($package['can_split_use'] == $packageModel::CAN_T){ ?>
        <span tips="<?php echo $lang->line('can_be_used_splitting'); ?>"><em class="iconfont color_main">&#xe61e;</em><tt><?php echo $lang->line('multi_usage');?></tt></span>
    <?php } ?> -->
<!-- </div> -->



<div class="post bg-white mt-16 support_list <?php if($no_attr_flag): ?>Ldn<?php endif; ?>"">
     <?php if($package['can_refund'] != $packageModel::CAN_REFUND_STATUS_FAIL && $package['type'] != $packageModel::PRODUCT_TYPE_BALANCE && $package['type'] != $packageModel::PRODUCT_TYPE_POINT): ?>

            <!--
             <span tips="<?php echo $lang->line('after_buy_apply_refund');?>"><em class="iconfont color_main">&#xe61e;</em>
                 <tt>
                     <?php if($package['can_refund'] == $packageModel::CAN_REFUND_STATUS_SEVEN): ?>
                         <?php echo $lang->line('7_refund_day');?>
                     <?php else: ?>
                         <?php echo $lang->line('refund_any_time');?>
                     <?php endif; ?>
                 </tt>
             </span>
             -->

              <div class="item fl f20 c666 box" tips="<?php echo $lang->line('after_buy_apply_refund');?>">
                    <span class="icon"></span>
                    <span>
                       <?php if($package['can_refund'] == $packageModel::CAN_REFUND_STATUS_SEVEN): ?>
                               <?php echo $lang->line('7_refund_day');?>
                      <?php else: ?>
                          <?php echo $lang->line('refund_any_time');?>
                   <?php endif; ?>
                    </span>
              </div>

         <?php endif; ?>


         <?php if($package['can_gift'] == $packageModel::CAN_T){ ?>
            <div class="item fl f20 c666 box" tips="<?php echo $lang->line('after_buy_donated'); ?>">
                <span class="icon"></span>
                <span>
                    <?php echo $lang->line('gift_a_friend'); ?>
                </span>
            </div>
         <?php } ?>


         <?php if($package['can_mail'] == $packageModel::CAN_T){ ?>
             <div class="item fl f20 c666 box" tips="<?php echo $lang->line('goods_can_mail');?>">
                   <span class="icon"></span>
                   <span>
                      <?php echo $lang->line('deliver_to_home'); ?>
                   </span>
             </div>
         <?php } ?>

         <?php if($package['can_pickup'] == $packageModel::CAN_T){ ?>
             <div class="item fl f20 c666 box" tips="<?php echo $lang->line('goods_support_shop_or_self');?>">
                  <span class="icon"></span>
                  <span>
                    <?php echo $lang->line('collect_from_hotel');?>
                  </span>
             </div>
         <?php } ?>

         <?php if($package['can_invoice'] == $packageModel::CAN_T){ ?>

             <div class="item fl f20 c666 box" tips="<?php echo $lang->line('purchase_can_invoice');?>">
                   <span class="icon"></span>
                   <span>
                     <?php echo $lang->line('invoice');?>
                   </span>
             </div>

         <?php } ?>


         <?php if($package['can_split_use'] == $packageModel::CAN_T){ ?>
             <div class="item fl f20 c666 box" tips="<?php echo $lang->line('can_be_used_splitting'); ?>">
                        <span class="icon"></span>
                        <span>
                         <?php echo $lang->line('multi_usage');?>
                        </span>
          </div>
         <?php } ?>
  </div>



<?php if( isset( $isTicket ) && !$isTicket ):?>
    <div class="choice mt-16 bg-white pd-19 box f20 pr select_type" <?php if(!$spec_product): ?> style="display:none" <?php endif; ?>>
        <div class="webkitbox input_item ">
            <?php
                $spec_compose = isset( $psp_summary['spec_compose'] ) ? json_decode($psp_summary['spec_compose'], true) : '';
                $spec_type = isset( $spec_compose['spec_type'] ) ? implode(' ',  $spec_compose['spec_type'] ) : '';
            ?>
            <div class="title c666">  <?php echo $lang->line('choose') . ' ' . $spec_type; ?></div>
            <div class="c98 content"></div>
        </div>
        <div class="arrow pa"></div>
    </div>
<?php else:?>
    <div class="choice mt-16 bg-white pd-19 box f20 pr select_type" <?php if(!$spec_product): ?> style="display:none" <?php endif; ?>>
        <a href="<?php echo Soma_const_url::inst()->get_url('*/*/ticket_select_time',array('id'=>$inter_id,'pid'=>$_GET['pid'],'tkid'=>$ticketId)); ?>">
            <div class="webkitbox input_item  pr">
                <div class="title c666">请选择门票时间</div>
                <div class="c98 content"></div>
            </div>
        </a>
        <div class="arrow pa"></div>
    </div>
<?php endif;?>

  <!--<div class="whiteblock ">
  	<div><em class="iconfont color_main">&#xe620;</em>
          <?php echo str_replace('[0]', $public['name'], $lang->line('provide_by')); ?>
      </div>
  </div>-->

 <div class="source box pd-19 bg-white mt-16 f24">
            <span class="icon"></span>
            <div class="content"><?php echo str_replace('[0]', $public['name'], $lang->line('provide_by')); ?></div>
 </div>


<?php if($spec_product): ?>
<div class="ui_pull color_666 page" style="display:none" onClick="toclose();" id="spec_page">
	<div class="flexgrow" style="min-height:40%"></div>
    <div class="bg_fff">
        <div class="flex bd_bottom bg_fff pad10">
            <div class="specimg"><div class="squareimg"><img src="<?php  if( $package['face_img'] )echo $package['face_img'];else echo base_url('public/soma/images/default2.jpg');?>" /></div></div>
            <div class="pad10 flexgrow">

                <?php
                    $low_price = $psp_setting[$package['product_id']][0]['spec_price'];
                    $high_setting = end($psp_setting[$package['product_id']]);
                    $high_price = $high_setting['spec_price'];
                ?>

                <?php if($show_y_flag): ?>
                    <div class="y color_main specprice"><?php echo $low_price . '~' . $high_price; ?></div>
                <?php else: ?>
                    <div class="color_main specprice"><?php echo $low_price . '~' . $high_price; ?></div>
                <?php endif; ?>
                <div class="h22 result"></div>
            </div>
            <div class="iconfont h34">&#xe612;</div>
        </div>
    </div>
    <div class="bg_fff _w flexgrow scroll">
        <div class="list_style_1 flexgrow speclist">
            <div class="webkitbox justify pad10 hide">
                <span><?php echo $lang->line('purchase_quantity');?></span>
                <span>
                    <div class="num_control bd webkitbox" style="float:right">
                        <div class="down_num bd_left">-</div>
                        <div class="result_num bd_left"><input id="selece_num" value="1" type="tel" min="1" max="9"></div>
                        <div class="up_num bd_lr">+</div>
                    </div>
                </span>
            </div>
        </div>
    </div>
    <footer class="flex bg_fff bd_top">
    	<div class="flexgrow pad10 center color_999">
            <?php echo $lang->line('cancel');?>
        </div>
        <div class="flexgrow sure_btn btn_main pad10 disable">
            <?php echo $lang->line('confirm');?>
        </div>
    </footer>
</div>
<?php endif; ?>

<?php
    /**
     * 显示秒杀库存
     **/
    if( !empty($killsec) && isset($killsec['is_stock']) && $killsec['is_stock']==Soma_base::STATUS_TRUE ):
?>
<!-- <div class="whiteblock" id="ks_stock_div" style="display: none;">
	<div class="justify webkitbox">
    	<div class="progress"><span class="bg_main fill1" style="width:0<?php //echo $ks_percent; ?>%">&nbsp;<img src="<?php echo base_url('public/soma/images/ruler.png'); ?>"></span></div>
        <div>
            <span class="color_main"><?php echo $lang->line('remaining_places');?>：</span>
            <span class="color_888 fill2">0/1</span>
        </div>
    </div>
</div> -->

<div class="store bg-white pd-19 mt-16" id="ks_stock_div">
    <div class="content box">
        <div class="progress flex1 pr">
            <div class="bar pa">
                <div class="pa fill1" style="width:0<?php //echo $ks_percent; ?>%"></div>
            </div>
        </div>
        <div class="c555 f20 surplus">
            <span class="c555"><?php echo $lang->line('remaining_places');?>：</span> <span class="cff9900 fill2"></span>
        </div>
     </div>
</div>

<script>
var removeBtnMask = false;
function fill_progress(){
	$.post('<?php echo Soma_const_url::inst()->get_url('*/killsec/find_killsec_stock_ajax', ['id'=>$inter_id]); ?>', {act_id:'<?php echo $killsec['act_id']; ?>'}, function(json)
	{
	    if( json.status == 1 ){
	    	$('.fill1').animate({width:json.percent+ '%'});
			$('.fill2').html(json.stock + '/' + json.total);
			$('#ks_stock_div').show();

	    }

        if(!removeBtnMask){
            $('#killsec_btn').removeClass('disabled');
            removeBtnMask = true;
        }
	},'json');
}
fill_progress();
window.setInterval(fill_progress, <?php echo $stock_reflesh_rate; ?>);
</script>
<?php endif; ?>

<div class="block bg-white mt-16 h24 know c333">
	<p class="bd_bottom">
    	<span class="c333 f24">
             <?php echo $lang->line('terms_and_conditions'); ?>
        </span>
    	<span class="h22">
            <?php /**有秒杀**/ if(!empty($killsec)){ ?>
                <?php if( isset($finish_killsec) && $finish_killsec ){ ?>
                <span class="bg_main bdradius pad2">
                    <?php echo $lang->line('flash_sale_over'); ?>
                </span>
                <?php } elseif($killsec['killsec_time'] >= date('Y-m-d H:i:s',time())){ ?>
                    <span class="bg_main bdradius pad2 f20" id="timeCalc">
                        <span class="j_dat"></span>
                        <span class="j_tmie"></span>
                    </span>
                    <script>
                        var oTime = '<?php echo date('Y/m/d H:i:s',strtotime($killsec['killsec_time']));?>';
                        var startFlag = false;
                        /*秒杀倒计时*/
                        function countdownTime(Time){
                            var endTime=new Date(Time);
                            var nowTime=new Date();
                            var s_time=endTime-nowTime;
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

                        if(parseInt(calcStrObj.j_date) <=0){
                            $('#timeCalc').find('.j_dat').html('<?php echo $lang->line('flash_sale_count_down');?>：');
                        }else{
                            $('#timeCalc').find('.j_dat').html('<?php echo $lang->line('flash_sale_count_down');?>：'+ calcStrObj.j_date+'<?php echo $lang->line('day');?>');
                        }

                        if(parseInt(calcStrObj.j_date) <=0 && parseInt(calcStrObj.j_hour) <=0){
                            $('#timeCalc').find('.j_tmie').html(calcStrObj.j_minute+'<?php echo $lang->line('min');?>'+calcStrObj.j_second + '<?php echo $lang->line('sec');?>');
                        }else{
                            $('#timeCalc').find('.j_tmie').html(calcStrObj.j_hour+'<?php echo $lang->line('hour');?>'+ calcStrObj.j_minute+'<?php echo $lang->line('min');?>'+calcStrObj.j_second + '<?php echo $lang->line('sec');?>');
                        }
                        $('#timeCalc').time=setInterval(function(){
                            if(parseInt(countdownTime(oTime).j_rest) <= 0 ){
                                startFlag = true;
                                $('#timeCalc').html('<?php echo $lang->line('flash_sale_in_progress');?>');
                                $('#btnText').html('秒杀购买');
                                clearInterval($('#timeCalc').time);
                            }else{
                                startFlag = false;
                            }
                            calcStrObj = countdownTime(oTime);

                            if(parseInt(calcStrObj.j_date) <=0){
                                $('#timeCalc').find('.j_dat').html('<?php echo $lang->line('flash_sale_count_down');?>：');
                            }else{
                                $('#timeCalc').find('.j_dat').html('<?php echo $lang->line('flash_sale_count_down');?>：'+ calcStrObj.j_date+'<?php echo $lang->line('day');?>');
                            }
                            if(parseInt(calcStrObj.j_date) <=0 && parseInt(calcStrObj.j_hour) <=0){
                                $('#timeCalc').find('.j_tmie').html(calcStrObj.j_minute+'<?php echo $lang->line('min');?>'+calcStrObj.j_second + '<?php echo $lang->line('sec');?>');
                            }else{
                                $('#timeCalc').find('.j_tmie').html(calcStrObj.j_hour+'<?php echo $lang->line('hour');?>'+ calcStrObj.j_minute+'<?php echo $lang->line('min');?>'+calcStrObj.j_second + '<?php echo $lang->line('sec');?>');
                            }
                        },1000)
                    </script>
                <?php }else{ ?>
                    <span class="bg_main bdradius pad2 f20">
                        <?php echo $lang->line('flash_sale_in_progress'); ?>
                    </span>
                    <script>
                        var startFlag = true;
                    </script>
                <?php } ?>
                <?php  /** end有秒杀*/?>
                <?php /**有拼团**/
} elseif (!empty($groupons)){ //foreach($groupons as $k=>$v){ ?>
                <span class="bg_main bdradius pad2 f20"><!--支付后并邀请 <?php echo $v['group_count']-1;?> 位好友参团，-->
                    <?php echo $lang->line('group_purchase_overtime');?>
                </span>
            <?php /**有活动**/
} elseif( isset($auto_rule[0]) ){ foreach($auto_rule as $k=>$v){ ?>
                <span class="bg_main bdradius pad2 f20"><?php echo $v['name']; ?></span>
            <?php
} } /** end**/?>

    	</span>
    </p>
    <?php if(isset($package['order_notice'])  && !empty($package['order_notice']) ){?>
    <p  class="color_999 f_s_12">
        <?php echo $package['order_notice']; ?>
    </p>
    <?php } ?>

</div>

<?php
$content = unserialize($package['compose']);
// 商品内容为空时自动隐藏
$flag = false;
if(is_array($content)) {
    foreach($content as $k=>$v) {
        if(empty($v['content'])) continue;
        $flag = true;
    }
}


if(!empty($content) && $flag){ ?>

<div class="bg_fff bd martop block h24 color_555">
	<p class="bd_bottom f24 c333">
        <?php echo $lang->line('item_details');?>
    </p>
    <ul class="block_list color_888">
        <li class="color_888 bd_bottom h24">
            <span class="f20"><?php echo $lang->line('name'); ?></span>
            <span class="f20"><?php echo $lang->line('number'); ?></span>
        </li>
        <?php if(is_array($content)){ foreach($content as $k=>$v){if(empty($v['content'])) continue; ?>
        <li class="bd_bottom h24 color_555">
            <span class="f20">
                <?php echo $v['content'];?>
            </span>
            <span class="f20"><?php echo $v['num'];?></span>
        </li>
        <?php }  }  ?>
    </ul>
</div>

<?php } ?>

<?php if($package['img_detail'] != null && $package['img_detail'] != ''): ?>
    <div class="bg_fff bd martop block h24 c333" id="showdetail">
    	<p class="bd_bottom">
            <?php echo $lang->line('details');?>
        </p>
        <div class="h24 fillcontent"><?php echo $package['img_detail'];?></div>
    </div>
<?php endif; ?>

<?php if($package['hotel_address'] != null && $package['hotel_address'] != ''): ?>
    <div class="bg_fff bd martop block" id="openLocation">
    	<em class="iconfont color_888" style="float:right;">&#xe607;</em>
        <p class="txtclip f24" style="width:82%;">
            <?php echo $lang->line('address') . '：' . $package['hotel_address'];?>
        </p>
    </div>
<?php endif; ?>

<!-- 推荐位  -->
 <?php echo isset($block) ? $block: '';?>
<!-- 推荐位  -->

<div class="foot_fixed foot_fixed__fsy">
    <div class="bg_fff webkitbox bd_top">
        <a href="<?php echo Soma_const_url::inst()->get_pacakge_home_page(array('id'=>$inter_id)); ?>" class="img_link">
            <img src="<?php echo base_url('public/soma/v1/images'); ?>/ico9.png"/>
        </a>
        <a href="<?php echo Soma_const_url::inst()->get_soma_ucenter(array('id'=>$inter_id)); ?>" class="img_link">
            <img src="<?php echo base_url('public/soma/v1/images'); ?>/ico10.png"/>
        </a>

        <?php if( $is_expire ): ?>
            <div class="h24 bdradius bg_999" style="border: 1px solid transparent">
                <?php echo $lang->line('expired'); ?>
            </div>
        <?php else : ?>
            <?php if( isset( $isTicket ) && !$isTicket ):?>
                <div class="h24 bdradius btn_void txtclip select_type" href="<?php echo Soma_const_url::inst ()->get_package_pay(array('pid'=>$_GET['pid'],'id'=>$inter_id,'bType'=>$bType));?>">
                    <?php if($show_y_flag && $inter_id !== 'a490782373'):?>¥<?php endif; ?>
                    <span>
                        <?php
                        if(isset($package['scopes']) && isset($package['scopes'][0]) ) {
                            echo $package['scopes'][0]['price'];
                        } else {
                            if ($inter_id !== 'a490782373') {
                                echo $package['price_package'];
                            }
                        }
                        ?>
                    </span>
                    <?php
                    if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE) {
                        echo $lang->line('soted_value_buy');
                    } elseif($package['type'] == $packageModel::PRODUCT_TYPE_POINT) {
                        echo $lang->line('point_buy');
                    } else {
                        if(isset($package['scopes']) && isset($package['scopes'][0]) ) {
                            echo $lang->line('exclusive_buy');
                        } else {
                            echo $lang->line('buy_now');
                        }
                    }
                    ?>
                </div>
            <?php else:?>
                <a class="h24 bdradius btn_void txtclip select_type" href="<?php echo Soma_const_url::inst()->get_url('*/*/ticket_select_time',array('id'=>$inter_id,'pid'=>$_GET['pid'],'tkid'=>$ticketId,'bType'=>$bType)); ?>">
                    <?php if($show_y_flag && $inter_id !== 'a490782373'):?>¥<?php endif; ?>
                    <span>
                        <?php
                        if(isset($package['scopes']) && isset($package['scopes'][0]) ) {
                            echo $package['scopes'][0]['price'];
                        } else {
                            if ($inter_id !== 'a490782373') {
                                echo $package['price_package'];
                            }
                        }
                        ?>
                    </span>
                    <?php
                    if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE) {
                        echo $lang->line('soted_value_buy');
                    } elseif($package['type'] == $packageModel::PRODUCT_TYPE_POINT) {
                        echo $lang->line('point_buy');
                    } else {
                        if(isset($package['scopes']) && isset($package['scopes'][0]) ) {
                            echo $lang->line('exclusive_buy');
                        } else {
                            echo $lang->line('buy_now');
                        }
                    }
                    ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>

   <?php if( isset($finish_killsec) && $finish_killsec ): ?>

       <div class="section pd-19 box" id="kill-price">
           <div class="price flex1 cff9900">
               <span class="f20 symbol"><?php if($show_y_flag):?>¥<?php endif; ?></span>
               <?php echo $killsec['killsec_price'];?>
               <span class="original c98 f20"><?php if($show_y_flag):?>原价¥<?php endif; ?><?php echo $package['price_package']; ?></span>
           </div>
       </div>
        <a  class="h24 bg_main bdradius txtclip disabled" id="soldout_btn" style="position: absolute;border-radius: 0px;height: 100%;right: -3px;width: 37%;top: 0;background: #808080">
            <span class="text" style="display: block; height: 48px; line-height: 48px;font-size: 16px;">
                 <?php echo $lang->line('sold_out');?>
            </span>
        </a>
    <?php /**有秒杀**/elseif( isset($killsec) && !empty($killsec)): ?>

    <a id="killsec_btn" class="h24 bg_main bdradius txtclip disabled">
        <span class="mask bdradius">活动加载中……</span>
        <span class="text">
        <?php if($show_y_flag):?>¥<?php endif; ?><?php echo $killsec['killsec_price'];?>
        <?php
        if($package['type'] == $packageModel::PRODUCT_TYPE_BALANCE) {
                echo $lang->line('soted_value_buy');
            } elseif($package['type'] == $packageModel::PRODUCT_TYPE_POINT) {
                echo $lang->line('point_buy');
            } else {
                echo $lang->line('flash_sale_buy');
            }
      ?>
        </span>
    </a>

    <?php /**有拼团**/ elseif( !empty($groupons) && !$is_expire ): ?>

        <?php foreach($groupons as $k=>$v): ?>
        <a href="<?php echo Soma_const_url::inst ()->get_groupon_first_pay(array('act_id'=>$v['act_id'],'id'=>$inter_id,'bType'=>$bType));?>"
            class="h24 bg_main bdradius txtclip"  style="border: 1px solid transparent">
            <?php if($show_y_flag):?>¥<?php endif; ?>

            <?php echo $v['group_price'];?> | <?php echo $v['group_count'] . ' ' . $lang->line('person_group');?>
        </a>
        <?php break; endforeach; ?>

    <?php elseif( isset($auto_rule[0]) ): ?>
        <a class="h24 bg_main bdradius txtclip" style="border: 1px solid transparent" href="<?php echo Soma_const_url::inst()->get_package_pay(array('pid'=>$_GET['pid'], 'id'=>$inter_id, 'rid'=>$auto_rule[0]['rule_id'], 'bType'=>$bType )); ?>">
            <?php echo $lang->line('group_purchase'); ?>
        </a>
    <?php endif; ?>



    </div>
    <?php if(isset($package['scopes']) && isset($package['scopes'][0]) ) : ?>
     <div class="zhuanshujia">
         <?php echo str_replace('[0]', $package['social']['name'], $lang->line('exclusive_tip')); ?>
     </div>
    <?php endif; ?>
</div>


<!-- <div style="padding-top:18%"></div> -->

<div class="ui_pull share_pull" style="display:none" onClick="toclose()"></div>

</div>


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
<script>
// 订阅成功
// msg 第一个参数为 显示的内容，如果不需要重新设置文案，传入null，默认文案为：‘您已订阅成功，我们将在活动开始前10分钟内通知您，为保证能收到提醒信息，请扫码关注公众号’
// success 点击好的成功的回掉
function subscribeSuccess (msg, success) {
    if (msg) {
        $('#subscribeMsg').html(msg)
    }
    $('#subscribe').show().find('a').off().on('click', function() {
            $('#subscribe').hide();
            if ($(this).hasClass('active')) {
                if(typeof success === 'function') {
                    success();
                }
         }
    });
}

// subscribeSuccess(null, function() {
//    console.log('success')
// })


// 显示二维码
// msg 二维码上面显示的文案
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


<?php /**有秒杀**/ if( isset($killsec) &&  !empty($killsec)){ ?>
var subscribe_lock= false;
$(function(){
    $('#killsec_btn').click(function(){
        var $this = $(this);
        if($this.hasClass('disabled')){
            return;
        }
        get_in_line()
    })
    $('#soldout_btn').click(function(){
        $.MsgBox.Alert( '很遗憾，您来晚了，欢迎关注我们下次活动');
    });
})
$(window).load(function(){
    $('#killsec_btn').removeClass('disabled');
});

var killsec = <?php echo json_encode($killsec); ?>;
var canSubscribe = <?php echo Soma_base::STATUS_TRUE; ?>;
console.log(killsec);

function get_in_line(){
	if(!startFlag){
		var tmptime= new Date('<?php echo date('Y/m/d H:i:s',strtotime($killsec['killsec_time']));?>');
		var tmpnow = new Date();
        if ( tmptime.getTime()-tmpnow.getTime() < 10*60*1000 ){ // 小于10分钟

            $.MsgBox.Alert( '秒杀即将开始，手快有，手慢无');

        }
        /*
        else if ( tmptime.getTime()-tmpnow.getTime() < 15*60*1000 ){ // 小于30分钟

			$.MsgBox.Confirm( '<?php echo $lang->line('flash_sale_prepare');?>',null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');

		}
		*/
        else{

            if (killsec.is_subscribe == canSubscribe) {
                if( subscribe_lock== true){

                    $.MsgBox.Confirm( '<?php echo $lang->line('subscribe_success');?>' ,null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');

                } else {
                    $.MsgBox.Confirm('<?php echo $lang->line('subscribe_and_reminder');?>', function(){
                        //window.location.href='';//rightEvent;
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
                        //window.location.href='';//leftEvent;
                    },'<?php echo $lang->line('subscribe_now');?>', '<?php echo $lang->line('say_later');?>');
                }
            } else {
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
            console.log(json);
            console.log(json.data);
			if( json.status == 1 ){
				var token= json.data.token;
				var instance_id= json.data.instance_id;
				//$.MsgBox.Confirm('', json.message,function(){
				location.href='<?php echo Soma_const_url::inst()->get_url('*/killsec/package_pay',
					array('id'=>$inter_id, 'pid'=>$_GET['pid'], 'act_id'=>$killsec['act_id'], 'bType'=>$bType )); ?>&instance_id='+ instance_id+ '&token='+ token;
				//} );
			} else if( json.status == 2 ){
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
</script>
<script>

$(".fsfl").on("animationEnd webkitAnimationEnd",function(){
    if($(".haoma").position().top < 15){
        $(".fsfl>div").addClass("move6");
    }
});
setTimeout(function(){
    $(".fsfl").removeClass("none");
},500);
$.fn.imgscroll({
	imgrate : 640/640,
	circlesize: '8px'
})

$('#how_sent').click(function(){
	toshow($('.how_sent_pull'));
});
$('#toshare').click(function(){
	toshow($('.share_pull'));
});
$('.how_sent_pull').click(toclose);
$('#showdetail').click(function(){
	//toshow($('.showdetail_pull'));
});
$('.showdetail_pull').click(toclose);

$('.support_list div').click(function(){
	$.MsgBox.Confirm($(this).attr('tips'),null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
	$('#left_btn').parent().remove();
});
var specdata = '',specid = '', _url = '',setting_id='',stock = 0,price = '-';
var scopes = <?php
                if(isset($package['scopes'])) {
                    echo json_encode($package['scopes']);
                } else {
                    echo json_encode(array());
                }
            ?>;

<?php if( isset( $isTicket ) && !$isTicket ):?>
$('.select_type').click(function(){
	if(specdata==''){
		pageloading();
		$.ajax({
			type: 'GET',
			url: '<?php echo Soma_const_url::inst()->get_url("*/*/ajax_product_spec"); ?>',
			data:{
				id:'<?php echo $this->inter_id; ?>',
				pid:<?php echo $package['product_id']; ?>
			},
			dataType:'JSON',
			error: function(){
				$.MsgBox.Confirm('<?php echo $lang->line('network_problem_refreah');?>',null,null,'<?php echo $lang->line('ok');?>','<?php echo $lang->line('cancel');?>');
				$('#mb_btn_no').remove();
			},
			success: function(data){
				if(data.status==1){
				  if(!jQuery.isEmptyObject(data.data.data)&&data.data.spec_type!=undefined){
					specdata = data.data;
					for(var i=specdata.spec_type.length-1;i>=0;i--){
						var html = $('<div class="flex flexrow"><div><?php echo $lang->line('goods');?>'+specdata.spec_type[i]+'</div><div class="specbtn"></div></div>');
						for(var j=0;j<specdata.spec_name[i].length;j++){
							var specbtn = $('<span class="bg_F8F8F8" specid="'+specdata.spec_name_id[i][j]+'">'+specdata.spec_name[i][j]+'</span>');
							specbtn.get(0).onclick=function(e){
								e.stopPropagation();
                                stock = '-',price = '-',specid = '',_url='',setting_id='';
								var  text = '<?php echo $lang->line('confirm');?>' ;
								$(this).addClass('bg_main').siblings().removeClass('bg_main');
								$('#spec_page .sure_btn').addClass('disable');
								$('.speclist .bg_main').each(function() {
									specid += $(this).attr('specid');
                                });
								for(var i =0;i< specdata.spec_id.length;i++){
									if( specid==specdata.spec_id[i].toString()){
										setting_id = specdata.setting_id[i];
									}
								}
								if( specdata.data[setting_id]!=undefined){
                                    _url = $('.foot_fixed .select_type').attr('href')+'&psp_sid='+specdata.data[setting_id].setting_id+'&bType='+'<?php echo $bType;?>';
									stock = Number(specdata.data[setting_id].stock);
									price = Number(specdata.data[setting_id].specprice);
                                    for(var i=0; i<scopes.length; i++) {
                                        if (scopes[i].setting_id && scopes[i].setting_id == setting_id) {
                                            price = scopes[i].price;
                                        }
                                    }

									var _html = '<?php echo $lang->line('selected');?>:'
									for(var d = 0;d<specdata.data[setting_id].spec_name.length;d++){
										_html+='"'+specdata.data[setting_id].spec_name[d]+'"';
									}
									$('.result').html(_html);
									if( stock<=0){
										text= '<?php echo $lang->line('inventory_shortage');?>';
									}else{
										$('#spec_page .sure_btn').removeClass('disable');
									}
								}
								//console.log(stock)
								$('.specprice').html(price);
								$('.select_type span').html(price);
								$('#spec_page .sure_btn').html(text);

							}
							html.find('.specbtn').append(specbtn);
						}
						$('.speclist').prepend(html);
					  }
					  $('.select_type').show();
					  toshow($('#spec_page'));
					}else{
						 window.location.href = $('.foot_fixed .select_type').attr('href');
					}
				} else {
                    $.MsgBox.Confirm('<?php echo $lang->line('try_again');?>', null, null, '<?php echo $lang->line('ok');?>', '<?php echo $lang->line('cancel');?>');
                }
			},
			complete: function(data){
				removeload();
			}
		});
	}else{
		if($(this).attr('href')!=undefined&&_url!=''&&stock>0) window.location.href = _url;
		else toshow($('#spec_page'));
	}
})
<?php endif;?>
$('#spec_page .speclist').click(function(e){
	e.stopPropagation();
})
$('#spec_page .sure_btn').click(function(e){
    e.stopPropagation();
	if($(this).hasClass('disable'))return;
	if(specdata.data[setting_id]!=undefined&&_url!=''&&stock>0) window.location.href = _url;
});

$('.make-money-close').off().on('click', function(ev){
  $('.make-money').hide();
   ev.preventDefault();
});
</script>
</html>